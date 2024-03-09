<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssignmentCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $assignmnet;
    private $createdBy;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $assignmnet, $createdBy)
    {
        $this->user = $user;
        $this->assignmnet = $assignmnet;
        $this->createdBy = $createdBy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Assignment Created Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.assignment_created',
            with: [
                'url' => route('assignment.submission.create', $this->assignmnet->key),
                'user' => $this->user,
                'assignment' => $this->assignmnet,
                'createdBy' => $this->createdBy
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
