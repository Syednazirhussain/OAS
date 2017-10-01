$(document).ready(function() {
    $('#request_view').hide();
    $('#A_request_confirm').hide();
var html = '',doctorId;
    $(window).load(function () {
        /*alert('working');*/
        var jsobj = {
            call : 'RegisterRequest'
        }
        $.post( "../classes/helper.php",jsobj,function (data){
            var jsObj = JSON.parse(data);
            html += '<table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">';
            html += '<thead>';
            html += '<tr role="row">';
            html += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 157px;">Name</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 259px;">Address</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 117px;">Nic</th>';
            html += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 60px;">Contact</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            for(var i=0;i<jsObj['rowsAffected'];i++){
                html += '<tr role="row" class="odd" id="'+jsObj['result'][i].id+'">';
                html += '<td class="sorting_1">'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</td>';
                html += '<td>'+jsObj['result'][i].address+'</td>';
                html += '<td>'+jsObj['result'][i].nic+'</td>';
                html += '<td>'+jsObj['result'][i].phone+'</td>';
                html += '</tr>';
            }
            html += '</tbody>';
            html += '</table>';
            $('#request').html(html);
        });
        var obj = {
            call : 'RegisterUser'
        }
        $.post( "../classes/helper.php",obj,function (data){
            var jsObj = JSON.parse(data);
            var table = '',mtable='';
            table += '<table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">';
            table += '<thead>';
            table += '<tr role="row">';
            table += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 157px;">Name</th>';
            table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 259px;">Address</th>';
            table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 117px;">Nic</th>';
            table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 60px;">Contact</th>';
            table += '</tr>';
            table += '</thead>';
            table += '<tbody>';
            for(var i=0;i<jsObj['rowsAffected'];i++){
                table += '<tr role="row" class="odd" id="'+jsObj['result'][i].id+'">';
                table += '<td class="sorting_1">'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</td>';
                table += '<td>'+jsObj['result'][i].address+'</td>';
                table += '<td>'+jsObj['result'][i].nic+'</td>';
                table += '<td>'+jsObj['result'][i].phone+'</td>';
                table += '</tr>';
            }
            table += '</tbody>';
            table += '</table>';
            $('#registerd').html(table);

            mtable += '<p><!-- Add some text here--></p>';
            mtable += '<table class="table table-striped projects">';
            mtable += '<thead>';
            mtable += '<tr>';
            mtable += '<th></th>';
            mtable += '<th>Name</th>';
            mtable += '<th>NIC</th>';
            mtable += '<th>Phone</th>';
            mtable += '<th style="width: 20%">Manage</th>';
            mtable += '</tr>';
            mtable += '</thead>';
            mtable += '<tbody>';
            for(var i=0;i<jsObj['rowsAffected'];i++) {
                mtable += '<tr id="'+jsObj['result'][i].id+'" >';
                mtable += '<td>';
                mtable += '<ul class="list-inline" style="align-content: center">';
                mtable += '<li>';
                mtable += '<img src="'+jsObj['result'][i].picPath+'" class="avatar" alt="Avatar">';
                mtable += '</li>';
                mtable += '</ul>';
                mtable += '</td>';
                mtable += '<td>';
                mtable += '<h4>'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</h4>';
                mtable += '</td>';
                mtable += '<td>';
                mtable += '<h4>'+jsObj['result'][i].nic+'</h4>';
                mtable += '</td>';
                mtable += '<td>';
                mtable += '<h4>'+jsObj['result'][i].phone+'</h4>';
                mtable += '</td>';
                mtable += '<td>';
                mtable += '<button  class="btn btn-primary btn-xs view"><i class="fa fa-eye"></i> View </button>';
                mtable += '<button  class="btn btn-info btn-xs deactive"><i class="fa fa-lock"></i> Edit</button>';
                mtable += '<button  class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </button>';
                mtable += '</td>';
                mtable += '</tr>';
            }
            mtable += '</tbody>';
            mtable += '</table>';
            $('#manage').html(mtable);
        });


    });
    
    
    $("body").delegate( ".odd", "click", function() {
        console.log($(this).attr("id"));
        doctorId =  $(this).attr("id");
        var jsobj = {
            doctorid : $(this).attr("id"),
            call     : 'AdminP_ViewDetailRequest'
        }
        $.post( "../classes/helper.php",jsobj,function (data) {
            var jsObj = JSON.parse(data);
            $('#request').hide();
            $('#Request_filter').hide();
            html = '';
            html += '<section class="panel">';
            html += '<div class="x_title">';
            html += '<h2>User Description</h2>';
            html += '<div class="clearfix"></div>';
            html += '</div>';
            html += '<div class="panel-body">';
            for (var i = 0 ; i<jsObj['rowsAffected'] ; i++) {
                html += '<h3 class="green"><i class="fa fa-user"></i> '+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</h3>';
                html += '<p><!-- add some text here--></p>';
                html += '<br>';
                html += '<div class="project_detail">';
                html += '<p class="title">Degree/Certificate</p>';
                html += '<p>'+jsObj['result'][i].degree+'</p>';
                html += '<p class="title">University/Board</p>';
                html += '<p>'+jsObj['result'][i].board+'</p>';
                html += '<p class="title">PMDC Registation Number</p>';
                html += '<p>'+jsObj['result'][i].pmdc+'</p>';
                html += '</div><br>';
                html += '<h5>Personal Info</h5>';
                html += '<ul class="list-unstyled project_files">';
                html += '<li><a href=""><i class="fa fa-envelope"></i> '+jsObj['result'][i].email+'</a>';
                html += '</li>';
                html += '<li><a href=""><i class="fa fa-mobile"></i> '+jsObj['result'][i].phone+'</a>';
                html += '</li>';
                html += '<li><a href=""><i class="fa fa-info"></i> '+jsObj['result'][i].nic+'</a>';
                html += '</li>';
                html += '<li><a href=""><i class="fa fa-location-arrow"></i> '+jsObj['result'][i].address+'</a>';
                html += '</li>';
                html += '<li><a href=""><i class="fa fa-graduation-cap"></i> '+jsObj['result'][i].name+'</a>';
                html += '</li>';
                html += '</ul><br>';
                html += '<div class="text-center mtop20">';
                html += '<button id="approved"  class="btn btn-sm btn-primary fa fa-unlock">Approved</button>';
                html += '<button id="ignore"  class="btn btn-sm btn-warning">Ignore</button>';
                html += '</div>';
            }
            html += '</div>';
            html += '</section>';
            $('#request_view').html(html);
            $('#request_view').fadeIn(500);
        });
    });

    $("body").delegate( "button.deactive", "click", function(){
        var doctorId = parseInt($(this).parents().eq(1).attr("id"));
        var jsobj = {
            doctorid : doctorId,
            call     : 'DeActiveDoctor'
        }
        $.post( "../classes/helper.php",jsobj,function (data){
            var jsObj = JSON.parse(data);
            if (jsObj[status] == 'success'){
                alert('Doctor successfully de-active..');
            }
        });

    });

    $("body").delegate( "button.view", "click", function(){
/*      alert("Doctor ID : "+parseInt($(this).parents().eq(1).attr("id")));*/
        $('#controlpanel').hide();
        var doctorId = parseInt($(this).parents().eq(1).attr("id"));
        var jsobj = {
            doctorid : doctorId,
            call     : 'GetRegUserById'
        }
        $.post( "../classes/helper.php",jsobj,function (data){
            var jsObj = JSON.parse(data);
            html = '';
            html += '<section class="panel">';
            html += '<div class="x_title">';
            html += '<h2>User Description</h2>';
            html += '<div class="clearfix"></div>';
            html += '</div>';
            html += '<div class="panel-body">';
            for (var i = 0 ; i<jsObj['rowsAffected'] ; i++) {
                html += '<h3 class="green"><i class="fa fa-user"></i> '+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</h3>';
                html += '<p><!-- add some text here--></p>';
                html += '<br>';
                html += '<div class="project_detail">';
                html += '<p class="title">Degree/Certificate</p>';
                html += '<p>'+jsObj['result'][i].degree+'</p>';
                html += '<p class="title">University/Board</p>';
                html += '<p>'+jsObj['result'][i].board+'</p>';
                html += '<p class="title">PMDC Registation Number</p>';
                html += '<p>'+jsObj['result'][i].pmdc+'</p>';
                html += '</div><br>';
                html += '<h5>Personal Info</h5>';
                html += '<ul class="list-unstyled project_files">';
                html += '<li><a href=""><i class="fa fa-envelope"></i> '+jsObj['result'][i].email+'</a>';
                html += '</li>';
                html += '<li><a href=""><i class="fa fa-mobile"></i> '+jsObj['result'][i].phone+'</a>';
                html += '</li>';
                html += '<li><a href=""><i class="fa fa-info"></i> '+jsObj['result'][i].nic+'</a>';
                html += '</li>';
                html += '<li><a href=""><i class="fa fa-location-arrow"></i> '+jsObj['result'][i].address+'</a>';
                html += '</li>';
                html += '<li><a href=""><i class="fa fa-graduation-cap"></i> '+jsObj['result'][i].name+'</a>';
                html += '</li>';
                html += '</ul><br>';
                html += '<div class="text-center mtop20">';
                html += '<button id="ignore"  class="btn btn-sm btn-warning">Back</button>';
                html += '</div>';
            }
            html += '</div>';
            html += '</section>';
            $('#manage_view_user').html(html);
            $('#manage_view_user').show();
        });

    });

    $("body").delegate( "#approved", "click", function() {
        /*alert('doctorid : '+ doctorId);*/
        var jsobj = {
            doctorid : doctorId,
            call     : 'AdminP_ApprovedRequest'
        }
        $.each(jsobj,function (i,value) {
           console.log(i+" "+value);
        });

       $.post( "../classes/helper.php",jsobj,function (data) {
            var jsObj = JSON.parse(data);
            if (jsObj['status'] == 'success' && jsObj['rowsAffected'] == 1) {
                $('#status').html(text);
                setInterval(function(){
                    $('#A_request_confirm').show();
                }, 5000);
                $('#request_view').hide();
                $('#Request_filter').show();
                $('#request').show();
            }
        });
    });

    $("body").delegate( "#ignore", "click", function() {
        $('#request_view').hide();
        $('#manage_view_user').hide();

        $('#controlpanel').show();
        $('#Request_filter').show();
        $('#request').show();
    });
});