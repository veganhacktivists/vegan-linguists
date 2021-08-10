<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'language_id',
        'title',
        'content',
        'plain_text',
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
        return $this->hasMany(TranslationRequest::class);
    }

    public function getNumCompleteTranslationRequestsAttribute()
    {
        return $this->translationRequests->where('status', TranslationRequestStatus::COMPLETE)->count();
    }

    public function scopeComplete(Builder $builder) {
        return $builder->whereNotExists(function(QueryBuilder $query) {
            $query->select(DB::raw(1))
                ->from('translation_requests')
                ->where('status', '<>', TranslationRequestStatus::COMPLETE)
                ->whereColumn('sources.id', 'translation_requests.source_id');
        });
    }

    public function scopeIncomplete(Builder $builder) {
        return $builder->whereExists(function(QueryBuilder $query) {
            $query->select(DB::raw(1))
                ->from('translation_requests')
                ->where('status', '<>', TranslationRequestStatus::COMPLETE)
                ->whereColumn('sources.id', 'translation_requests.source_id');
        });
    }
}
