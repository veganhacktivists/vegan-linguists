<?php

namespace App\Models;

use App\Events\CommentCreatedEvent;
use App\Events\CommentDeletedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['author'];

    protected $fillable = [
        'author_id',
        'content',
        'plain_text',
    ];

    protected $dispatchesEvents = [
        'created' => CommentCreatedEvent::class,
        'deleted' => CommentDeletedEvent::class,
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
}
