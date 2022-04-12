<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Point;

class DetailController extends Controller
{
    //
    public function index(Request $response)
    {

        $id = $response->id_data;

        $name = $response->name_data;


        $get_icon = Account::where('username', $name)->get('icon');

        $get_point = Point::where('edit_id', $id)->get('good_point');

        return['icon_data' => $get_icon, 'point_data' => $get_point];

    }
}
