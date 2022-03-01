<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailConf extends Mailable
{
    use Queueable, SerializesModels;

    public $user_name_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name_data)
    {
        //
        $this->user_name_data = $user_name_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hou007@hkoruy.sakura.ne.jp', 'プラマイカウンターサービス')
        ->view('emails.confirm')
        ->subject('登録のご確認について')
        ->with(['user_name' => $this->user_name_data]);
    }
}
