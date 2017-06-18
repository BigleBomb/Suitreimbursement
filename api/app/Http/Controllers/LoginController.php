<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Index login controller
     *
     * When user success login will retrive callback as api_token
     */
    public function index(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $login = User::where('email', $email)->first();
        if (!$login) {
            $res['success'] = false;
            $res['message'] = 'Your email or password incorrect!';

            return response($res);
        }else{
            if (Hash::check($password, $login->password)) {
                $api_token = sha1(time());
                $create_token = User::where('id', $login->id)->update(['token' => $api_token]);
                $user = User::where('id', $login->id)->first();
                if ($create_token) {
                    $res['success'] = true;
                    $res['user_data'] = $user;

                    return response($res);
                }
            }else{
                $res['success'] = false;
                $res['message'] = 'You email or password incorrect!';

                return response($res);
            }
        }
    }
}