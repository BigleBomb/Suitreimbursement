<?php
include('config.php');
session_start();
if(isset($_POST['project_id']))
{
    $id = $_POST['project_id'];
    $ch = curl_init();
    $token = $_SESSION['token'];
    curl_setopt($ch, CURLOPT_URL,"$SERVER/project/get/$id?token=".$token);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    $resp = json_decode($server_output);

    if($resp != null){
        if ($resp->success == true){
            $project = $resp->result->project_name;
            $user_count = $resp->result->user_count;
            $date = $resp->result->date;
            $total = $resp->result->total_cost;
            $details = $resp->result->details;
            $update = $resp->result->updated_at;
            $created = $resp->result->created_at;
            
            echo "<div class='content'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='card'> 
                                <div class='card-header' data-background-color='orange'>
                                    <h4 class='title'>Project <strong>$project</strong></h4>
                                    <p class='category'><i>$details</i></p>
                                </div>
                                <div class='card-content'>
                                    <div class='container-fluid'>
                                        <div class='row'>
                                            <div class='col-lg-12'>
                                                <h4>Project Details</h4>
                                                <table class='table'>
                                                    <thead style='visibility:hidden'>
                                                        <th class='col-lg-3'>header</th>
                                                        <th>header</th
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Project Name</td>
                                                            <td>$project</td>
                                                        </tr>
                                                        <tr>
                                                            <td>User count</td>
                                                            <td>".$user_count."</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Created at</td>
                                                            <td>".date_format(date_create($created), 'jS F, Y')."</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Updated at</td>
                                                            <td>".date_format(date_create($update), 'jS F, Y')."</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <hr style='color:#000000'>
                                        <div class='row'>
                                            <div class='col-lg-4'>
                                                <h4>Users list</h4>
                                                <table class='table'>
                                                    <thead>
                                                        <th class='col-lg-2'>UID</th>
                                                        <th>Name</th>
                                                        <th>Action</th>
                                                    </thead>
                                                    <tbody>";
                                                        if($resp->result->user_data != null){
                                                            foreach($resp->result->user_data as $user){
                                                                $name = $user->nama;
                                                                $limit = $user->limit;
                                                                $uid = $user->id;
                                                                $email = $user->email;
                                                                echo "<tr><td>$uid</td>";
                                                                echo "<td>$name</td>";
                                                                echo "<td title='Click to see details'><button type='button' class='btn btn-primary user-info' data-background-color='orange' style='width:50px'><i class='material-icons text-center'>keyboard_arrow_right</i></td></td>";
                                                            }
                                                        }
                                                        else{
                                                            echo "<td colspan=2 align=center>No user in this project</td>";
                                                        }
                                                        echo "
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class='col-lg-8'>
                                                <h4>Reimburse list</h4>
                                                <table class='table'>
                                                    <thead style='border:none'>
                                                        <th class='col-lg-1'>RID</th>
                                                        <th>Requested by</th>
                                                        <th>Category</th>
                                                        <th>Cost</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </thead>
                                                    <tbody>";
                                                        if($resp->result->reimburse_data != null){
                                                            foreach($resp->result->reimburse_data as $reimburse){
                                                                $rid = $reimburse->id;
                                                                $name = $reimburse->user_name;
                                                                $category = $reimburse->category;
                                                                $cost = $reimburse->cost;
                                                                $date = $reimburse->date;
                                                                echo "<tr id='tr".$rid."'><td>$rid</td>
                                                                    <td>$name</td>
                                                                    <td>$category</td>
                                                                    <td>$cost</td>
                                                                    <td>".date_format(date_create($date), 'jS F, Y')."</td>
                                                                    <td title='Click to see details'><button type='button' class='btn btn-primary reimburse-info' data-background-color='orange' style='width:50px'><i class='material-icons'>keyboard_arrow_right</i></td></tr>";
                                                            }
                                                        }
                                                        else{
                                                            echo "<td colspan=5 align=center>No reimburse in this project</td>";
                                                        }
                                                echo "</tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class='card-footer'>
                        <button type='button' style='float:left;' class='btn' id='back'><i class='material-icons'>arrow_back</i>  Back</button>
                    </div>";
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