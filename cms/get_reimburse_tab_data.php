<?php
    include('config.php');
    session_start();
    $ch = curl_init();
    $type = $_POST['type'];
    $token = $_SESSION['token'];
    $url = "$SERVER/reimburse/list/$type?token=".$token;
    $color;
    switch($type){
        case 'pending':
            $color = 'orange';
            break;
        case 'accepted':
            $color = 'green';
            break;
        case 'rejected':
            $color = 'red';
            break;
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    $resp = json_decode($server_output, true);
    if($resp['success'] != false){
        foreach($resp['result'] as $result){
            echo "<tr><tr id='tr".$result['id']."'>
                <td>#".$result['id']."</td>
                <td>".$result['user_data']['nama']."</td>
                <td>".$result['nama_proyek']."</td>
                <td>".$result['jenis_pengeluaran']."</td>
                <td>".date_format(date_create($result['tanggal']), 'jS F\,\ Y')
                ."</td>
                <td>Rp ".number_format($result['jumlah_pengeluaran'], 0, ",", ".")."</td>
                <td class='text-center'>
                <button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='$color'>More info</td>
            </tr>";
        }
    }
    else{
        echo "<tr><h4>".$resp['message']."</h4></tr>";
    }
?>