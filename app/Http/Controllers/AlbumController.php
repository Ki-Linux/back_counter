<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Http\Controllers\Controller;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    //
    public function index(Request $request)//リマインダーのデータを取ってくる
    {

        $album = Album::where('username', $request->username)->get(['id', 'title', 'image', 'selector', 'target', 'present', 'created_at']);


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

        //前回のアイコンを削除
        $get_before_image = Album::where('id', $id)->get('image');

        Storage::delete('public/album/'.$get_before_image[0]->image);


        Album::where('id', $id)->delete();

        return ['can_delete' => true];//削除できたことを知らせる
    }
}
