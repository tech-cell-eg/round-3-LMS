<?php

namespace App\Events;

use App\Models\Course;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserEnrolled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $course;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Course $course)
    {
        $this->user = $user;
        $this->course = $course;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->course->instructor_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => "{$this->user->name} joined your course: {$this->course->title}",
            'user' => [
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
            ],
            'course' => [
                'id' => $this->course->id,
                'title' => $this->course->title,
            ],
            'enrollment_date' => now()->diffForHumans(),
        ];
    }
}
