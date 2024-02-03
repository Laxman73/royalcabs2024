<?php
include "../includes/common.php";

$PAGE_TITLE2 = 'Password';

$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'change_password.php';

if(isset($_GET['txtcurrpass'])) $txtcurrpass = $_GET['txtcurrpass'];
elseif(isset($_POST['txtcurrpass'])) $txtcurrpass = $_POST['txtcurrpass'];

if(isset($_GET['txtnewpass'])) $txtnewpass = $_GET['txtnewpass'];
elseif(isset($_POST['txtnewpass'])) $txtnewpass = $_POST['txtnewpass'];

if(isset($_GET['mode'])) $mode = $_GET['mode'];
elseif(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode ='A';

$modalTITLE ='New '.$PAGE_TITLE2;

if($mode=='A')
{
	$txtnewpass ='';
	$txtcurrpass ='';
}
else if($mode=='U')
{
	$txtid = $_SESSION[PROJ_SESSION_ID]->user_id;
	$dataArr = GetDataFromID("users", "iUserID", $txtid);
	if(empty($dataArr))
	{
		header("location: $disp_url");
		exit;
	}

	$pass='';
	$oldpass = db_output($dataArr[0]->vPassword);
	$currpass = $_POST['txtcurrpass'];

	if($oldpass == $currpass){
		$newpass = $_POST['txtnewpass'];
		$values = " vPassword='$newpass' ".$pass;

		$QUERY = UpdataData('users',$values, "iUserID=$txtid");
		$_SESSION[PROJ_SESSION_ID]->success_info = "Password Changed Successfully";
		header("location: $disp_url");
	}else{
		$_SESSION[PROJ_SESSION_ID]->alert_info = "Password not changed. Entered current password is incorrect. Please try again";
		header("location: $disp_url");
	}
	exit;
	
}
?>
<!doctype html>
<html lang="en">
<head>
<?php include "load.links.php"; ?>
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
  <?php include "load.header.php"; ?>
  <div class="app-main">
    <?php include "load.menu.php"?>
    <!-- load side menu: end -->
    <div class="app-main__outer">
      <div class="app-main__inner">
        <div id="LBL_INFO"><?php echo $sess_info_str; ?></div>
        <div class="row col-md-12">
          <div class="main-card mb-3 card col-md-12">
            <div class="card-header-tab card-header">
              <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-key mr-3 text-muted opacity-6"> </i><?php echo $modalTITLE; ?> </div>
            </div>
            <div class="card-body">
              <form id="chngpass_frm" name="chngpass_frm" method="post" action="<?php echo $disp_url; ?>">
                <input type="hidden" name="mode" id="txtid" value="<?php echo "U"; ?>">
                <div class="col-md-12">
                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtcurrpass" class="">Current Password</label><b><sup style="color:red"> *</sup></b>
                        <input name="txtcurrpass" id="txtcurrpass" type="password" value="<?php echo $txtcurrpass; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtnewpass" class="">New Password</label><b><sup style="color:red"> *</sup></b>
                        <input name="txtnewpass" id="txtnewpass" type="password" value="<?php echo $txtnewpass; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  
                  <button type="button" onClick="location.href='<?php echo $disp_url; ?>';" class="mt-2 btn btn-secondary">Back</button>
                  <button type="submit" class="mt-2 btn btn-success">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer Comes Here -->
      <?php include "load.footer.php"; ?>
      <!-- Footer End -->
    </div>
  </div>
</div>
<div class="app-drawer-overlay d-none animated fadeIn"></div>
<?php include "load.scripts.php"; ?>
<script type="text/javascript" src="../scripts/ajax.js"></script>
<script type="text/javascript" src="../scripts/common.js"></script>
<script type="text/javascript" src="../scripts/md5.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
	$("#chngpass_frm").submit(function(){

		var ret = true;
		var md = "<?php echo $mode ?>";

		var cur_p = $(this).find('#txtcurrpass');
		var new_p = $(this).find('#txtnewpass');

		if($.trim(cur_p.val()) == ''){
			ShowError(cur_p,"Please enter current password");
      ret= false;
		}
		if($.trim(new_p.val()) == ''){
			ShowError(new_p,"Please enter new password");
      ret= false;
		}

		if($.trim(cur_p.val()) != '' && $.trim(new_p.val()) != '')
		{
			p1_str = GenerateNewPass(b64_md5(cur_p.val()));
			cur_p.val(p1_str);
			p2_str = GenerateNewPass(b64_md5(new_p.val()));
			new_p.val(p2_str);
		}

		return ret;

	});
	
});
</script>
</body>
</html>
