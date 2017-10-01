<?php
require_once('autoload.php');
$_pdo = new pdocrudhandler();
$city = $_pdo->select('city',array('*'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User SignUp</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link href="../build/css/profile.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- morris.js -->
    <script src="../vendors/raphael/raphael.min.js"></script>
    <script src="../vendors/morris.js/morris.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/user-signup.js"></script>
</head>
<body class="userSignUpPage">
<div class="main_container">
    <?php include 'header.html';?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Users SignUp</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="status"></div>
                    <form id="patientsignup"  class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name*<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="fname" name="fname" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name*<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="lname" name="lname" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="email" class="form-control col-md-7 col-xs-12" type="email" name="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="gender">
                                    <option value="">Choose option</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select city*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="city" id="city">
                                    <option value="">Choose option</option>
                                    <?php for( $l=0 ; $l<count($city['result']) ; $l++ ){?>
                                        <option value="<?= $city['result'][$l]->id; ?>" <?= (isset($_POST['city']) && $city['result'][$l]->name == $_POST['city']) ? "selected" : "";?>><?= $city['result'][$l]->name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select area*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="areaid" id="area">
                                    <option value="">Choose option</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" type="text" name="address" id="address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">CNIC*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" placeholder="45504-1086420-5" maxlength="15" type="text" name="nic" id="nic" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Cell*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" placeholder="342-2361422" type="text" name="phone" id="phone" maxlength="12" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">User name*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" type="text" name="username" id="phone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Password*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" type="password" name="password" id="password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password*</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" type="password" name="confirmpassword" id="cpassword" required>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <!--  <input type="button" class="btn btn-primary" value="Back" id="back">-->
                                <input type="button" class="btn btn-success" value="Submit" id="submit">
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.html';?>
    <!-- /page content -->
</div>
</body>
</html>
<?php
/*if(isset($_POST['submit'])){
    $params = $_POST;
    unset($params['submit']);
    unset($params['city']);
    $response = $_pdo->insert('user',array('email' => $params['username'],'password' => $params['password'],'active' => 1,'lastLogin' => date('Y-m-d h:i:s'),'professionid' => 2));
    if($response['status'] == "success" && $response['rowsAffected'] == 1){
        $get = $_pdo->select('user',array("id"),"where email = ? and password = ?",array($params['username'],$params['password']));
        $id = $get['result'][0]->id;
        if ($id){
            $_pdo->insert('patient',array('fname' => $params['fname'],'lname' => $params['lname'],'email' => $params['email'],'gender' => $params['gender'],'nic' => $params['nic'],'phone' => $params['phone'],'areaid' => $params['areaid'],'userid' => $id,'address' => $params['address']));
        }
    }

}*/
?>
