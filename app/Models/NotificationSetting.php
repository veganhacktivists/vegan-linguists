<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $attributes = [
        'site' => true,
        'email' => true,
    ];

    protected $fillable = ['user_id', 'notification_type', 'site', 'email'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTitleAttribute()
    {
        return $this->notification_type::getTitle();
    }

    public function getDescriptionAttribute()
    {
        return $this->notification_type::getDescription();
    }

    public function isDatabaseEnabled()
    {
        return $this->notification_type::isDatabaseEnabled();
    }

    public function isMailEnabled()
    {
        return $this->notification_type::isMailEnabled();
    }
}
