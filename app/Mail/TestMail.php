<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // fromは差出人　Toは受取人
        // return $this->from('ka1301@outlook.jp')->subject('test')->view('emails.test');
        return $this->from('test@laravel-test-app.ml')
            ->subject('test-lareavle')
            ->view('emails.test');
    }
}
