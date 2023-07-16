<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\TestingSendingEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessNewsSubs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $email, public $subject, public $body)
    {
        //
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Execute the job.
     */
    public function handle( ): void
    {
        //
        Mail::to($this->email)->send(new TestingSendingEmail($this->subject, $this->body));
    }
}
