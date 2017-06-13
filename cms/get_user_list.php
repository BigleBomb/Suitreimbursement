<?php
session_start();
include('config.php');
    $ch = curl_init();

    $token = $_SESSION['token'];
    $url = "$SERVER/users?token=".$token;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    $resp = json_decode($server_output, true);
    if($resp!=null){
        foreach($resp['result'] as $result){
            echo "<tr id='tr".$result['id']."'>
                <td>#".$result['id']."</td>
                <td>".$result['nama']."</td>
                <td>".$result['email']."</td>
                <td>".date_format(date_create($result['created_at']), 'jS F\,\ Y')."</td>
                <td class='text-center'><button type='button' class='btn btn-primary modify-user' data-toggle='modal'>Modify<span><button type='button' class='btn btn-primary delete-user' data-toggle='modal'>Delete</td>
            </tr>";
        }
    }
    else{
        echo "Data not found";
    }
?>