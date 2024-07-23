<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewPost;
use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendPostCreatedNotifications implements ShouldQueue
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
    public function handle(PostCreated $event): void
    {   
        $postGroupIds = $event->post->postGroups->pluck('id');

        foreach (User::whereHas('postGroups', function ($query) use ($postGroupIds) {
            $query->whereIn('post_groups.id', $postGroupIds);
        })
        ->whereNot('id', $event->post->author_id)
        ->cursor() as $user) {
            $user->notify(new NewPost($event->post));
        }
    }
}
