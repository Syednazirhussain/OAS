<?php
class license extends pdocrudhandler{
    private $_days;
    public function generate_key_string() {
        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $segment_chars = 5;
        $num_segments = 4;
        $key_string = '';
        for ($i = 0; $i < $num_segments; $i++) {
            $segment = '';
            for ($j = 0; $j < $segment_chars; $j++) {
                $segment .= $tokens[rand(0, 35)];
            }
            $key_string .= $segment;
            if($i < ($num_segments - 1)) {
                $key_string .= '-';
            }
        }
        return $key_string;
    }
    public function insertKeys($plan){
        for($i=0;$i<count($plan);$i++){
            for($j=0;$j<$plan[$i]['numOfKeys'];$j++){
                $this->insert('licensekeys',array('licenseKey' => $this->generate_key_string(),'expired' => 0,'idUser' => 1,'daysValidFor' => $plan[$i]['days'], 'inUse' => 0));
            }
        }

    }
    public function validateLicenseKey($key){
        $license = $this->select("licensekeys",array("*"),"where licenseKey = ? and expired = ? and usedBy = ?",array($key,0,0));
        $this->updateLicense($license);
    }
    public function updateLicense($license){
        if($license['status'] = 'success' && $license['rowsAffected'] > 0){
            //$newLicenseDate = date('Y-m-d h:i:s',strtotime($_SESSION['currentLicenseDate'] . "+".$license['result']->daysValidFor." day"));
            $newLicenseDate = date('Y-m-d h:i:s',strtotime("+".$license['result'][0]->daysValidFor." days"));
            $_SESSION['newSub'] = $newLicenseDate;
            $this->update('user',array('licenseExpiryDate' => $newLicenseDate),'where idUser = ?',array($_SESSION['userid']));
            $this->update('licensekeys',array('usedBy' => $_SESSION['userid'],'expired' => 1),'where idLicenseKeys = ?',array($license['result'][0]->idLicenseKeys));
            header('location:license.php?status=success');
        }else {
            header('location:license.php?status=failure');
        }
    }
}
//$key = new license();
//$plan = array(array('days' => 30, 'numOfKeys' => 100), array('days' => 365, 'numOfKeys' => 50), array('days' => 1825, 'numOfKeys' => 25), array('days' => 3650, 'numOfKeys' => 10));
//$key->insertKeys($plan);
?>