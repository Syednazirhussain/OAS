$(document).ready(function () {
    var apptId,patientid,doctorid;
    $('#perscribtion').hide();
    $('#AP_FilterByDate').hide();
    $('#PP_prescribtion').hide();
    $("body").delegate( ".appt", "click", function() {
        console.log($(this).attr("id"));
        apptId = $(this).attr("id");
        var jsobj = {
            'apptId' : apptId,
            'call'   : 'get_pId_By_aId'
        }
        $.post('../classes/helper.php',jsobj,function (response) {
            iDependOnMyParameter(response);
        });
        function iDependOnMyParameter(param){
            var jsObj = JSON.parse(param);
            patientid = jsObj['result'][0].patientid;
        }
        $('#p_detail').val('');
        $('#CA_FilterByDate').hide();
        $('#perscribtion').show();
        $('#AP_FilterByDate').show();
        $('#Confirm_Appt').hide();
    });

    $('#precrib_back').click(function () {
        $('#perscribtion').hide();
        $('#PP_prescribtion').hide();
        $('#AP_FilterByDate').hide();
        $('#CA_FilterByDate').show();
        $('#Confirm_Appt').show();
    });


    /*Doctor-profile page add prescribtion  start*/
    $('#precrib_send').click(function () {
        var p_detail = $('#p_detail').val();
        console.log(p_detail+" "+apptId);
        var jsobj= {
            'p_detail' : p_detail,
            'apptId' : apptId,
            'call' : 'Send_prescribtion'
        }
        $.post('../classes/helper.php',jsobj,function (response) {
            var jsObj = JSON.parse(response);
            if (jsObj['rowsAffected'] == 1){
                $('#p_detail').val('');
                alert('Prescribtion has been sent to the patient');
            }else{
                alert('Prescribtion has been not sent to the patient');
            }
        });
        
    });
    /*Doctor-profile page add prescribtion  end*/
    
    /*Doctor-profile page show all appointments that are not confirmed start*/
  $(window).load(function () {
      doctorid = $('.form-horizontal').attr('id');
      var jsobj = {
          doctorId : $('.form-horizontal').attr('id'),
          call : 'Allappointment'
      }
      $.post("../classes/helper.php",jsobj,function (response) {
          var jsObj = JSON.parse(response);
          console.log(jsObj);
          html = "";
          if (jsObj['rowsAffected'] == 0) {
              html =  '<div class="bs-example __web-inspector-hide-shortcut__" data-example-id="simple-jumbotron">';
              html += '<div class="jumbotron">';
              html += '<h1>Appointment Requests</h1>';
              html += '<p>Currently there is not enough requests for appointments...</p>';
              html += '</div> </div>';
          }else{
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
          }
          $('#Table').html(html);
      });
      var table = '';
      var jsobj = {
          doctorId : $('.form-horizontal').attr('id'),
          call : 'Confirmed_Appointment'
      }
      $.post('../classes/helper.php',jsobj,function (response) {
          console.log(response);
          var jsObj = JSON.parse(response);
          table += '<div class="x_title">';
          table += '<h2>Confirmed Appointment</h2>';
          table += '<div class="clearfix"></div>';
          table += '</div>';
          table += '<table  class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">';
          table += '<thead>';
          table += '<tr role="row">';
          table += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 160px;">Patient Name</th>';
          table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">NIC number</th>';
          table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Phone number</th>';
          table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Description</th>';
          table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Dates</th>';
          table += '</tr>';
          table += '</thead>';
          table += '<tbody>';
          for (var i=0 ; i < jsObj['rowsAffected'] ; i++){
              table += '<tr role="row" class="appt" id="'+jsObj['result'][i].id+'">';
              table += '<td class="sorting_1">'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</td>';
              table += '<td class="sorting_1">'+jsObj['result'][i].nic+'</td>';
              table += '<td class="sorting_1">'+jsObj['result'][i].phone+'</td>';
              table += '<td class="sorting_1">'+jsObj['result'][i].description+'</td>';
              table += '<td class="sorting_1">'+jsObj['result'][i].Dates+'</td>';
              table += '</tr>';
          }
          table += '</tbody>';
          table += '</table>';
          $('#Confirm_Appt').html(table);
      });
      /*
      var jsobj = {
          doctorId : $('.form-horizontal').attr('id'),
          call : 'Dappointment'
      }
      $.post('../classes/helper.php',jsobj,function (response) {
          console.log(response);
          var jsObj = JSON.parse(response);
          table += '<div class="x_title">';
          table += '<h2>Confirmed Appointment</h2>';
          table += '<div class="clearfix"></div>';
          table += '</div>';
          table += '<table id="datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">';
          table += '<thead>';
          table += '<tr role="row">';
          table += '<th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 160px;">Patient Name</th>';
          table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">NIC number</th>';
          table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Phone number</th>';
          table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Description</th>';
          table += '<th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 59px;">Dates</th>';
          table += '</tr>';
          table += '</thead>';
          table += '<tbody>';
          for (var i=0 ; i < jsObj['rowsAffected'] ; i++){
              table += '<tr role="row" class="appt" id="'+jsObj['result'][i].id+'">';
              table += '<td class="sorting_1">'+jsObj['result'][i].fname+' '+jsObj['result'][i].lname+'</td>';
              table += '<td class="sorting_1">'+jsObj['result'][i].nic+'</td>';
              table += '<td class="sorting_1">'+jsObj['result'][i].phone+'</td>';
              table += '<td class="sorting_1">'+jsObj['result'][i].description+'</td>';
              table += '<td class="sorting_1">'+jsObj['result'][i].Dates+'</td>';
              table += '</tr>';
          }
          table += '</tbody>';
          table += '</table>';
          $('#doctorAppointment').html(table);
      });*/
  });
    /*Doctor-profile page show all appointments that are not confirmed end*/

    /*Doctor-profile page filter patient previous history by date start*/
    $('#ap_dateFilter').change(function () {
        console.log($(this).val()+" "+patientid);
        var jsobj = {
            'patientId' : patientid,
            'date'   : $(this).val(),
            'call'   : 'Appt_Prescrib_Datefilter'
        }
        $.post("../classes/helper.php",jsobj,function (response){
            var html = '';
           var jsObj = JSON.parse(response);
            console.log(jsObj);
            for (var i=0 ; i<jsObj['rowsAffected'] ; i++) {
                html += '<ul class="list-unstyled msg_list">';
                html += '<li><a>';
                html += '<span class="image">';
                html += '<i class="fa fa-paper-plane">&nbsp;&nbsp;</i>';
                html += '</span><span>';
                html += '<span>Appointment Number # '+jsObj['result'][i].appt_id+'</span>';
                html += '<span class="time">'+jsObj['result'][i].Dates+'</span>';
                html += '</span><span class="message">'+jsObj['result'][i].p_detail+'</span>';
                html += '</a></li></ul>';
            }
            $('#PP_prescribtion').html(html);
            $('#PP_prescribtion').show();
        });
    });
    /*Doctor-profile page filter patient previous history by date ended*/

    /*Doctor-profile page filter in bulk patient previous history by date start*/
    $('#Filter_Bulk').change(function () {
        console.log($(this).val());
        var jsobj = {
            'status' : $(this).val(),
            'patientId' : patientid,
            'call'   : 'AP_Filter_By_Bulk'
        }
        $.post("../classes/helper.php",jsobj,function (response){
            var html = '';
            var jsObj = JSON.parse(response);
            console.log(jsObj);
            for (var i=0 ; i<jsObj['rowsAffected'] ; i++) {
                html += '<ul class="list-unstyled msg_list">';
                html += '<li><a>';
                html += '<span class="image">';
                html += '<i class="fa fa-paper-plane">&nbsp;&nbsp;</i>';
                html += '</span><span>';
                html += '<span>Appointment Number # '+jsObj['result'][i].appt_id+'</span>';
                html += '<span class="time">'+jsObj['result'][i].Dates+'</span>';
                html += '</span><span class="message">'+jsObj['result'][i].p_detail+'</span>';
                html += '</a></li></ul>';
            }
            $('#PP_prescribtion').html(html);
            $('#PP_prescribtion').show();
        });
    });
    /*Doctor-profile page filter in bulk patient previous history by date ended*/

    /*Doctor-profile page payment button ended*/
/*    $('#payment').click(function () {
        alert("Appt Id : "+apptId+" Doctor Id : "+doctorid+" Patient Id : "+patientid);
    });*/
    /*Doctor-profile page payment button ended*/
    

});
