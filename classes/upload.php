<?php

/*echo "<pre>";echo print_r($_FILES)."<br/>PatientID : ".$_POST['patientId'];exit;*/

if(isset($_POST['patientId']) && isset($_FILES['files'])){
    uploadMultipleFiles($_POST['patientId']);
}

function uploadMultipleFiles($Id){
    $files = '';$status='';$existfiles = '';
    $path = '';
    $total = count($_FILES['files']['name']);
    for($i=0; $i<$total; $i++) {
        if ($_FILES["files"]["error"][$i] > 0) {
            echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
        } else {
            if (file_exists('../Project/uploads/'.$Id.'_'.$_FILES['files']['name'][$i])) {
                $existfiles .= $_FILES['files']['name'][$i].' ';
                continue;
            } else {
                $tmpFilePath = $_FILES['files']['tmp_name'][$i];
                if ($tmpFilePath != ""){
                    $newFilePath = '../Project/uploads/'.$Id.'_'.$_FILES['files']['name'][$i];
                    if(move_uploaded_file($tmpFilePath,$newFilePath)) {

                    }
                }
            }
        }
        $path .= $Id.'_'.$_FILES['files']['name'][$i].' ';
        $files .= $_FILES['files']['name'][$i].' ';
    }
    $existfilesArray = explode(' ',$existfiles);
    $filesArray = explode(' ',$files);
    if (count($existfilesArray) > 0 && $existfiles != ''){
        $status .= '<div class="alert alert-success alert-dismissible fade in" role="alert">';
        $status .= '<strong>Status: </strong>Files already shared <strong>'.$existfiles.'</strong> ';
        $status .= '</div><br/><br/><br/>';
        echo $status;
    }
    if (count($filesArray) > 0 && $files != ''){
        $status .= '<div class="alert alert-success alert-dismissible fade in" role="alert">';
        $status .= '<strong>Status: </strong>Files uploaded successfully <strong>'.$files.'</strong> ';
        $status .= '</div><br/><br/>';
        echo $status;
    }
/*    $res = $_pdo->update('complaints',array('images'=>trim($path,"^")),'where id = ?', array($Id));
    if($res['status'] = 'success' && $res['rowsAffected'] == 1){
    }*/
}



?>