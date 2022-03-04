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
            'username' => 'hou',
            'picture' => 'http://myho.com',
            'my_comment' => '私はサッカーが好きです。',
            'can_good' => 1,
            'can_comment' => 1,
            'can_see' => 1,
            'can_top' => 1,
        ]);
    }
}
