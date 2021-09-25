<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'native_name',
    ];

    protected $appends = [
        'full_name',
    ];

    public function getFullNameAttribute()
    {
        $fullName = "{$this->name} ({$this->native_name})";

        if (isset($this->translators_count)) {
            $fullName .= " " . trans_choice('[1] (:count translator)|[*] (:count translators)', $this->translators_count);
        }

        return $fullName;
    }

    public function translators()
    {
        return $this->belongsToMany(User::class);
    }
}
