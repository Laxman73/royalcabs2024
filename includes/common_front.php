<?php
include "config.inc.php"; // db configurations
include "define.inc.php"; // # defines
include "generic.inc.php"; // # common functions
include "common.inc.php"; // # project specific functions
include "userdat_converge.php"; // #
include "sql.inc.php"; // # sql functions
include "custom.php"; // # sql functions
//include "dynamic_front.inc.php"; // */

$CON = GetConnected();

session_start();


$PAGE_TITLE = SITE_NAME." - ";

// if(!empty($sess_user_id))
// {

// }
?>