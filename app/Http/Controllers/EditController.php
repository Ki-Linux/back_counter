<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edit;

class EditController extends Controller
{
    //
    public function store(Request $response)
    {
        $edit = new Edit();

        $edit->create([
            'username' => $response->username,
            'picture' => $response->image,
            'can_list' => $response->can_list,
            'my_comment' => $response->comment,
            'can_good' => $response->show_good,
            'can_comment' => $response->others_comment,
            'can_see' => $response->can_see,
            'can_top' => $response->to_top,
        ]);

        return ["success" => "store_true"];
    }

    public function allData(Request $response) 
    {

        $skip_num = $response->contents_num;

        $pull_all = Edit::where('can_list', 1)->skip($skip_num)->take(4)->get();

        return ['allData' => $pull_all];

    }

    public function onlyTop(Request $response)
    {
        $pull_top = Edit::where('can_top', 1)->get(['picture', 'my_comment']);

        return ['topData' => $pull_top];
    }

    public function index(Request $response)
    {
        $edit = new Edit();

        $which_data = $response->id;
        $sql_data = 'id';
        $array_send_data = ['*'];

        

        if($response->username) {
           // $user_content = Edit::where('username', $response->username)->get(['id', 'picture', 'my_comment', 'updated_at']);
           $which_data = $response->username;
           $sql_data = 'username';
           $array_send_data = ['id', 'picture', 'my_comment', 'updated_at'];
        }

        $user_content = Edit::where($sql_data, $which_data)->get($array_send_data);


        return $user_content;
    }

    public function delete(Request $request, $id)
    {
        //$edit = new Edit();

        $user_content = Edit::where('id', $id)->delete();

        return $id;
    }

    public function update(Request $request, $id)
    {

        $user_content = Edit::where('id', $id)
                            ->update([
                                'picture' => $request->image,
                                'my_comment' => $request->comment,
                                'can_list' => $request->can_list,
                                'can_good' => $request->show_good,
                                'can_comment' => $request->others_comment,
                                'can_see' => $request->can_see,
                                'can_top' => $request->to_top,
                            ]);

    }
}
