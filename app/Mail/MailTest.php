<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTest extends Mailable
{
    use Queueable, SerializesModels;

    public $password_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password_data)
    {
        //
       $this->password_data = $password_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->from('hou007@hkoruy.sakura.ne.jp', 'プラマイカウンターサービス')
                    ->view('emails.test')
                    ->subject('プラマイカウンターのパスワード確認について')
                    ->with(['password' => $this->password_data]);
    }
}
