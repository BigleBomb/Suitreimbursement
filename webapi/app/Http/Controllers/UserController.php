<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Register new user
     *
     * @param $request Request
     */
    public function register(Request $request)
    {
        function test(){
            
        }
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

    public function set(Request $request, $menu, $id){
        if($menu === 'nama'){
            if($request->has('nama')){
                $nama = $request->input('nama');
                $user = User::where('id', $id)->first();
                if($user){
                    $user->nama = $nama;
                    if($user->save()){
                        $res['success'] = true;
                        $res['message'] = 'User id '.$id.' name has been changed';

                        return response($res);                        
                    }
                    else{
                        $res['success'] = false;
                        $res['message'] = 'Error updating id '.$id.' name';

                        return response($res);
                    }
                }
                else{
                    $res['success'] = false;
                    $res['message'] = 'Invalid user';

                    return response($res);
                }
            }
        }
        else if($menu === 'privillege'){
            if($request->has('level')){
                $priv = $request->input('level');
                $user = User::where('id', $id)->first();
                if($user){
                    $user->privilege = $priv;
                    if($user->save()){
                        $res['success'] = true;
                        $res['message'] = 'Privilliges for '.$user->username.' has been updated';
                    
                        return response($res);
                    }
                    else{
                        $res['success'] = false;
                        $res['message'] = 'Failed updating privilleges';

                        return response($res);
                    }
                }
                else{
                    $res['success'] = false;
                    $res['message'] = 'Unknown user id';
                }
            }
        }
        else if($menu === 'email'){
            if($request->has('email')){
                $email = $request->input('email');
                $user = User::where('id', $id)->first();
                if($user){
                    $user->email = $email;
                    if($user->save()){
                        $res['success'] = true;
                        $res['message'] = 'Email for id '.$id.' changed';

                        return response($res);
                    }
                    else{
                        $res['success'] = false;
                        $res['message'] = 'Error changing email for id '.$id;

                        return response($res);
                    }
                }
                else{
                    $res['success'] = false;
                    $res['message'] = 'Invalid user id';

                    return response($res);
                }
            }else{
                $res['success'] = false;
                $res['message'] = 'Please enter the email';

                return response($res);
            }
        }
        else if($menu === 'password'){
            if($request->has('password')){
                if($request->has('oldpw')){
                    $pass = $request->input('password');
                    $oldpw = $request->input('oldpw');
                    $user = User::where('id', $id)->first();
                    if(Hash::check($oldpw, $user->password)){
                        if($user){
                            if(Hash::check($pass, $user->password)){
                                $res['success'] = false;
                                $res['message'] = 'New password cannot be the same as the old one';

                                return response($res);
                            }
                            else{
                                $user->password = Hash::make($pass);
                                if($user->save()){
                                    $res['success'] = true;
                                    $res['message'] = 'Success updating password for user '.$id;

                                    return response($res);
                                }else{
                                    $res['success'] = false;
                                    $res['message'] = 'Error saving the password';

                                return response($res);
                                }
                            }
                        }else{
                            $res['success'] = false;
                            $res['message'] = 'User '.$id.' does not exist';

                            return response($res);
                        }
                    }
                    else{
                        $res['success'] = false;
                        $res['message'] = 'Old password is wrong';

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
        else{
            $res['success'] = false;
            $res['message'] = 'Invalid menu';

            return response($res);
        }
    }
}