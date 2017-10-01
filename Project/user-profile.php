<?php
require_once('autoload.php');
$user = new user();
$user->checklogin();
if (isset($_SESSION['patientid'])) {
     $id = $_SESSION['patientid'];
     $_Pdo = new pdocrudhandler();
     $patient = $_Pdo->select('patient', array('*'), "where patientid = ? ", array($id));
} else {
     echo "Login Failed...";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User profile</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>


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
    <script src="../build/js/patient.js"></script>
    <script>
        $(document).ready(function() {
        $('#logout').click(function () {
            var jsobj = {
                call : 'logout'
            }
            $.post('../classes/user.php',jsobj,function (data) {
                var jsObj = JSON.parse(data);
                if (jsObj === true){
                    window.location.href = "login.php";
                }
            });
        });        
        });
    </script>
</head>
<body class="profilePage">
    <div class="main_container">
    <?php/* require_once('header.html');*/?>
        <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">
            <div class="col-md-7 col-sm-7 col-xs-8 text-right headline">Online Appointment System</div>
            <?php if(stripos($_SERVER['REQUEST_URI'],'signup') === false && stripos($_SERVER['REQUEST_URI'],'login') === false){?>
                <div class="fa fa-power-off col-md-5 col-sm-5 col-xs-4 text-right logout-hover">&nbsp;<a id="logout">Logout</a></div>
            <?php } ?>
        </div>
    <!-- page content -->
    <div class="right_col" role="main" id="<?php echo $id;?>">
        <div class="">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="col-md-2 col-sm-2 col-xs-12 profile_left">
                                <div class="profile_img">
                                    <div id="crop-avatar">
                                        <!-- Current avatar -->
                                        <img class="img-responsive avatar-view" src="<?php echo $patient['result'][0]->picPath; ?>" alt="<?php  echo $patient['result'][0]->fname; ?>" title="<?php  echo $patient['result'][0]->fname." ".$patient['result'][0]->lname; ?>">
                                    </div>
                                </div>
                                <h3><?php echo $patient['result'][0]->fname." ".$patient['result'][0]->lname;?></h3>
                                <ul class="list-unstyled user_data">
                                    <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $patient['result'][0]->address ?>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope user-profile-icon"></i> <?php echo $patient['result'][0]->email?>
                                    </li>
                                    <li class="m-top-xs">
                                        <i class="fa fa-phone user-profile-icon"></i>
                                        <!--<a href="http://www.kimlabs.com/profile/" target="_blank">--><?php echo $patient['result'][0]->phone; ?><!--</a>-->
                                    </li>
                                </ul>
                                <a  class="btn btn-success editprofile" href="user-edit-profile.php?id=<?php echo $id;?>" target="_blank"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                                <br/>
                                <!-- start skills -->
                                <h4><i class="notifications"></i> Notifications</h4>
                                <div id="notification"></div>
                                <!-- end of skills -->
                            </div>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab_content3" role="tab"
                                                                                  id="profile-tab2" data-toggle="tab"
                                                                                  aria-expanded="false">Doctors</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_content1" id="home-tab"
                                                                                  role="tab" data-toggle="tab"
                                                                                  aria-expanded="true">
                                            Activity</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_content2" role="tab"
                                                                            id="profile-tab" data-toggle="tab"
                                                                            aria-expanded="false">Sharing Document</a>
                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="profile-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="x_panel noBorder">
                                                        <div class="x_content">
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <select class="col-md-4 col-sm-4 col-xs-12 customSelect" name="speciality"  id="speciality">
                                                                        <option value="0">Speciality</option>
                                                                        <?php
                                                                        $Special = $_Pdo->select('speciality',array('*'));
                                                                         for( $l=0 ; $l<$Special['rowsAffected'] ; $l++ ){
                                                                            echo "<option value=\"{$Special['result'][$l]->id}\"> {$Special['result'][$l]->name}</option>";
                                                                       } ?>
                                                                    </select>
                                                                    <select class="col-md-4 col-sm-4 col-xs-12 customSelect" name="fees" id="fees">
                                                                        <option value="0">Fees</option>
                                                                        <?php
                                                                        $doctor = $_Pdo->select('doctor',array('*'));
                                                                        for( $l=0 ; $l<$doctor['rowsAffected'] ; $l++ ){
                                                                            echo "<option value=\"{$doctor['result'][$l]->fees}\"> {$doctor['result'][$l]->fees}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <select class="col-md-4 col-sm-4 col-xs-12 customSelect" name="location" id="location">
                                                                        <option value="0">Location</option>
                                                                        <?php
                                                                        $area = $_Pdo->customSelect("select id,name from area where cityid = (select a.cityid from area as a inner join patient as p on p.areaid = a.id inner join city as c on
                                                                                 c.id = a.cityid where p.patientid = {$id})");
                                                                        for( $l=0 ; $l<$area['rowsAffected'] ; $l++ ){
                                                                            echo "<option value=\"{$area['result'][$l]->id}\"> {$area['result'][$l]->name}</option>";
                                                                        }?>
                                                                    </select>
                                                                </div>
                                                                <div id="Days"></div>
                                                                <div id="time_slot"></div>
                                                                <form id="takeAppointment" class="form-horizontal form-label-left" novalidate="">
                                                                   <span class="section">Take an appointment</span>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Preferred Appt.Date <span class="required"></span>
                                                                        </label>
                                                                        <div class="calendar left single">
                                                                            <div class="daterangepicker_input">
                                                                                <input class="input-mini form-control active" id="date" name="date" type="date">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Brief Problem Description <span class="required"></span>
                                                                        </label>
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                            <textarea class="form-control" rows="5" name="description"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <input type='hidden' name="patientId" value='<?php echo "$id";?>'/>
                                                                    <div class="ln_solid"></div>
                                                                    <div class="form-group">
                                                                        <div class="col-md-6 col-md-offset-3">
                                                                            <button type="button" class="btn btn-primary"><a style="color: white" href="user-profile.php">Back</a></button>
                                                                            <button id="send"  type="button" name="submit"   class="btn btn-success">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <div class="x_content bs-example-popovers">
                                                                    <div id="confirm" class="alert alert-success alert-dismissible fade in" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                    </div>
                                                                </div>
                                                                <div id="Doctors"></div>
                                                                <div id="payment"></div>
                                                                <div class="popup" data-popup="popup-1">
                                                                    <div class="popup-inner" id="ViewDoctor">

                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content1" aria-labelledby="home-tab">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
<!--                                                        <h2>Default Example <small>Users</small></h2>-->
                                                        <ul class="nav navbar-right panel_toolbox">
                                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"> Collapse</i></a>
                                                            </li>
                                                            <li><a class="close-link"><i class="fa fa-close"> Close</i></a>
                                                            </li>
                                                        </ul>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                        <p class="text-muted font-13 m-b-30">
                                                            <!-- Add some text here-->
                                                        </p>
                                                        <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div class="row">
                                                                <div id="patientActivity" class="col-sm-12"></div>
                                                                <div id="view_appointments" class="animated flipInY col-lg-6col-md-6col-sm-6 col-xs-12"></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                            <div  id="PatientSharingDoc" class="col-md-12 col-sm-12 col-xs-12"></div>
                                            <div id="sharedData" class="col-md-12 col-sm-12 col-xs-12"></div>
                                            <div id="upload" class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <h2>Shared Document <small>Like test reports and prescribtion</small></h2>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                        <p id="msg"></p>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="files">Upload Files <span class="required"></span>
                                                                </label>
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                    <input type="file" class="form-control col-md-7 col-xs-12" id="multiFiles" name="files[]" multiple="multiple"/>
                                                                </div>
                                                            </div>
                                                            <div class="ln_solid"></div>
                                                            <div class="form-group">
                                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" id="<?php echo $id; ?>">
                                                                    <button id="upload" type="button" class="btn btn-success">Upload</button>
                                                                    <button id="back" type="button" class="btn btn-primary">Back</button>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.html';?>
    <!-- /page content -->
    </div>
</body>
</html>
