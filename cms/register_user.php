<?php
include('config.php');
    if(isset($_POST['nama'])
    ){
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $priv = $_POST['priv'];
        switch($priv){
            case "User":
                $priv = 1;
                break;
            case "Admin":
                $priv = 2;
                break;
            default:
                $priv = 1;
                break;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"$SERVER/user/register");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                "nama=$nama&username=$username&email=$email&privilege=$priv");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);

        if($resp != null){
            $message = $resp->message;
            if ($resp->success==true){
                $password = $resp->pass;

                echo $message;
                $to = $email;
                $subject = "Reimburse Account";
                $txt = "Username for your reimburse account is ".$username." and the password : ".$password;
                $headers = "From: noreply@vixelmedia.com" . "\r\n" .
                "CC: chrisnafc@gmail.com";

                mail($to,$subject,$txt,$headers);
                
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