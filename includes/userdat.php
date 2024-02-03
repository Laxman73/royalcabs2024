<?php 
// data that needs to be rememberered...
class userdat
{
	var $log_time;		// time of login
	var $log_stat;		// log status - is the user logged in or not
	var $sess_id;		// session id
///////////////////////////////////////////////

	var $user_id;		// de user's id		
	var $user_code;		// de user's id		
	var $user_name;		// de user's name	
	var $user_level;	//
	var $user_pic;	//	
	var $user_lastlogin;	//	
	var $user_ip;	//	
	var $user_dep;
	var $depttype;
	var $user_property;
///////////////////////////////////////////////

	var $srch_ctrl_arr = array();
	var $list_cart_arr = array();
	var $list_pics_arr = array();
	var $list_param_arr = array();
	var $lhs_menu = true;
	
	var $info;			// error msg
	var $success_info;		// error msg
	var $error_info;			// error msg
	var $alert_info;			// error msg
	var $sess_token;
	var $sess_active;
}

class alertdat
{
	var $success_info;
	var $error_info;
	var $alert_info;
	var $warning_info;
}

$sess_id = session_id();

if(empty($sess_id))
{
	ini_set('session.gc_maxlifetime', 3600);
	session_start();

}

/*if(empty($sess_id)){
$time = $_SERVER['REQUEST_TIME'];
//exit;
$timeout_duration = 50;

if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_start();
}

$_SESSION['LAST_ACTIVITY'] = $time;

}*/

?>