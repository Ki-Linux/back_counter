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
}
