<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="uitoas" content="appointment">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Online appointment system</title>

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
    <script src="../build/js/custom.min.js"></script>    <!-- jQuery Smart Wizard -->
    <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- jQuery Smart Wizard -->
    <script>
        $(document).ready(function() {
            $(window).load(function(){
                var jsonObj = {
                    call : 'getAllprofession'
                };
                $.post( "../classes/helper.php",jsonObj, function( data ) {
                    html = "";
                    var jsObj = JSON.parse(data);
                    html += '<option value="">Select User Type</option>';
                    for(var i=0;i<jsObj['result'].length;i++){
                        html += "<option value='"+jsObj['result'][i]['professionid']+"'>"+jsObj['result'][i]['name']+"</option>";
                    }
                    $('#pid').html(html);
                });
            });
            $('#submit').click(function () {
                  /*alert('Jquerey working');*/
                var text = '';
                var jsObj = {};
                var data = $('#Login').serializeArray();

                $.each(data, function (index, feild) {
                    jsObj[feild.name] = feild.value;
                    console.log(feild.name + " --> " + feild.value);
                });
                jsObj['call'] = 'login';
                $.post("../classes/user.php", jsObj, function (data) {
                    var jsobj = JSON.parse(data);
                    if( typeof jsobj === 'string' ) {
                        if (jsobj == 'Doctor'){
                            text +='<div class="alert alert-success text-center" role="alert" id="error" style="margin-top: 10px;">';
                            text +='<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"> </span>';
                            text +='<span> <strong>User Type '+ jsobj+' : </strong>You are successfully login </span>';
                            text +='</div>';
                            $('#message').html(text);
                            $(':input', '#Login')
                                .not(':button, :submit, :reset, :hidden')
                                .val('')
                                .removeAttr('checked')
                                .removeAttr('selected');
                            $("#Login").trigger('reset'); //jquery
                            document.getElementById("Login").reset();
                            setInterval(function () {
                                window.location.href = "doctor-profile.php";
                            }, 3000);
                        }else if (jsobj == 'Patient'){
                            text +='<div class="alert alert-success text-center" role="alert" id="error" style="margin-top: 10px;">';
                            text +='<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"> </span>';
                            text +='<span> <strong>User Type '+ jsobj+' : </strong>You are successfully login </span>';
                            text +='</div>';
                            $('#message').html(text);
                            $(':input', '#Login')
                                .not(':button, :submit, :reset, :hidden')
                                .val('')
                                .removeAttr('checked')
                                .removeAttr('selected');
                            $("#Login").trigger('reset'); //jquery
                            document.getElementById("Login").reset();
                            setInterval(function () {
                                window.location.href = "user-profile.php";
                            }, 3000);
                        }else if(jsobj == 'Admin'){
                            text +='<div class="alert alert-success text-center" role="alert" id="error" style="margin-top: 10px;">';
                            text +='<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"> </span>';
                            text +='<span> <strong>User Type '+ jsobj+' : </strong>You are successfully login </span>';
                            text +='</div>';
                            $('#message').html(text);
                            $(':input', '#Login')
                                .not(':button, :submit, :reset, :hidden')
                                .val('')
                                .removeAttr('checked')
                                .removeAttr('selected');
                            $("#Login").trigger('reset'); //jquery
                            document.getElementById("Login").reset();
                            setInterval(function () {
                                window.location.href = "Admin.php";
                            }, 3000);
                        }else {
                            text +='<div class="alert alert-danger text-center" role="alert" id="error" style="margin-top: 10px;">';
                            text +='<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"> </span>';
                            text +='<span> <strong>Required Inputs : </strong>' + jsobj + '</span>';
                            text +='</div>';
                            $('#message').html(text);
                        }
                    }
                });
            });

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
    <!-- /jQuery Smart Wizard -->
</head>
<body class="indexPage">
<div class="main_container">
    <!-- include 'header.html'; -->
    <div class="col-md-12 col-sm-12 col-xs-12 mainHeader">
    <div class="col-md-7 col-sm-7 col-xs-8 text-right headline">Online Appointment System</div>
        <?php if(stripos($_SERVER['REQUEST_URI'],'signup') === false && stripos($_SERVER['REQUEST_URI'],'login') === false){?>
        <div class="fa fa-power-off col-md-5 col-sm-5 col-xs-4 text-right logout-hover">&nbsp;<a id="logout" style="cursor: pointer;">Logout</a></div>
    <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div>
                    <h2>Login Page</h2>
                </div>
                <div class="x_content">
                    <div class="createAccount">
                        <label  class="control-label col-md-3 col-sm-3 col-xs-12">Create An Account</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="signup" class="signupdd" required  onchange="if (this.value == -1){}else{window.location.href = this.value;}">
                                <option value="-1">Sign Up</option>
                                <option value="user-signup.php">As User</option>
                                <option value="doctor-signup.php">As Doctor</option>
                            </select>
                        </div>
                        <div class="ln_solid"></div>
                    </div>
                    <div class="clearfix"><hr></div>
                    <form id="Login"  class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label  class="control-label col-md-3 col-sm-3 col-xs-12">Login As</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="pid" class="pnamedd" id="pid" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-3 col-sm-3 col-xs-12">User Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" type="text" name="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input  class="form-control col-md-7 col-xs-12" type="password" name="password" required>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="button"  id="submit" class="btn btn-info">Login</button>
                            </div>
                        </div>
                    </form>
                    <div id="message"></div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.html';?>
    <!-- /page content -->
</div>
</body>
</html>
<?php ob_flush();?>
