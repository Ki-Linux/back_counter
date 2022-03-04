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

        $reminder = new Reminder();

        if($titlePost != "" && $contentPost != "") {

            $reminder->create([
                'title' => $titlePost,
                'content' => $contentPost,
            ]);
    
            return ['resTitle' => $titlePost, 'resContent' => $contentPost];
        }

        return ['resTitle' => 'can not send', 'resContent' => ''];
        
    }
}
