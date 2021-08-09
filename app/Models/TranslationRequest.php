<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class TranslationRequestStatus {
    const UNCLAIMED = 'UNCLAIMED';
    const CLAIMED = 'CLAIMED';
    const COMPLETE = 'COMPLETE';
}

class TranslationRequest extends Model
{
    use HasFactory;

    protected $attributes = [
        'status' => TranslationRequestStatus::UNCLAIMED,
        'content' => '',
        'plain_text' => '',
    ];

    protected $fillable = [
        'source_id',
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
        return $this->hasOne(Language::class);
    }

    public function translator()
    {
        return $this->hasOne(User::class, 'id', 'translator_id');
    }
}
