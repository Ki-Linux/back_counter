<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Login;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        //$user = Login::all();
        return ['ier' => 'weri'];
    }
}
