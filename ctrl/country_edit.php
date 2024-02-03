<?php
include "../includes/common.php";

$PAGE_TITLE2 = 'Country';
$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'country_disp.php';
$edit_url = 'country_edit.php';

if(isset($_GET['mode'])) $mode = $_GET['mode'];
elseif(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode ='A';

if(isset($_GET['id'])) $txtid = $_GET['id'];
elseif(isset($_POST['txtid'])) $txtid = $_POST['txtid'];
else $mode ='A';

if($mode=='A')
{
	$txtid = '';
	$txtname = '';
	$txtshortcode = '';
	$rdstatus = 'A';

	$modalTITLE = 'New '.$PAGE_TITLE2;
	$form_mode ='I';
}
else if($mode=='I')
{
	$txtname = db_input_default($_POST['txtname'], 'v');
	$txtshortcode = db_input_default($_POST['txtshortcode'], 'v');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');

	LockTable('country');
	$txtid = NextID('iCountryID', 'country');
	$q = "INSERT INTO country (iCountryID, vName, cShortCode, iRank, cStatus) 
			VALUES ($txtid, $txtname, $txtshortcode, $txtid, $rdstatus)";
	$r = sql_query($q, "country_edit.E.38");
	UnLockTable();

	$_SESSION[PROJ_SESSION_ID]->success_info = "Country Details Successfully Inserted";
}
else if($mode=='E')
{
	$dataArr = GetDataFromID("country", "iCountryID", $txtid);
	
	$txtid = $dataArr[0]->iCountryID;
	$txtname = db_output($dataArr[0]->vName);
	$txtshortcode = db_output($dataArr[0]->cShortCode);
	$rdstatus = $dataArr[0]->cStatus;

	$modalTITLE = 'Edit '.$PAGE_TITLE2;
	$form_mode ='U';
}
else if($mode=='U')
{
	$txtname = db_input_default($_POST['txtname'], 'v');
	$txtshortcode = db_input_default($_POST['txtshortcode'], 'v');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');
	
	$q = "UPDATE country SET vName=$txtname, cShortCode=$txtshortcode, cStatus=$rdstatus WHERE iCountryID=$txtid ";
	$r = sql_query($q, "country_edit.E.68");
	$_SESSION[PROJ_SESSION_ID]->success_info = "Country Details Successfully Updated";
}
elseif($mode=='D')
{
	$txtid = $_GET['id'];
	$loc_str = $edit_url . "?mode=E&id=$txtid"; 
	
	$chk_arr = array();
	//$chk_arr['Appointments'] = GetXFromYID('select count(*) from  where iCountryID='.$txtid.' and cStatus!="X"');
	$chk = array_sum($chk_arr);
	
	if(!$chk)
	{
		$q3 = "UPDATE country SET cStatus='X' WHERE iCountryID=$txtid";
		$r3 = sql_query($q3, 'country_edit.D.87');
		
		$_SESSION[PROJ_SESSION_ID]->success_info = "Country Details Successfully Deleted";
		$loc_str = $disp_url;
	}
	else $_SESSION[PROJ_SESSION_ID]->alert_info = "Country Details Could Not Be Deleted Because of Existing ".(CHK_ARR2Str($chk_arr))." Dependencies";
	
	header("location: $loc_str");
	exit;
}

if($mode=='I' || $mode=='U')
{
	header("location: $edit_url?mode=E&id=$txtid");
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
  <?php //include "loadtheme.settings.php"; ?>
  <div class="app-main">
    <?php include "load.menu.php"?>
    <div class="app-main__outer">
      <div class="app-main__inner">
        <div class="app-inner-layout">
          <div class="page-title-subheading opacity-10">
			<nav class="" aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"> <a style="cursor:pointer;" href="javascript:;"><?php echo GetXFromYID("SELECT vTitle FROM menu WHERE iMenuID = (SELECT iParentID FROM menu WHERE vUrl = '$disp_url')"); ?></a> </li>
					<li class="breadcrumb-item"> <a href="<?php echo $disp_url; ?>"><?php echo $PAGE_TITLE2; ?></a> </li>
					<li class="active breadcrumb-item" aria-current="page"> <?php echo $modalTITLE; ?> </li>
				</ol>
			</nav>
          </div>
          <div id="LBL_INFO"><?php echo $sess_info_str; ?></div>
          <!-- Begin Page Content Here :: -->
          <div class="row">
            <!-- FIRST BOX STARTS-->
            <div class="col-lg-12 col-xl-12">
              <div class="main-card mb-3 card col-md-12">
                <div class="card-header-tab card-header">
                  <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-map mr-3 text-muted opacity-6"> </i><?php echo $modalTITLE; ?> </div>
                </div>
                <div class="card-body">
                  <form class="" name="stateForm" id="stateForm" method="post" action="<?php echo $edit_url; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
                    <input type="hidden" name="user_token" id="user_token" value="<?php echo $sess_user_token; ?>">
                    <div class="col-md-12">
                      <div class="form-row">
						<div class="col-md-6">
							<div class="position-relative form-group">
								<label for="txtname" class="">Name <span class="text-danger">*</span></label>
								<input name="txtname" id="txtname" type="text" value="<?php echo $txtname; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="position-relative form-group">
								<label for="txtshortcode" class="">ShortCode <span class="text-danger">*</span></label>
								<input name="txtshortcode" id="txtshortcode" type="text" value="<?php echo $txtshortcode; ?>" class="form-control">
							</div>
						</div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-row">
                        <div class="col-md-12">
                          <div class="position-relative form-group">
                            <label for="rdstatus" class="">Status</label>
                            <?php echo FillRadios($rdstatus, 'rdstatus', $STATUS_ARR); ?>
						  </div>
                        </div>
                      </div>
                      <button type="button" onClick="location.href='<?php echo $disp_url; ?>';" class="mt-2 btn btn-secondary">Back</button>
                      <button type="submit" class="mt-2 btn btn-success">Save</button>
                      <?php 
				if($mode=='E')
					echo '<button type="button" onclick="ConfirmDelete(\'Country\',\''.$edit_url.'?mode=D&id='.$txtid.'\');" class="mt-2 btn btn-danger">Delete</button>';
				?>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- End Page Content Here :: -->
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
<!--Input Mask-->
<script src="dist/assets/js/vendors/form-components/input-mask.js"></script>
<script type="text/javascript">
// Forms Input Mask
$( document ).ready(function() {
    $(".input-mask-trigger").inputmask();
});

//form validation
$( document ).ready(function() {
	$("#stateForm").submit( function() {
		err = 0;
		err_arr = new Array();
		ret_val = true;

		var txtname = $(this).find('#txtname');
		var txtshortcode = $(this).find('#txtshortcode');

		if(txtname.val() == 0 || txtname.val() === '') {
			ShowError( txtname, "Please enter Name");
			err_arr[err] = txtname;
			err ++;
		} else HideError(txtname);

		if(txtshortcode.val() == 0 || txtshortcode.val() === '') {
			ShowError( txtshortcode, "Please enter ShortCode");
			err_arr[err] = txtshortcode;
			err ++;
		} else HideError(txtshortcode);

		if(err > 0) {
			ret_val = false;
		}

		return ret_val;
	});
});
</script>
</body>
</html>
