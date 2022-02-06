<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification
{
    abstract public static function getTitle();
    abstract public static function getDescription();

    public static function isDatabaseEnabled()
    {
        return true;
    }

    public static function isMailEnabled()
    {
        return true;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(User $user)
    {
        $media = [];

        if (static::isDatabaseEnabled() && $user->shouldBeNotified(static::class, 'site')) {
            $media[] = 'database';
        }

        if (
            static::isMailEnabled() &&
            $user->shouldBeNotified(static::class, 'email')
        ) {
            $media[] = 'mail';
        }

        return $media;
    }
}
