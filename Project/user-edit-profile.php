<?php
require_once('autoload.php');
$_pdo = new pdocrudhandler();
$city = $_pdo->select('city',array('*'));
if (isset($_GET['id'])){
    $id = $_GET['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit profile page - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../build/css/editprofile.css" rel="stylesheet">
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
    <script src="../build/js/custom.min.js"></script>
    <script src="../build/js/custom.js"></script>
    <script src="../build/js/editprofile.js"></script>
</head>
<body>
<div class="container bootstrap snippets">
    <div class="row">
        <div class="col-xs-12 col-sm-9">
            <form class="form-horizontal" id="<?php echo $id; ?>">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">General Information</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-5">
                                <input id="fname" name="fname" type="text" class="form-control">
                            </div>
                            <div class="col-sm-5 option">
                                <a class="trigger" id="fnameEdit">Edit</a>
                                <a class="trigger" id="fnameSave">Save</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-5">
                                <input name="lname" type="text" class="form-control">
                            </div>
                            <div class="col-sm-5 option">
                                <a class="trigger" id="lnameEdit">Edit</a>
                                <a class="trigger" id="lnameSave">Save</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-5">
                                <input name="email" type="text" class="form-control">
                            </div>
                            <div class="col-sm-5 option">
                                <a class="trigger" id="emailEdit">Edit</a>
                                <a class="trigger" id="emailSave">Save</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-5">
                                <input name="phone" maxlength="10" type="text" class="form-control">
                            </div>
                            <div class="col-sm-5 option">
                                <a class="trigger" id="phoneEdit">Edit</a>
                                <a class="trigger" id="phoneSave">Save</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Location</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">City</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="city" id="city">
                                    <option value="">Select City</option>
                                    <?php for( $l=0 ; $l<count($city['result']) ; $l++ ){?>
                                        <option value="<?= $city['result'][$l]->id; ?>" <?= (isset($_POST['city']) && $city['result'][$l]->name == $_POST['city']) ? "selected" : "";?>><?= $city['result'][$l]->name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Area</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="areaid" id="area">
                                    <option value="">Select Areas</option>
                                </select>
                            </div>
                            <div class="col-sm-5 option">
                                <a class="trigger" id="locEdit">Edit</a>
                                <a class="trigger" id="locSave">Save</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-5">
                                <input name="address" type="text" class="form-control" maxlength="40">
                            </div>
                            <div class="col-sm-5 option">
                                <a class="trigger" id="addressEdit">Edit</a>
                                <a class="trigger" id="addressSave">Save</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Security</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Current password</label>
                            <div class="col-sm-5">
                                <input id="currentpassword" name="currentpassword" type="password" class="form-control">
                            </div>
                            <div class="col-sm-5 option">
                                <span class="message"></span>
                                <a class="trigger" id="cpasswordEdit">Edit</a>
                                <a class="trigger" id="cpasswordCheck">Check</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">New password</label>
                            <div class="col-sm-5">
                                <input id="password" name="newpassword" type="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Confirm password</label>
                            <div class="col-sm-5">
                                <input id="cpassword" name="confirmpassword" type="password" class="form-control">
                            </div>
                            <div class="col-sm-5 option">
                                <span id="checkpassword"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button id="submit" type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>