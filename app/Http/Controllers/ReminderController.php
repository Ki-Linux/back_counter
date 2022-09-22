<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Login;
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

        if($titlePost != "" && $contentPost != "") {
            if($userPost === "*") {
                $logins_username = Login::select('*')->get();
                foreach($logins_username as $login_username=>$index) {
                    $reminder->create([
                        'title' => $titlePost,
                        'content' => $contentPost,
                        'username' => $index->username,
                        'watched' => 0,
                    ]);                 
                }

                return ['resTitle' => $titlePost, 'resContent' => $contentPost, 'resName' => 'name'];                
            }

            $reminder->create([
                'title' => $titlePost,
                'content' => $contentPost,
                'username' => $userPost,
                'watched' => 0,
            ]);
    
            return ['resTitle' => $titlePost, 'resContent' => $contentPost, 'resName' => $userPost];
        }

        return ['resTitle' => 'can not send', 'resContent' => '', 'resName' => ''];        
    }

    public function index(Request $request)//リマインダーのデータを取ってくる
    {

        $userName = $request->username;
        $reminder = Reminder::where('username', $userName)
                                ->get(['id', 'title', 'content', 'watched','updated_at']);
     
        if(count($reminder) > 0) {
            for($i=0; $i < count($reminder); $i++) {
                $reminder[$i]->updated_at = $reminder[$i]->updated_at->addHour(9);        
            }
        }
        
        return ['name' => $reminder];
    }

    public function update(Request $request, $id)
    {
        $user_content = Reminder::where('id', $id)
                            ->update([
                                'watched' => $request->change_watched,                             
                            ]);
        return $id;
    }

    public function delete(Request $request, $id)
    {
        Reminder::where('id', $id)->delete();
        return true;
    }
}
