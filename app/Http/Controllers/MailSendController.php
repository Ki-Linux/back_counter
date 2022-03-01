<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTest;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;

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

    //
    public function send(Request $request) {
 
    $mail = $request->mail;

    $login = new Login();
    $name = Login::where('mail', $mail)->first();


    if($name) {
        Mail::to($mail)
		->send(new MailTest($name->password));

        return ['result' => 'dddddd'];
    } else {

        return ['result' => 'sdsd'];

    }

	


    }

    
}
