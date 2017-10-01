<?php
require_once('autoload.php');
$_pdo = new pdocrudhandler();
$city = $_pdo->select('city',array('*'));
$speciality = $_pdo->select('speciality',array('*'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Doctor SignUp</title>

    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../vendors/starrr/dist/starrr.css" rel="stylesheet">
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
    <script src="../build/js/custom.min.js"></script>
    <script src="../build/js/user-signup.js"></script>
</head>
<body class="doctorSignUpPage">
<div class="main_container">
    <?php include 'header.html';?>
    <div class="row">
        <div id="form"class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Doctor SignUp</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="status"></div>
                    <div id="statusTime"></div>
                    <form id="doctorsignup"  class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name<span class="required"></span></label>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="text" name="fname"  required="required" class="form-control col-md-7 col-xs-12" placeholder="First">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="text"  name="lname" required="required" class="form-control col-md-7 col-xs-12" placeholder="Last">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email & Gender</label>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="email" required placeholder="Email">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <select class="form-control" name="gender">
                                    <option value="">Gender</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <select class="form-control" name="city" id="city">
                                    <option value="">City</option>
                                    <?php for( $l=0 ; $l<count($city['result']) ; $l++ ){?>
                                        <option value="<?= $city['result'][$l]->id; ?>" <?= (isset($_POST['city']) && $city['result'][$l]->name == $_POST['city']) ? "selected" : "";?>><?= $city['result'][$l]->name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <select class="form-control" name="areaid" id="area">
                                    <option value="">Areas</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" type="text" name="address" required placeholder="Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">CNIC & Cell<span class="required"></span></label>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="text" name="nic"  required="required" maxlength="15" class="form-control col-md-7 col-xs-12" placeholder="CNIC# 455041-086420-5">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="texts"  name="phone" required="required" maxlength="12" class="form-control col-md-7 col-xs-12" placeholder="Cell# 342-2361422">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >PMDC no<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="pmdc"  required="required" placeholder="PMDC registration no" type="number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Degree title<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="degree" class="form-control col-md-7 col-xs-12"  required="required" type="text" placeholder="eg. Bahcelor degree in dentistry">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">University/Board<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12"  placeholder="Enter name of institute" required="required" type="text" name="board">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Speciality</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="speciality">
                                    <option value="">Select</option>
                                    <?php for( $l=0 ; $l<count($speciality['result']) ; $l++ ){?>
                                        <option value="<?= $speciality['result'][$l]->id; ?>" <?= (isset($_POST['specialitiy']) && $speciality['result'][$l]->name == $_POST['specialitiy']) ? "selected" : "";?>><?= $speciality['result'][$l]->name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fees<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input class="form-control col-md-7 col-xs-12" name="fees"  required="required" placeholder="Set fees" type="number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Username<span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="username"  required="required" class="form-control col-md-7 col-xs-12" placeholder="User name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Security<span class="required"></span></label>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="password" name="password" id="password" required="required" class="form-control col-md-7 col-xs-12" placeholder="Password">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="password"  name="confirmpassword" id="cpassword" required="required" class="form-control col-md-7 col-xs-12" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                               <!-- <input type="button" class="btn btn-primary" value="Back" id="back">-->
                                <input type="button" class="btn btn-success" value="Submit" id="dsubmit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="form2" class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Timetable<small>Please Scheduling you week days and their corresponding time</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="statusTime"></div>
                <!--    <div class="alert alert-success alert-dismissible fade in" role="alert">';
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"></span></button>';
                        <strong>Status : </strong>Your Timetable Successfully Updated..
                    </div>-->
                    <form id="doctorsignUp_time" class="form-horizontal form-label-left" novalidate="" method="post">
                        <div class="center">
                        <div class="form-group spacing">
                            <input class="adjust" type="checkbox" id="monday" name="monday" value="monday">
                            <label  for="monday">Mon</label>
                            <label class="adjust" for="tstart">Start Time</label>
                            <input  type="time" name="m_start" id="tstart">
                            <label class="adjust" for="tend">End Time</label>
                            <input  type="time" name="m_end" id="tend">
                        </div>
                        <div class="form-group spacing">
                            <input class="adjust" type="checkbox" id="tuesday" name="tuesday" value="tuesday">
                            <label  for="tuesday">&nbsp;Tue</label>
                            <label class="adjust" for="tstart">Start Time</label>
                            <input  type="time" name="tu_start" id="tstart">
                            <label class="adjust" for="tend">End Time</label>
                            <input  type="time" name="tu_end" id="tend">
                        </div>
                        <div class="form-group spacing">
                            <input class="adjust" type="checkbox" id="wednesday" name="wednesday" value="wednesday">
                            <label   for="wednesday">Wed</label>
                            <label class="adjust" for="tstart">Start Time</label>
                            <input  type="time" name="w_start" id="tstart">
                            <label class="adjust" for="tend">End Time</label>
                            <input  type="time" name="w_end" id="tend">
                        </div>
                        <div class="form-group spacing">
                            <input class="adjust" type="checkbox" id="thursday" name="thursday" value="thursday">
                            <label  for="thursday">Thu</label>
                            <label class="adjust" for="tstart">Start Time</label>
                            <input  type="time" name="th_start" id="tstart">
                            <label class="adjust" for="tend">End Time</label>
                            <input  type="time" name="th_end" id="tend">
                        </div>
                        <div class="form-group spacing">
                            <input class="adjust" type="checkbox" id="friday" name="friday" value="friday">
                            <label  for="friday">Fri&nbsp;&nbsp;</label>
                            <label class="adjust" for="tstart">Start Time</label>
                            <input  type="time" name="f_start" id="tstart">
                            <label class="adjust" for="tend">End Time</label>
                            <input  type="time" name="f_end" id="tend">
                        </div>
                        <div class="form-group spacing">
                            <input class="adjust" type="checkbox" id="saturday" name="saturday" value="saturday">
                            <label   for="saturday">Sat&nbsp;</label>
                            <label class="adjust" for="tstart">Start Time</label>
                            <input  type="time" name="sa_start" id="tstart">
                            <label class="adjust" for="tend">End Time</label>
                            <input  type="time" name="sa_end" id="tend">
                        </div>
                        <div class="form-group spacing">
                            <input class="adjust" type="checkbox" id="sunday" name="sunday" value="sunday">
                            <label   for="sunday">Sun</label>
                            <label class="adjust" for="tstart">Start Time</label>
                            <input  type="time" name="su_start" id="tstart">
                            <label class="adjust" for="tend">End Time</label>
                            <input  type="time" name="su_end" id="tend">
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-6">
                               <!-- <input type="button" class="btn btn-primary" value="Back" id="dtback">-->
                                <input type="button" class="btn btn-success" value="Submit" id="dtsubmit">
                            </div>
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

?>
