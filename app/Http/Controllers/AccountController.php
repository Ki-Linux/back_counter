<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Controllers\Controller;
use \Symfony\Component\HttpFoundation\Response;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $response)
    {
        //
        $username = $response->accountName;

        $pull_img = Account::where('username', $username)->get(['id', 'icon', 'comment']);

        return ['img_data' => $pull_img];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $account = new Account();

        $account->create([
            'username' => 'hou',
            'icon' => 'icon',
            'comment' => 'thi is me',
            
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $select_data = Account::where('id', $id);//idからデータを選出
        $account_content = $select_data->get(['username', 'icon', 'comment']);

        $icon = $account_content[0]->icon;
        $name = $account_content[0]->username;
        $comment = $account_content[0]->comment;

        $number = $request->judgeNumber;

        //データによって変更を変える
        if($number == 0) {

            $icon = $request->changeContent;

        } else if($number == 1) {

            $name = $request->changeContent;

        } else {

            $comment = $request->changeContent;

        }

        $select_data
        ->update([
            'icon' => $icon,
            'username' => $name,   
            'comment' => $comment,
        ]);

        $judge_success = true;

        return ['select_comment' => $judge_success];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
