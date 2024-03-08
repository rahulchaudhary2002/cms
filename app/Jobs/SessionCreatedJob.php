<?php

namespace App\Jobs;

use App\Mail\SessionCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SessionCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $users = [];

    /**
     * Create a new job instance.
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->users as $user) {
            Mail::to($user->email)->send(new SessionCreatedMail($user));
        }
    }
}
