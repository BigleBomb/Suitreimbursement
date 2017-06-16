<?php
include('config.php');
session_start();
    if(isset($_POST['user_id'])
    ){
        $id = $_POST['user_id'];
        $ch = curl_init();
        $token = $_SESSION['token'];
        curl_setopt($ch, CURLOPT_URL,"$SERVER/reimburse/get/$id?token=".$token);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output);


        if($resp != null){
            if ($resp->success == true){
                $nama = $resp->result->nama;
                $username = $resp->result->username;
                $email = $resp->result->email;
                $resp['result']=$result;
                
                echo "<table class='table'>
                    <thead class='text-primary'>
                    <th width=20px>RID</th>
                    <th class='col-lg-3'>Name</th>
                    <th width=250 align=left>Project name</th>
                    <th class='col-lg-1'>Type</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Note</th>
                </thead>";
                echo "<tbody><tr id='tr".$result['id']."'>
                <td>#".$result['id']."</td>
                <td>".$result['user_data']['nama']."</td>
                <td>".$result['nama_proyek']."</td>
                <td>".$result['jenis_pengeluaran']."</td>
                <td>".date_format(date_create($result['tanggal']), 'jS F\,\ Y')
                ."</td>
                <td>Rp ".number_format($result['jumlah_pengeluaran'], 0, ",", ".")."</td>
                <td>Rp ".$result['nama_proyek']."</td>
                 </tr></tbody></table>";
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