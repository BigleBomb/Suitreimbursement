<?php
include('config.php');
session_start();
if(isset($_POST['reimburse_id']))
{
    $id = $_POST['reimburse_id'];
    $ch = curl_init();
    $token = $_SESSION['token'];
    curl_setopt($ch, CURLOPT_URL,"$SERVER/item/getbyreimburse/$id?token=".$token);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    $resp = json_decode($server_output);

    if($resp!=null){
        if($resp->success != false){
            echo $resp;
        }
        else{
            echo $resp->message;
        }
    }
    else{
        echo "Could not connect to the server";
    }
}
?>