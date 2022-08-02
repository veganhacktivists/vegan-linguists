<?php

namespace App\Models;

use App\Events\CommentCreatedEvent;
use App\Events\CommentDeletedEvent;
use App\Events\CommentUpdatedEvent;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['author'];

    protected $fillable = [
        'author_id',
        'content',
        'plain_text',
        'metadata',
        'metadata->resolved_at',
    ];

    protected $dispatchesEvents = [
        'created' => CommentCreatedEvent::class,
        'updated' => CommentUpdatedEvent::class,
        'deleted' => CommentDeletedEvent::class,
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function getTruncatedTextAttribute()
    {
        $plainText = html_entity_decode($this->plain_text);

        if (strlen($plainText) >= 100) {
            return substr($plainText, 0, 97) . '…';
        }

        return trim($plainText);
    }

    public function hasAnnotation()
    {
        return Arr::has($this->metadata, 'annotation');
    }

    public function getIsResolvedAttribute()
    {
        return $this->resolved_at !== null;
    }

    public function getResolvedAtAttribute()
    {
        $resolvedAt = Arr::get($this->metadata, 'resolved_at', null);

        return $resolvedAt === null
            ? $resolvedAt
            : new CarbonImmutable($resolvedAt);
    }

    public function markAsResolved()
    {
        if (!$this->hasAnnotation() || $this->is_resolved) {
            return $this;
        }

        return $this->update(['metadata->resolved_at' => time()]);
    }

    public function scopeResolved(Builder $builder)
    {
        return $builder->whereRaw(
            "json_extract(metadata, '$.resolved_at') <> 'null'"
        );
    }

    public function scopeOrderByResolveDate(
        Builder $builder,
        string $order = 'asc'
    ) {
        $order = $order === 'asc' ? 'asc' : 'desc'; // since we're putting a variable in a raw query

        return $builder->orderByRaw(
            "json_extract(metadata, '$.resolved_at') $order"
        );
    }
}
