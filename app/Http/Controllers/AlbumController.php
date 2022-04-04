<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Http\Controllers\Controller;
use \Symfony\Component\HttpFoundation\Response;

class AlbumController extends Controller
{
    //
    public function index(Request $request)//リマインダーのデータを取ってくる
    {


     $data = Album::all();

        return ['name' => $data];

    }
}
