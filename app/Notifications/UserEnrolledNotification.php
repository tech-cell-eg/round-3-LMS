<?php

namespace App\Notifications;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserEnrolledNotification extends Notification
{
    use Queueable;

    
    /**
     * Create a new notification instance.
     */
    public function __construct(public User $student, public Course $course) { }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->student->full_name} joined your course: {$this->course->title}",
            'user' => [
                'name' => $this->student->full_name,
                'avatar' => $this->student->avatar?->path ?? null,
            ],
            'course' => [
                'id' => $this->course->id,
                'title' => $this->course->title,
            ],
            'enrollment_date' => now()->diffForHumans(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
