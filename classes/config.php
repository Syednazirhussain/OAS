<?php
class config{
	public static function getDbCredentials(){
		$credentials = array(
			"serverAddress" => '127.0.0.1',
			"username" 		=> 'root',
			"password" 		=> '',
			"dbname" 		=> 'fyp'
		);
		return $credentials;
	}
}
?>

