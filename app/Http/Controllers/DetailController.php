<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Point;
use App\Models\Edit;
use App\Models\Reminder;
use App\Models\Report;
use App\Models\View;

class DetailController extends Controller
{
    //
    public function index(Request $response)
    {

        $id = $response->id_data;

        $name = $response->name_data;

        $my_name = $response->my_name;

        $get_icon = Account::where('username', $name)->get('icon');

        $get_can_comment_see = Edit::where('id', intval($id))
                                        ->get(['can_good', 'can_see', 'can_comment']);

        $get_point = [];

        if($get_can_comment_see[0]->can_good == 1) {//いいねを許可しているときだけいいねする

            $get_point = Point::where('edit_id', intval($id))->get('good_point');

        }

        $get_can_see = $get_can_comment_see[0]->can_see;
        $now_view = 0;

        if($get_can_see == 1) {//自分以外の閲覧をプラス1する

            $get_view = View::where('username', $name)
                                ->where('edit_id', intval($id))
                                ->get(['username', 'views']);

            $now_name = $get_view[0]->username;
            $now_view = $get_view[0]->views;

            if($my_name != $now_name) {

                $now_view++;

                View::where('username', $name)
                        ->where('edit_id', intval($id))
                        ->update([
                            'views' => $now_view,
                        ]);

            }

       }
        
        return['icon_data' => $get_icon, 'point_data' => $get_point, 'which_comment' => $get_can_comment_see, 'can_see' => $get_can_see, 'view_data' => $now_view];

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

        $can_report_good = Report::where('username', $get_post_name_comment[0]->username)
                                    ->where('good_or_comment', 'good')
                                    ->get('can_report');
                    
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
