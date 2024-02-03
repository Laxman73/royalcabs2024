<?php
include "../includes/common.php";

$PAGE_TITLE2 = 'Dist. Matrix';
$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'dist_matrix_disp.php';
$edit_url = 'dist_matrix_edit.php';

if(isset($_GET['mode'])) $mode = $_GET['mode'];
elseif(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode ='A';

if(isset($_GET['id'])) $txtid = $_GET['id'];
elseif(isset($_POST['txtid'])) $txtid = $_POST['txtid'];
//else $mode ='A';

if($mode=='A')
{
	$txtid = '';
	$cmbfrom = '';
	$cmbto = '';
	$txtdist = '';
	$rdstatus = 'A';

	$modalTITLE = 'New '.$PAGE_TITLE2;
	$form_mode ='I';
}
else if($mode=='N')
{
	$txtid = '';
	$cmbfrom = $_GET['cmbfrom'];
	$cmbto = $_GET['cmbto'];
	$txtdist = '';
	$rdstatus = 'A';

	$modalTITLE = 'New '.$PAGE_TITLE2;
	$form_mode ='I';
}
else if($mode=='I')
{
	$cmbfrom = db_input_default($_POST['cmbfrom'], 'i');
	$cmbto = db_input_default($_POST['cmbto'], 'i');
	$txtdist = db_input_default($_POST['txtdist'], 'f');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');

	if($cmbfrom!=$cmbto)
	{
		LockTable('location_distance');
		$txtid = NextID('iLocDistanceID', 'location_distance');
		$q = "INSERT INTO location_distance (iLocDistanceID, iLocID_From, iLocID_To, fDistanceInKM, cStatus) 
				VALUES ($txtid, $cmbfrom, $cmbto, $txtdist, $rdstatus)";
		$r = sql_query($q, "dist_matrix_edit.E.38");
		UnLockTable();
		LockTable('location_distance');
		$txtid = NextID('iLocDistanceID', 'location_distance');
		$q = "INSERT INTO location_distance (iLocDistanceID, iLocID_From, iLocID_To, fDistanceInKM, cStatus) 
				VALUES ($txtid, $cmbto, $cmbfrom, $txtdist, $rdstatus)";
		$r = sql_query($q, "dist_matrix_edit.E.38");
		UnLockTable();
		$_SESSION[PROJ_SESSION_ID]->success_info = "Dist. Matrix Details Successfully Inserted";
	}
	else $_SESSION[PROJ_SESSION_ID]->alert_info = "Dist. Matrix Details Could Not Be Updated Because of same locations";
}
else if($mode=='E')
{
	$dataArr = GetDataFromID("location_distance", "iLocDistanceID", $txtid);
	
	$txtid = $dataArr[0]->iLocDistanceID;
	$cmbfrom = db_output($dataArr[0]->iLocID_From);
	$cmbto = db_output($dataArr[0]->iLocID_To);
	$txtdist = db_output($dataArr[0]->fDistanceInKM);
	$rdstatus = $dataArr[0]->cStatus;

	$modalTITLE = 'Edit '.$PAGE_TITLE2;
	$form_mode ='U';
}
else if($mode=='U')
{
	$cmbfrom = db_input_default($_POST['cmbfrom'], 'i');
	$cmbto = db_input_default($_POST['cmbto'], 'i');
	$txtdist = db_input_default($_POST['txtdist'], 'f');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');

	if($cmbfrom!=$cmbto)
	{
		$q = "UPDATE location_distance SET iLocID_From=$cmbfrom, iLocID_To=$cmbto, fDistanceInKM=$txtdist, cStatus=$rdstatus WHERE iLocDistanceID=$txtid ";
		$r = sql_query($q, "dist_matrix_edit.E.68");
		$_q2="select iLocDistanceID from location_distance where iLocID_From=$cmbto and  iLocID_To=$cmbfrom  ";
		$_r2=sql_query($_q2,"IFRECORDEXIST");
		if (sql_num_rows($_r2)) {
			list($x_id)=sql_fetch_row($_r2);
			$q = "UPDATE location_distance SET iLocID_From=$cmbto, iLocID_To=$cmbfrom, fDistanceInKM=$txtdist, cStatus=$rdstatus WHERE iLocDistanceID=$x_id ";
			$r = sql_query($q, "dist_matrix_edit.E.68");
		}
		$_SESSION[PROJ_SESSION_ID]->success_info = "Dist. Matrix Details Successfully Updated";
	}
	else $_SESSION[PROJ_SESSION_ID]->alert_info = "Dist. Matrix Details Could Not Be Updated Because of same locations";
}
elseif($mode=='D')
{
	$txtid = $_GET['id'];
	$loc_str = $edit_url . "?mode=E&id=$txtid"; 
	
	$chk_arr = array();
	//$chk_arr['Appointments'] = GetXFromYID('select count(*) from  where iLocDistanceID='.$txtid.' and cStatus!="X"');
	$chk = array_sum($chk_arr);
	
	if(!$chk)
	{
		$q3 = "UPDATE location_distance SET cStatus='X' WHERE iLocDistanceID=$txtid";
		$r3 = sql_query($q3, 'dist_matrix_edit.D.87');
		
		$_SESSION[PROJ_SESSION_ID]->success_info = "Dist. Matrix Details Successfully Deleted";
		$loc_str = $disp_url;
	}
	else $_SESSION[PROJ_SESSION_ID]->alert_info = "Dist. Matrix Details Could Not Be Deleted Because of Existing ".(CHK_ARR2Str($chk_arr))." Dependencies";
	
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
                  <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-graph1 mr-3 text-muted opacity-6"> </i><?php echo $modalTITLE; ?> </div>
                </div>
                <div class="card-body">
                  <form class="" name="stateForm" id="stateForm" method="post" action="<?php echo $edit_url; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
                    <input type="hidden" name="user_token" id="user_token" value="<?php echo $sess_user_token; ?>">
                    <div class="col-md-12">
                      <div class="form-row">
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label for="cmbfrom" class="">From <span class="text-danger">*</span></label>
								<?php echo FillTreeData($cmbfrom, 'cmbfrom', 'COMBO2', '0', 'iLocationID,vName', 'location', " cStatus!='X' "); ?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label for="cmbto" class="">To <span class="text-danger">*</span></label>
								<?php echo FillTreeData($cmbto, 'cmbto', 'COMBO2', '0', 'iLocationID,vName', 'location', " cStatus!='X' "); ?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label for="txtdist" class=""> Distance In KM <span class="text-danger">*</span></label>
								<input name="txtdist" id="txtdist" type="number" step="0.01" value="<?php echo $txtdist; ?>" class="form-control">
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
					echo '<button type="button" onclick="ConfirmDelete(\'Dist. Matrix\',\''.$edit_url.'?mode=D&id='.$txtid.'\');" class="mt-2 btn btn-danger">Delete</button>';
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

		var cmbfrom = $(this).find('#cmbfrom');
		var cmbto = $(this).find('#cmbto');
		var txtdist = $(this).find('#txtdist');

		if(cmbfrom.val() == 0 || cmbfrom.val() === '') {
			ShowError( cmbfrom, "Please select From");
			err_arr[err] = cmbfrom;
			err ++;
		} else HideError(cmbfrom);

		if(cmbto.val() == 0 || cmbto.val() === '') {
			ShowError( cmbto, "Please select To");
			err_arr[err] = cmbto;
			err ++;
		} else HideError(cmbto);

		if(txtdist.val() == 0 || txtdist.val() === '') {
			ShowError( txtdist, "Please enter Distance");
			err_arr[err] = txtdist;
			err ++;
		} else HideError(txtdist);

		if(err > 0) {
			ret_val = false;
		}

		return ret_val;
	});
});
</script>
</body>
</html>
