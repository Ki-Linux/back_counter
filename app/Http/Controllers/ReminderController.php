<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
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

        $reminder = Reminder::whereIn('username', [$userName, '*'])->get(['title', 'content']);
        //Letter::select('*')->get();

        return ['name' => $reminder];

    }
}
