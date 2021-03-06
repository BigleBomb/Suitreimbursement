<?php
include('config.php');
session_start();
    if(isset($_POST['reimburse_id'])
    ){
        $id = $_POST['reimburse_id'];
        $reason = $_POST['reason'];
        $ch = curl_init();
        $token = $_SESSION['token'];
        curl_setopt($ch, CURLOPT_URL,"$SERVER/reimburse/accept/$id?token=$token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                "reason=$reason");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);

        if($resp != null){
            if ($resp->success == true){
                $message = $resp->message;

                echo "$message";
                $to = $email;
                $subject = "Reimburse Accepted";
                $txt = "Your reimbursement request with ID ".$id." has been accepted.";
                $headers = "From: noreply@vixelmedia.com";

                mail($to,$subject,$txt,$headers);
                
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