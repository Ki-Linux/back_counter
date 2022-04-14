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
}
