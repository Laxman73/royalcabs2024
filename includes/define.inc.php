<?php
##	DEFINES 		###################################################################################
define('TODAY',date("Y-m-d"));
define('NOW',date("Y-m-d H:i:s"));
define('TOMMORROW', date("Y-m-d", strtotime("+1 day")));
define('YESTERDAY', date("Y-m-d", strtotime("-1 day")));
define('CURRENTTIME',date("H:i:s"));

define('TODAY2',date("d-m-Y"));
define('NOW2',date("d-m-Y H:i:00"));
define('TOMMORROW2', date("d-m-Y", strtotime("+1 day")));
define('YESTERDAY2', date("d-m-Y", strtotime("-1 day")));
define('LAST7DAYS', date("Y-m-d", strtotime("-7 day")));

define('NOW3', date("Ymd.Hi"));
// define('PAYROLL_PROCESS_START', '2014-03');
define('THIS_WEEK', date("W"));
define('THIS_MONTH', date("m"));
define('THIS_YEAR', date("Y"));

define('LAST_WEEK', date("W", strtotime("-1 week")));
define('LAST_MONTH', date("m", strtotime("-1 month")));
define('LAST_YEAR', date("Y", strtotime("-1 year")));

define('CURRENT_MONTH', date("m"));
define('CURRENT_YEAR', date("Y"));

define('FINANCIAL_YEAR_STARTDAY', '04-01');
define('FINANCIAL_YEAR_ENDDAY', '03-31');

define('MONTH_START', date("Y-m-01"));
define('MONTH_START2', date("01-m-Y"));

define('MONTH_YEAR', date("mY"));
define('TODAY1',date("Ymd"));

define('URL_REWRITTING','ON');
define('PROJ_DELIMITER', '[DCC_BREAK]');
$STARTOFMONTH="01-".THIS_MONTH."-".THIS_YEAR;

// define('SEND_MAILER', 0);
define('OFFICIAL_EMAILID','');
define('OFFICIAL_SITE','');
define('PROJ_SESSION_ID', 'rhi_adm');
define('PROJ_FRONT_SESSION_ID', 'rhi_frt');
define('PROJ_ALERT_SESSION_ID', 'rhi_alt1');
define('PROJ_ALERT_SESSION_ID2', 'rhi_alt2');
define('THUMBNAIL_ALLOWED', 1);	// 1 - Yes, 0 - No.
define('RANDOMIZE_FILENAME', 1); // 0 - Randomize Uploaded Image Name, 1 - Customize Uploaded Image Name
define('SQL_ERROR', 1);
define('NEWLINE', "\r\n");
define('TAB_SPACE', "\t");
define('FORCE_PRINT_DOWNLOAD', 1); // default is 0
define('IS_WAMP_SETUP', 1);
define('WEEK_START_DAY', 1); // 0: Sunday, 1: Monday...
define('QTR_START_MONTH', 1); // Jan
define('QTR_MONTH_OFFSET', 0); // Jan
define('ADD_SLASHES', 0);
define('NA', '- n/a -');
define('IS_INTERNET', false);
define('PROJ_RM_SESSION_ID', 'Booking');

##	PATH DEFINES	###################################################################################
define('AJAX_INC_URL',SITE_ADDRESS.'includes/ajax.inc.php');

define('IMAGE_PATH',SITE_ADDRESS.'images/');
define('IMAGE_UPLOAD',DOCROOT.'images/');

define('USER_PATH',SITE_ADDRESS.'uploads/users/');
define('USER_UPLOAD',DOCROOT.'uploads/users/');

define('VEHICLE_IMG_PATH',SITE_ADDRESS.'uploads/vehicle/');
define('VEHICLE_IMG_UPLOAD',DOCROOT.'uploads/vehicle/');


define('SLIDER_DESKTOP_PATH',SITE_ADDRESS.'uploads/slider_desktop/');
define('SLIDER_DESKTOP_UPLOAD',DOCROOT.'uploads/slider_desktop/');

define('SLIDER_MOBILE_PATH',SITE_ADDRESS.'uploads/slider_mobile/');
define('SLIDER_MOBILE_UPLOAD',DOCROOT.'uploads/slider_mobile/');

##	IMAGE DEFINES	###################################################################################
define("PRINT_RECORD_IMG", "<img src='" . IMAGE_PATH . "print.png' alt='Print' border='0' align='absmiddle'>");
define("EXPORT_CSV_RECORD_IMG", "<img src='" . IMAGE_PATH . "csv-export.png' alt='CSV Export' border='0' align='absmiddle'>");
define("IMPORT_CSV_RECORD_IMG", '<i class="fa fa-upload"></i>');
define("BARCODE_RECORD_IMG", "<img src='" . IMAGE_PATH . "barcode.png' alt='Print Labels' border='0' align='absmiddle'>");
define("FEATURED_IMG", "<img src='" . IMAGE_PATH . "featured.gif' border='0' alt='featured' align='absmiddle'>");
define("UNFEATURED_IMG", "<img src='" . IMAGE_PATH . "unfeatured.gif' border='0' align='absmiddle'>");
define("EDIT_IMG_SMALL", '<i class="fa fa-edit"></i>');
define("EDIT_IMG", '<span class="glyphicon glyphicon-edit"> </span>');
define("DELETE_IMG_SMALL", '<i class="fa fa-remove"></i>');
define("DELETE_IMG", '<span class="glyphicon glyphicon-remove"> </span>');

define("NOIMAGE", IMAGE_PATH."/no-image.png");

//define("EDIT_IMG", "<img src='" . IMAGE_PATH . "edit.gif' alt='Edit Record' border='0' align='absmiddle'>");
//define("DELETE_IMG", "<img src='" . IMAGE_PATH . "delete.gif' alt='Delete Record' border='0' align='absmiddle'>");
define("ACTIVE_IMG", "<img src='" . IMAGE_PATH . "active.png'  alt='Active' border='0' align='absmiddle'>");
define("INACTIVE_IMG", "<img src='" . IMAGE_PATH . "inactive.png' alt='Blocked' border='0' align='absmiddle'>");

define("STARRED_IMG", "<img src='" . IMAGE_PATH . "star.png'  alt='Starred' border='0' align='absmiddle'>");
define("UNSTARRED_IMG", "<img src='" . IMAGE_PATH . "not-star.png' alt='UnStarred' border='0' align='absmiddle'>");
define("YES_IMG", "<img src='" . IMAGE_PATH . "yes-ico.gif'  alt='Yes' border='0' align='absmiddle'>");
define("NO_IMG", "<img src='" . IMAGE_PATH . "no-ico.gif' alt='No' border='0' align='absmiddle'>");
define("ADD_IMG", "<img src='" . IMAGE_PATH . "add.gif' alt='Add' border='0' align='absmiddle'>");
define("RMV_IMG", "<img src='" . IMAGE_PATH . "remove.gif' alt='Remove' border='0' align='absmiddle'>");

define("MOD_BLOCK_IMG", "<img src='" . IMAGE_PATH . "mod_block.gif'  alt='Active' border='0' align='absmiddle'>");
define("MOD_VIEW_IMG", "<img src='" . IMAGE_PATH . "mod_view.gif' alt='Blocked' border='0' align='absmiddle'>");
define("MOD_EDIT_IMG", "<img src='" . IMAGE_PATH . "mod_edit.gif' alt='Blocked' border='0' align='absmiddle'>");

define('TSK_ICON', '<img src="images/icons/default/tasks.png" alt="task" border="0" align="absmiddle" />');
define('MTG_ICON', '<img src="images/icons/default/meeting.png" alt="meeting" border="0" align="absmiddle" />');
define('RFI_ICON', '<img src="images/icons/default/rfi.png" alt="rfi" border="0" align="absmiddle" />');
define('INS_ICON', '<img src="images/icons/default/inspection.png" alt="inspection" border="0" align="absmiddle" />');
define('PROJECT_ICON', '<img src="images/icons/default/project.png" alt="project" border="0" align="absmiddle" />');
define('USERS_ICON', '<img src="images/icons/default/users.png" alt="users" border="0" align="absmiddle" />');
define('INSPECTION_PICS_ICON', '<img src="images/icons/default/media.png" alt="users" border="0" align="absmiddle" />');

define('GEN_SERVICES_ICON', '<img src="images/icons/default/gen_services.png" alt="services" border="0" align="absmiddle" />');
define('GEN_LOCATION_ICON', '<img src="images/icons/default/gen_location.png" alt="locations" border="0" align="absmiddle" />');
define('DOCUMENTS_ICON', '<img src="images/icons/default/documents.png" alt="documents" border="0" align="absmiddle" />');

define('ADD_ICON', '<img src="images/icons/default/add_new.png" alt="New Record" border="0" align="absmiddle" />');
define('PRINT_ICON', '<img src="images/icons/default/print.png" alt="Print" border="0" align="absmiddle" />');
define('EXCEL_ICON', '<img src="images/icons/default/excel_file.png" alt="Excel Export" border="0" align="absmiddle" />');
define('FUNCTION_ICON', '<img src="images/icons/default/settings.png" border="0" align="absmiddle" />');
define('BARCODE_ICON', '<img src="images/icons/default/barcode.png" border="0" align="absmiddle" />');
define('RESET_ICON', '<img src="images/icons/default/reset.png" border="0" align="absmiddle" />');
define('ARCHIVE_ICON', '<img src="images/icons/default/error.png" title="Archive This" border="0" align="absmiddle" />');
define('UNARCHIVE_ICON', '<img src="images/icons/default/alert.png" title="Restore This" border="0" align="absmiddle" />');
define('UPLOAD_ICON', '<img src="images/icons/default/upload.png" title="Upload This" border="0" align="absmiddle" />');
define("PRELOAD_BAR", "<img src='" . IMAGE_PATH . "preloader_bar.png' alt='Loading Now...' border='0' align='absmiddle'>");
define('DOWNLOAD_ICON', '<img src="images/icons/default/download.png" title="Download This" border="0" align="absmiddle" />');

##	NO IMAGE DEFINES	###################################################################################
define('NO_PHOTO_SML', '<img src="images/avatar.png" alt="" class="radius2" />');
// define('NO_ALBUM', '<img src="'.IMAGE_PATH.'artist-img.jpg" border="0">');

##	DEFINED ARRAYs	###################################################################################
$IMG_TYPE = array('gif','png','pjpeg','jpeg','jpg','JPG');
$DOC_TYPE = array('txt','doc','docx','pdf','xls','xlsx');
$IMG_FILE_TYPE = array('image/gif','image/png','image/pjpeg','image/jpeg','image/jpg');
$DOC_FILE_TYPE = array('text/plain','application/msword','application/vnd.ms-word','application/pdf','application/vnd.ms-excel');

$DISPLAY_ARR = array("Y"=>"Yes","N"=>"No");

$MODE_ARR = array('A'=>'Add','E'=>'Edit');
$WEEKDAY_ARR = array('0'=>'Sunday', '1'=>'Monday', '2'=>'Tuesday', '3'=>'Wednesday', '4'=>'Thursday', '5'=>'Friday', '6'=>'Saturday');
$WEEKDAY_ARR2 = array('SUN'=>'Sunday', 'MON'=>'Monday', 'TUE'=>'Tuesday', 'WED'=>'Wednesday', 'THU'=>'Thursday', 'FRI'=>'Friday', 'SAT'=>'Saturday');
$WEEKDAY_ORDER_ARR = array("'SUN'", "'MON'", "'TUE'", "'WED'", "'THU'", "'FRI'", "'SAT'");
$WEEKDAY_ARR3 = array('0'=>'SUN', '1'=>'MON', '2'=>'TUE', '3'=>'WED', '4'=>'THU', '5'=>'FRI', '6'=>'SAT');
$MONTH_ARR = array("1"=>"January", "2"=>"February", "3"=>"March", "4"=>"April", "5"=>"May", "6"=>"June", "7"=>"July", "8"=>"August", "9"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
$SHORT_MONTH_ARR = array("1"=>"Jan", "2"=>"Feb", "3"=>"Mar", "4"=>"Apr", "5"=>"May", "6"=>"Jun", "7"=>"Jul", "8"=>"Aug", "9"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dec");
$SHORT_MONTH_ARR = array("1"=>"Jan", "2"=>"Feb", "3"=>"Mar", "4"=>"Apr", "5"=>"May", "6"=>"Jun", "7"=>"Jul", "8"=>"Aug", "9"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dec");

$TIME_CAR_ARR = array("12:00 AM"=>"12:00 AM","12:30 AM"=>"12:30 AM","01:00 AM"=>"01:00 AM","01:30 AM"=>"01:30 AM","02:00 AM"=>"02:00 AM","02:30 AM"=>"02:30 AM","03:00 AM"=>"03:00 AM","03:30 AM"=>"03:30 AM","04:00 AM"=>"04:00 AM","04:30 AM"=>"04:30 AM","05:00 AM"=>"05:00 AM","05:30 AM"=>"05:30 AM","06:00 AM"=>"06:00 AM","06:30 AM"=>"06:30 AM","07:00 AM"=>"07:00 AM","07:30 AM"=>"07:30 AM","08:00 AM"=>"08:00 AM","08:30 AM"=>"08:30 AM","09:00 AM"=>"09:00 AM","09:30 AM"=>"09:30 AM","10:00 AM"=>"10:00 AM","10:30 AM"=>"10:30 AM","11:00 AM"=>"11:00 AM","11:30 AM"=>"11:30 AM","12:00 PM"=>"12:00 PM","12:30 PM"=>"12:30 PM","01:00 PM"=>"01:00 PM","01:30 PM"=>"01:30 PM","02:00 PM"=>"02:00 PM","02:30 PM"=>"02:30 PM","03:00 PM"=>"03:00 PM","03:30 PM"=>"03:30 PM","04:00 PM"=>"04:00 PM","04:30 PM"=>"04:30 PM","05:00 PM"=>"05:00 PM","05:30 PM"=>"05:30 PM","06:00 PM"=>"06:00 PM","06:30 PM"=>"06:30 PM","07:00 PM"=>"07:00 PM","07:30 PM"=>"07:30 PM","08:00 PM"=>"08:00 PM","08:30 PM"=>"08:30 PM","09:00 PM"=>"09:00 PM","09:30 PM"=>"09:30 PM","10:00 PM"=>"10:00 PM","10:30 PM"=>"10:30 PM","11:00 PM"=>"11:00 PM","11:30 PM"=>"11:30 PM");
$PASS_ARR = array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7");
$PASS_ARR_COACH = array("7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25" ,"26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30","31"=>"31","32"=>"32","33"=>"33","34"=>"34","35"=>"35");

$C_PASS_ARR=array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25" ,"26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30","31"=>"31","32"=>"32","33"=>"33","34"=>"34","35"=>"35");




$EMAIL_TYPE_ARR = array('CC'=>'CC', 'BCC'=>'BCC');
$PAYMENT_STATUS_ARR = array('N'=>'Not Paid','P'=>'Paid');
$USER_LEVEL_ARR = array('0'=>'System Admin');
$YES_ARR = array('Y'=>'Yes', 'N'=>'No');
$YES_ARR2 = array('Y'=>YES_IMG, 'N'=>NO_IMG);

$ONLINE_ARR = array('Y'=>'Online', 'N'=>'Offline');
$STATUS_ARR = array("A"=>"Active", "I"=>"Inactive");

$PERIOD_ARR = array("M"=>"Month","Y"=>"Year");
$GENDER_ARR = array("M"=>"Male", "F"=>"Female");
$GENDER_ARR2 = array("M"=>"pe-7s-male icon-gradient bg-malibu-beach", "F"=>"pe-7s-female icon-gradient bg-warm-flame");
##	DEFINED ERROR MSGS	###################################################################################

define('NO_RECORDS_IN_TABLE', 'No Data Records Found In Table');
define('READONLY_ACCESS', '<div class="err_lbl1" align="center">You Can No Longer Add/ Modify Records For This Module Locally. Inorder To Do So, You Need To Login To The Online Module.</div>');
define('INVALID_ACCESS', 'Invalid Access Detected. Script Terminated.');
define('MODULE_ACCESS_DENIED', 'Invalid Access: You Do Not Have The Necessary Permissions To View This Module');
define('MODULE_EDIT_DENIED', 'Invalid Access: You Do Not Have The Necessary Permissions To Edit This Process');
define('INVALID_PARAMETER', 'Invalid Parameter Detected. Script Terminated.');

#######################################################################################################
$FULL_MONTH_ARR = array("01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
#######################################################################################################

$RENTAL_RATE_TYPE_ARR = array("F"=>"Fix Price", "R"=>"Price Range", "E"=>"Enquire on request");

$SYS_SET_TYPE_ARR = array("D"=>"Define", "V"=>"Variable", "A"=>"Array");
$SYS_SET_DATA_ARR = array("I"=>"Integer", "N"=>"Float", "B"=>"Boolean", "C"=>"Char/Text", "D"=>"Date/Time");

?>