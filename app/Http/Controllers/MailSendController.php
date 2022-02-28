<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTest;


class MailSendController extends Controller
{
    //
    public function send() {
   
	$data = [];

	Mail::to('linuxseima@gmail.com')
		->send(new MailTest('これはパスワードをいれる'));
    }
}
