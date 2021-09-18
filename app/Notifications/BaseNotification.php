<?php

namespace App\Notifications;

interface BaseNotification
{
    public static function getTitle();
    public static function getDescription();
}
