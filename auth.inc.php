<?php

# login with the username and password.
function login($username, $password){
	include_once("db.inc.php");
	if($username == USERNAME && $password == USERPASS){
		session_set_cookie_params(3600*6, '/', 'mtl.parkr.me');
		session_id(SESSION_ID);
		session_start();
		session_register(SESSION_ID);
		$_SESSION['started'] = true;
		return true;
	}else{
		return false;
	}
}

# if session is open, return true. otherwise, return false
function session_open(){
	include_once("db.inc.php");
	return (session_is_registered(SESSION_ID) || $_SESSION['started'] == true || $_COOKIE['PHPSESSID'] == SESSION_ID);
}

# logout
function logout(){
	if(session_open()){
		//session_write_close();
		session_destroy();
	}
}

?>