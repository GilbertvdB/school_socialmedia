<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Notifications\NewRegisteredUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewRegisteredUserNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserRegistered $event): void
    {
        $event->user->notify(new NewRegisteredUser($event->user));
    }
}
