<?php
include('config.php');
session_start();
    if(isset($_POST['user_id'])
    ){
        $id = $_POST['user_id'];
        $ch = curl_init();
        $token = $_SESSION['token'];
        curl_setopt($ch, CURLOPT_URL,"$SERVER/user/get/$id?token=$token");
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);


        if($resp != null){
            if ($resp->success == true){
                $id = $resp->result->id;
                $nama = $resp->result->nama;
                $username = $resp->result->username;
                $email = $resp->result->email;
                $limit = $resp->result->limit;
                echo "<table class='table'>
                        <thead>
                            <th class='col-md-5'></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>User ID</td>
                                <td>$id</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td id='tdName'>$nama
                                    <button id='btnuser' type='button' rel='tooltip' class='btn btn-primary btn-simple btn-xs buttonedit'>
										<i class='material-icons'>edit</i>
									</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td id='tdUsername'>$username
                                    <button id='btnuser' type='button' rel='tooltip' class='btn btn-primary btn-simple btn-xs buttonedit'>
										<i class='material-icons'>edit</i>
									</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td id='tdEmail'>$email
                                    <button type='button' rel='tooltip' class='btn btn-primary btn-simple btn-xs buttonedit'>
										<i class='material-icons'>edit</i>
									</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Limit</td>
                                <td id='tdLimit'>".number_format($limit, 0, ",", ".")."
                                    <button type='button' rel='tooltip' class='btn btn-primary btn-simple btn-xs buttonedit'>
										<i class='material-icons'>edit</i>
									</button>
                                </td>
                            </tr>
                        </tbody>";
            }
            else {
                echo "Failed to get user id";
            }
        }
        else{
                echo "Could not connect to server";
        }
    }
?>