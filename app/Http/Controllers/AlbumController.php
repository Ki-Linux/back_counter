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

        $album = Album::where('username', $request->username)->get(['id', 'title', 'image', 'selector', 'target', 'present']);


        return ['album_content' => $album];

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

        return true;

    }

    public function delete(Request $request, $id)//データを消す
    {
        //$edit = new Edit();

        Album::where('id', $id)->delete();

        return ['can_delete' => true];//削除できたことを知らせる
    }
}
