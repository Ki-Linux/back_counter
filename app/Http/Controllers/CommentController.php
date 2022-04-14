<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    //
    public function store(Request $response)
    {
        $comment = new Comment();

        $comment->create([
            'edit_id' => $response->id_data,
            'other_comment' => $response->comment,
            'username' => $response->username,
        ]);


        return ["success" => 'ui'];
    }

    public function index(Request $response)
    {
        $id = $response->id_data;

        $get_pointed_comment = Comment::where('edit_id', $id)->get(['other_comment', 'username']);

        $only_name_data = array();//重複したデータがない名前の配列

        for($i=0; $i < count($get_pointed_comment); $i++) {//名前が重複しないように配列に入れる

            $user_name = $get_pointed_comment[$i]->username;

            if(in_array($user_name, $only_name_data)) {

                continue;

            }
            array_push($only_name_data, $user_name);
        }

        $name_icon_array = array();

        for($j=0; $j < count($only_name_data); $j++) {//名前と画像の連想配列を作る
            array_push($name_icon_array, ["username" => $get_pointed_comment[$j]->username, "icon" => $j]);
        }



        return ['name_icon' => $name_icon_array, 'name_comment' => $get_pointed_comment];
    }
}
