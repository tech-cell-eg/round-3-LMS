<?php

namespace App\Observers;

use App\Events\UserEnrolled;
use App\Models\Enrollment;

class EnrollmentObserver
{
    /**
     * Handle the Enrollment "created" event.
     */
    public function created(Enrollment $enrollment): void
    {
        event(new UserEnrolled(
            $enrollment->user,
            $enrollment->course
        ));
    }
}
