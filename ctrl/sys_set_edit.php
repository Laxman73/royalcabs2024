<?php
include "../includes/common.php";

$PAGE_TITLE2 = 'System Settings';
$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'sys_set_disp.php';
$edit_url = 'sys_set_edit.php';

if(isset($_GET['mode'])) $mode = $_GET['mode'];
elseif(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode ='A';

if(isset($_GET['id'])) $txtid = $_GET['id'];
elseif(isset($_POST['txtid'])) $txtid = $_POST['txtid'];
else $mode ='A';

if($mode=='A')
{
	$txtid = '';
	$cmbtype = '';
	$txtcode = '';
	$cmbdata = '';
	$txtvalue = '';
	$rdstatus = 'A';

	$modalTITLE = 'New '.$PAGE_TITLE2;
	$form_mode ='I';
}
else if($mode=='I')
{
	$cmbtype = db_input_default($_POST['cmbtype'], 'c');
	$txtcode = db_input_default($_POST['txtcode'], 'v');
	$cmbdata = db_input_default($_POST['cmbdata'], 'c');
	$txtvalue = db_input_default($_POST['txtvalue'], 'v');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');

	LockTable('sys_settings');
	$txtid = NextID('iSettingID', 'sys_settings');
	$q = "INSERT INTO sys_settings (iSettingID, cType, vCode, cData, vValue, cStatus) 
			VALUES ($txtid, $cmbtype, $txtcode, $cmbdata, $txtvalue, $rdstatus)";
	$r = sql_query($q, "sys_set_edit.E.38");
	UnLockTable();

	$_SESSION[PROJ_SESSION_ID]->success_info = "System Settings Details Successfully Inserted";
}
else if($mode=='E')
{
	$dataArr = GetDataFromID("sys_settings", "iSettingID", $txtid);
	
	$txtid = $dataArr[0]->iSettingID;
	$cmbtype = db_output($dataArr[0]->cType);
	$txtcode = db_output($dataArr[0]->vCode);
	$cmbdata = db_output($dataArr[0]->cData);
	$txtvalue = db_output($dataArr[0]->vValue);
	$rdstatus = $dataArr[0]->cStatus;

	$modalTITLE = 'Edit '.$PAGE_TITLE2;
	$form_mode ='U';
}
else if($mode=='U')
{
	$cmbtype = db_input_default($_POST['cmbtype'], 'c');
	$txtcode = db_input_default($_POST['txtcode'], 'v');
	$cmbdata = db_input_default($_POST['cmbdata'], 'c');
	$txtvalue = db_input_default($_POST['txtvalue'], 'v');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');
	
	$q = "UPDATE sys_settings SET cType=$cmbtype, vCode=$txtcode, cData=$cmbdata, vValue=$txtvalue, cStatus=$rdstatus WHERE iSettingID=$txtid ";
	$r = sql_query($q, "sys_set_edit.E.68");
	$_SESSION[PROJ_SESSION_ID]->success_info = "System Settings Details Successfully Updated";
}
elseif($mode=='D')
{
	$txtid = $_GET['id'];
	$loc_str = $edit_url . "?mode=E&id=$txtid"; 
	
	$chk_arr = array();
	//$chk_arr['Appointments'] = GetXFromYID('select count(*) from  where iSettingID='.$txtid.' and cStatus!="X"');
	$chk = array_sum($chk_arr);
	
	if(!$chk)
	{
		$q3 = "UPDATE sys_settings SET cStatus='X' WHERE iSettingID=$txtid";
		$r3 = sql_query($q3, 'sys_set_edit.D.87');
		
		$_SESSION[PROJ_SESSION_ID]->success_info = "System Settings Details Successfully Deleted";
		$loc_str = $disp_url;
	}
	else $_SESSION[PROJ_SESSION_ID]->alert_info = "System Settings Details Could Not Be Deleted Because of Existing ".(CHK_ARR2Str($chk_arr))." Dependencies";
	
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
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="cmbtype" class="">Type <span class="text-danger">*</span></label>
								<?php echo FillCombo($cmbtype, 'cmbtype', 'COMBO', 'Type', $SYS_SET_TYPE_ARR); ?>
							</div>
						</div>
						<div class="col-md-9">
							<div class="position-relative form-group">
								<label for="txtcode" class="">Code <span class="text-danger">*</span></label>
								<input name="txtcode" id="txtcode" type="text" value="<?php echo $txtcode; ?>" class="form-control">
							</div>
						</div>
                      </div>

                      <div class="form-row">
						<div class="col-md-3">
							<div class="position-relative form-group">
								<label for="cmbdata" class="">Data <span class="text-danger">*</span></label>
								<?php echo FillCombo($cmbdata, 'cmbdata', 'COMBO', 'Data', $SYS_SET_DATA_ARR); ?>
							</div>
						</div>
						<div class="col-md-9">
							<div class="position-relative form-group">
								<label for="txtvalue" class="">Value <span class="text-danger">*</span></label>
								<input name="txtvalue" id="txtvalue" type="text" value="<?php echo $txtvalue; ?>" class="form-control">
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
					echo '<button type="button" onclick="ConfirmDelete(\'System Settings\',\''.$edit_url.'?mode=D&id='.$txtid.'\');" class="mt-2 btn btn-danger">Delete</button>';
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

		var cmbtype = $(this).find('#cmbtype');
		var txtcode = $(this).find('#txtcode');
		var cmbdata = $(this).find('#cmbdata');
		var txtvalue = $(this).find('#txtvalue');

		if(cmbtype.val() == 0 || cmbtype.val() === '') {
			ShowError( cmbtype, "Please select type");
			err_arr[err] = cmbtype;
			err ++;
		} else HideError(cmbtype);

		if(txtcode.val() == 0 || txtcode.val() === '') {
			ShowError( txtcode, "Please enter code");
			err_arr[err] = txtcode;
			err ++;
		} else HideError(txtcode);

		if(cmbdata.val() == 0 || cmbdata.val() === '') {
			ShowError( cmbdata, "Please select data");
			err_arr[err] = cmbdata;
			err ++;
		} else HideError(cmbdata);

		if(txtvalue.val() == 0 || txtvalue.val() === '') {
			ShowError( txtvalue, "Please enter value");
			err_arr[err] = txtvalue;
			err ++;
		} else HideError(txtvalue);

		if(err > 0) {
			ret_val = false;
		}

		return ret_val;
	});
});
</script>
</body>
</html>
