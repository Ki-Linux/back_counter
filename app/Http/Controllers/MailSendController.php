<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTest;
use App\Mail\MailReport;
use App\Mail\MailContact;
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

    public function send(Request $request) {
 
        $mail = $request->mail;

        $login = new Login();
        $letter = new Letter();

        $name = Login::where('mail', $mail)->first();

        $check_object = Letter::select('*')->get();

        if($name) {//メールアドレスがあるとき

            foreach($check_object as $check=>$index) {//繰り返してデータ取得
               
                if(Hash::check($index->same, $name->random)) {

                    Mail::to($mail)
                        ->send(new MailTest($index->word));
    
                    return ['result' => true ];
                }
    
            }
        }
    
        return ['result' => false ];

    }

    public function report(Request $request) 
    {

        $id = $request->id;
        $reported_name = $request->reported_name;
        $user_comment = $request->user_comment;
        $from_name = $request->from_name;
        $post_or_comment = $request->post_or_comment;

        $report_contents = [$id, $reported_name, $user_comment, $from_name, $post_or_comment];
            
        Mail::to('seima0616@ezweb.ne.jp')
            ->send(new MailReport($report_contents));
        
        return ['can_delete_or_report' => 'can_report'];

    }


    public function contact(Request $request) 
    {

        $content = $request->content;
        $address = $request->address;

        $contact_contents = [$content, $address];
            
        Mail::to('seima0616@ezweb.ne.jp')
            ->send(new MailContact($contact_contents));
        
        return ['can_contact' => true];

    }

    
}
