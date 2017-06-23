<?php
    include('config.php');
    if(isset($_SESSION['token'])){
        $token = $_SESSION['token'];
        $uid = $_SESSION['user_id'];

        $ch = curl_init();
        $url = "$SERVER/user/get/$uid?token=".$token;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $resp = json_decode($server_output, true);
        if($resp!=null){
            if($resp['success'] != false){
                
            }else{
                echo "<div id='Alert' class='modal fade' data-backdrop='static' data-keyboard='false' role='dialog'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-body'>
                                    <div class='alert alert-danger'>Your session token does not match, please login</div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' id='redirectlogin' class='btn btn-default' data-dismiss='modal'>Login</button>
                                </div>
                            </div>
                        </div>
                    </div>";
                echo '<script>';
                echo '$(document).ready(function() {';
                echo '$("#Alert").modal("show");';
                echo '$("#redirectlogin").click(function(){';
                echo '  window.location.replace("http://localhost/suitreimbursement/cms/login.php")';
                echo '  });';
                echo '});';
                echo '</script>';
            }
        }
    }
?>