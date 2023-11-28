<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait DispatchEmails
{
    /**
     * The sendEmail function sends an email using Laravel's Mail facade and dispatches it to a
     * specified email address.
     */
    protected function sendEmail($email, $mailObject)
    {
        dispatch(function () use ($email, $mailObject) {
            Mail::to($email)->send($mailObject);
        });
    }
}
