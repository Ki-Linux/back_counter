<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edit;
use App\Models\Account;
use App\Models\Point;
use App\Models\Comment;
use App\Models\View;

use Illuminate\Support\Facades\Storage;

class EditController extends Controller
{
    //
    public function store(Request $response)
    {

        $default_or_selected = $response->default_or_selected;
        $username = $response->username;
        $file = $response->file;
        $storage = Storage::disk('s3');

        $post_file = $file;

        if($file != 'notImg') {

            if($default_or_selected == 'true') {

                $post_file = $storage->putFile('post', $file, 'public');
    
            } else {
    
                $del_directory = str_replace('counter/', '', $file);
            
                $storage->copy('counter/'.$del_directory, 'post/'.$del_directory);
                $post_file = 'post/'.$del_directory;

            }

        }

        $edit = new Edit();
        $point = new Point();
        $view = new View();

        $edit->create([
            'username' => $response->username,
            'picture' => $post_file,
            'can_list' => $response->can_list,
            'my_comment' => $response->comment,
            'can_good' => $response->show_good,
            'can_comment' => $response->others_comment,
            'can_see' => $response->can_see,
            'can_top' => $response->to_top,
        ]);

        $push_now_id = Edit::orderBy('created_at', 'desc')->first('id');//今入れた値のidを抽出

        if($response->show_good == 1) {
            $point->create([
                'edit_id' => $push_now_id->id,
                'good_point' => 0
            ]);
        }

        if($response->can_see == 1) {
            $view->create([
                'username' => $response->username,
                'edit_id' => $push_now_id->id,
                'views' => 0,
            ]);
        }
        
        return ["success" => "store_true"];
    }

    public function allData(Request $response) 
    {

        $skip_num = $response->contents_num;

        $pull_all = Edit::where('can_list', 1)
                            ->orderBy('updated_at', 'desc')
                            ->limit(4)
                            ->offset($skip_num)
                            ->get(['id', 'username', 'picture', 'my_comment', 'updated_at']);

        if(count($pull_all) > 0) {
            
            for($i=0; $i < count($pull_all); $i++) {

                $pull_all[$i]->updated_at = $pull_all[$i]->updated_at->addHour(9);

            }
        }

        $last_num = false;

        if(count($pull_all) != 4) {
            $last_num = true;
        }

        return ['allData' => $pull_all, 'last_number' => $last_num];

    }

    public function onlyTop(Request $response)
    {
        $pull_top = Edit::where('can_top', 1)->get(['picture', 'my_comment']);

        return ['topData' => $pull_top];
    }

    public function index(Request $response)
    {

        $edit = new Edit();

        $sql_data;
        $reference_data;
        $array_send_data;
    

        if($response->target == 'list') {

           $sql_data = 'username';
           $reference_data = $response->username;
           $array_send_data = ['id', 'picture', 'my_comment', 'can_see', 'created_at'];

        } else if($response->target == 'edit') {

            $sql_data = 'id';
            $reference_data = $response->id;
            $array_send_data = [
                'id', 
                'username', 
                'picture', 
                'my_comment', 
                'can_top', 
                'can_see', 
                'can_list', 
                'can_good', 
                'can_comment', 
                'created_at'
            ];

        }

        $user_content = Edit::where($sql_data, $reference_data)
                            ->orderBy('created_at', 'desc')
                            ->get($array_send_data);

        return ['contents' => $user_content];
    }

    public function delete(Request $request, $id)
    {
        //削除
        $storage = Storage::disk('s3');

        $get_delete_image = Edit::where('id', $id)->get('picture');

        $image_data = $get_delete_image[0]->picture;

        $data_exist = $storage->exists($image_data);

        if($data_exist) {

            $storage->delete($image_data);

        }

        Edit::where('id', $id)->delete();

        $delete_sql = [new Point(), new View(), new Comment()];

        foreach($delete_sql as $sql) {

            $sql->where('edit_id', $id)->delete();

        }
        
        return ["can_delete" => true];

    }

    public function post_update(Request $response)
    {

        $default_or_selected = $response->default_or_selected;
        $username = $response->username;
        $id = $response->id;
        $file = $response->file;
        $storage = Storage::disk('s3');

        $post_file = $file;

        if($default_or_selected == 'true') {

            $post_file = $storage->putFile('post', $file, 'public');

        }

        $before_image = Edit::where('id', intval($id))->get('picture');

        if($before_image[0]->picture != $post_file) {

           $storage->delete($before_image[0]->picture);
            
        }
        
        Edit::where('id', intval($id))
                ->update([
                    'username' => $response->username,
                    'picture' => $post_file,
                    'my_comment' => $response->comment,
                    'can_good' => $response->show_good,
                    'can_comment' => $response->others_comment,
                    'can_see' => $response->can_see,
                    'can_top' => $response->to_top,
                    'can_list' => $response->can_list, 
                ]);

        return["success" => "update_true"];

    }
}

