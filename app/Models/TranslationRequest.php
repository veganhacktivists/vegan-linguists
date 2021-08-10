<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function source()
    {
        return $this->hasOne(Source::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function translator()
    {
        return $this->hasOne(User::class, 'id', 'translator_id');
    }
}
