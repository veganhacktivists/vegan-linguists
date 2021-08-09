<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'language_id',
        'content',
        'plain_text',
    ];

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function language()
    {
        return $this->hasOne(Language::class);
    }

    public function translationRequests()
    {
        return $this->hasMany(TranslationRequest::class);
    }
}
