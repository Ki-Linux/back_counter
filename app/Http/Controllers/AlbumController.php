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

    public function store(Request $request)//リマインダーのデータを取ってくる
    {
        $album = new Album();

        $album->create([
            'username' => $request->username,
            'image' => $request->image,
            'selector' => $request->selector,
            'target' => $request->target,
            'present' => $request->present,
            'title' => $request->title,
        ]);

        return ["album" => true];

    }
}
