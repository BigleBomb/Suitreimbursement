<?php
include('config.php');
session_start();
if(isset($_POST['reimburse_id']))
{
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
            $project = $resp->result->reimburse_data->project_name;
            $date = $resp->result->date;
            // $total = $resp->result->total_cost;
            // $details = $resp->result->details;
            $status = $resp->result->status;
            $reason = $resp->result->reason;
            // $update = $resp->result->updated_at;
            // $item_data = $resp->result->item_data;
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
                $uid = $user->id;
                $email = $user->email;
            }
            echo "<div class='content'>
                <div class='row'>
                <div class='col-md-12'>";
                    if($status == 1){
                        echo "
                        <div class='alert alert-success'>
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
                    echo "
                    <div class='card'> 
                        <div class='card-header' data-background-color='orange'>
                            <h4 class='title'>Requested by <strong>$name</strong> on ".date_format(date_create($date), 'jS F, Y')."</h4>
                            <p class='category'><i>$email</i></p>
                        </div>
                        <div class='card-content'>
                            <div class='container'>
                            <div class='row'>
                            <div class='col-lg-6'>
                            <h4>Reimburse detail</h4>
                            <table class='table'>
                                <thead style='visibility:hidden'>
                                    <th class='col-lg-3'>header</th>
                                    <th>header</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>User ID</td>
                                        <td>$uid</td>
                                    </tr>
                                    <tr>
                                        <td>Project</td>
                                        <td>$project</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>Rp. ".number_format($total, 0, ",", ".");
                                            if($total > $limit)
                                                echo "<p class='text-danger'> (Exceeding user's limit which is ".number_format($limit, 0, ",", ".").")</a>";
                                        echo "</td>
                                    </tr>
                                    <tr>
                                        <td>Reason</td>
                                        <td>$reason</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><font color=$color><b>$statd</b></font></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <div class='col-lg-6'>
                            <h4>Pictures</h4>
                            <div class='row'>";
                            if($item_data!=null){
                                foreach($item_data as $item){
                                    echo "<div class=col-md-4'>
                                            <a href='#' class='thumbnail'>
                                                <img src='$imageroot/u$uid/r$id/$item->picture' alt='...'>
                                            </a>
                                        </div>";
                                }   
                            }
                            else{
                                echo "<div align=center>No pictures found</div>";
                            }
                            echo "</tbody>
                            </table>
                            </div>
                            </div>
                            </div>
                        <div>
                            <h4>Pictures</h4>
                            <div class='row'>";
                            if($item_data!=null){
                                foreach($item_data as $item){
                                    echo "<div class=col-xs-3 col-md-3'>
                                            <a href='#' class='thumbnail'>
                                                <img src='$imageroot/u$uid/r$id/$item->picture' alt='...'>
                                            </a>
                                        </div>";
                                }   
                            }
                            else{
                                echo "<div align=center>No pictures found</div>";
                            }
                        echo "</div>
                            <h4>Reason</h4>";

                if($status == 0){
                    echo "
                        <textarea id='reason' placeholder='Enter a reason to either accept or reject the request' class='form-control' style='max-width: 100%; max-height: 100%;'></textarea>
                    </div>
                    <div class='clearfix'></div></div>
                    <div class='card-footer' align='right'>
                        <button type='button' style='float:left;' class='btn' id='back-to-project'><i class='material-icons'>arrow_back</i>  Back</button>
                        <button type='button' class='btn btn-success' id='accept'>Accept</button>
                        <button type='button' class='btn btn-danger' id='reject'>Reject</button>
                    </div>";
                }else if($status == 1){
                    echo "<textarea readonly id='reason' class='form-control' style='max-width: 100%; max-height: 100%;' disabled>$reason</textarea>
                    </div>
                    <div class='card-footer'>
                        <button type='button' style='float:left;' class='btn' id='back-to-project'><i class='material-icons'>arrow_back</i>  Back</button>
                    </div>";
                }else if($status == 2){
                    echo "<textarea readonly id='reason' class='form-control' style='max-width: 100%; max-height: 100%;' disabled>$reason</textarea>
                    </div>
                    <div class='card-footer'>
                        <button type='button' style='float:left;' class='btn' id='back-to-project'><i class='material-icons'>arrow_back</i>  Back</button>
                    </div>";
                }
                echo "</div></div></div>";
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