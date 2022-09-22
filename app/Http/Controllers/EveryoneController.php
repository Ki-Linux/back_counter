<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class EveryoneController extends Controller
{
    //
    public function index(Request $request)
    {
        $username = $request->username;
        $account_comment = Account::where('username', $username)->first('comment');
        
        return ['my_comment' => $account_comment];       
    }
}
