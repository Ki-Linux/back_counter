<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edit;
use App\Models\Account;
use App\Models\Point;
use App\Models\Report;
use App\Models\View;

class EditController extends Controller
{
    //
    public function store(Request $response)
    {
        $edit = new Edit();
        $point = new Point();
        $report = new Report();
        $view = new View();

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

        $push_now_id = Edit::orderBy('created_at', 'desc')->first('id');//今入れた値のidを抽出

        foreach (['good', 'comment'] as $good_and_comment) {//goodとcommentを入れる

            $report->create([//いいねやコメントの報告、最初はyesにする
                'username' => $response->username,
                'edit_id' => $push_now_id->id,
                'good_or_comment' => $good_and_comment,
                'can_report' => 1,//1はyes, 0はno
            ]);

        }

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

        $pull_all = Edit::where('can_list', 1)->orderBy('updated_at', 'desc')->limit(4)->offset($skip_num)->get(['id', 'username', 'picture', 'my_comment', 'updated_at']);

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

        //if($response->target == 'edit') {
            $sql_data;
            $reference_data;
            $array_send_data;
    

        if($response->target == 'list') {
           // $user_content = Edit::where('username', $response->username)->get(['id', 'picture', 'my_comment', 'updated_at']);
           $sql_data = 'username';
           $reference_data = $response->username;
           $array_send_data = ['id', 'picture', 'my_comment', 'can_see', 'created_at'];

        } else if($response->target == 'edit') {

            $sql_data = 'id';
            $reference_data = $response->id;
            $array_send_data = ['id', 'username', 'picture', 'my_comment', 'can_top', 'can_see', 'can_list', 'can_good', 'can_comment'];

        }

        $user_content = Edit::where($sql_data, $reference_data)->get($array_send_data);


        return ['contents' => $user_content];
    }

    public function delete(Request $request, $id)
    {
        //$edit = new Edit();

        $user_content = Edit::where('id', $id)->delete();

        return $id;
    }

    public function update(Request $request, $id)
    {

        /*$user_content = Edit::where('id', intval($id))
                            ->update([
                                'username' => $request->username,
                                'picture' => $request->image,
                                'my_comment' => $request->comment,
                                'can_good' => $request->show_good,
                                'can_comment' => $request->others_comment,
                                'can_see' => $request->can_see,
                                'can_top' => $request->to_top,
                                'can_list' => $request->can_list, 
                            ]);*/

        /*if($request->can_see == 1) {//この投稿の閲覧数を表示するときは閲覧数データ作る
            $view = new View();

            $view->create([
                'username' => 'towa',
                'edit_id' => $id,
                'views' => 0,
            ]);
        } else {//この投稿の閲覧数を表示しないときは閲覧数データ消す
            View::where('edit_id', $id)->delete();
        }*/

        return['ui' => $request->image];
        //あとでやる

        /*if($request->show_good == 1) {
            Point::where('edit_id', $id)
                            ->update([
                                'picture' => $request->image,
                                'my_comment' => $request->comment,
                                'can_list' => $request->can_list,
                                'can_good' => $request->show_good,
                                'can_comment' => $request->others_comment,
                                'can_see' => $request->can_see,
                                'can_top' => $request->to_top,
                            ]);
        }*/

    }
}
