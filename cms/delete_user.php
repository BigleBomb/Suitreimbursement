<?php
include('config.php');
session_start();
    if(isset($_POST['user_id'])
    ){
        $id = $_POST['user_id'];
        $ch = curl_init();
        $token = $_SESSION['token'];
        curl_setopt($ch, CURLOPT_URL,"$SERVER/user/delete/$id?token=$token");
        curl_setopt($ch, CURLOPT_POST, 0);
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
                echo "Failed to get user id";
            }
        }
        else{
                echo "Could not connect to the server";
        }
    }
?>