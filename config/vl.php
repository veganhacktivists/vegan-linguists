<?php

return [
    'notifications' => [
        'resolved_comment_batch_interval' => env(
            'RESOLVED_COMMENT_BATCH_EMAIL_INTERVAL_MINUTES',
            30
        ),
    ],
    'heartbeats' => [
        'new_translation_requests_email' => env('HEARTBEAT_NEW_TRANSLATION_REQUESTS_EMAIL', 'https://example.com'),
        'resize_new_profile_photos' => env('HEARTBEAT_RESIZE_NEW_PROFILE_PHOTOS', 'https://example.com'),
    ],
];
