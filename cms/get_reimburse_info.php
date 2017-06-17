<?php
include('config.php');
session_start();
    if(isset($_POST['reimburse_id'])
    ){
        $id = $_POST['reimburse_id'];
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
                $project = $resp->result->nama_proyek;
                $date = $resp->result->tanggal;
                $type = $resp->result->jenis_pengeluaran;
                $total = $resp->result->jumlah_pengeluaran;
                $details = $resp->result->keterangan;
                $status = $resp->result->status;
                $reason = $resp->result->alasan;
                $update = $resp->result->updated_at;
                $statd;
                $color;
                switch($status){
                    case 0:
                        $statd = "Pending";
                        $color = 'orange';
                        break;
                    case 1:
                        $statd = "Accepted";
                        $color = 'green';
                        break;
                    case 2:
                        $statd = "Rejected";
                        $color = 'red';
                }
                foreach($resp->result->user_data as $user){
                    $name = $user->nama;
                    $limit = $user->limit;
                    $id = $user->id;
                    $email = $user->email;
                }
                echo "<div class='modal-body '>
					<table class='table'>";
                        if($status == 1){
                            echo "<div class='alert alert-success'>
                            This request was accepted on ".date_format(date_create($update), 'jS F, Y')."
                            </div>
                            ";
                        }
                        else if($status == 2){
                            echo "<div class='alert alert-danger'>
                            This request was rejected on ".date_format(date_create($update), 'jS F, Y')."
                            </div>
                            ";
                        }
                        echo "<h4>Requested by $name on ".date_format(date_create($date), 'jS F, Y')."</h4>
                        <p><i>$email</i></p>
                        <thead>
                            <th class='col-lg-3'></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>User ID</td>
                                <td>$id</td>
                            </tr>
                            <tr>
                                <td>Project</td>
                                <td>$project</td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td>$type</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>Rp. ".number_format($total, 0, ",", ".");
                                    if($total > $limit)
                                        echo "<p class='text-danger'> (Exceeding user's limit which is $limit)</a>";
                                echo "</td>
                            </tr>
                            <tr>
                                <td>Details</td>
                                <td>$details</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><font color=$color><b>$statd</b></font></td>
                            </tr>
                        </tbody>
                    </table>";

                    if($status == 0){
                        echo "
                        <div height='10px' width='10px'>
                            <h4>Pictures</h4>
                            <center><img src='images/photo_bg.jpg' style='max-height:50%; max-width:50%;'></img></center><br>
                            <h4>Reason for accepting/rejecting</h4>
                            <textarea id='reason' class='form-control' style='max-width: 100%; max-height: 100%;'></textarea>
                        </div>
						<div class='clearfix'></div></div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-success' id='accept'>Accept</button>
						<button type='button' class='btn btn-danger' id='reject'>Reject</button>
					</div>";
                    }else if($status == 1){
                        echo "
                        <div height='10px' width='10px'>
                            <h4>Pictures</h4>
                            <center><img src='images/photo_bg.jpg' style='max-height:50%; max-width:50%;'></img></center><br>
                            <h4>Reason of acceptance</h4>
                            <textarea readonly id='reason' class='form-control' style='max-width: 100%; max-height: 100%;'>$reason</textarea>
                        </div>";
                    }else if($status == 2){
                        echo "
                        <div height='10px' width='10px'>
                            <h4>Pictures</h4>
                            <center><img src='images/photo_bg.jpg' style='max-height:50%; max-width:50%;'></img></center><br>
                            <h4>Reason of rejection</h4>
                            <textarea readonly id='reason' class='form-control' style='max-width: 100%; max-height: 100%;'>$reason</textarea>
                        </div>";
                    }
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