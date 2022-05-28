<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//追加
use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\Letter;
use App\Models\Account;
use App\Models\Report;
use App\Models\Name;
use App\Models\Token;

use Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailConf;

use Exception;
use Log;
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

        $item = Login::where('mail', $mail)->first();
        
        if(!$item || !Hash::check($password, $item->password)) {

            $request->validate([
                'mail' => 'required',
                'password' => 'required'
            ]);

            return ['divided_data' => 'nothing'];

        }

        $token_box = new Token();
        $name = new Name();
           

        $token = $item->createToken('token')->plainTextToken;

        $divide_content = str_split($token, mb_strlen($token) / 2);

        $token_box->create([
            'account_id' => $item->id,
            'token' => Hash::make($token),
        ]);

        $name->create([
            'account_id' => $item->id,
            'front' => $divide_content[0],
        ]);

        return response()->json(['divided_data' => $divide_content[1], 'username' => $item->username]);
        
    }

    public function confirm_token(Request $request)
    {

        $name = $request->username;
        $divided_back = substr($request->divided_back, 25);

        $get_id = Login::where('username', $name)->get('id');

        $get_front = Name::where('account_id', $get_id[0]->id)->orderBy('id', 'desc')->first('front');


        $get_hashed = Token::where('account_id', $get_id[0]->id)->orderBy('id', 'desc')->first('token');

        $united = $get_front->front.$divided_back;

        $token_check = false;

        if(Hash::check($united, $get_hashed->token)) {

            $token_check = true;

        }
        
        return $token_check;

    }

    public function delete(Request $request, $id)//commentを消す
    {

        Name::where('account_id', $id)->delete();

        Token::where('account_id', $id)->delete();

        return ['logout' => true];

    }

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

        $mail_name = Login::where('mail', $mail)->get('id');
        $user_name = Login::where('username', $userName)->get('id');

        if(count($mail_name) != 0) {

            return ['next_go' => 'not_one'];

        } else if(count($user_name) != 0) {

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
                'comment' => 'コメントはありません',
            ]);

            Mail::to($mail)
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

            $send_data = $get_report_contents;
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

        $check_object = Letter::select('*')->get();

        $name = Login::where('id', $id)->first('random');

        foreach($check_object as $check=>$index) {//繰り返してデータ取得
               
            if(Hash::check($index->same, $name->random)) {

                Letter::where('same', $index->same)
                        ->update([
                            'word' => $written_password
                        ]);

            }
    
        }


        Login::where('username', $username)
                ->where('id', $id)
                ->update([
                    'password' => Hash::make($written_password),
                ]);


        return ['change_password_success' => true];
        
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

        Report::where('username', $username)
                ->where('user_id', $id)
                ->where('good_or_comment', $push_name)
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