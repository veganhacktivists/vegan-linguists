<?php

namespace App\Models;

use App\Events\TranslationRequestUpdatedEvent;
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
    ];

    protected $fillable = [
        'source_id',
        'language_id',
        'translator_id',
        'status',
        'content',
        'plain_text',
    ];

    protected $dispatchesEvents = [
        'updated' => TranslationRequestUpdatedEvent::class,
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

    public function isComplete()
    {
        return $this->status === TranslationRequestStatus::COMPLETE;
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

    public function scopeUnclaimed(Builder $query)
    {
        return $query->where('status', TranslationRequestStatus::UNCLAIMED);
    }

    public function scopeExcludingSourceAuthor(Builder $builder, User $user)
    {
        return $builder->whereNotExists(function(QueryBuilder $query) use ($user) {
            $query->select(DB::raw(1))
                ->from('sources')
                ->where('author_id', $user->id)
                ->whereColumn('sources.id', 'translation_requests.source_id');
        });
    }

    public function scopeWhereSourceLanguageId(Builder $builder, mixed $languageId)
    {
        return $builder->whereExists(function(QueryBuilder $query) use ($languageId) {
            $query->select(DB::raw(1))
                ->from('sources')
                ->when(is_int($languageId), function(QueryBuilder $q) use ($languageId) {
                    $q->where('sources.language_id', $languageId);
                })
                ->when(is_iterable($languageId), function(QueryBuilder $q) use ($languageId) {
                    $q->whereIn('sources.language_id', $languageId);
                })
                ->whereColumn('sources.id', 'translation_requests.source_id');
        });
    }

    public function scopeWhereLanguageId(Builder $builder, mixed $languageId)
    {
        return $builder
            ->when(is_int($languageId), function(Builder $q) use ($languageId) {
                $q->where('language_id', $languageId);
            })
            ->when(is_iterable($languageId), function(Builder $q) use ($languageId) {
                $q->whereIn('language_id', $languageId);
            });
    }
}
