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
            $reimburse_count = $resp->result->reimburse_count;
            $date = $resp->result->date;
            $total = $resp->result->total_cost;
            $details = $resp->result->details;
            $update = $resp->result->updated_at;
            $created = $resp->result->created_at;
            $reimburse_data = $resp->result->reimburse_data;
            
            echo "<div class='content'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='card'> 
                                <div class='card-header' data-background-color='orange'>
                                    <h4 class='title'>Project <strong id='project-label'>$project</strong></h4>
                                    <p class='category'><i id='project-detail-label'>$details</i></p>
                                </div>
                                <div class='card-content'>
                                    <div class='container-fluid'>
                                        <div class='row'>
                                            <div class='col-lg-12'>
                                                <h4 class='col-lg-5 style='padding-left:0px; float:left'>Project Details</h4>
                                                <div style='float:right'>
                                                    <button id='edit-project' class='btn' data-background-color='blue'>Edit</button>
                                                    <button id='delete-project' class='btn' data-background-color='red'>Delete</button>
                                                </div>
                                                <table class='table'>
                                                    <!--<thead style='visibility:hidden'>
                                                        <th class='col-lg-3'>header</th>
                                                        <th>header</th
                                                    </thead>-->
                                                    <tbody>
                                                        <tr>
                                                            <td class='col-lg-3'>Project Name</td>
                                                            <td class='project-name' id='pr$id'>$project (PID:$id)</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Project Details</td>
                                                            <td class='project-details'>$details</td>
                                                        </tr>
                                                        <tr>
                                                            <td>User count</td>
                                                            <td>".$user_count."</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Reimburse request</td>
                                                            <td>$reimburse_count</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total cost</td>
                                                            <td>";
                                                                $rcost = 0;
                                                                foreach($reimburse_data as $reimburse){
                                                                    $rcost += $reimburse->cost;
                                                                }
                                                                echo "Rp.".number_format($rcost, 0, ",", ".");
                                                            echo "</td>
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
                                            <div class='col-lg-4 table-responsive'>
                                                <h4>Users list</h4>
                                                <button type='button' id='display-user-list' class='btn btn-primary add-user' data-background-color='green' data-toggle='modal' data-target='#addUserModal' style='margin:1px'>Add user</button>
                                                <table class='table'>
                                                    <tr>
                                                        <table class='table'>
                                                        <thead>
                                                            <th class='col-lg-2'>UID</th>
                                                            <th class='col-lg-7'>Name</th>
                                                            <th class='col-lg-4'>Action</th>
                                                        </thead>
                                                        </table>
                                                    </tr>
                                                    <tr>
                                                        <div id='style-10' class='table scrollbar'>
                                                        <table class='table'>";
                                                            if($resp->result->user_data != null){
                                                                foreach($resp->result->user_data as $user){
                                                                    $name = $user->nama;
                                                                    $limit = $user->limit;
                                                                    $uid = $user->id;
                                                                    $email = $user->email;
                                                                    echo "<tr id=tru$uid class='tr_user_id'><td class='col-lg-2'>#$uid</td>";
                                                                    echo "<td class='col-lg-10'>$name</td>";
                                                                    echo "<td class='col-lg-1' title='Click to delete user from this project'><button type='button' class='btn btn-primary delete-user' data-background-color='blue' style=' text-align: center'><i class='material-icons'>delete</i></td>";
                                                                }
                                                            }
                                                            else{
                                                                echo "<td colspan=2 align=center><h4>No user in this project</h4></td>";
                                                            }
                                                            echo "
                                                        </table>
                                                        </div>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class='col-lg-8 table-responsive'>
                                                <h4>Reimburse list</h4>
                                                <ul class='nav nav-tabs' data-tabs='tabs'>
                                                    <li class='active'>
                                                        <a href='#pending' id='pendingtab' data-toggle='tab'>
                                                            <i class='material-icons'>info_outline</i>
                                                            Pending
                                                        <div class='ripple-container'></div></a>
                                                    </li>
                                                    <li class=''>
                                                        <a href='#accepted' id='acceptedtab' data-toggle='tab'>
                                                            <i class='material-icons'>done</i>
                                                            Accepted
                                                        <div class='ripple-container'></div></a>
                                                    </li>
                                                    <li class=''>
                                                        <a href='#rejected' id='rejectedtab' data-toggle='tab'>
                                                            <i class='material-icons'>close</i>
                                                            Rejected
                                                        <div class='ripple-container'></div></a>
                                                    </li>
                                                </ul>

                                                <div class='tab-content'>
                                                    <div class='tab-pane fade in active' id='pending'>
                                                        <table class='table'>
                                                            <tr>
                                                                <table class='table'>
                                                                <thead class='text-primary'>
                                                                    <th class='col-lg-1'>RID</th>
                                                                    <th class='col-lg-3'>Name</th>
                                                                    <th class='col-lg-2'>Project name</th>
                                                                    <th class='col-lg-2'>Date</th>
                                                                    <th class='col-lg-2'>Total</th>
                                                                    <th class='col-lg-2'>Action</th>
                                                                </thead>
                                                                </table>
                                                            </tr>
                                                            <tr>
                                                                <div id='style-10' class='table scrollbar'>
                                                                <table class='table'>";
                                                                    $ch = curl_init();

                                                                    $token = $_SESSION['token'];
                                                                    $url = "$SERVER/project/getreimburselist/$id/pending?token=".$token;
                                                                    curl_setopt($ch, CURLOPT_URL, $url);
                                                                    curl_setopt($ch, CURLOPT_POST, 0);
                                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                    $server_output = curl_exec ($ch);
                                                                    curl_close ($ch);
                                                                    $res = json_decode($server_output);

                                                                    if($res->success != false){
                                                                        foreach($res->result as $result){
                                                                            echo "<tr id='tr".$result->id."'>
                                                                                <td class='col-lg-1'>#".$result->id."</td>
                                                                                <td class='col-lg-3'>".$result->user_name."</td>
                                                                                <td class='col-lg-2'>".$project."</td>
                                                                                <td class='col-lg-2'>".date_format(date_create($result->date), 'jS F\,\ Y')
                                                                                ."</td>
                                                                                <td class='col-lg-2'>Rp ".number_format($result->cost, 0, ",", ".")."</td>
                                                                                <td title='Click to see details'><button type='button' class='col-lg-2 btn btn-primary reimburse-info' data-background-color='blue'><i class='material-icons text-center'>keyboard_arrow_right</i></td>
                                                                            </tr>";
                                                                        }
                                                                    }
                                                                    else{
                                                                        echo "<tr><td colspan='6' align=center><h4>".$res->message."</h4></td></tr>";
                                                                    }
                                                                echo "</table>
                                                                </div>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class='tab-pane fade' id='accepted'>
                                                         <table class='table'>
                                                            <tr>
                                                                <table class='table'>
                                                                <thead class='text-primary'>
                                                                    <th class='col-lg-1'>RID</th>
                                                                    <th class='col-lg-3'>Name</th>
                                                                    <th class='col-lg-2'>Project name</th>
                                                                    <th class='col-lg-2'>Date</th>
                                                                    <th class='col-lg-2'>Total</th>
                                                                    <th class='col-lg-2'>Action</th>
                                                                </thead>
                                                                </table>
                                                            </tr>
                                                            <tr>
                                                                <div id='style-10' class='table scrollbar'>
                                                                <table class='table'>";
                                                                    $ch = curl_init();

                                                                    $token = $_SESSION['token'];
                                                                    $url = "$SERVER/project/getreimburselist/$id/accepted?token=".$token;
                                                                    curl_setopt($ch, CURLOPT_URL, $url);
                                                                    curl_setopt($ch, CURLOPT_POST, 0);
                                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                    $server_output = curl_exec ($ch);
                                                                    curl_close ($ch);
                                                                    $res = json_decode($server_output);

                                                                    if($res->success != false){
                                                                        foreach($res->result as $result){
                                                                            echo "<tr id='tr".$result->id."'>
                                                                                <td class='col-lg-1'>#".$result->id."</td>
                                                                                <td class='col-lg-3'>".$result->user_name."</td>
                                                                                <td class='col-lg-2'>".$project."</td>
                                                                                <td class='col-lg-2'>".date_format(date_create($result->date), 'jS F\,\ Y')
                                                                                ."</td>
                                                                                <td class='col-lg-2'>Rp ".number_format($result->cost, 0, ",", ".")."</td>
                                                                                <td title='Click to see details'><button type='button' class='col-lg-2 btn btn-primary reimburse-info' data-background-color='blue'><i class='material-icons text-center'>keyboard_arrow_right</i></td>
                                                                            </tr>";
                                                                        }
                                                                    }
                                                                    else{
                                                                        echo "<tr><td colspan='6' align=center><h4>".$res->message."</h4></td></tr>";
                                                                    }
                                                                echo "</table>
                                                                </div>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class='tab-pane fade' id='rejected'>
                                                         <table class='table'>
                                                            <tr>
                                                                <table class='table'>
                                                                <thead class='text-primary'>
                                                                    <th class='col-lg-1'>RID</th>
                                                                    <th class='col-lg-3'>Name</th>
                                                                    <th class='col-lg-2'>Project name</th>
                                                                    <th class='col-lg-2'>Date</th>
                                                                    <th class='col-lg-2'>Total</th>
                                                                    <th class='col-lg-2'>Action</th>
                                                                </thead>
                                                                </table>
                                                            </tr>
                                                            <tr>
                                                                <div id='style-10' class='table scrollbar'>
                                                                <table class='table'>";
                                                                    $ch = curl_init();

                                                                    $token = $_SESSION['token'];
                                                                    $url = "$SERVER/project/getreimburselist/$id/rejected?token=".$token;
                                                                    curl_setopt($ch, CURLOPT_URL, $url);
                                                                    curl_setopt($ch, CURLOPT_POST, 0);
                                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                                    $server_output = curl_exec ($ch);
                                                                    curl_close ($ch);
                                                                    $res = json_decode($server_output);

                                                                    if($res->success != false){
                                                                        foreach($res->result as $result){
                                                                            echo "<tr id='tr".$result->id."'>
                                                                                <td class='col-lg-1'>#".$result->id."</td>
                                                                                <td class='col-lg-3'>".$result->user_name."</td>
                                                                                <td class='col-lg-2'>".$project."</td>
                                                                                <td class='col-lg-2'>".date_format(date_create($result->date), 'jS F\,\ Y')
                                                                                ."</td>
                                                                                <td class='col-lg-2'>Rp ".number_format($result->cost, 0, ",", ".")."</td>
                                                                                <td title='Click to see details'><button type='button' class='col-lg-2 btn btn-primary reimburse-info' data-background-color='blue'><i class='material-icons text-center'>keyboard_arrow_right</i></td>
                                                                            </tr>";
                                                                        }
                                                                    }
                                                                    else{
                                                                        echo "<tr><td colspan='6' align=center><h4>".$res->message."</h4></td></tr>";
                                                                    }
                                                                echo "</table>
                                                                </div>
                                                            </tr>
                                                        </table>
                                                    </div>
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