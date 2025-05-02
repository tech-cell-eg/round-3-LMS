<?php

namespace App\Observers;

use App\Models\Enrollment;
use App\Notifications\UserEnrolledNotification;

class EnrollmentObserver
{
    /**
     * Handle the Enrollment "created" event.
     */
    public function created(Enrollment $enrollment): void
    {
        $instructor = $enrollment->course->instructor;

        $instructor->notify(new UserEnrolledNotification(
            student: $enrollment->user,
            course: $enrollment->course
        ));
    }
}
