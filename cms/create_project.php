<?php
include('config.php');
session_start();
    if(isset($_POST['project_name'])
    ){
        $pnama = $_POST['project_name'];
        $date = $_POST['date'];
        $detail = $_POST['detail'];
        $token = $_SESSION['token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"$SERVER/project/create?token=$token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                "project_name=$pnama&date=$date&details=$detail");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);

        if($resp != null){
            $message = $resp->message;
            if ($resp->success==true){
                $password = $resp->pass; 
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