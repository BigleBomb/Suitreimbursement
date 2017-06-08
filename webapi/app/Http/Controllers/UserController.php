<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    /**
     * Register new user
     *
     * @param $request Request
     */
    public function register(Request $request)
    {
        function randomPassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); 
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass);
        }

        $username = $request->input('username');
        $email = $request->input('email');
        $password = randomPassword();

        $register = User::create([
            'username'=> $username,
            'email'=> $email,
            'password'=> $password,
        ]);

        if ($register) {
            $res['success'] = true;
            $res['message'] = 'Success register! Your password is '.$password.' please change it immediately';

            return response($res);
        }else{
            $res['success'] = false;
            $res['message'] = 'Failed to register!';

            return response($res);
        }
    }

    /**
     * Get user by id
     *
     * URL /user/{id}
     */
    public function get_user(Request $request, $id)
    {
        $user = User::where('id', $id)->get();
        if ($user) {
              $res['success'] = true;
              $res['message'] = $user;
        
              return response($res);
        }else{
          $res['success'] = false;
          $res['message'] = 'Cannot find user!';
        
          return response($res);
        }
    }

    /*
     * Ganti password
     *
     * URL /changepass/{id}?password=
     */

    public function changepass(Request $request, $id)
    {
        $hasher = app()->make('hash');
        if($request->has('password')){
            if($request->has('oldpw')){
                $user = User::where('id', $id)->first();
                if($user){
                    if($user->password === $hasher->make($request->input('password'))){
                        $res['success'] = false;
                        $res['message'] = 'New password cannot be the same as the old one';

                        return response($res);
                    }
                    $user->password = $hasher->make($request->input('password'));
                    if($user->save()){
                        $res['success'] = true;
                        $res['message'] = 'Success updating password for user '.$id;

                        return response($res);
                    }else{
                        $res['success'] = false;
                        $res['message'] = 'Error saving the password';

                       return response($res);
                    }
                }else{
                    $res['success'] = false;
                    $res['message'] = 'User '.$id.' does not exist';

                    return response($res);
                }
            }else{
                $res['success'] = false;
                $res['message'] = "Please enter the old password.";

                return response($res);
            }
        }else{
            $res['success']  = false;
            $res['message'] = 'Please enter the new password';

            return response($res);
        }
    }
}