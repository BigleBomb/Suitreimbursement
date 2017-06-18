<?php
include('config.php');
session_start();
    if(isset($_POST['user_id'])
    ){
        $id = $_POST['user_id'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $limit = $_POST['limit'];
        $ch = curl_init();
        $token = $_SESSION['token'];
        curl_setopt($ch, CURLOPT_URL,"$SERVER/user/update/$id?token=$token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                "name=$name&username=$username&email=$email&limit=$limit");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);

        if($resp != null){
            if ($resp->success == true){
                $message = $resp->message;

                echo "$message";
            }
            else {
                echo $resp->message;
            }
        }
        else{
                echo "Could not connect to the server";
        }
    }
?>