<?php
    include('config.php');
    session_start();
    if(isset($_POST['user_id']) && isset($_POST['project_id'])){
        $project_id = $_POST['project_id'];
        $user_id = $_POST['user_id'];
        $ch = curl_init();
        $token = $_SESSION['token'];
        curl_setopt($ch, CURLOPT_URL,"$SERVER/project/deleteuser?token=$token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                "user_id=$user_id&project_id=$project_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);

        if($resp!=null){
            if($resp->success == true)
                echo $resp->message;
            else
                echo $resp->message;
        }
        else
            echo "Could not connect to server.";
    }
?>