<?php

namespace Lareon\CMS\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public         $subject,
        public array   $introduction,
        public ?string $actionUrl = null,
        public ?string $actionText = null,
        public ?array $content = null,
    )
    {
        //
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->view('lareon::emails.notification')
            ->with([
                'subject' => $this->subject,
                'introduction' => $this->introduction,
                'actionUrl' => $this->actionUrl,
                'actionText' => $this->actionText,
                'content' => $this->content,
            ]);
    }
}
