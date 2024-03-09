<?php

namespace App\Jobs;

use App\Mail\AssignmentCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AssignmentCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $users = [];
    private $assignment;
    private $createdBy;

    /**
     * Create a new job instance.
     */
    public function __construct($users, $assignment, $createdBy)
    {
        $this->users = $users;
        $this->assignment = $assignment;
        $this->createdBy = $createdBy;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->users as $user) {
            Mail::to($user->email)->send(new AssignmentCreatedMail($user, $this->assignment, $this->createdBy));
        }
    }
}
