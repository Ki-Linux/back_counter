<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Point;
use App\Models\Edit;
use App\Models\Reminder;
use App\Models\Report;

class DetailController extends Controller
{
    //
    public function index(Request $response)
    {

        $id = $response->id_data;

        $name = $response->name_data;


        $get_icon = Account::where('username', $name)->get('icon');

        $get_point = Point::where('edit_id', intval($id))->get('good_point');

        $get_can_comment = Edit::where('id', intval($id))->get('can_comment');
        

        return['icon_data' => $get_icon, 'point_data' => $get_point, 'which_comment' => $get_can_comment];

    }

    public function update(Request $request, $id)
    {

        $now_point = Point::where('edit_id', $id)->get('good_point');

        $now_good = $now_point[0]->good_point;

        $more_point = $now_good + 1;
        
        Point::where('edit_id', $id)
                            ->update([
                                'good_point' => $more_point,
                            ]);

                            
        $username = $request->username;

        $reminder = new Reminder();

        $get_post_name_comment = Edit::where('id', $id)->get(['username', 'my_comment']);


        $can_report_good = Report::where('edit_id', $id)->where('good_or_comment', 'good')->get('can_report');
                    
        if($username != $get_post_name_comment[0]->username && $can_report_good[0]->can_report == 1) {//他の人の投稿かつレポートをオンにしているとき
                    
            $set_title = $username.'さんからいいねがありました。';
            $set_content = $username.'さんから'.'「'.$get_post_name_comment[0]->my_comment.'」'.'の投稿にいいねがありました。';
            $set_name = $get_post_name_comment[0]->username;
                    
            $reminder->create([
                'title' => $set_title,
                'content' => $set_content,
                'username' => $set_name,
                'watched' => 0,
            ]);

        }
    }
}
