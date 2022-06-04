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

        if(count($album) > 0) {

            for($i=0; $i < count($album); $i++) {

                $album[$i]->created_at = $album[$i]->created_at->addHour(9);

            }
        }

        return ['album_content' => $album];

    }

    public function store(Request $request)//リマインダーのデータを取ってくる
    {
        $default_or_selected = $request->default_or_selected;

        $file = $request->file;

        $post_file;

        $storage = Storage::disk('s3');

        if($default_or_selected == 'true') {

            $post_file = $storage->putFile('album', $file, 'public');
        //request()->file->storeAs('public'.$album_or_post, $file_name);

        } else {

            $del_directory = str_replace('counter/', '', $file);
        
            $storage->copy('counter/'.$del_directory, 'album/'.$del_directory);

            $post_file = 'album/'.$del_directory;
            //Storage::copy('public/counter/'.$move_file_name, 'public'.$album_or_post.$move_file_name);
        }

        $album = new Album();

        $album->create([
            'username' => $request->username,
            'image' => $post_file,
            'selector' => $request->selector,
            'target' => $request->target,
            'present' => $request->present,
            'title' => $request->title,
        ]);

        return true;

    }

    public function delete(Request $request, $id)//データを消す
    {

        //前回のアイコンを削除
        $get_before_image = Album::where('id', $id)->get('image');

        $storage = Storage::disk('s3');

        $storage->delete($get_before_image[0]->image);

        Album::where('id', $id)->delete();

        return ['can_delete' => true];//削除できたことを知らせる
    }
}
