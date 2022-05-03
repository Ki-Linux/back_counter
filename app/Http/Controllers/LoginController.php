<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//追加
use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\Letter;
use App\Models\Account;
use App\Models\Report;
//use App\Models\User;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailConf;
//use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Mail;
//use App\Mail\TestEmail;
//use Log;
use Exception;
use Log;
//use SendGrid;
//use SendGrid\Mail;
use \Symfony\Component\HttpFoundation\Response;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    public function login(Request $request)
    {
        $mail = $request->mail;
        $password = $request->password; 

        //$user = User::where('mail', $mail)->first();

        //$login = new Login();
        $item = Login::where('mail', $mail)->first();
        //$user_name = Login::where('username', $mail)->first();
        //$item = $login::where('mail', $reuqest->mail);
        //!Hash::check($password, $item->password
        
        if(!$item || !Hash::check($password, $item->password)) {

            $request->validate([
                'mail' => 'required',
                'password' => 'required'
            ]);
            return ['token' => 'nothing'];

            //return 'パスワードが違います';
            

            /*return*/ 
           
            //$validator->errors()->merge('mail', 'メールが違うか、パスワードが違うか');
            //throw new ValidationException(['mail' => 'メールが違うか、パスワードが違うか']);

            /*$login->create([
                'mail' => $request->mail,
                'username' => "d",
                'password' => $request->password,
            ]);*/
            //return response()-json(['mail' => 'ui', 'password' => 'oi'],200);
        }

        //return ['token' => $item->username];
        
           

            $token = $item->createToken('token')->plainTextToken;
            return response()->json([compact('token'), 'username' => $item->username]);


        /*$login->create([
            'mail' => $request->mail,
            'username' => "uidfvd",
            'password' => $request->password,
        ]);*/
        
        

    }

    /*public function test() {
        $this->sendMail();
        return view('index');
    }*/

    /*public function sendMail(Request $request)
    {
        //$data = ['message' => 'この内容がTest Emailの下のpタグに書かれる'];
        //Mail::to('linuxseima@gmail.com')->send(new TestEmail($data));
        

        //return ['re' => $request];
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(getenv('FROM_EMAIL'), getenv('FROM_NAME'));
        $email->setSubject("test");
        $email->addTo('linuxseima@gmail.com');
 
        $sendGrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        $email->addContent(
            "text/plain",
            strval(
                view(
                    'emails/templates/notificationMail',
                    compact('data')
                )
            )
        );
        $email->addContent(
            "text/html",
            strval(
                view(
                    'emails/templates/notificationMail',
                    compact('data')
                )
            )
        );
         
        try {
            $sendGrid->send($email);
            return true;
        } catch (Exception $e) {
            echo $e;
            // Log::debug($e->getMessage());
            return false;
        }
    }*/

    public function index(Request $request)
    {
        $name = $request->username;

        $get_id = Login::where('username', $name)->get('id');

        return $get_id[0]->id;

    }

    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $mail = $request->mail;
        $userName = $request->username;
        $password = $request->password;
        $code = Str::random(3);

        $login = new Login();
        $letter = new Letter();
        $account = new Account();
        $report = new Report();
        //$item = Login::where('mail', 'sei@gmail.com')->first(['mail']);
        //$item = $login::where('mail', $reuqest->mail);
        $mail_name = Login::where('mail', $mail)->first();
        $user_name = Login::where('username', $userName)->first();

        if($mail_name) {

            return ['next_go' => 'not_one'];

        } else if($user_name) {

            return ['next_go' => 'not_two'];

        } else {

            $login->create([
                    'mail' => $mail,
                    'username' => $userName,
                    'password' => Hash::make($password),
                    'random' => Hash::make($code),
            ]);

            $push_now_id = Login::orderBy('created_at', 'desc')->first('id');//今入れた値のidを抽出

            foreach (['good', 'comment'] as $good_and_comment) {//goodとcommentを入れる

                $report->create([//いいねやコメントの報告、最初はyesにする
                    'username' => $userName,
                    'user_id' => $push_now_id->id,
                    'good_or_comment' => $good_and_comment,
                    'can_report' => 1,//1はyes, 0はno
                ]);

            }

            $letter->create([
                'same' => $code,
                'word' => $password,
            ]);

            $account->create([
                'username' => $userName,
                'icon' => 'not',
                'comment' => '',
            ]);

            Mail::to('seima0616@ezweb.ne.jp')
		        ->send(new MailConf($userName));

            return ['next_go' => 'yes'];

        }

    }

    public function only_check_password(Request $request)
    {

        $username = $request->username;
        $written_password = $request->password;

        $get_hashed_password = Login::where('username', $username)->get('password');

        $password_check = false;

        if(Hash::check($written_password, $get_hashed_password[0]->password)) {

            $password_check = true;

        }

            
        return $password_check;

    }

    public function get_user_info(Request $request)
    {

        $username = $request->username;
        $select_info = $request->clicked_num;

        $get_address_name = Login::where('username', $username)->get('mail');
        $get_report_contents = Report::where('username', $username)->get('can_report');
        $send_data;

        if($select_info == 0) {

            $send_data = $get_address_name[0]->mail;
            
        } else if($select_info == 2) {

            $send_data = $get_report_contents;//
        }

        return ['get_contents' => $send_data];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $username = $request->username;
        $written_password = $request->password;

        Login::where('username', $username)->where('id', $id)
                            ->update([
                                'password' => $written_password,
                            ]);

        //if($id === '1') {
            return ['change_password_success' => true];
       // }
        
    }

    public function post_reminder_update(Request $request, $id)
    {
        $username = $request->username;
        $yes_no = $request->yes_no;
        $good_or_comment = $request->good_or_comment;
        $push_name;

        if($good_or_comment == 0) {
            $push_name = 'good';
        } else if($good_or_comment == 1) {
            $push_name = 'comment';
        }

        Report::where('username', $username)->where('user_id', $id)->where('good_or_comment', $push_name)
                            ->update([
                                'can_report' => $yes_no,
                            ]);

        return ['update_reminder' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
