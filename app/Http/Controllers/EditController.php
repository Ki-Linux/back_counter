<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edit;

class EditController extends Controller
{
    //
    public function store(Request $response)
    {
        $edit = new Edit();

        $edit->create([
            'username' => $response->username,
            'picture' => $response->image,
            'my_comment' => $response->comment,
            'can_good' => $response->show_good,
            'can_comment' => $response->others_comment,
            'can_see' => $response->can_see,
            'can_top' => $response->to_top,
        ]);
    }

    public function index(Request $response)
    {
        $edit = new Edit();

        $user_content = Edit::where('username', $response->username)->get(['id', 'picture', 'my_comment', 'updated_at']);

        return $user_content;
    }

    public function delete(Request $request, $id)
    {
        //$edit = new Edit();

        $user_content = Edit::where('id', $id)->delete();

        return $id;
    }
}
