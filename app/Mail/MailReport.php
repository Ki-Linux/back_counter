<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report_contents)
    {
        //
        $this->report_contents = $report_contents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hou007@hkoruy.sakura.ne.jp', 'プラマイカウンターサービス通報')
                    ->view('emails.report')
                    ->subject('プラマイカウンターサービスの通報がありました。')
                    ->with(['report_contents' => $this->report_contents]);
    }
}
