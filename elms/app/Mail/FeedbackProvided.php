<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EnumeratorAssign\EnumeratorAssign;

class FeedbackProvided extends Mailable
{
    use Queueable, SerializesModels;
    public $model;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EnumeratorAssign $model)
    {
        $this->model  = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emitter.email.feedback');
    }
}
