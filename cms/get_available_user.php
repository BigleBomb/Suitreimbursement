<?php
    include('config.php');
    session_start();
    if(isset($_POST['project_id'])){
        $pid = $_POST['project_id'];
        $ch = curl_init();
        $token = $_SESSION['token'];
        curl_setopt($ch, CURLOPT_URL,"$SERVER/project/getavailableuser/$pid?token=$token");
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);

        if($resp!=null){
            if($resp->success == true){
                echo "<option selected='selected' value='' disabled hidden></option>";
                foreach($resp->result as $userlist){
                    $uid = $userlist->id;
                    $name = $userlist->nama;
                    echo "<option value=$uid>$name (UID:$uid)</option>";
                }
            }
            else
                echo "<option selected>$resp->message</option>";
        }
        else
            echo "Could not connect to server.";
    }
?>