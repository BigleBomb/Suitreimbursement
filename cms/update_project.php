<?php
include('config.php');
session_start();
    if(isset($_POST['project_name']) && 
    isset($_POST['project_details']) &&
    isset($_POST['project_id']))
    {
        $name = $_POST['project_name'];
        $details = $_POST['project_details'];
        $id = $_POST['project_id'];
        $ch = curl_init();
        $token = $_SESSION['token'];
        curl_setopt($ch, CURLOPT_URL,"$SERVER/project/update/$id?token=$token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                "project_name=$name&project_details=$details");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);

        if($resp != null){
            if ($resp->success == true){
                echo $resp->message;;
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