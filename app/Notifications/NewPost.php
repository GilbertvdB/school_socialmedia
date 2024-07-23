<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPost extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Post $post)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {   
        $appName = config('app.name');
        return (new MailMessage)
                    ->subject("{$this->post->title}")
                    ->greeting("{$this->post->title}")
                    ->line("{$this->post->user->name} > {$this->post->post_groups_names}" )
                    ->line(Str::limit($this->post->body, 150))
                    ->action("View post in {$appName}", url('/posts',['post' => $this->post]))
                    ->salutation(" ");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
