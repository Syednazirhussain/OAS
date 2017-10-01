<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administrator</title>

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
    <script src="../build/js/admin.js"></script>
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
                                        <img class="img-responsive avatar-view" src="images\admin.png" alt="Avatar" title="Change the avatar">
                                    </div>
                                </div>
                                <h3>Administrator</h3>
                                <ul class="list-unstyled user_data">
                                    <li><i class="fa fa-map-marker user-profile-icon"></i> Syed Nazir Hussain<!-- name -->
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope user-profile-icon"></i> syednazir13@gmail.com
                                    </li>
                                    <li class="m-top-xs">
                                        <i class="fa fa-phone user-profile-icon"></i>
                                        <a href="http://www.kimlabs.com/profile/" target="_blank">02134690046</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab_content3" role="tab"
                                                                                  id="profile-tab2" data-toggle="tab"
                                                                                  aria-expanded="false">Requests</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_content1" id="home-tab"
                                                                            role="tab" data-toggle="tab"
                                                                            aria-expanded="true">
                                                Users</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#tab_content2" role="tab"
                                                                            id="profile-tab" data-toggle="tab"
                                                                            aria-expanded="false">Manage Accounts</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="profile-tab">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <h2>Registration Request <small>Doctor</small></h2>
                                                        <ul class="nav navbar-right panel_toolbox">
                                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i>Collapse</a>
                                                            </li>
                                                            <li><a class="close-link"><i class="fa fa-close"></i>Hide</a>
                                                            </li>
                                                        </ul>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
                                                        <p class="text-muted font-13 m-b-30">
                                                            Those listed user were not able access their account until you approve their request <code>Final Year Project</code>
                                                        </p>
                                                        <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                            <div id="Request_filter" class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="dataTables_length" id="datatable_length">
                                                                        <label>Show
                                                                            <select name="datatable_length" aria-controls="datatable" class="form-control input-sm">
                                                                                <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                                                                            </select> entries</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div id="datatable_filter" class="dataTables_filter">
                                                                        <label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="datatable"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div id="request" class="col-sm-12"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div id="request_view" class="col-md-12 col-sm-12 col-xs-12">
                                                    <div id="A_request_confirm" class="alert alert-success alert-dismissible fade in " role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content1" aria-labelledby="home-tab">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="x_panel">
                                                        <div class="x_title">
                                                            <h2>Registered User <small>Doctor</small></h2>
                                                            <ul class="nav navbar-right panel_toolbox">
                                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i>Collapse</a>
                                                                </li>
                                                                <li><a class="close-link"><i class="fa fa-close"></i>Hide</a>
                                                                </li>
                                                            </ul>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="x_content">
                                                            <p class="text-muted font-13 m-b-30">
                                                                Those listed user were not able access their account until you approve their request <code>Final Year Project</code>
                                                            </p>
                                                            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                <div id="Request_filter" class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="dataTables_length" id="datatable_length">
                                                                            <label>Show
                                                                                <select name="datatable_length" aria-controls="datatable" class="form-control input-sm">
                                                                                    <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                                                                                </select> entries</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div id="datatable_filter" class="dataTables_filter">
                                                                            <label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="datatable"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div id="registerd" class="col-sm-12"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                            <div class="row">
                                                <div id="controlpanel" class="col-md-12">
                                                    <div class="x_panel">
                                                        <div class="x_title">
                                                            <h2>Control Panel</h2>
                                                            <ul class="nav navbar-right panel_toolbox">
                                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"> Collapse</i></a>
                                                                </li>
                                                                <li><a class="close-link"><i class="fa fa-close"> Hide</i></a>
                                                                </li>
                                                            </ul>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div id="manage" class="x_content"></div>
                                                    </div>
                                                </div>
                                                <div id="manage_view_user" class="col-md-12 col-sm-12 col-xs-12"></div>
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
