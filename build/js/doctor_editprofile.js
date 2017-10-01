$(document).ready(function(){
    var doctorid,cityId,areaId;
    $('#fnameSave').hide();
    $('#lnameSave').hide();
    $('#emailSave').hide();
    $('#phoneSave').hide();
    $('#addressSave').hide();
    $('#locSave').hide();
    $('#cpasswordCheck').hide();
    $('#checkpassword').hide();
    $('.message').hide();
    $("input[name=fname]").prop('disabled', true);
    $("input[name=lname]").prop('disabled', true);
    $("input[name=email]").prop('disabled', true);
    $("input[name=phone]").prop('disabled', true);
    $("input[name=address]").prop('disabled', true);
    jQuery("#city").attr('disabled',true);
    jQuery("#area").attr('disabled',true);
    $("input[name=currentpassword]").prop('disabled', true);
    $("input[name=newpassword]").prop('disabled', true);
    $("input[name=confirmpassword]").prop('disabled', true);

    /* userEdit page dependent select combo box  started */
    $('#city').change(function(){
        cityId =  $('#city').val();
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
    /* userEdit page dependent select combo box  ended */

    /* Patient-profile page  user edit profile start */
    $(window).load(function () {
        //alert($('.form-horizontal').attr("id"));
        doctorid = $('.form-horizontal').attr("id");
        var jsobj = {
            doctorid : $('.form-horizontal').attr("id"),
            call      : 'GetDoctorData'
        }
        $.post( "../classes/helper.php",jsobj,function (data){
            var jsObj = JSON.parse(data);
            $("input[name='fname']").val(jsObj['result'][0].fname);
            $("input[name='lname']").val(jsObj['result'][0].lname);
            $("input[name='address']").val(jsObj['result'][0].address);
            $("input[name='email']").val(jsObj['result'][0].email);
            $("input[name='phone']").val(jsObj['result'][0].phone);
        });
    });
    /* Patient-profile page  user edit profile ended */

    /* Patient-profile page  edit fname  started */
    $('#fnameEdit').click(function () {
        $(this).hide();
        $("input[name=fname]").prop('disabled', false);
        $('#fnameSave').show();
    });
    $('#fnameSave').click(function () {
        $(this).hide();
        /* alert( $("input[name=fname]").val());*/
        $("input[name=fname]").prop('disabled', true);
        var obj = {
            doctorid : doctorid,
            fname     : $("input[name=fname]").val(),
            call      : 'DEditFname'
        }
        $.post( "../classes/helper.php",obj,function (data) {
            var jsObj = JSON.parse(data);
            $.each(jsObj,function (index,value) {
                console.log(index+" : "+value);
            });
        });
        $('#fnameEdit').show();
    });
    /* Patient-profile page  edit fname  started */

    /* Patient-profile page  edit lname  started */
    $('#lnameEdit').click(function () {
        $(this).hide();
        $("input[name=lname]").prop('disabled', false);
        $('#lnameSave').show();
    });
    $('#lnameSave').click(function () {
        $(this).hide();
        /* alert( $("input[name=fname]").val());*/
        $("input[name=lname]").prop('disabled', true);
        var obj = {
            doctorid : doctorid,
            lname     : $("input[name=lname]").val(),
            call      : 'DEditLname'
        }
        $.post( "../classes/helper.php",obj,function (data) {
            var jsObj = JSON.parse(data);
            $.each(jsObj,function (index,value) {
                console.log(index+" : "+value);
            });
        });
        $('#lnameEdit').show();
    });
    /* Patient-profile page  edit lname  ended */

    /* Patient-profile page  edit email  started */
    $('#emailEdit').click(function () {
        $(this).hide();
        $("input[name=email]").prop('disabled', false);
        $('#emailSave').show();
    });
    $('#emailSave').click(function () {
        $(this).hide();
        /* alert( $("input[name=fname]").val());*/
        $("input[name=email]").prop('disabled', true);
        var obj = {
            doctorid : doctorid,
            email     : $("input[name=email]").val(),
            call      : 'DEditEmail'
        }
        $.post( "../classes/helper.php",obj,function (data) {
            var jsObj = JSON.parse(data);
            $.each(jsObj,function (index,value) {
                console.log(index+" : "+value);
            });
        });
        $('#emailEdit').show();
    });
    /* Patient-profile page  edit email  ended */

    /* Patient-profile page  edit phone  started */
    $('#phoneEdit').click(function () {
        $(this).hide();
        $("input[name=phone]").prop('disabled', false);
        $('#phoneSave').show();
    });
    $('#phoneSave').click(function () {
        $(this).hide();
        /* alert( $("input[name=fname]").val());*/
        $("input[name=phone]").prop('disabled', true);
        var obj = {
            doctorid : doctorid,
            phone     : $("input[name=phone]").val(),
            call      : 'DPhoneEdit'
        }
        $.post( "../classes/helper.php",obj,function (data) {
            var jsObj = JSON.parse(data);
            $.each(jsObj,function (index,value) {
                console.log(index+" : "+value);
            });
        });
        $('#phoneEdit').show();
    });
    /* Patient-profile page  edit phone  ended */


    /* Patient-profile page  edit city/Area  started */
    $('#locEdit').click(function () {
        $(this).hide();
        jQuery("#city").attr('disabled',false);
        jQuery("#area").attr('disabled',false);
        $('#locSave').show();
    });
    $('#locSave').click(function () {
        $(this).hide();
        areaId = $('#area').val();
        /*alert("City ID : "+cityId+" Area ID : "+areaId);*/
        jQuery("#city").attr('disabled',true);
        jQuery("#area").attr('disabled',true);
        var obj = {
            doctorid : doctorid,
            areaid    : areaId,
            call      : 'DCityAreaEdit'
        }
        $.post( "../classes/helper.php",obj,function (data) {
            var jsObj = JSON.parse(data);
            $.each(jsObj,function (index,value) {
                console.log(index+" : "+value);
            });
        });
        $('#locEdit').show();
    });
    /* Patient-profile page  edit city/Area ended */

    /* Patient-profile page  edit Address  started */
    $('#addressEdit').click(function () {
        $(this).hide();
        $("input[name=address]").prop('disabled', false);
        $('#addressSave').show();
    });
    $('#addressSave').click(function () {
        $(this).hide();
        /* alert( $("input[name=fname]").val());*/
        $("input[name=address]").prop('disabled', true);
        var obj = {
            doctorid : doctorid,
            address     : $("input[name=address]").val(),
            call      : 'DAddressEdit'
        }
        $.post( "../classes/helper.php",obj,function (data) {
            var jsObj = JSON.parse(data);
            $.each(jsObj,function (index,value) {
                console.log(index+" : "+value);
            });
        });
        $('#addressEdit').show();
    });
    /* Patient-profile page  edit Address  ended */


    /* Patient-profile page  edit current password  started */
    $('#cpasswordEdit').click(function () {
        $(this).hide();
        $("input[name=currentpassword]").prop('disabled', false);
        $('#cpasswordCheck').show();
    });
    $('#cpasswordCheck').click(function () {
        var obj = {
            doctorid : doctorid,
            currentpassword     : $("input[name=currentpassword]").val(),
            call      : 'DCheckCpassword'
        }
        $.post( "../classes/helper.php",obj,function (data) {
            iDependOnMyParameter(data);
        });
        function iDependOnMyParameter(param) {
            var jsObj = JSON.parse(param);
            $.each(jsObj,function (index,value) {
                console.log(index+" : "+value);
            });
            if (jsObj['rowsAffected'] == 1 && jsObj['status'] == 'success' ){
                /*.css({ "background-color": "#ffe", "border-left": "5px solid #ccc" })*/
                $('.message').css({ "color": "green", "font-weight": "bold" });
                $('.message').text("Correct Password..");
                $('.message').show();
                $("input[name=currentpassword]").prop('disabled', true);
                $("input[name=newpassword]").prop('disabled', false);
                $("#password").focus();
                $("#password").focusin();
                $("input[name=confirmpassword]").prop('disabled', false);
                $('#cpasswordCheck').hide();
                $('#cpasswordEdit').show();
            }else{
                $('.message').css({ "color": "red", "font-weight": "bold" });
                $('.message').text("Wrong Password..");
                $('.message').show();

            }
        }
        //$('#phoneEdit').show();
    });
    /* Patient-profile page  edit current password  ended */




    /* Patient-profile page  edit password started */
    $('#submit').click(function(){
        if($('#password').val() != $('#cpassword').val()){
            $('#password').css('border','1px solid red');
            $('#cpassword').css('border','1px solid red');
            /*return false;*/
        }else{
            var jsObj = {
                doctorid : doctorid,
                cpassword :  $("input[name=confirmpassword]").val(),
                call      : 'DEditPassword'
            };
            $.post("../classes/helper.php",jsObj,function (data) {
                var jsObj = JSON.parse(data);
                if (jsObj['rowsAffected'] == 1 && jsObj['status'] == 'success' ){
                    $('.message').hide();
                    $("input[name=newpassword]").val("");
                    $("input[name=confirmpassword]").val("");
                    /*.css({ "background-color": "#ffe", "border-left": "5px solid #ccc" })*/
                    $('#checkpassword').css({ "color": "green", "font-weight": "bold" });
                    $('#checkpassword').text("Password Changed Successfully..");
                    $('#checkpassword').show();

                }else{
                    $('#checkpassword').css({ "color": "red", "font-weight": "bold" });
                    $('#checkpassword').text("Some Error Occure..");
                    $('#checkpassword').show();
                }
            });
        }
    });
    $('#password').keyup(function(){
        $('#password').css('border','1px solid #ccc');
        $('#cpassword').css('border','1px solid #ccc');
    });
    $('#cpassword').keyup(function(){
        $('#password').css('border','1px solid #ccc');
        $('#cpassword').css('border','1px solid #ccc');
    });
    /* Patient-profile page  edit password ended */

});