$(document).ready(function () {
    var html = '',table='',patientid,prescribtionid;


    $(window).load(function () {
/*        alert('page loaded..');*/
      
        patientid = $('.right_col').attr('id');
        var jsobj = {
            patientID : patientid,
            call : 'Notification'
        }
        $.post('../classes/helper.php',jsobj,function (response) {
            console.log(response);
            var jsObj = JSON.parse(response);
            html += '<div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12 notifications">';
            html += '<div class="tile-stats">';
            html += '<div class="icon"><i class="fa fa-comments-o"></i></div>';
            html += '<div class="count">'+jsObj['rowsAffected']+'</div>';
            html += '<h3>New Activity</h3>';
            html += '<p>See your activity tab for details</p></div></div>';
            $('#notification').html(html);
        });
        var jsobj = {
            patientID : patientid,
            call : 'Pactivity'
        }
        $.post('../classes/helper.php',jsobj,function (response) {
            console.log(response);
            var jsObj = JSON.parse(response);
            table += '<table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">';
            table += '<thead>';
            table += '<tr role="row">';
            table += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 157px;">Dr Name</th>';
            table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 259px;">Speciality</th>';
            table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 117px;">Date</th>';
            table += '</tr>';
            table += '</thead>';
            table += '<tbody>';
            for (var i=0;i<jsObj['rowsAffected'];i++){
                table += '<tr role="row" class="activity" id="'+jsObj['result'][i].id+'">';
                table += '<td>'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</td>';
                table += '<td>'+jsObj['result'][i].name+'</td>';
                table += '<td>'+jsObj['result'][i].Dates+'</td>';
                table += '</tr>';
            }
            table += '</tbody>';
            table += '</table>';
            $('#patientActivity').html(table);
        });
        var jsobj = {
            patientID : patientid,
            call : 'PatientSharingDoc'
        }
        $.post('../classes/helper.php',jsobj,function (response) {
            table = '';
            console.log(response);
            var jsObj = JSON.parse(response);
            table += '<div class="x_panel">';
            table += '<div class="x_title">';
            table += '<h2>Sharing Reports<small>Corresponding To Appointment ID</small></h2>';
            table += '<ul class="nav navbar-right panel_toolbox">';
            table += '<li><a class="collapse-link"><i class="fa fa-chevron-up"> Collapse</i></a> </li>';
            table += '<li><a class="close-link"><i class="fa fa-close"> Close</i></a>';
            table += '</li> </ul>';
            table += '<div class="clearfix"></div> </div>';
            table += '<div class="x_content">';
            table += '<p class="text-muted font-13 m-b-30">  Add some text here </p>';
            table += '<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">';
            table += '<div class="row">';
            table += '<div class="col-sm-12">';
            table += '<table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">';
            table += '<thead>';
            table += '<tr role="row">';
            table += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 157px;">Dr. Name</th>';
            table += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 157px;">Appointment ID</th>';
            table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 259px;">Perscribtion Details</th>';
            table += '</tr>';
            table += '</thead>';
            table += '<tbody>';
            for (var i=0;i<jsObj['rowsAffected'];i++){
                table += '<tr role="row" class="sharingData" id="'+jsObj['result'][i].p_id+'">';
                table += '<td>'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</td>';
                table += '<td>'+jsObj['result'][i].id+'</td>';
                table += '<td>'+jsObj['result'][i].p_detail+'</td>';
                table += '</tr>';
            }
            table += '</tbody>';
            table += '</table>';
            table += '</div> </div> </div> </div> </div>';
            $('#PatientSharingDoc').html(table);
        });

        
        
    });
    $('#sharedData').hide();
    $('#upload').hide();

    $("body").delegate( ".sharingData", "click", function(){
        /*alert($(this).attr("id"));*/
        prescribtionid = $(this).attr("id");
        $('#PatientSharingDoc').hide();
        //alert($(this).attr("id"));
        var jsobj = {
            prescribtionId : $(this).attr("id"),
            call     : 'sharedData'
        }
        $.post( "../classes/helper.php",jsobj,function (data) {
            var jsObj = JSON.parse(data);
            html = '';
            html += '<section class="panel">';
            html += '<div class="x_title">';
            html += '<h2>Appointment Details</h2>';
            html += '<div class="clearfix"></div>';
            html += '</div>';
            html += '<div class="panel-body">';
            html += '<h3 class="green"><i class="fa fa-clock-o"></i> '+jsObj['result'][0].s_time+' To '+jsObj['result'][0].e_time+' <i class="fa fa-calendar-o"></i> '+jsObj['result'][0].Dates+'</h3>';
            html += '<p></p>';
            html += '<br>';
            html += '<div class="project_detail">';
            html += '<p class="title">Problem Description</p>';
            html += '<p>'+jsObj['result'][0].description+'</p>';
            html += '<p class="title">Doctor Prescribtion</p>';
            html += '<p>'+jsObj['result'][0].p_detail+'</p>';
            html += '</div><br>';
            html += '<p class="title">Shared files to the corresponding appointment&nbsp;<code>Click for download</code></p>';
            html += '<ul class="-list">';
            var str = jsObj['result'][0].filePath;
            var res = str.split("^");
            for (var i=0; i<res.length; i++) {
                url = res[i].substr(1 + res[i].lastIndexOf("/"));
                html += '<li><a href="'+res[i]+'">'+url.replace(/[0-9]_/g, '')+'</a></li>';
            }
            html += '</ul>';
            html += '</div>';
            html += '</section>';
            $('#sharedData').html(html);
            $('#sharedData').fadeIn(500);
            $('#upload').show();
        });
        
    });
    
    

    $("body").delegate( ".activity", "click", function(){
        //alert($(this).attr("id"));
        var ApptId = parseInt($(this).attr("id"));
        var jsobj = {
            ApptId : ApptId,
            call     : 'getPatientAppt'
        }
        $.post( "../classes/helper.php",jsobj,function (data){
            var jsObj = JSON.parse(data);
            html = '';
            html += '<div class="tile-stats">';
            html += '<div class="icon"><i class="fa fa-check-square-o"></i> </div>';
            html += '<div class="count">Appointment ID : '+jsObj['result'][0].id+'</div>';
            html += '<h3>Timings  '+jsObj['result'][0].s_time+' to '+jsObj['result'][0].e_time+'</h3>';
            html += '<h3>'+jsObj['result'][0].description+'</h3> </div>';
            html += '<p>Your Appointment was confirmed by doctor you will be pay appointment fees to the corresponding appointment ID </p> </div>';
            /*html += '<div class="text-center mtop20">';*/
            html += '<button id="ignore"  class="btn btn-primary">Back</button>';
            /*html += '</div>';*/
            $('#patientActivity').hide();
            $('#view_appointments').html(html);
            $('#view_appointments').show();
    });
    });

    $("body").delegate( "#ignore", "click", function() {
        $('#patientActivity').show();
        $('#view_appointments').hide();
    });
    
    $("#back").click(function() {
        $('#PatientSharingDoc').show();
        $('#sharedData').hide();
        $('#upload').hide();
    });


    $('#upload').on('click', function () {
        /*alert(patientid);*/
        var form_data = new FormData();
        var ins = document.getElementById('multiFiles').files.length;
        for (var x = 0; x < ins; x++) {
            form_data.append("files[]", document.getElementById('multiFiles').files[x]);
        }
        form_data.append("patientId",patientid);
        form_data.append("prescribtionId",prescribtionid);
       $.ajax({
            url: '../classes/upload.php', // point to server-side PHP script
            dataType: 'text', // what to expect back from the PHP script
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (response) {
                $('#msg').html(response);
                setInterval(function(){
                    window.location.href = "user-profile.php";
                }, 10000);
                // display success response from the PHP script
            },
            error: function (response) {
                $('#msg').html(response); // display error response from the PHP script
            }
        });
    });



});