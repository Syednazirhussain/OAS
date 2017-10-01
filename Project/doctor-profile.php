<?php
require_once('autoload.php');
$user = new user();
$user->checklogin();
if (isset($_SESSION['doctorid'])) {
    $d_id = $_SESSION['doctorid'];
    $pdo = new pdocrudhandler();
    $doctor = $pdo->select('doctor', array('*'), "where id = ? ", array($d_id));
}else{
    echo "Login Failed";
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

    <title>Doctor profile</title>

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
    <script src="../build/js/Appointment_Load.js"></script>
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
        <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">
            <div class="col-md-7 col-sm-7 col-xs-8 text-right headline">Online Appointment System</div>
            <?php if(stripos($_SERVER['REQUEST_URI'],'signup') === false && stripos($_SERVER['REQUEST_URI'],'login') === false){?>
                <div class="fa fa-power-off col-md-5 col-sm-5 col-xs-4 text-right logout-hover">&nbsp;<a id="logout">Logout</a></div>
            <?php } ?>
        </div>
    <!-- page content -->
    <div class="right_col" role="main">
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
                                        <img class="img-responsive avatar-view" src="<?php echo  $doctor['result'][0]->picPath;  ?>" alt="Avatar" title="<?php echo  $doctor['result'][0]->fname." ".$doctor['result'][0]->lname;  ?>">
                                    </div>
                                </div>
                                <h3><?php echo $doctor['result'][0]->fname." ".$doctor['result'][0]->lname;?></h3>
                                <ul class="list-unstyled user_data">
                                    <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $doctor['result'][0]->address ?>
                                    </li>

                                    <li>
                                        <i class="fa fa-envelope user-profile-icon"></i> <?php echo $doctor['result'][0]->email?>
                                    </li>

                                    <li class="m-top-xs">
                                        <i class="fa fa-phone user-profile-icon"></i>
                                        <a href="http://www.kimlabs.com/profile/" target="_blank"><?php echo $doctor['result'][0]->phone; ?></a>
                                    </li>
                                </ul>
                                <a  href="doctor-edit-profile.php?id=<?php echo  $doctor['result'][0]->id;  ?>" class="btn btn-success" target="_blank">
                                    <i class="fa fa-edit m-right-xs"></i>Edit Profile
                                </a>
                            </div>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab_content3" role="tab"
                                                                                  id="profile-tab2" data-toggle="tab"
                                                                                  aria-expanded="false">Patients</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_content1" id="home-tab"
                                                                                  role="tab" data-toggle="tab"
                                                                                  aria-expanded="true">
                                            Appointments</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_content2" role="tab"
                                                                            id="profile-tab" data-toggle="tab"
                                                                            aria-expanded="false">Shared Data</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="profile-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="x_panel noBorder">
                                                        <div class="x_content">
                                                            <div class="row">
                                                                <div id="FilterByDate"class="well" style="overflow: auto">
                                                                    <div class="col-md-4">
                                                                        Filter By Date
                                                                        <form class="form-horizontal" id="<?php echo $d_id;?>">
                                                                                <div class="control-group">
                                                                                    <div class="controls">
                                                                                        <div class="input-prepend input-group">
                                                                                            <span class="add-on input-group-addon">
                                                                                                <i class="glyphicon glyphicon-calendar fa fa-filter"></i>
                                                                                            </span>
                                                                                                <input type="date" name="date" style="width: 200px" id="dateFilter"  class="form-control">
                                                                                                <input type="hidden" name="doctorid" value="<?php echo $d_id; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div id="view_patient">
                                                                    <div class="bs-example" data-example-id="simple-jumbotron">
                                                                        <div class="jumbotron" id="problem_description">
                                                                            <h1>Problem Description</h1>
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="list-unstyled timeline">
                                                                        <li>
                                                                            <div class="block">
                                                                                <div class="tags">
                                                                                    <a class="tag">
                                                                                        <span>Name</span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="block_content">
                                                                                    <h2 class="title">
                                                                                        <a id="name"></a>
                                                                                    </h2>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="block">
                                                                                <div class="tags">
                                                                                    <a class="tag">
                                                                                        <span>E-mail</span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="block_content">
                                                                                    <h2 class="title">
                                                                                        <a id="email"></a>
                                                                                    </h2>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="block">
                                                                                <div class="tags">
                                                                                    <a class="tag">
                                                                                        <span>NIC number</span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="block_content">
                                                                                    <h2 class="title">
                                                                                        <a id="nic"></a>
                                                                                    </h2>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="block">
                                                                                <div class="tags">
                                                                                    <a  class="tag">
                                                                                        <span>Mobile number</span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="block_content">
                                                                                    <h2 class="title">
                                                                                        <a id="phone"></a>
                                                                                    </h2>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="block">
                                                                                <div class="tags">
                                                                                    <a  class="tag">
                                                                                        <span>Address</span>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="block_content">
                                                                                    <h2 class="title">
                                                                                        <a id="address"></a>
                                                                                    </h2>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                    <div class="x_panel">
                                                                        <div class="x_title">
                                                                            <h2>Today's Time Slot</h2>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="x_content">
                                                                            <div id="time_slot"></div>
                                                                        </div>
                                                                        <div class="x_content">
                                                                            <div class="col-md-12">
                                                                                <h4 class="heading2">Set Appointment Duration</h4>
                                                                                <span >
                                                                                    <label class="lable label-primary" for="s_time">Start Time</label>
                                                                                    <input type="time" name="s_time" id="s_time" class="time">
                                                                                </span>
                                                                                &nbsp;
                                                                                <span>
                                                                                     <label class="lable label-primary" for="e_time">End Time</label>
                                                                                    <input type="time" name="e_time" id="e_time" class="time">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Buttons Confirm/Payment/Back -->
                                                                    <div class="col-xs-12">
                                                                        <button id="back_doctorTab" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-history"></i> Back</button>
                                                                       <!-- <button id="payment" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-info-circle"></i> Payment</button>-->
                                                                        <button id="ApptConfirm" class="btn btn-success pull-right"><i class="fa fa-check"></i> Confirm</button>
                                                                    </div>
                                                                </div>
                                                                <div id="Table"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content1" aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="x_panel noBorder">
                                                        <div class="x_content">
                                                            <div class="row">
                                                                <div id="CA_FilterByDate"class="well" style="overflow: auto">
                                                                    <div class="col-md-4">
                                                                        Filter By Date
                                                                        <form class="form-horizontal" id="<?php echo $d_id;?>">
                                                                            <div class="control-group">
                                                                                <div class="controls">
                                                                                    <div class="input-prepend input-group">
                                                                                            <span class="add-on input-group-addon">
                                                                                                <i class="glyphicon glyphicon-calendar fa fa-filter"></i>
                                                                                            </span>
                                                                                        <input type="date" name="date" style="width: 200px" id="ca_dateFilter"  class="form-control">
                                                                                        <input type="hidden" name="doctorid" value="<?php echo $d_id; ?>">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div id="AP_FilterByDate" class="well" style="overflow: auto">
                                                                    <div class="col-md-4">
                                                                            <span class="add-on input-group-addon">
                                                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                                            </span>
                                                                            <input type="date" name="date"  id="ap_dateFilter"  class="form-control">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <p class="align">Filter patient previous prescribtion</p>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                            <span class="add-on input-group-addon">
                                                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                                            </span>
                                                                            <select id="Filter_Bulk" name="Filter_Bulk" class="form-control">
                                                                                <option>filter in bulk</option>
                                                                                <option value="last_week">Last week</option>
                                                                                <option value="last_month">Last month</option>
                                                                                <option value="quater_year">Quater year</option>
                                                                                <option value="half_year">Half year</option>
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                                <div id="Confirm_Appt"></div>
                                                                <div id="PP_prescribtion"></div>
                                                                <div  id="perscribtion" class="col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="x_panel">
                                                                        <div class="x_title">
                                                                            <h2>Add Prescribtion</h2>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="x_content">
                                                                            <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                                                <div class="form-group">
                                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                        <textarea type="text" id="p_detail" required="required" class="form-control col-md-7 col-xs-12" style="overflow: hidden; resize: vertical; word-wrap: break-word; height: 115px; width: 975px"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="ln_solid"></div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-0">
                                                                                        <button id="precrib_back" type="button" class="btn btn-primary">Back</button>
                                                                                        <button id="precrib_send" type="button" class="btn btn-success">Send</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                            <!-- start user projects -->
                                          
                                            <!-- end user projects -->

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
