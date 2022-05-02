<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailContact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_contents)
    {
        //
        $this->contact_contents = $contact_contents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hou007@hkoruy.sakura.ne.jp', 'プラマイカウンターサービスお問い合わせ')
                    ->view('emails.contact')
                    ->subject('プラマイカウンターサービスのお問い合わせがありました。')
                    ->with(['contact_contents' => $this->contact_contents]);
    }
}
