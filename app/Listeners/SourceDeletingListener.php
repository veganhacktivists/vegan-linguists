<?php

namespace App\Listeners;

use App\Events\SourceDeletingEvent;
use App\Models\TranslationRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SourceDeletingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  SourceDeletingEvent  $event
     * @return void
     */
    public function handle(SourceDeletingEvent $event)
    {
        TranslationRequest::where('source_id', $event->source->id)->get()->each->delete();
    }
}
