<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTest;
use App\Models\Login;
use App\Models\Letter;
use Hash;
//use Illuminate\Support\Facades\DB;

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
    $letter = new Letter();

    $name = Login::where('mail', $mail)->first();

    $check_object = Letter::select('*')->get();

    //hou@gmail.com p ppppppp

    if($name) {//メールアドレスがあるとき

        foreach($check_object as $check=>$index) {//繰り返してデータ取得
               
            if(Hash::check($index->same, $name->random)) {
                Mail::to('seima0616@ezweb.ne.jp')
                    ->send(new MailTest($index->word)); //$index->word'
    
                return ['result' => true ];
            }
    
        }
    }
    

    return ['result' => false ];

    /*else {

        return ['result' => 'sdsd'];

    }*/




    /*if($name) {
        Mail::to('seima0616@ezweb.ne.jp')
		->send(new MailTest($check_word));

        return ['result' => 'dddddd'];
    } else {

        return ['result' => 'sdsd'];

    }*/

	


    }

    
}
