<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTest;

use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;


class MailSendController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    public function upload()
    {
        return ['result' => 'sdsd'];
    }
    //
    public function send(Request $request) {
   
	$data = [];
    $mail = $request->password;

	Mail::to('linuxseima@gmail.com')
		->send(new MailTest('これはパスワードをいれる'));


        return ['result' => 'sdsd'];
    }

    
}
