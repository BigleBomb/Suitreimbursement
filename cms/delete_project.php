<?php
include('config.php');
session_start();
    if(isset($_POST['project_id'])
    ){
        $id = $_POST['project_id'];
        $token = $_SESSION['token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"$SERVER/project/delete/$id?token=$token");
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);

        if($resp != null){
            $message = $resp->message;
            if ($resp->success==true){
                echo $message;
            }
            else {
                echo $message;
            }
        }
        else{
            echo "Could not connect to the server.";
        }
    }
?>