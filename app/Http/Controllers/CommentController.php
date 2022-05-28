<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Comment;
use App\Models\Report;
use App\Models\Edit;
use App\Models\Reminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class CommentController extends Controller
{
    //
    public function store(Request $response)
    {
        
        $comment = new Comment();
        $reminder = new Reminder();

        $username = $response->username;

        $comment->create([
            'edit_id' => $response->id_data,
            'other_comment' => $response->comment,
            'username' => $username,
        ]);

        $get_post_name_comment = Edit::where('id', $response->id_data)->get(['username', 'my_comment']);

        $can_report_comment = Report::where('username', $get_post_name_comment[0]->username)
                                        ->where('good_or_comment', 'comment')
                                        ->get('can_report');

        if($username != $get_post_name_comment[0]->username && $can_report_comment[0]->can_report == 1) {//他の人の投稿かつレポートをオンにしているとき

            $set_title = $username.'さんからコメントがありました。';
            $set_content = $username.'さんから'.'「'.$get_post_name_comment[0]->my_comment.'」'.'の投稿にコメントがあります。';
            $set_name = $get_post_name_comment[0]->username;

            $reminder->create([
                'title' => $set_title,
                'content' => $set_content,
                'username' => $set_name,
                'watched' => 0,
            ]);

        }

        return ["success" => $get_post_name_comment[0]->my_comment];
    }

    public function index(Request $response)
    {
        $id = $response->id_data;

        $get_pointed_comment = Comment::where('edit_id', intval($id))->get(['other_comment', 'username', 'updated_at']);


        $only_name_data = array();//重複したデータがない名前の配列

        for($i=0; $i < count($get_pointed_comment); $i++) {//名前が重複しないように配列に入れる

            $user_name = $get_pointed_comment[$i]->username;

            $get_pointed_comment[$i]->updated_at = $get_pointed_comment[$i]->updated_at->addHour(9);

            if(in_array($user_name, $only_name_data)) {

                continue;
            }

            array_push($only_name_data, $user_name);

        }

        $name_icon_array = array();

        for($j=0; $j < count($only_name_data); $j++) {//名前と画像の連想配列を作る

            $name = $only_name_data[$j];

            $get_image = Account::where("username", $only_name_data[$j])->get("icon");
            array_push($name_icon_array, ["username" => $name, "icon" => $get_image[0]->icon]);

        }

        return ['name_icon' => $name_icon_array, 'name_comment' => $get_pointed_comment];
    }

    public function delete(Request $request, $id)//commentを消す
    {

        Comment::where('edit_id', $id)
                    ->where('username', $request->username)
                    ->where('other_comment', $request->user_comment)
                    ->delete();

        return ['can_delete_or_report' => 'can_delete'];//削除できたことを知らせる

    }

    public function ui(Request $response)
    {
        $file_name = $response->file->getClientOriginalName();
        $response->file->storeAs('public/account/', $file_name);

        $account = new Account();

        $account->create([
            'username' => 'seima',
            'icon' => 'public/account/'.$file_name,
            'comment' => 'me',
        ]);

    }

}
