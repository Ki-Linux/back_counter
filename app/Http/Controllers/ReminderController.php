<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Login;//
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\Response;

class ReminderController extends Controller
{

    //
    public function store(Request $request) 
    {
        $titlePost = $request->title;
        $contentPost = $request->content;
        $userPost = $request->username;

        $reminder = new Reminder();

        if($titlePost != "" && $contentPost != "" && $userPost != "") {

            if($userPost === "*") {

                $logins_username = Login::select('*')->get();
                foreach($logins_username as $login_username=>$index) {
                    $reminder->create([
                        'title' => $titlePost,
                        'content' => $contentPost,
                        'username' => $index->username,
                    ]);
                    //return ['resContent' => $index];
                }
                
            }

            $reminder->create([
                'title' => $titlePost,
                'content' => $contentPost,
                'username' => $userPost,
            ]);
    
            return ['resTitle' => $titlePost, 'resContent' => $contentPost, 'resName' => $userPost];
        }

        return ['resTitle' => 'can not send', 'resContent' => '', 'resName' => ''];
        
    }

    public function index(Request $request)//リマインダーのデータを取ってくる
    {

        $userName = $request->username;


        $reminder = Reminder::where('username', $userName)->get(['title', 'content', 'updated_at']);
     

        return ['name' => $reminder];

    }
}
