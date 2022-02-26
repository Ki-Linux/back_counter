<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//追加
use App\Http\Controllers\Controller;
use App\Models\Login;
//use App\Models\User;
use Hash;
use Illuminate\Validation\ValidationException;
//use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    public function login(Request $request)
    {
        $mail = $request->mail;
        $password = $request->password; 

        //$user = User::where('mail', $mail)->first();

        //$login = new Login();
        $item = Login::where('mail', $mail)->first();
        //$item = $login::where('mail', $reuqest->mail);
        //!Hash::check($password, $item->password
        
        if(!$item || $password != $item->password) {

            $request->validate([
                'mail' => 'required',
                'password' => 'required'
            ]);
            return ['token' => $item];

            //return 'パスワードが違います';
            

            /*return*/ 
           
            //$validator->errors()->merge('mail', 'メールが違うか、パスワードが違うか');
            //throw new ValidationException(['mail' => 'メールが違うか、パスワードが違うか']);

            /*$login->create([
                'mail' => $request->mail,
                'username' => "d",
                'password' => $request->password,
            ]);*/
            //return response()-json(['mail' => 'ui', 'password' => 'oi'],200);
        }
        
            $token = $item->createToken('token')->plainTextToken;
            return response()->json(compact('token'),200);

        /*$login->create([
            'mail' => $request->mail,
            'username' => "uidfvd",
            'password' => $request->password,
        ]);*/
        
        

    }

    public function index(Request $request)
    {
        /*$mail = $request->mail;
        $password = $request->password; 

        $login = new Login();
        $item = Login::where('mail', $mail)->first();
        return $item;*/
        //return ['ier' => 'weri'];
    }

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
        $login = new Login();
        $item = Login::where('mail', 'sei@gmail.com')->first(['mail']);
        //$item = $login::where('mail', $reuqest->mail);
        
        //if($item) {
            $login->create([
                'mail' => $request->mail,
                'username' => $request->username,
                'password' => $request->password,
            ]);
        //}
        

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
