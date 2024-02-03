<?php
include "config.inc.php"; // db configurations
include "define.inc.php"; // # defines
include "generic.inc.php"; // # common functions
include "common.inc.php"; // # project specific functions
include "userdat.php"; // #
include "sql.inc.php"; // # sql functions
include "custom.php"; // custom functions created for this project
include "dynamic.inc.php"; // */

if(!$logged && $NO_REDIRECT==0)
{
	session_destroy();
	ForceOut(9);
	exit;
}

$PAGE_TITLE = SITE_NAME." | ";

?>
