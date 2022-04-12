<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class DetailController extends Controller
{
    //
    public function index(Request $response)
    {

        $name = $response->name_data;

        $get_icon = Account::where('username', $name)->get('icon');

        return['icon_data' => $get_icon];

    }
}
