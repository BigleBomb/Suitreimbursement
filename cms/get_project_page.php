<?php
    include('config.php');
    session_start();
    if(isset($_SESSION['token'])){
        echo "<div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='card-header' data-background-color='orange'>
                        <h4 class='title'>Projects list</h4>
                        <p class='category'>New project on ";
                            $ch = curl_init();
                            $token = $_SESSION['token'];
                            $url = "$SERVER/project/last/1?token=".$token;
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $server_output = curl_exec ($ch);
                            curl_close ($ch);
                            $resp = json_decode($server_output);
                            
                            if($resp->success == true){
                                foreach($resp->result as $result){
                                    echo date_format(date_create($result->created_at), 'jS F Y');
                                }		
                            }
                            else{
                                echo "Data not found";
                            }
                        echo "</p>
                    </div>
                    <div class='card-content table-responsive'>
                        <table class='table table-hover'>
                            <thead class='text-warning'>
                                <th class='col-lg-1'>RID</th>
                                <th class='col-lg-2'>Project name</th>
                                <th class='col-lg-2'>Users count</th>
                                <th class='col-lg-2'>Reimburses count</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th style='visibility:hidden'>Action</th>
                            </thead>
                            <tbody>";
                                $ch = curl_init();

                                $token = $_SESSION['token'];
                                $url = "$SERVER/project/all?token=".$token;
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_POST, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $server_output = curl_exec ($ch);
                                curl_close ($ch);
                                $resp = json_decode($server_output);
                                if($resp->success!=false){
                                    foreach($resp->result as $result){
                                        echo "<tr id='tr".$result->id."'><td>#".$result->id."</td>
                                            <td>".$result->project_name."</td>
                                            <td>".$result->user_count."</td>
                                            <td>".$result->reimburse_count."</td>
                                            <td>".date_format(date_create($result->date), 'jS F\,\ Y')
                                            ."</td>
                                            <td>Rp ".number_format($result->total_cost, 0, ",", ".")."</td>
                                            <td><button type='button' class='btn btn-primary more-info' data-toggle='modal' data-background-color='orange'>More info</td>
                                            
                                        </tr>";
                                    }
                                }
                                else{
                                    echo "<tr><td colspan=6 align=center><h4>".$resp->message."</h4></td></tr>";
                                }
                            echo "</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>";
    }
?>