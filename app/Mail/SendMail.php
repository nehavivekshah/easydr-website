<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $viewName;
    public $viewData;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $viewName
     * @param array $viewData
     */
    public function __construct($subject, $viewName, $viewData = [])
    {
        $this->subject = $subject;
        $this->viewName = $viewName;
        $this->viewData = $viewData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view($this->viewName)
                    ->with($this->viewData)
                    ->from('admin@easydoctor.com', 'Easy Doctor');
    }
}
