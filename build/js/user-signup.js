/**
 * Created by AbdulMoiz on 12/25/16.
 */
$(document).ready(function(){
    var html,doctorId,ApptId,userid;
    $('#confirm').hide();
    $("#Days").hide();
    $("#time").hide();
    $('#payment').hide();
    /*  $("#myTabContent").show();*/
    $("#takeAppointment").hide();

    /* signUp page dependent select combo box  started */
    $('#city').change(function(){
        var jsonObj = {
            cityId : $('#city').val(),
            call : 'getAreasForCity'
        };
        $.post( "../classes/helper.php",jsonObj, function( data ) {
            html = "";
            var jsObj = JSON.parse(data);
            for(var i=0;i<jsObj['result'].length;i++){
                html += "<option value='"+jsObj['result'][i]['id']+"'>"+jsObj['result'][i]['name']+"</option>";
            }
            $('#area').html(html);
        });
    });
    /* signUp page dependent select combo box  ended */

    /* Patient-profile page search doctor for taking an appointment started */
    var s_id = 0,fees = 0, location = 0;
    search(0,0,0);
    $('#location').change(function () {
        location = $('#location').val();
        search(s_id,fees,location);
    });
    $('#speciality').change(function () {
        s_id = $('#speciality').val();
        search(s_id,fees,location);
    });
    $('#fees').change(function () {
        fees = $('#fees').val();
        search(s_id,fees,location);
    });
    function search(S_id,fees,location) {
        var jsonObj = {
            speciality : S_id,
            fees : fees,
            Location : location,
            call : 'filter'
        };
        $.post( "../classes/helper.php",jsonObj,function (data){
            html = "";
            var jsObj = JSON.parse(data);
            console.log(jsObj);
            for(var i=0;i<jsObj['rowsAffected'];i++) {
                html+='<div class="col-md-6 col-sm-6 col-xs-12 profile_details" id="'+jsObj['result'][i].id+'">';
                html+='<div class="well profile_view">';
                html+='<div class="col-sm-12">';
                html+='<h4 class="brief"><i>'+jsObj['result'][i].speciality+'</i></h4>';
                html+='<div class="left col-xs-7">';
                html+='<h2>'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</h2>';
                html+='<p><strong>About: </strong> '+jsObj['result'][i].degree+' </p>';
                html+='<ul class="list-unstyled">';
                html+='<li><i class="fa fa-building"></i> Address: '+jsObj['result'][i].address+'</li>';
                html+='<li><i class="fa fa-phone"></i> Phone #: '+jsObj['result'][i].phone+'</li>';
                html+='</ul>';
                html+='</div>';
                html+='<div class="right col-xs-5 text-center">';
                html+='<img src='+jsObj['result'][i].picPath+' alt="" class="img-circle img-responsive" title="'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'">';
                html+='</div>';
                html+='</div>';
                html+='<div class="col-xs-12 bottom text-center">';
                html+='<div class="col-xs-12 col-sm-6 emphasis">';
                html+='<p class="ratings">';
                html+='<a>4.0 </a>';
                html+='<a href="#"><span class="fa fa-star"></span';
                html+='<a href="#"><span class="fa fa-star"></span></a>';
                html+='<a href="#"><span class="fa fa-star"></span></a>';
                html+='<a href="#"><span class="fa fa-star"></span></a>';
                html+='<a href="#"><span class="fa fa-star-o"></span></a>';
                html+='</p>';
                html+='</div>';
                html+='<div class="col-xs-12 col-sm-6 emphasis">';
                html+='<button type="button" class="btn btn-success btn-xs take-appointment"> <i class="fa">';
                html+='</i> <i class="fa fa-comments-o"></i>Take Appointment</button>';
                html+='<a data-popup-open="popup-1" id="'+jsObj['result'][i].id+'" href="#" type="button" class="btn btn-warning btn-xs view-profile">';
                html+='<i class="fa fa-user"> </i> View Profile';
                html+='</a>';
                html+='<a  id="'+jsObj['result'][i].id+'" type="button" class="btn btn-primary btn-xs payment">';
                html+='<i class="fa fa-cc-visa"> </i>&nbsp;Payment&nbsp;';
                html+='</a>';
                html+='</div>';
                html+='</div>';
                html+='</div>';
                html+='</div>';
            }
            $('#Doctors').html(html);
        });
    }
    /* Patient-profile page search doctor for taking an appointment ended */
    $("body").delegate( ".payment", "click", function() {
       /// alert($(this).attr("id"));
        var html = '';
        html += '<div class="col-md-12 col-sm-12 col-xs-12">';
        html += '<div class="x_panel">';
        html += '<div class="x_title">';
        html += '<img src="images/Easypaisa.png" width="10%" height="10%" >';
        html += '<div class="clearfix"></div>';
        html += '</div>';
        html += '<div class="x_content">';
        html += '<div class="row invoice-info" id="EasyPaisa_Data"> </div>';
        html += '<form class="form-horizontal form-label-left input_mask" id="easy-paisa">';
        html += '<div class="form-group">';
        html += '<label class="control-label col-md-2 col-sm-2 col-xs-4">Appointment ID </label>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12">';
        html += '<input type="text" name="AppointmentID" class="form-control" placeholder="Enter your appointment id"> </div> </div>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">';
        html += '<input type="text" class="form-control has-feedback-left" name="Sender-NIC" placeholder="Sender NIC Number">';
        html += '<span class="fa fa-male form-control-feedback left" aria-hidden="true"></span>';
        html += '</div>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">';
        html += '<input type="text" class="form-control has-feedback-left" name="Receiver-NIC" placeholder="Receiver NIC Number">';
        html += '<span class="fa fa-male form-control-feedback left" aria-hidden="true"></span>';
        html += '</div>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">';
        html += '<input type="text" class="form-control has-feedback-left" name="Sender-Mobile" placeholder="Sender Mobile Number">';
        html += '<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>';
        html += '</div>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">';
        html += '<input type="text" class="form-control has-feedback-left" name="Receiver-Mobile" placeholder="Receiver Mobile Number">';
        html += '<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>';
        html += '</div>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">';
        html += '<input type="text" class="form-control has-feedback-left" name="Amount" placeholder="Enter Amount To Transfer">';
        html += '<span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>';
        html += '</div>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">';
        html += '<input type="password" class="form-control has-feedback-left" name="PIN-Code" placeholder="Enter Secret Code">';
        html += '<span class="fa fa-code form-control-feedback left" aria-hidden="true"></span>';
        html += '</div>';
        html += '<div class="ln_solid"></div>';
        html += '<div class="form-group">';
        html += '<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-0">';
        html += '<button  type="submit" class="btn btn-success ">Submit</button>';
        html += '</div> </div> </form> </div> </div> </div>';
        html += '<div class="col-md-12 col-sm-12 col-xs-12">';
        html += '<div class="x_panel">';
        html += '<div class="x_title">';
        html += '<img src="images/mastercard.png" width="10%" height="10%" >';
        html += '<div class="clearfix"></div> </div>';
        html += '<div class="x_content">';
        html += '<div class="row invoice-info" id="Bank_Data"> </div>';
        html += '<form class="form-horizontal form-label-left input_mask" id="master-card">';
        html += '<div class="form-group">';
        html += '<label class="control-label col-md-2 col-sm-2 col-xs-4">Select Bank</label>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12">';
        html += '<select class="form-control" name="Bank">';
        html += '<option value="-1">Select Option</option>';
        html += '<option value="Standard Charter">Standard Charter</option>';
        html += '<option value="UBL">UBL</option>';
        html += '<option value="Bank Alfalah">Bank Alfalah</option>';
        html += '</select>';
        html += '</div> </div>';
        html += '<div class="form-group">';
        html += '<label class="control-label col-md-2 col-sm-2 col-xs-4">Account</label>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12">';
        html += '<input type="text" name="Account-Number" class="form-control" placeholder="Enter your account number"> </div> </div>';
        html += '<div class="form-group">';
        html += '<label class="control-label col-md-2 col-sm-2 col-xs-4">Transfer To Account</label>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12">';
        html += '<input type="text" name="Receiver-Account-Number" class="form-control" placeholder="Enter receiver account number"> </div> </div>';
        html += '<div class="form-group">';
        html += '<label class="control-label col-md-2 col-sm-2 col-xs-4">Transfer Amount</label>';
        html += '<div class="col-md-6 col-sm-6 col-xs-12">';
        html += '<input type="text" name="Transfer-Account" class="form-control" placeholder="Enter amount to transfer"> </div> </div>';
        html += '<div class="ln_solid"></div>';
        html += '<div class="form-group">';
        html += '<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-7">';
        html += '<button type="submit" class="btn btn-success">Submit</button> </div>';
        html += '</div> </form><br><br>';
        html += '<button id="ShowDoctor" type="button" class="btn btn-primary">Back</button>';
        html += '</div> </div> </div>';
        $('#Doctors').hide();
        $('#payment').html(html);
        $('#payment').show();
    });
    $('#EasyPaisa_Data').hide();
    $('body').delegate('#easy-paisa', 'submit', function() {
        //alert('working');
        var html = '',i=0;
        var data =  $(this).serializeArray();
        html += '<div class="col-sm-4 invoice-col">';
        $.each(data,function(index,feild){
            if (i == 0){
                html += '<b>'+feild.name+' # '+feild.value+'<br><br>';
            }else{
                html += '<br><b>'+feild.name+' :</b>'+feild.value;
            }
            i++;
            ///console.log(feild.name+" --> "+feild.value);
        });
        html += '</div>';
        $('#EasyPaisa_Data').html(html);
        $('#EasyPaisa_Data').show();
        $(this).hide();
        return false;
    });

    $('body').delegate('#master-card', 'submit', function() {
        //alert('working');
        var html = '',i=0;
        var data =  $(this).serializeArray();
        html += '<div class="col-sm-4 invoice-col">';
        $.each(data,function(index,feild){
            if (i == 0){
                html += '<b>'+feild.name+' : '+feild.value+'<br><br>';
            }else{
                html += '<br><b>'+feild.name+' :</b> '+feild.value;
            }
            i++;
            ///console.log(feild.name+" --> "+feild.value);
        });
        html += '</div>';
        $('#Bank_Data').html(html);
        $('#Bank_Data').show();
        $(this).hide();
        return false;
    });
    
    $("body").delegate( "#ShowDoctor", "click", function() {
        $('#Doctors').show();
        $('#payment').hide();
    });
    /* Patient-profile page  doctor Payment started */

    /* Patient-profile page  doctor Payment ended */


    /* Patient-profile page  doctor view profile started */
    $(function() {
        //--http://inspirationalpixels.com/tutorials/custom-popup-modal--- OPEN
        $("body").delegate( '[data-popup-open]', "click", function(e)  {
            console.log($(this).attr("id"));
            var jsonObj = {
                doctorid : $(this).attr("id"),
                call : 'ViewDoctor'
            };
            $.post( "../classes/helper.php",jsonObj,function (data) {
                html = "";
                var jsObj = JSON.parse(data);
                for(var i=0;i<jsObj['rowsAffected'];i++) {
                html += '<img class="img-responsive avatar-view" src='+jsObj['result'][i].picPath+' title="'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'"/>';
                html += '<h2>University / Board</h2>';
                html += '<p>'+jsObj['result'][i].board+'</p>';
                html += '<h2>Degree / Certificate</h2>';
                html += '<p>'+jsObj['result'][i].degree+'</p>';
                html += '<h2>Speciality</h2>';
                html += '<p>'+jsObj['result'][i].name+'</p>';
                html += '<p><a data-popup-close="popup-1" href="#">Close</a></p>';
                html += '<a class="popup-close" data-popup-close="popup-1" href="#">x</a>';
                }
                $('#ViewDoctor').html(html);
            });
            var targeted_popup_class = jQuery(this).attr('data-popup-open');
            $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
            e.preventDefault();
        });

        //--http://inspirationalpixels.com/tutorials/custom-popup-modal#step-html--- CLOSE
        $("body").delegate( '[data-popup-close]', "click" , function(e)  {
            var targeted_popup_class = jQuery(this).attr('data-popup-close');
            $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

            e.preventDefault();
        });
    });
    /* Patient-profile page  doctor view profile ended */

    /* Patient-profile page select doctor for taking an appointment started */
    $("body").delegate( "button.take-appointment", "click", function() {
        var html = '';
        doctorId = parseInt($(this).parents().eq(3).attr("id"));
        console.log(doctorId);
        /*        $("#myTabContent").hide();*/
        $("#Doctors").hide();
        var jsObj = {
            'doctorid' : doctorId,
            'call' : "Doctor_Available_Day"
        }
        $.post("../classes/helper.php",jsObj,function (response) {
            var jsObj = JSON.parse(response);
            html += '<table class="table table-striped jambo_table bulk_action">';
            html += '<thead><tr><th>Available Days In Week</th><th>Opening Time</th><th>Closing Time</th> </tr></thead>';
            html += '<tbody>';
            for (var i=0 ; i < jsObj['rowsAffected'] ; i++) {
                html += '<tr >';
                html += '<td>'+jsObj['result'][i].name+'</td>';
                html += '<td >'+jsObj['result'][i].starttime+'</td>';
                html += '<td >'+jsObj['result'][i].endtime+'</td>';
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table>';
            $("#Days").show();
            $("#Days").html(html);
        });
        $("#time").show();
        $("#takeAppointment").show();
    });
    /* Patient-profile page select doctor for taking an appointment ended */

    /* Patient-profile page taking an appointment started */
    $('#send').click(function () {
        var array = $('#takeAppointment').serializeArray();
        var jsObj={};
        $.each(array,function (index,feild) {
            jsObj[feild.name] = feild.value;
        });
        jsObj['doctorId'] = doctorId;
        jsObj['call'] = 'Appointment';
        console.log(jsObj);
        $.post("../classes/helper.php",jsObj,function (data) {
            var Obj = JSON.parse(data);
            console.log(Obj);
            if (Obj['rowsAffected'] == 1 && Obj['status'] == 'success') {
                $('#confirm').show();
                $('#confirm' ).css({"background-color":"rgba(38,185,154,0.88)","border-color":"rgba(38,185,154, 0.88)","color": "#ffffff"});
                $('#confirm').text('Your appointment has been sent to your doctor');
            }else{
                $('#confirm').show();
                $('#confirm' ).css({"background-color":"rgba(185, 38, 52, 0.88","border-color":"rgba(185, 38, 45, 0.88)"});
                $('#confirm').text('Please fill the required feild...');
            }
        });
    });
    /* Patient-profile page taking an appointment ended */


    $('#view_patient').hide();
    $('#Table').show();
    $('#FilterByDate').show();

    /* Doctor-profile page view appointment detail and booked time started */
    $("body").delegate( ".odd", "click", function() {
        console.log($(this).attr("id"));
        ApptId = $(this).attr("id");
        var jsonObj = {
            ApptId : $(this).attr("id"),
            call : 'Check_appointment'
        };
        $.post("../classes/helper.php",jsonObj,function (Obj){
            iDependOnMyParameter(Obj);

        });
        function iDependOnMyParameter(param) {
            var jsObj = JSON.parse(param);
            $('#problem_description p').text(jsObj['result'][0].description);
            $('#name').text(jsObj['result'][0].fname+" "+jsObj['result'][0].lname);
            $('#nic').text(jsObj['result'][0].nic);
            $('#phone').text(jsObj['result'][0].phone);
            $('#address').text(jsObj['result'][0].address);
            $('#email').text(jsObj['result'][0].email);
            var jsObj = {
                'date' : jsObj['result'][0].Dates,
                'doctorid' : jsObj['result'][0].doctorid,
                'call' : 'Doctor_Time_Slot'
            }
            $.post("../classes/helper.php",jsObj,function (response){
                var jsObj = JSON.parse(response);
                html = '';
                html += '<div id="time" class="row tile_count">';
                for(var i = 0 ; i<jsObj['rowsAffected'] ; i++) {
                    html += '<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">';
                    html += '<span class="count_top"><i class="fa fa-user"></i> '+ jsObj['result'][i].fname + ' ' + jsObj['result'][i].lname + '</span>';
                    html += '<div class="count">' + jsObj['result'][i].s_time + '-' + jsObj['result'][i].e_time + '</div>';
                    html += '<span class="count_bottom">' + jsObj['result'][i].Dates + '</span>';
                    html += '</div>';
                }
                html += '</div>';
                $('#time_slot').html(html);
            });
            
            // You should do your work here that depends on the result of the request!
        }

        $('#view_patient').show();
        $('#Table').hide();
        $('#FilterByDate').hide();
        /* $('#table').hide();*/
    });
    /* Doctor-profile page view appointment detail ended */


    /* Doctor-profile page back to appointment list started */
    $('#back_doctorTab').click(function () {
        $('#view_patient').hide();
        $('#Table').show();
        $('#FilterByDate').show();
    });
    /* Doctor-profile page back to appointment list  ended */

    /* Doctor-profile page appointment filter by date started */
    $('#dateFilter').change(function () {
        console.log($('input[name=doctorid]').val());
        var jsonObj = {
            date : $(this).val(),
            doctorid : $('input[name=doctorid]').val(),
            call : 'filterByDate'
        };
        $.post( "../classes/helper.php",jsonObj,function (data){
            var jsObj = JSON.parse(data);
            console.log(jsObj);
            html = "";
            html =  '<table id="doctorTable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">';
            html += '<thead>';
            html += '<tr role="row">';
            html += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 160px;">Name</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 261px;">Description</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 113px;">Date</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            for (var i=0 ; i < jsObj['rowsAffected'] ; i++){
                html += '<tr role="row" class="odd" id="'+jsObj['result'][i].id+'">';
                html += '<td class="sorting_1">'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</td>';
                html += '<td>'+jsObj['result'][i].description+'</td>';
                html += '<td>'+jsObj['result'][i].Dates+'</td>';
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table>';
            $('#Table').html(html);
        });
    });
    /* Doctor-profile page appointment filter by date ended */

    /* Doctor-profile page confirmed appointment  start */
    $('#ca_dateFilter').change(function () {
        console.log($('input[name=doctorid]').val()+" "+ $(this).val());
        var jsonObj = {
            date : $(this).val(),
            doctorid : $('input[name=doctorid]').val(),
            call : 'CA_filterByDate'
        };
        $.post( "../classes/helper.php",jsonObj,function (data){
            var jsObj = JSON.parse(data);
            console.log(jsObj);
            html = "";
            html =  '<table id="doctorTable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">';
            html += '<thead>';
            html += '<tr role="row">';
            html += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 160px;">Patient Name</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">NIC number</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Phone number</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Description</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Dates</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            for (var i=0 ; i < jsObj['rowsAffected'] ; i++){
                html += '<tr role="row" class="appt" id="'+jsObj['result'][i].id+'">';
                html += '<td class="sorting_1">'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</td>';
                html += '<td class="sorting_1">'+jsObj['result'][i].nic+'</td>';
                html += '<td class="sorting_1">'+jsObj['result'][i].phone+'</td>';
                html += '<td class="sorting_1">'+jsObj['result'][i].description+'</td>';
                html += '<td class="sorting_1">'+jsObj['result'][i].Dates+'</td>';
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table>';
            $('#Confirm_Appt').html(html);
        });
    });
    /* Doctor-profile page confirmed appointment  end */
    

    /* Doctor-profile page appointment preffered date started */
    $('#ApptConfirm').click(function () {
/*        console.log("AppointmentId : "+ApptId+"Start Time  "+$('#s_time').val()+" End Time "+$('#e_time').val());*/
        if( $('#s_time').val() == '' &&  $('#e_time').val() == ''){
            alert('Please giving appointment time');
        }else{
        var jsobj = {
             AppointmentId : ApptId,
            s_time : $('#s_time').val(),
            e_time : $('#e_time').val(),
            call : 'AppointmentConfirm'
        }
        $.post("../classes/helper.php",jsobj,function (response) {
            alert('Appointment Confirmed..');
            console.log(response);
        });
        }
/* change requirement 3rd milestone        if(value == ''){
            /!* alert('value is null'+value);*!/
            var jsobj = {
                AppointmentId : ApptId,
                call : 'AppointmentConfirm'
            }
            $.post("../classes/helper.php",jsobj,function (response) {
                alert('Appointment Confirmed..');
                console.log(response);
            });
        }else{
            /!*            alert(value);*!/
            var jsobj = {
                AppointmentId : ApptId,
                prefferedDate : value,
                call : 'ModifyApptDate'
            }
            $.post("../classes/helper.php",jsobj,function (response) {
                alert('Appointment Confirmed..');
                console.log(response);
            });
        }*/

    });
    /* Doctor-profile page appointment preffered date ended */

    /* usersignup back button click start */
  /*  $('#back').click(function(){
        window.location.href = "login.php";
    });*/
    /* usersignup back button click end */

    /* doctorsignup timetable back button click start */
    $('#dtback').click(function(){
        window.location.href = "login.php";
    });
    /* doctorsignup timetable back button click end */


    /* usersignup form submit click start */
    $('#submit').click(function(){
        if($('#password').val() != $('#cpassword').val()){
            $('#password').css('border','1px solid red');
            $('#cpassword').css('border','1px solid red');
            /*return false;*/
        }else{
                var text = '';
                var jsObj = {};
                var data = $('#patientsignup').serializeArray();
                $.each(data,function(index,feild){
                    jsObj[feild.name] = feild.value;
                    console.log(feild.name+" "+feild.value);
                });
                jsObj['call'] = 'usersignup';
                $.post("../classes/helper.php",jsObj,function (data) {
                    var response = JSON.parse(data);
                    if( typeof response === 'string' ) {
                        text += '<div class="alert alert-danger alert-dismissible fade in" role="alert">';
                        text += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
                        text += '<strong>Required Inputs : </strong>' + response + '</div>';
                        $('#status').html(text);
                    } else {
                        $(':input','#patientsignup')
                            .not(':button, :submit, :reset, :hidden')
                            .val('')
                            .removeAttr('checked')
                            .removeAttr('selected');
                        $("#patientsignup").trigger('reset'); //jquery
                        document.getElementById("patientsignup").reset();
                        text += '<div class="alert alert-success alert-dismissible fade in" role="alert">';
                        text += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
                        text += '<strong>Status : </strong>You Are Successfully signUp</div>';
                        $('#status').html(text);
                        setInterval(function(){
                            window.location.href = "login.php";
                        }, 5000);
                    }
                });
        }
    });
    /* usersignup form submit click end */

    $('#form').show();
    $('#form2').hide();
    /* Doctor-signup form submit click start */
    $('#dsubmit').click(function(){
        if($('#password').val() != $('#cpassword').val()){
            $('#password').css('border','1px solid red');
            $('#cpassword').css('border','1px solid red');
            /*return false;*/
        }else{
            var text = '';
            var jsObj = {};
            var data = $('#doctorsignup').serializeArray();
            $.each(data,function(index,feild){
                jsObj[feild.name] = feild.value;
                console.log(feild.name+" --> "+feild.value);
            });
            jsObj['call'] = 'doctorsignup';
            $.post("../classes/helper.php",jsObj,function (data) {
                var response = JSON.parse(data);
                userid = response['userid'];
                console.log(response);
                console.log(response['userid']);
                if( typeof response === 'string' ) {
                    text += '<div class="alert alert-danger alert-dismissible fade in" role="alert">';
                    text += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
                    text += '<strong>Required Inputs : </strong>' + response + '</div>';
                    $('#status').html(text);
                } else {
                    $(':input','#doctorsignup')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .removeAttr('checked')
                        .removeAttr('selected');
                    $("#doctorsignup").trigger('reset'); //jquery
                    document.getElementById("doctorsignup").reset();
                    text += '<div class="alert alert-success alert-dismissible fade in" role="alert">';
                    text += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
                    text += '<strong>Status : </strong>You Are Successfully signUp</div>';
                    $('#status').html(text);
                    setInterval(function(){
                        $('#form').hide();
                        $('#form2').show();
                    }, 5000);
                }
            });
        }
    });
    /* Doctor-signup form submit click end */

    /* Doctor-signup Timetable checkbox working start */
    $("input[name=m_start]").prop('disabled', true);
    $("input[name=m_end]").prop('disabled', true);
    $("input[name=tu_start]").prop('disabled', true);
    $("input[name=tu_end]").prop('disabled', true);
    $("input[name=w_start]").prop('disabled', true);
    $("input[name=w_end]").prop('disabled', true);
    $("input[name=th_start]").prop('disabled', true);
    $("input[name=th_end]").prop('disabled', true);
    $("input[name=f_start]").prop('disabled', true);
    $("input[name=f_end]").prop('disabled', true);
    $("input[name=sa_start]").prop('disabled', true);
    $("input[name=sa_end]").prop('disabled', true);
    $("input[name=su_start]").prop('disabled', true);
    $("input[name=su_end]").prop('disabled', true);
    /*Add dynamically required attribute start*/
 /*   $("input[name=sa_start]").removeAttr('required');
    $("input[name=sa_end]").removeAttr('required');*/
    $('#monday').change(function() {
        if(this.checked) {
            $("input[name=m_start]").prop('disabled', false);
            $("input[name=m_end]").prop('disabled', false);
        }else {
            $("input[name=m_start]").prop('disabled', true);
            $("input[name=m_end]").prop('disabled', true);
        }
    });
    $('#tuesday').change(function() {
        if(this.checked) {
            $("input[name=tu_start]").prop('disabled', false);
            $("input[name=tu_end]").prop('disabled', false);
        }else {
            $("input[name=tu_start]").prop('disabled', true);
            $("input[name=tu_end]").prop('disabled', true);
        }
    });
    $('#wednesday').change(function() {
        if(this.checked) {
            $("input[name=w_start]").prop('disabled', false);
            $("input[name=w_end]").prop('disabled', false);
        }else {
            $("input[name=w_start]").prop('disabled', true);
            $("input[name=w_end]").prop('disabled', true);
        }
    });
    $('#thursday').change(function() {
        if(this.checked) {
            $("input[name=th_start]").prop('disabled', false);
            $("input[name=th_end]").prop('disabled', false);
        }else {
            $("input[name=th_start]").prop('disabled', true);
            $("input[name=th_end]").prop('disabled', true);
        }
    });
    $('#friday').change(function() {
        if(this.checked) {
            $("input[name=f_start]").prop('disabled', false);
            $("input[name=f_end]").prop('disabled', false);
        }else {
            $("input[name=f_start]").prop('disabled', true);
            $("input[name=f_end]").prop('disabled', true);
        }
    });
    /*$('#freeform_first_name').removeAttr('required');

     $('#freeform_first_name').attr('required', 'required');*/
    $('#saturday').change(function() {
        if(this.checked) {
            $("input[name=sa_start]").attr('required', 'required');
            $("input[name=sa_end]").attr('required', 'required');
            $("input[name=sa_start]").prop('disabled', false);
            $("input[name=sa_end]").prop('disabled', false);
        }else {
            $("input[name=sa_start]").removeAttr('required');
            $("input[name=sa_end]").removeAttr('required');
            $("input[name=sa_start]").prop('disabled', true);
            $("input[name=sa_end]").prop('disabled', true);
        }
    });
    $('#sunday').change(function() {
        if(this.checked) {
            $("input[name=su_start]").prop('disabled', false);
            $("input[name=su_end]").prop('disabled', false);
        }else {
            $("input[name=su_start]").prop('disabled', true);
            $("input[name=su_end]").prop('disabled', true);
        }
    });
    /* Doctor-signup Timetable checkbox working end */

    /* Doctor-signup timetable form submit click start */
    $('#dtsubmit').click(function(){
        var text = '';
        var jsObj = {};
        var data = $('#doctorsignUp_time').serializeArray();
        $.each(data,function(index,feild){
            jsObj[feild.name] = feild.value;
            console.log(feild.name+" --> "+feild.value);
        });
        jsObj['userId'] = userid;
        jsObj['call'] = 'doctorsignupTimetable';
        $.post( "../classes/helper.php",jsObj,function (data) {
            var response = JSON.parse(data);
            if (response['rowsAffected'] == 1){
                alert('Your Time Table Successfully Updated..');
                setInterval(function () {
                    window.location.href = "login.php";
                }, 5000);
            }
            if (typeof response === 'string') {
                text += '<div class="alert alert-danger alert-dismissible fade in" role="alert">';
                text += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
                text += '<strong>Status : </strong>'+response+'</div>';
                $('#statusTime').html(text);
            } else {
                $("input[name=m_start]").prop('disabled', true);
                $("input[name=m_end]").prop('disabled', true);
                $("input[name=tu_start]").prop('disabled', true);
                $("input[name=tu_end]").prop('disabled', true);
                $("input[name=w_start]").prop('disabled', true);
                $("input[name=w_end]").prop('disabled', true);
                $("input[name=th_start]").prop('disabled', true);
                $("input[name=th_end]").prop('disabled', true);
                $("input[name=f_start]").prop('disabled', true);
                $("input[name=f_end]").prop('disabled', true);
                $("input[name=sa_start]").prop('disabled', true);
                $("input[name=sa_end]").prop('disabled', true);
                $("input[name=su_start]").prop('disabled', true);
                $("input[name=su_end]").prop('disabled', true);
                text += '<div class="alert alert-success alert-dismissible fade in" role="alert">';
                text += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
                text += '<strong>Status : </strong> Your Time Table Successfully Updated</div>';
                $('#statusTime').html(text);
                setInterval(function () {
                    window.location.href = "login.php";
                }, 5000);
            }
        });
    });
    /* Doctor-signup timetable form submit click end */

    /* Patient profile check date according to doctor days start */
    $('#date').change(function(){
        var html = '';
        /*alert('working..');*/
        $('#confirm').hide();
        /*alert(this.value);*/         //Date in full format alert(new Date(this.value));
        var Obj = {
            'date' : $(this).val(),
            'doctorid' : doctorId,
            'call' : 'Doctor_Time_Slot'
        }
        $.post("../classes/helper.php",Obj,function (response){
            var jsObj = JSON.parse(response);
            html += '<div id="time" class="row tile_count">';
            for(var i = 0 ; i<jsObj['rowsAffected'] ; i++) {
                html += '<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">';
                html += '<span class="count_top"><i class="fa fa-user"></i> '+ jsObj['result'][i].fname + ' ' + jsObj['result'][i].lname + '</span>';
                html += '<div class="count">' + jsObj['result'][i].s_time + '-' + jsObj['result'][i].e_time + '</div>';
                html += '<span class="count_bottom">' + jsObj['result'][i].Dates + '</span>';
                html += '</div>';
            }
            html += '</div>';
            $('#time_slot').html(html);
        });
        var myDate = new Date(this.value);
        var jsObj = {
            'dayid' : myDate.getDay()+1,
            'doctorid' : doctorId,
            'call' : 'Doctor_Available_Date'
        }
        $.post("../classes/helper.php",jsObj,function (response) {
            var Obj = JSON.parse(response);
            if (Obj['rowsAffected'] == 0 && Obj['status'] == 'success') {
                $('#confirm' ).css({"background-color":"rgba(185, 38, 52, 0.88","border-color":"rgba(185, 38, 45, 0.88)"});
                $('#confirm').show();
                $('#confirm').text('Please select doctor available days....');
            }
        });
    });
    /* Patient profile check date according to doctor days end */




    $('#password').keyup(function(){
        $('#password').css('border','1px solid #ccc');
        $('#cpassword').css('border','1px solid #ccc');
    });

    $('#cpassword').keyup(function(){
        $('#password').css('border','1px solid #ccc');
        $('#cpassword').css('border','1px solid #ccc');
    });


});




