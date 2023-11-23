<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait DispatchEmails
{
    protected function sendEmail($email, $mailObject)
    {
        dispatch(function () use ($email, $mailObject) {
            Mail::to($email)->send($mailObject);
        });
    }
}
