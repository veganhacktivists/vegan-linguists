<?php

namespace App\Models;

use App\Events\SourceDeletingEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Source extends Model
{
    use HasFactory;

    protected $with = ['language'];

    protected $fillable = [
        'author_id',
        'language_id',
        'title',
        'content',
        'plain_text',
    ];

    protected $dispatchesEvents = [
        'deleting' => SourceDeletingEvent::class,
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function translationRequests()
    {
        return $this->hasMany(TranslationRequest::class)
            ->orderByStatus('desc')
            ->orderBy('language_id', 'asc');
    }

    public function isOwnedBy(User $user)
    {
        return $this->author_id === $user->id;
    }

    public function getNumCompleteTranslationRequestsAttribute()
    {
        return $this->translationRequests
            ->where('status', TranslationRequestStatus::COMPLETE)
            ->count();
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->title);
    }

    public function scopeOrderByRecency(
        Builder $builder,
        string $order = 'desc'
    ) {
        return $builder->orderBy('created_at', $order);
    }

    public function scopeComplete(Builder $builder)
    {
        return $builder->whereNotExists(function (QueryBuilder $query) {
            $query
                ->select(DB::raw(1))
                ->from('translation_requests')
                ->where('status', '<>', TranslationRequestStatus::COMPLETE)
                ->whereColumn('sources.id', 'translation_requests.source_id');
        });
    }

    public function scopeIncomplete(Builder $builder)
    {
        return $builder->whereExists(function (QueryBuilder $query) {
            $query
                ->select(DB::raw(1))
                ->from('translation_requests')
                ->where('status', '<>', TranslationRequestStatus::COMPLETE)
                ->whereColumn('sources.id', 'translation_requests.source_id');
        });
    }
}
