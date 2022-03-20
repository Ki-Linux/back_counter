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

        $pull_img = Account::where('username', $username)->get(['id', 'icon']);

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

        $select_data = Account::where('id', $id);
        $account_content = $select_data->get(['username', 'icon', 'comment']);

        $name = $account_content[0]->username;
        $icon = $account_content[0]->icon;
        $comment = $account_content[0]->comment;

        if($request->judgeNumber == 2) {

            $name = $request->changeContent;

        } else if($request->judgeNumber == 1) {
            $icon = $request->changeContent;
        } else {
            $comment = $request->changeContent;
        }

        $select_data
        ->update([
            'username' => $name,
            'icon' => $icon,
            'comment' => $comment,
        ]);

        return ['update_data', $name];
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
