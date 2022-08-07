<?php

namespace App\Models;

use App\Events\TranslationRequestApprovedEvent;
use App\Events\TranslationRequestDeletingEvent;
use App\Events\TranslationRequestReviewerAddedEvent;
use App\Events\TranslationRequestUpdatedEvent;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class TranslationRequest extends Model
{
    use HasFactory;

    protected $with = ['language'];

    protected $attributes = [
        'status' => TranslationRequestStatus::UNCLAIMED,
        'content' => '',
        'plain_text' => '',
        'num_approvals_required' => 0,
    ];

    protected $fillable = [
        'source_id',
        'language_id',
        'translator_id',
        'status',
        'content',
        'plain_text',
        'num_approvals_required',
    ];

    protected $dispatchesEvents = [
        'updated' => TranslationRequestUpdatedEvent::class,
        'deleting' => TranslationRequestDeletingEvent::class,
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function translator()
    {
        return $this->hasOne(User::class, 'id', 'translator_id');
    }

    public function reviewers()
    {
        return $this->belongsToMany(
            User::class,
            'reviewer_translation_request',
            'translation_request_id',
            'reviewer_id'
        )->withPivot('approved');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function assignTo(User $translator)
    {
        $this->update([
            'translator_id' => $translator->id,
            'status' => TranslationRequestStatus::CLAIMED,
        ]);
    }

    public function unclaim()
    {
        $this->update([
            'translator_id' => null,
            'status' => TranslationRequestStatus::UNCLAIMED,
        ]);
    }

    public function submit(string $content, string $plainText)
    {
        $status =
            $this->num_approvals_required > 0
                ? TranslationRequestStatus::UNDER_REVIEW
                : TranslationRequestStatus::COMPLETE;

        $this->update([
            'content' => $content,
            'plain_text' => $plainText,
            'status' => $status,
        ]);
    }

    public function addReviewer(User $user)
    {
        $this->reviewers()->attach($user->id, ['approved' => false]);
        TranslationRequestReviewerAddedEvent::dispatch($this, $user);
    }

    public function setApproval(User $user)
    {
        $this->reviewers()->updateExistingPivot($user->id, [
            'approved' => true,
        ]);
        TranslationRequestApprovedEvent::dispatch($this, $user);
    }

    public function hasBeenApprovedBy(User $user)
    {
        if ($this->relationLoaded('reviewers')) {
            return (bool) optional(
                optional($this->reviewers->find($user))->pivot
            )->approved;
        }

        $user = $this->reviewers()
            ->where('users.id', $user->id)
            ->first();

        return $user && $user->pivot->approved;
    }

    public function getNumApprovalsAttribute()
    {
        return $this->reviewers()
            ->wherePivot('approved', '=', 1)
            ->count();
    }

    public function getNumApprovalsRemainingAttribute()
    {
        return $this->num_approvals_required - $this->num_approvals;
    }

    public function isComplete()
    {
        return $this->status === TranslationRequestStatus::COMPLETE;
    }

    public function isUnderReview()
    {
        return $this->status === TranslationRequestStatus::UNDER_REVIEW;
    }

    public function isUnclaimed()
    {
        return $this->status === TranslationRequestStatus::UNCLAIMED;
    }

    public function isClaimed()
    {
        return $this->status === TranslationRequestStatus::CLAIMED;
    }

    public function isClaimedBy(User $user)
    {
        return $user->id === $this->translator_id;
    }

    public function hasReviewer(User $user)
    {
        if ($this->relationLoaded('reviewers')) {
            return $this->reviewers->contains($user);
        }

        return $this->reviewers()
            ->where('users.id', $user->id)
            ->exists();
    }

    public function doesNeedReviewers()
    {
        return $this->isUnderReview() &&
            $this->reviewers()->count() < $this->num_approvals_required;
    }

    public function scopeUnclaimed(Builder $query)
    {
        return $query->where(
            'translation_requests.status',
            TranslationRequestStatus::UNCLAIMED
        );
    }

    public function scopeNeedsReviewers(Builder $query)
    {
        return $query
            ->where(
                'translation_requests.status',
                TranslationRequestStatus::UNDER_REVIEW
            )
            ->has(
                'reviewers',
                '<',
                DB::raw('translation_requests.num_approvals_required')
            );
    }

    public function scopeUnderReview(Builder $query)
    {
        return $query->where(
            'translation_requests.status',
            TranslationRequestStatus::UNDER_REVIEW
        );
    }

    public function scopeIncomplete(Builder $query)
    {
        return $query->where(
            'translation_requests.status',
            '<>',
            TranslationRequestStatus::COMPLETE
        );
    }

    public function scopeComplete(Builder $query)
    {
        return $query->where(
            'translation_requests.status',
            TranslationRequestStatus::COMPLETE
        );
    }

    public function scopeExcludingTranslator(Builder $query, User $user)
    {
        return $query
            ->where('translator_id', '<>', $user->id)
            ->orWhere('translator_id', null);
    }

    public function scopeExcludingReviewer(Builder $builder, User $user)
    {
        return $builder->whereNotExists(function (QueryBuilder $query) use (
            $user
        ) {
            $query
                ->select(DB::raw(1))
                ->from('reviewer_translation_request')
                ->where('reviewer_id', $user->id)
                ->whereColumn(
                    'reviewer_translation_request.translation_request_id',
                    'translation_requests.id'
                );
        });
    }

    public function scopeExcludingSourceAuthor(Builder $builder, User $user)
    {
        return $builder->whereNotExists(function (QueryBuilder $query) use (
            $user
        ) {
            $query
                ->select(DB::raw(1))
                ->from('sources')
                ->where('author_id', $user->id)
                ->whereColumn('sources.id', 'translation_requests.source_id');
        });
    }

    public function scopeWhereSourceLanguageId(
        Builder $builder,
        mixed $languageId
    ) {
        return $builder->whereExists(function (QueryBuilder $query) use (
            $languageId
        ) {
            $query
                ->select(DB::raw(1))
                ->from('sources')
                ->when(is_int($languageId), function (QueryBuilder $q) use (
                    $languageId
                ) {
                    $q->where('sources.language_id', $languageId);
                })
                ->when(is_iterable($languageId), function (
                    QueryBuilder $q
                ) use ($languageId) {
                    $q->whereIn('sources.language_id', $languageId);
                })
                ->whereColumn('sources.id', 'translation_requests.source_id');
        });
    }

    public function scopeWhereLanguageId(Builder $builder, mixed $languageId)
    {
        return $builder
            ->when(is_int($languageId), function (Builder $q) use (
                $languageId
            ) {
                $q->where('language_id', $languageId);
            })
            ->when(is_iterable($languageId), function (Builder $q) use (
                $languageId
            ) {
                $q->whereIn('language_id', $languageId);
            });
    }

    public function scopeOrderByStatus(Builder $query, string $order = 'asc')
    {
        $statuses = [
            TranslationRequestStatus::UNCLAIMED,
            TranslationRequestStatus::CLAIMED,
            TranslationRequestStatus::UNDER_REVIEW,
            TranslationRequestStatus::COMPLETE,
        ];

        if ($order === 'desc') {
            $statuses = array_reverse($statuses);
        }

        return $query->orderBy(
            DB::raw(
                sprintf("FIELD(status, '%s')", implode("','", $statuses)),
                'asc'
            )
        );
    }

    public function scopeWhereCreatedAfter(
        Builder $query,
        Carbon|CarbonImmutable $date
    ) {
        return $query->where('created_at', '>', $date);
    }
}
