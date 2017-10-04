<?php
require_once('../Project/autoload.php');
class helper extends pdocrudhandler{
    public function  getAreasForCity($params){
        $result = $this->select("area",array("*"),"where cityid = ?",array($params['cityId']));
        return $result;
    }
    public function filter($params){
        $_pdo = new pdocrudhandler();
        if($params){
            $whereClause = "";
            if(isset($params['speciality']) && $params['speciality'] != 0){
                if($whereClause == ""){
                    $whereClause .= "where specialityid = ".$params['speciality'];
                }else{
                    $whereClause .= " and specialityid = ".$params['speciality'];
                }
            }
            if(isset($params['fees'])  && $params['fees'] != 0){
                if($whereClause != ""){
                    $whereClause .= " and fees <= ".$params['fees'];
                }else{
                    $whereClause .= "where fees <= ".$params['fees'];
                }
            }
            if(isset($params['Location']) && $params['Location'] != 0){
                if($whereClause != ""){
                    $whereClause .= " and areaid = ".$params['Location'];
                }else{
                    $whereClause .= "where areaid = ".$params['Location'];
                }
            }
            $query = "select d.*,s.name as speciality,a.name as area from doctor d
                      inner join speciality s on d.specialityid = s.id
                      inner join area a on a.id = d.areaid ".$whereClause;
            $result = $_pdo->customSelect($query);
            return $result;
        }else{
            $result = $_pdo->select('doctor',array('*'));
            return $result;
        }

    }
    public function Appointment($params){
        $data = array();
        if($params['description'] != null && $params['date'] != null){
            $result = $this->insert('appointments',array('patientid' => $params['patientId'],'doctorid' => $params['doctorId'],'description' => $params['description'],'Dates' => $params['date'],'confirm' => 0));
            return $result;
        }else{
            $data['rowsAffected'] = 0;
            $data['status'] = false;
            return $data;
        }

    }
    public function Check_appointment($params){
        $result =  $this->customSelect("select p.*, a.* from appointments as a inner join patient as p on a.patientid = p.patientid 
                   where a.id =".$params['ApptId']);
        return $result;
    }
    public function filterByDate($params){
          $query = "select a.*,p.* from appointments
          as a inner join patient as p
          on  a.patientid = p.patientid where doctorid = ".$params['doctorid']." and Dates = '{$params['date']}'  ORDER BY a.id DESC";
            $result = $this->customSelect($query);
        return $result;
    }
    public function Allappointment($params){
        $query = "select a.*,p.* from appointments
              as a inner join patient as p
              on  a.patientid = p.patientid where doctorid =  ".$params['doctorId']." and confirm = 0  ORDER BY a.id DESC";
        $result = $this->customSelect($query);
        return $result;
    }
    public function AppointmentConfirm($params){
/*        return "AppointmentId : ".$params['AppointmentId']."Start Time  ".$params['s_time']." End Time ".$params['e_time'];*/
        $result = $this->update("appointments",array("confirm" => 1,"s_time" => $params['s_time'],"e_time" => $params['e_time']),"where id = ?",array($params['AppointmentId']));
        /* changes */
        $query = "select a.*,p.*,d.fname as dfname,d.lname as dlname from appointments

              as a inner join patient as p

              on  a.patientid = p.patientid 
			  
			  inner join doctor as d
			  
			  where a.id =  ".$params['AppointmentId'];

        $resultEmail = $this->customSelect($query);
        $this->sendEmail(strtolower(trim($resultEmail['result'][0]->email)), $resultEmail['result'][0]->dfname." ".$resultEmail['result'][0]->dlname);
        return $resultEmail['result'][0]->dfname." ".$resultEmail['result'][0]->dlname;
    }
    public function Notification($params){
        $result = $this->select('appointments',array('*'),'where patientid = ? and confirm = ?',array($params['patientID'],1));
        return $result;
    }
    public function Pactivity($params){

        $result = $this->customSelect("select d.fname,d.lname,a.*,s.name from doctor as d inner join speciality as s on d.specialityid = s.id
inner join appointments as a on d.id = a.doctorid where a.confirm = 1 and a.patientid = {$params['patientID']}");
        return $result;
    }
    public function Confirmed_Appointment($params){
        $query = "select p.patientid,a.id,p.fname,p.lname,p.nic,p.phone,a.description,a.Dates from appointments as a inner join
                  patient as p on p.patientid = a.patientid inner join doctor as d on d.id = a.doctorid
                  where a.confirm = 1 and d.id = {$params['doctorId']} order by a.id desc";
        $result = $this->customSelect($query);
        return $result;
    }
    public function usersignup($params){
        unset($params['call']);
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        $missingFeild = array();
        $count = 0;
        $message = "";
        foreach ($params as $key => $value){
            if($params[$key] != ""){
                if ($key == "email"){
                    if(!preg_match_all($regex,$params[$key])){
                        $missingFeild[$count] = "Email not valid";
                        $count++;
                    }
                }
            }else{
                if($key == "fname"){
                    $missingFeild[$count] = "First Name";
                    $count++;
                }elseif ($key == "lname"){
                    $missingFeild[$count] = "Last Name";
                    $count++;
                }elseif ($key == "areaid"){
                    $missingFeild[$count] = "Area";
                    $count++;
                }elseif ($key == "phone"){
                    $missingFeild[$count] = "Cell";
                    $count++;
                }elseif ($key == "confirmpassword"){
                    $missingFeild[$count] = "Confirm Password";
                    $count++;
                }elseif ($key == "nic") {
                    $missingFeild[$count] = "NIC";
                    $count++;
                }else {
                    $missingFeild[$count] = $key;
                    $count++;
                }
            }
        }
        if (empty($missingFeild)){
            unset($params['city']);
            $response = $this->insert('user',array('email' => $params['username'],'password' => $params['password'],'active' => 1,'lastLogin' => date('Y-m-d h:i:s'),'professionid' => 2));
            if($response['status'] == "success" && $response['rowsAffected'] == 1){
                $get = $this->select('user',array("id"),"where email = ? and password = ?",array($params['username'],$params['password']));
                $id = $get['result'][0]->id;
                if ($id){
                    $result =  $this->insert('patient',array('fname' => $params['fname'],'lname' => $params['lname'],'email' => $params['email'],'gender' => $params['gender'],'nic' => $params['nic'],'phone' => $params['phone'],'areaid' => $params['areaid'],'userid' => $id,'address' => $params['address'],'picPath' => "images/user.png"));
                    return $result;
                }
            }
        }else{
            for($i=0;$i<$count;$i++){
                ($i == 0) ? $message = "Error[] :- [".($i+1)."] ".$missingFeild[$i].", " : $message.= "[".($i+1)."] ".$missingFeild[$i].", ";
            }
            return $message.= " (Total error : ".$count.")";
        }
    }
    public function doctorsignup($params){
        unset($params['call']);
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        $missingFeild = array();
        $count = 0;
        $message = "";
        foreach ($params as $key => $value){
            if($params[$key] != ""){
                if ($key == "email"){
                    if(!preg_match_all($regex,$params[$key])){
                        $missingFeild[$count] = "Email not valid";
                        $count++;
                    }
                }
            }else{
                if($key == "fname"){
                    $missingFeild[$count] = "First Name";
                    $count++;
                }elseif ($key == "lname"){
                    $missingFeild[$count] = "Last Name";
                    $count++;
                }elseif ($key == "areaid"){
                    $missingFeild[$count] = "Area";
                    $count++;
                }elseif ($key == "phone"){
                    $missingFeild[$count] = "Cell";
                    $count++;
                }elseif ($key == "confirmpassword"){
                    $missingFeild[$count] = "Confirm Password";
                    $count++;
                }elseif ($key == "nic") {
                    $missingFeild[$count] = "NIC";
                    $count++;
                }else {
                    $missingFeild[$count] = $key;
                    $count++;
                }
            }
        }
        if (empty($missingFeild)){
                unset($params['city']);
                $response = $this->insert('user',array('email' => $params['username'],'password' => $params['password'],'active' => 0,'lastLogin' => date('Y-m-d h:i:s'),'professionid' => 1));
                if($response['status'] == "success" && $response['rowsAffected'] == 1){
                    $get = $this->select('user',array("id"),"where email = ? and password = ?",array($params['username'],$params['password']));
                    $id = $get['result'][0]->id;
                    if ($id){
                        $result = $this->insert('doctor', array('fname' => $params['fname'], 'lname' => $params['lname'], 'email' => $params['email'], 'gender' => $params['gender'], 'address' => $params['address'], 'nic' => $params['nic'], 'phone' => $params['phone'], 'pmdc' => $params['pmdc'], 'degree' => $params['degree'], 'board' => $params['board'], 'fees' => $params['fees'], 'areaid' => $params['areaid'], 'specialityid' => $params['speciality'], 'userid' => $id,'picPath'=>'images/user.png'));
                        $result['userid'] = $id;
                        return $result;
                    }
                }
            return 0;
        }else{
            for($i=0;$i<$count;$i++){
                ($i == 0) ? $message = "Error[] :- [".($i+1)."] ".$missingFeild[$i].", " : $message.= "[".($i+1)."] ".$missingFeild[$i].", ";
            }
            return $message.= " (Total error : ".$count.")";
        }
    }
    public  function Doctor_Available_Day($params){
        $result = $this->customSelect("select d.name,t.starttime,t.endtime from timetable as t inner join days as d on t.dayid = d.id  where doctorid = {$params['doctorid']}");
        return $result;
    }
    public function Doctor_Available_Date($params){
/*        return "Doctor ID : ".$params['doctorid']." Day ID : ".$params['dayid'];*/
        $result = $this->select('timetable',array('*'),'where doctorid = ? and dayid = ?',array($params['doctorid'],$params['dayid']));
        return $result;
    }
    public function Doctor_Time_Slot($params){
        $querey = "select p.fname,p.lname,a.* from appointments as a inner join patient as p on a.patientid = p.patientid where a.doctorid = ".$params['doctorid']." and a.Dates = '{$params['date']}' and confirm = 1";
        $result = $this->customSelect($querey);
        /*return "Date : ".$params['date']." DoctorID : ".$params['doctorid'];*/
        return $result;
    }
    public function CA_filterByDate($params){
        /*select * from appointments where doctorid = 1 and Dates = '2017-05-05' and confirm = 1;*/
        /*echo $params['doctorid']." ".$params['date'];*/
        $querey = "select p.fname,p.lname,p.nic,p.phone,a.description,a.Dates from appointments as a inner join
                  patient as p on p.patientid = a.patientid inner join doctor as d on d.id = a.doctorid
                  where a.confirm = 1 and d.id = {$params['doctorid']} and a.Dates = '{$params['date']}'";
        $reault = $this->customSelect($querey);
        return $reault;
    }
    public function Send_prescribtion($params){
        $result = $this->insert('prescribtion',array('p_detail' => $params['p_detail'],'appt_id' => $params['apptId']));
        return $result;
    }
    public function Appt_Prescrib_Datefilter($params){
        $querey = "select a.Dates,p.* from prescribtion as p inner join appointments as a on p.appt_id = a.id where a.Dates = '{$params['date']}' and a.patientid = {$params['patientId']}";
        $result = $this->customSelect($querey);
        return $result;
    }
    public function get_pId_By_aId($params){
        /*select patientid from appointments where id = 80*/
        $result = $this->select('appointments',array('patientid'),'where id = ?',array($params['apptId']));
        return $result;
    }
    public function AP_Filter_By_Bulk($params){
        /*echo print_r($params);exit;*/
        $querey = "";$result = "";
        if ($params['status'] == 'last_week'){
            $date = date('Y-m-d');
            $current_date = strtotime($date);
            $pervious_date = date('Y-m-d', strtotime('-7 day', $current_date));
            $querey = "select a.Dates,p.* from prescribtion as p inner join appointments as a on p.appt_id = a.id
                       where a.patientid = {$params['patientId']} and a.Dates BETWEEN '{$pervious_date}' AND '{$date}' ";
            $result = $this->customSelect($querey);
        }elseif ($params['status'] == 'last_month'){
            $date = date('Y-m-d');
            $current_date = strtotime($date);
            $pervious_date = date('Y-m-d', strtotime('-1 month', $current_date));
            $querey = "select a.Dates,p.* from prescribtion as p inner join appointments as a on p.appt_id = a.id
                       where a.patientid = {$params['patientId']} and a.Dates BETWEEN '{$pervious_date}' AND '{$date}' ";
            $result = $this->customSelect($querey);
        }elseif ($params['status'] == 'quater_year'){
            $date = date('Y-m-d');
            $current_date = strtotime($date);
            $pervious_date = date('Y-m-d', strtotime('-3 month', $current_date));
            $querey = "select a.Dates,p.* from prescribtion as p inner join appointments as a on p.appt_id = a.id
                       where a.patientid = {$params['patientId']} and a.Dates BETWEEN '{$pervious_date}' AND '{$date}' ";
            $result = $this->customSelect($querey);
        }elseif ($params['status'] == 'half_year'){
            $date = date('Y-m-d');
            $current_date = strtotime($date);
            $pervious_date = date('Y-m-d', strtotime('-6 month', $current_date));
            $querey = "select a.Dates,p.* from prescribtion as p inner join appointments as a on p.appt_id = a.id
                       where a.patientid = {$params['patientId']} and a.Dates BETWEEN '{$pervious_date}' AND '{$date}' ";
            $result = $this->customSelect($querey);
        }
        return $result;
    }
    public function doctorsignupTimetable($params){
        echo print_r($params)."<br>";
        /*select id from doctor where userid = 40; $doctor['result'][0]->fname*/
        $result = $this->select('doctor',array('id'),'where userid = ?',array($params['userId']));
        $doctorid = $result['result'][0]->id;
        unset($params['call']);
        $days = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
        $dayCount = 0;
        $errorCount = 0;
        $message = '';
        $selectedDays = array();
        $error = array();
        for ($i=0 ; $i<count($days) ; $i++){
            if (isset($params[$days[$i]])){
                $selectedDays[$dayCount] = $days[$i];
                $dayCount++;
            }
        }
        echo print_r($selectedDays)."<br>";
        $querey = "insert into timetable(doctorid,dayid,starttime,endtime) ";

        for($i=0;$i<$dayCount;$i++){
            if($selectedDays[$i] == 'monday'){
                if (isset($params['m_start']) && $params['m_start'] != null && isset($params['m_end']) && $params['m_end'] != null){
                    ($i != ($dayCount-1)) ? $querey .= "select {$doctorid},1,'{$params['m_start']}','{$params['m_end']}' union all " : $querey .= "select {$doctorid},1,'{$params['m_start']}','{$params['m_end']}'";
                }else{
                     $error[$errorCount] = $selectedDays[$i]." Invalid Time ";
                    $errorCount++;
                }
            }elseif ($selectedDays[$i] == 'tuesday'){
                if (isset($params['tu_start']) && $params['tu_start'] != null && isset($params['tu_end']) && $params['tu_end'] != null){
                    ($i != ($dayCount-1)) ? $querey .= "select {$doctorid},2,'{$params['tu_start']}','{$params['tu_end']}' union all " : $querey .= "select {$doctorid},2,'{$params['tu_start']}','{$params['tu_end']}'";
                }else{
                    $error[$errorCount] = $selectedDays[$i]." Invalid Time ";
                    $errorCount++;
                }
            }elseif ($selectedDays[$i] == 'wednesday'){
                if (isset($params['w_start']) && $params['w_start'] != null && isset($params['w_end']) && $params['w_end'] != null){
                    ($i != ($dayCount-1)) ? $querey .= "select {$doctorid},3,'{$params['w_start']}','{$params['w_end']}' union all " : $querey .= "select {$doctorid},3,'{$params['w_start']}','{$params['w_end']}'";
                }else{
                    $error[$errorCount] = $selectedDays[$i]." Invalid Time ";
                    $errorCount++;
                }
            }elseif ($selectedDays[$i] == 'thursday'){
                if (isset($params['th_start']) && $params['th_start'] != null && isset($params['th_end']) && $params['th_end'] != null){
                    ($i != ($dayCount-1)) ? $querey .= "select {$doctorid},4,'{$params['th_start']}','{$params['th_end']}' union all " : $querey .= "select {$doctorid},4,'{$params['th_start']}','{$params['th_end']}'";
                }else{
                    $error[$errorCount] = $selectedDays[$i]." Invalid Time ";
                    $errorCount++;
                }
            }elseif ($selectedDays[$i] == 'friday'){
                if (isset($params['f_start']) && $params['f_start'] != null && isset($params['f_end']) && $params['f_end'] != null){
                    ($i != ($dayCount-1)) ? $querey .= "select {$doctorid},5,'{$params['f_start']}','{$params['f_end']}' union all " : $querey .= "select {$doctorid},5,'{$params['f_start']}','{$params['f_end']}'";
                }else{
                    $error[$errorCount] = $selectedDays[$i]." Invalid Time ";
                    $errorCount++;
                }
            }elseif ($selectedDays[$i] == 'saturday'){
                if (isset($params['sa_start']) && $params['sa_start'] != null && isset($params['sa_end']) && $params['sa_end'] != null){
                    ($i != ($dayCount-1)) ? $querey .= "select {$doctorid},6,'{$params['sa_start']}','{$params['sa_end']}' union all " : $querey .= "select {$doctorid},6,'{$params['sa_start']}','{$params['sa_end']}'";
                }else{
                    $error[$errorCount] = $selectedDays[$i]." Invalid Time ";
                    $errorCount++;
                }
            }else{
                if (isset($params['su_start']) && $params['su_start'] != null && isset($params['su_end']) && $params['su_end'] != null){
                    ($i != ($dayCount-1)) ? $querey .= "select {$doctorid},7,'{$params['su_start']}','{$params['su_end']}' union all " : $querey .= "select {$doctorid},7,'{$params['su_start']}','{$params['su_end']}'";
                }else{
                    $error[$errorCount] = $selectedDays[$i]." Invalid Time ";
                    $errorCount++;
                }
            }
        }
        if (empty($error)){
            $result = $this->executeqry($querey);
            return $result;
        }else {
            /*echo $errorCount."<br>".print_r($error);*/
            for ($i = 0; $i < $errorCount; $i++) {
                ($i != ($errorCount - 1)) ? $message .= $error[$i]." , " : $message .= $error[$i];
            }
            return $message;
        }
    }
    public function RegisterRequest(){
        $result = $this->customSelect("select d.*,u.active,s.name from doctor as d inner join user as u on d.userid = u.id inner join
                                       speciality as s on d.specialityid = s.id where u.active = 0");
        return $result;
    }
    public function AdminP_ViewDetailRequest($params){
        $result = $this->customSelect("select d.*,u.active,s.name from doctor as d inner join user as u on d.userid = u.id inner join
 speciality as s on d.specialityid = s.id where u.active = 0 and d.id = ".$params['doctorid']);
        return $result;
    }
    public function AdminP_ApprovedRequest($params){
        $response = $this->select('doctor',array('userid'),'where id = ?',array($params['doctorid']));
        $result = $this->update("user",array("active" => 1),"where id = ?",array($response['result'][0]->userid));
        return $result;
    }
    public function RegisterUser(){
        $result = $this->customSelect("select d.*,u.active from doctor as d inner join user as u on d.userid = u.id where u.active = 1");
        return $result;
    }
    public function GetRegUserById($params){
        $result = $this->customSelect("select d.*,s.name from doctor as d inner join speciality as s on d.specialityid = s.id where d.id = ".$params['doctorid']);
        return $result;
    }
    public function DeActiveDoctor($params){
        $response = $this->select('doctor',array('userid'),'where id = ?',array($params['doctorid']));
        $result = $this->update('user',array("active" => 0),"where id = ?",array($response['result'][0]->userid));
        return $result;
    }
    public function getPatientAppt($params){
        //echo "<pre>".print_r($params);
        $result = $this->select('appointments',array('*'),'where id = ?',array($params['ApptId']));
        return $result;
    }
    public function ViewDoctor($params){
        $result = $this->customSelect("select d.fname,d.lname,d.board,d.degree,d.fees,d.picPath,s.name from doctor as d inner join speciality as s
                        on d.specialityid = s.id where d.id = ".$params['doctorid']);
        return $result;
    }
    public function GetPatientData($params){
        $result = $this->select('patient',array('*'),'where patientid = ?',array($params['patientid']));
        return $result;
    }
    public function EditFname($params){
        $result = $this->update('patient',array('fname' => $params['fname']),'where patientid = ?',array($params['patientid']));
        return $result;
    }
    public function EditLname($params){
        $result = $this->update('patient',array('lname' => $params['lname']),'where patientid = ?',array($params['patientid']));
        return $result;
    }
    public function EditEmail($params){
        $result = $this->update('patient',array('email' => $params['email']),'where patientid = ?',array($params['patientid']));
        return $result;
    }
    public function PhoneEdit($params){
        $result = $this->update('patient',array('phone' => $params['phone']),'where patientid = ?',array($params['patientid']));
        return $result;
    }
    public function CityAreaEdit($params){
        $result = $this->update('patient',array('areaid' => $params['areaid']),'where patientid = ?',array($params['patientid']));
        return $result;
    }
    public function AddressEdit($params){
        $result = $this->update('patient',array('address' => $params['address']),'where patientid = ?',array($params['patientid']));
        return $result;
    }
    public function CheckCpassword($params){
        $result = $this->customSelect("select userid from patient as p inner join user as u on p.userid = u.id where u.password = '{$params['currentpassword']}' 
                  and p.patientid = {$params['patientid']}");
        return $result;
    }
    public function EditPassword($params){
        $get = $this->select('patient',array('userid'),'where patientid = ? ',array($params['patientid']));
        if ($get['status'] == 'success' && $get['rowsAffected'] == 1){
            $result = $this->update('user',array('password' => $params['cpassword']),'where id = ? ',array($get['result'][0]->userid));
            return $result;
        }else{
            return $get;
        }
    }
    public function GetDoctorData($params){
        $result = $this->select('doctor',array('*'),'where id = ?',array($params['doctorid']));
        return $result;
    }
    public function DEditFname($params){
        $result = $this->update('doctor',array('fname' => $params['fname']),'where id = ?',array($params['doctorid']));
        return $result;
    }
    public function DEditLname($params){
        $result = $this->update('doctor',array('lname' => $params['lname']),'where id = ?',array($params['doctorid']));
        return $result;
    }
    public function DEditEmail($params){
        $result = $this->update('doctor',array('email' => $params['email']),'where id = ?',array($params['doctorid']));
        return $result;
    }
    public function DPhoneEdit($params){
        $result = $this->update('doctor',array('phone' => $params['phone']),'where id = ?',array($params['doctorid']));
        return $result;
    }
    public function DCityAreaEdit($params){
        $result = $this->update('doctor',array('areaid' => $params['areaid']),'where id = ?',array($params['doctorid']));
        return $result;
    }
    public function DAddressEdit($params){
        $result = $this->update('doctor',array('address' => $params['address']),'where id = ?',array($params['doctorid']));
        return $result;
    }
    public function DCheckCpassword($params){
        //echo "<pre>".print_r($params);
        $result = $this->customSelect("select userid from doctor as d inner join user as u on d.userid = u.id where u.password = '{$params['currentpassword']}' 
                  and d.id = {$params['doctorid']}");
        return $result;
    }
    public function DEditPassword($params){
        $get = $this->select('doctor',array('userid'),'where id = ? ',array($params['doctorid']));
        if ($get['status'] == 'success' && $get['rowsAffected'] == 1){
            $result = $this->update('user',array('password' => $params['cpassword']),'where id = ? ',array($get['result'][0]->userid));
            return $result;
        }else{
            return $get;
        }
    }
    public function PatientSharingDoc($params){
        //select id from appointments where patientid = 1 and confirm = 1;
/*        $get = $this->select('appointments',array('id'),'where patientid = ? and confirm = ?',array($params['patientID'],1));
        //echo "<pre>".print_r($get);
        $querey = "select * from prescribtion where appt_id in (";
        for ($i=0 ; $i<$get['rowsAffected'] ; $i++){
            ($i != ($get['rowsAffected'] -1)) ? $querey.=$get['result'][$i]->id."," : $querey.=$get['result'][$i]->id;
        }
        $querey .= ")";
        $result = $this->customSelect($querey);
        return $result;*/
        $result = $this->customSelect("select d.fname,d.lname,a.id,p.p_detail,p_id  from appointments as a inner join doctor as d
                  on d.id = a.doctorid inner join prescribtion as p on p.appt_id = a.id where a.patientid = {$params['patientID']}
                  and a.confirm = 1");
        return $result;
    }
    public function sharedData($params){
        $result = $this->customSelect("select a.*,p.* from appointments as a inner join prescribtion as p on 
                  a.id = p.appt_id where p.p_id = {$params['prescribtionId']}");
        return $result;

    }
    public function getAllprofession(){
        $result = $this->select('profession',array('*'));
        return $result;
    }
    public function get_doctor_detail($params){
        $result = $this->select('doctor',array('*'),'where id = ?',array($params['doctorid']));
        return $result;
    }
}
$mendetoryParam = array(
    'filter'				=>	array('speciality','fees','Location'),
    'getAreasForCity'	    =>	array('cityId'),
    'Appointment'			=>	array('patientId','doctorId','description','date'),
    'Check_appointment'     =>  array('ApptId'),
    'filterByDate'          => array('date','doctorid'),
    'Allappointment'        => array('doctorId'),
    'AppointmentConfirm'    => array('AppointmentId','s_time','e_time'),
   /* 'ModifyApptDate'        => array('AppointmentId','prefferedDate'),*/
    'Notification'          => array('patientID'),
    'Pactivity'             => array('patientID'),
  /*  'Dappointment'          => array('doctorid'),*/
    'Confirmed_Appointment' => array('doctorId'),
    'usersignup'            => array('fname','lname','email','gender','city','areaid','address','nic','phone','username','password','confirmpassword'),
    'doctorsignup'          => array('fname','lname','email','gender','city','areaid','address','nic','phone','pmdc','degree','board','speciality','fees','username','password','confirmpassword'),
    'Doctor_Available_Day'  => array('doctorid'),
    'Doctor_Available_Date' => array('dayid','doctorid'),
    'Doctor_Time_Slot'      => array('date','doctorid'),
    'CA_filterByDate'       => array('date','doctorid'),
    'Send_prescribtion'     => array('apptId','p_detail'),
    'Appt_Prescrib_Datefilter'=> array('date','patientId'),
    'get_pId_By_aId'        => array('apptId'),
    'AP_Filter_By_Bulk'     => array('status','patientId'),
    'RegisterRequest'       => array(),
    'AdminP_ViewDetailRequest'=> array('doctorid'),
    'AdminP_ApprovedRequest'=> array('doctorid'),
    'RegisterUser'          => array(),
    'GetRegUserById'        => array('doctorid'),
    'DeActiveDoctor'        => array('doctorid'),
    'getPatientAppt'        => array('ApptId'),
    'ViewDoctor'            => array('doctorid'),
    'GetPatientData'        => array('patientid'),
    'EditFname'             => array('patientid','fname'),
    'EditLname'             => array('patientid','lname'),
    'EditEmail'             => array('patientid','email'),
    'PhoneEdit'            => array('patientid','phone'),
    'CityAreaEdit'          => array('patientid','areaid'),
    'AddressEdit'           => array('patientid','address'),
    'CheckCpassword'        => array('patientid','currentpassword'),
    'EditPassword'          => array('patientid','cpassword'),
    'GetDoctorData'         => array('doctorid'),
    'DEditFname'            => array('doctorid','fname'),
    'DEditLname'            => array('doctorid','lname'),
    'DEditEmail'            => array('doctorid','email'),
    'DPhoneEdit'            => array('doctorid','phone'),
    'DCityAreaEdit'         => array('doctorid','areaid'),
    'DAddressEdit'          => array('doctorid','address'),
    'DCheckCpassword'       => array('doctorid','currentpassword'),
    'DEditPassword'         => array('doctorid','cpassword'),
    'PatientSharingDoc'     => array('patientID'),
    'sharedData'            => array('prescribtionId'),
    'getAllprofession'      => array(),
    'get_doctor_detail'     => array('doctorid')
);



if(isset($_POST['call']) && isset($mendetoryParam[$_POST['call']])){
    $data = array();
    $missingFields = array();
    $flag = true;
    foreach($mendetoryParam[$_POST['call']] as $value){
        if(!isset($_POST[$value])){
            $flag = false;
            $missingFields[] = $value;
        }
    }
    if(count($missingFields) > 0){
        $data['status'] =  false;
        $data['error'] =  'Required parameter(s) missing';
        $data['missingParameters'] = implode(',',$missingFields);
        echo json_encode($data,true);
    }else{
        $helperObj = new helper();
        $data = $_POST;
        $mathodToCall = (string)$_POST['call'];
        $response = $helperObj->$mathodToCall($data);
        echo json_encode($response);
    }
}elseif (isset($_POST['call']) && $_POST['call'] == 'doctorsignupTimetable'){
    $helperObj = new helper();
    $mathodToCall = (string)$_POST['call'];
    echo json_encode($helperObj->$mathodToCall($_POST));
}elseif(isset($_POST['call']) && $_POST['call'] == 'uploadMultipleFiles'){
    echo "<pre>".print_r($_POST);
} else {
    echo json_encode(array('status'=>false,'error'=>'Invalid method called'));
}
?>