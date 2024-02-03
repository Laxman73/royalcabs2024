<?php
include "../includes/common.php";
include "../includes/thumbnail.php";

$PAGE_TITLE2 = 'Vehicle List';
$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'veh_list_disp.php';
$edit_url = 'veh_list_edit.php';

if (isset($_GET['mode'])) $mode = $_GET['mode'];
elseif (isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode = 'A';

if (isset($_GET['id'])) $txtid = $_GET['id'];
elseif (isset($_POST['txtid'])) $txtid = $_POST['txtid'];
else $mode = 'A';

$OWNER_ARR = GetXArrFromYID('select iOwnerID, vName from owner where cStatus!="X" order by iOwnerID', '3');
$TYPE_ARR = GetXArrFromYID('select iVTypeID, CONCAT(vName, " (", vSeats, ")") from gen_vehicle_type where cStatus!="X" order by iVTypeID', '3');
$TRAN_ARR = GetXArrFromYID('select iVTransID, vName from gen_vehicle_transmission where cStatus!="X" order by iVTransID', '3');
$FUEL_ARR = GetXArrFromYID('select iVFuelID, vName from gen_vehicle_fuel where cStatus!="X" order by iVFuelID', '3');

if ($mode == 'A') {
	$txtid = '';
	$cmbowner = '';
	$cmbtype = '';
	$cmbtran = '';
	$cmbfuel = '';
	$file_pic = '';
	$txtname = '';
	$txturlname = '';
	$txtdesc = '';
	$txtseats = '';
	$txtsafe = '';
	$txtcont = '';
	$cmbairbag = 'Y';
	$cmbrecmed = 'Y';
	$cmbcat = array();
	$rdstatus = 'A';

	$modalTITLE = 'New ' . $PAGE_TITLE2;
	$form_mode = 'I';
} else if ($mode == 'I') {
	// DFA($_POST);
	// exit;
	$txtseats=db_input($_POST['txtseats']);
	//$cmbowner = isset($_POST['cmbowner']) ? db_input($_POST['cmbowner']) : '';
	$cmbtype = db_input($_POST['cmbtype']);
	//$cmbtran = db_input($_POST['cmbtran']);
	//$cmbfuel = db_input($_POST['cmbfuel']);
	$txtname = db_input($_POST['txtname']);
	$txturlname = strtolower(GetUrlName($txtname));
	//$txtdesc = db_input($_POST['txtdesc']);
	//$txtsafe = db_input($_POST['txtsafe']);
	$cmbcat = $_POST['cmbcat'];
	//$txtcont = db_input($_POST['txtcont']);
	$cmbairbag = db_input($_POST['cmbairbag']);
	$cmbrecmed = db_input($_POST['cmbrecmed']);
	$rdstatus = db_input($_POST['rdstatus']);

	LockTable('vehicle');
	$txtid = NextID('iVehicleID', 'vehicle');
	$q = "INSERT INTO vehicle (iVehicleID, iVTypeID, iVTransID, iVFuelID,iSeats, vName, vUrlName, vDesc, vSafety, vTermsConditions, cAirBags, cRecommended, iRank, cStatus) 
			VALUES ('$txtid','$cmbtype', '0', '0','$txtseats', '$txtname', '$txturlname', NULL, NULL, NULL, '$cmbairbag', '$cmbrecmed', '$txtid', '$rdstatus')";
	$r = sql_query($q, "veh_list_edit.E.38");
	UnLockTable();
	foreach ($cmbcat as $key => $value) {
		LockTable('vehicle_cat_assoc');
		$iVCAssocID=NextID('iVCAssocID','vehicle_cat_assoc');
		$txtrank=GetMaxRank('vehicle_cat_assoc');
		$_q1="insert into vehicle_cat_assoc values('$iVCAssocID','$txtid','$value','$txtrank','A')";
		$_r1=sql_query($_q1,"ERR1.INSERT_VEHICLE_ASSOC");
		UnLockTable();
		// code...
	}

	$_SESSION[PROJ_SESSION_ID]->success_info = "Vehicle Details Successfully Inserted";
} else if ($mode == 'E') {
	$dataArr = GetDataFromID("vehicle", "iVehicleID", $txtid);

	$txtid = $dataArr[0]->iVehicleID;
	$cmbowner = db_output($dataArr[0]->iOwnerID);
	$cmbtype = db_output($dataArr[0]->iVTypeID);
	$cmbtran = db_output($dataArr[0]->iVTransID);
	$cmbfuel = db_output($dataArr[0]->iVFuelID);
	$txtname = db_output($dataArr[0]->vName);
	$txturlname = db_output($dataArr[0]->vUrlName);
	$txtdesc = db_output2($dataArr[0]->vDesc);
	$txtseats = db_output2($dataArr[0]->iSeats);
	$file_pic = db_output2($dataArr[0]->vPic);
	$txtsafe = db_output2($dataArr[0]->vSafety);
	$txtcont = db_output2($dataArr[0]->vTermsConditions);
	$cmbairbag = db_output($dataArr[0]->cAirBags);
	$cmbrecmed = db_output($dataArr[0]->cRecommended);
	$rdstatus = $dataArr[0]->cStatus;

	$cmbcat = GetXArrFromYID("SELECT iVCatID FROM vehicle_cat_assoc WHERE iVehicleID=$txtid AND cStatus='A'", "2");

	$modalTITLE = 'Edit ' . $PAGE_TITLE2;
	$form_mode = 'U';
} else if ($mode == 'U') {
	$txtseats=db_input($_POST['txtseats']);
	//$cmbowner = isset($_POST['cmbowner']) ? db_input($_POST['cmbowner']) : '';
	$cmbtype = db_input($_POST['cmbtype']);
	//$cmbtran = db_input($_POST['cmbtran']);
	//$cmbfuel = db_input($_POST['cmbfuel']);
	$txtname = db_input($_POST['txtname']);
	$txturlname = strtolower(GetUrlName($txtname));
	//$txtdesc = db_input($_POST['txtdesc']);
	//$txtsafe = db_input($_POST['txtsafe']);
	$cmbcat = $_POST['cmbcat'];
	//$txtcont = db_input($_POST['txtcont']);
	$cmbairbag = db_input($_POST['cmbairbag']);
	$cmbrecmed = db_input($_POST['cmbrecmed']);
	$rdstatus = db_input($_POST['rdstatus']);

	$q = "UPDATE vehicle SET iOwnerID='0', iVTypeID='$cmbtype', iVTransID='0', iVFuelID='0', vName='$txtname', vUrlName='$txturlname', vDesc=NULL, vSafety=NULL, vTermsConditions=NULL, cAirBags='$cmbairbag', cRecommended='$cmbrecmed', cStatus='$rdstatus',iSeats='$txtseats' WHERE iVehicleID=$txtid ";
	$r = sql_query($q, "veh_list_edit.E.68");



//delete previous assocation details 
sql_query("delete from vehicle_cat_assoc where iVehicleID=$txtid ");

	//updating the category association table

	foreach ($cmbcat as $key => $value) {
		LockTable('vehicle_cat_assoc');
		$iVCAssocID=NextID('iVCAssocID','vehicle_cat_assoc');
		$txtrank=GetMaxRank('vehicle_cat_assoc');
		$_q1="insert into vehicle_cat_assoc values('$iVCAssocID','$txtid','$value','$txtrank','A')";
		$_r1=sql_query($_q1,"ERR1.INSERT_VEHICLE_ASSOC");
		UnLockTable();
		// code...
	}




	$_SESSION[PROJ_SESSION_ID]->success_info = "Vehicle Details Successfully Updated";
} elseif ($mode == 'D') {
	$txtid = $_GET['id'];
	$loc_str = $edit_url . "?mode=E&id=$txtid";

	$chk_arr = array();
	//$chk_arr['Appointments'] = GetXFromYID('select count(*) from  where iVehicleID='.$txtid.' and cStatus!="X"');
	$chk = array_sum($chk_arr);

	if (!$chk) {
		$q2 = "UPDATE vehicle_cat_assoc SET cStatus='X' WHERE iVehicleID=$txtid";
		$r2 = sql_query($q2, 'veh_list_edit.D.86');

		$q3 = "UPDATE vehicle SET cStatus='X' WHERE iVehicleID=$txtid";
		$r3 = sql_query($q3, 'veh_list_edit.D.87');

		$_SESSION[PROJ_SESSION_ID]->success_info = "Vehicle Details Successfully Deleted";
		$loc_str = $disp_url;
	} else $_SESSION[PROJ_SESSION_ID]->alert_info = "Vehicle Details Could Not Be Deleted Because of Existing " . (CHK_ARR2Str($chk_arr)) . " Dependencies";

	header("location: $loc_str");
	exit;
}elseif ($mode=='DELPIC') {
	$pic_name = GetXFromYID('select vPic from vehicle where iVehicleID=' . $txtid);
  if (!empty($pic_name))
  	DeleteFile($pic_name, VEHICLE_IMG_UPLOAD);

  sql_query("update vehicle set vPic='' where iVehicleID=$txtid ");
  $_SESSION[PROJ_SESSION_ID]->success_info = "Image removed Successfully";
  header("location: $edit_url?mode=E&id=$txtid");
	exit;

	
}

if ($mode == 'I' || $mode == 'U') {
	if (is_uploaded_file($_FILES["file_pic"]["tmp_name"])) {
        $uploaded_pic = $_FILES["file_pic"]["name"];
        $name = basename($_FILES['file_pic']['name']);
        $file_type = $_FILES['file_pic']['type'];
        $size = $_FILES['file_pic']['size'];
        $extension = substr($name, strrpos($name, '.') + 1);

        if (IsValidFile($file_type, $extension, 'P')) {
            $pic_name = GetXFromYID('select vPic from vehicle where iVehicleID=' . $txtid);

            if (!empty($pic_name))
                DeleteFile($pic_name, VEHICLE_IMG_UPLOAD);

            if (RANDOMIZE_FILENAME == 0) {
                $newname = NormalizeFilename($uploaded_pic); // normalize the file name
                $pic_name = $txtid . "_vehicle_pic" . $newname;
            } else
                $pic_name = $txtid . '_vehicle_pic' . NOW3 . '.' . $extension;

            $tmp_name = "TMP_" . $pic_name;

            $dir = opendir(VEHICLE_IMG_UPLOAD);
            move_uploaded_file($_FILES["file_pic"]["tmp_name"], VEHICLE_IMG_UPLOAD . $tmp_name);
            ThumbnailImage($tmp_name, $pic_name, VEHICLE_IMG_UPLOAD, 400, 268);
            chmod(VEHICLE_IMG_UPLOAD . $pic_name, 0644);
            DeleteFile($tmp_name, VEHICLE_IMG_UPLOAD);
            closedir($dir);   // close the directory

            $q = "update vehicle set vPic='$pic_name' where iVehicleID=$txtid";
            $r = sql_query($q, 'User.E.126');
        } elseif (!in_array($extension, $IMG_TYPE)) {
            // if ($size > 3000000)
            //     $_SESSION[PROJ_SESSION_ID]->error_info = "Profile Image Could Not Be Uploaded as the File Size is greate then 3MB";
            // elseif (!in_array($extension, $IMG_TYPE))
            $_SESSION[PROJ_FRONT_SESSION_ID]->error_info = "Please only upload files that end in types: " . implode(',', $IMG_TYPE) . ". Please select a new file to upload and submit again.";
        }
    }

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
	<?php include "_include_form.php"; ?>
	<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
		<?php include "load.header.php"; ?>

		
		<div class="app-main">
			<?php include "load.menu.php" ?>
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
										<div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-car mr-3 text-muted opacity-6"> </i><?php echo $modalTITLE; ?> </div>
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
															<label for="txtname" class="">Name <span class="text-danger">*</span></label>
															<input name="txtname" id="txtname" type="text" value="<?php echo $txtname; ?>" class="form-control">
														</div>
													</div>
													<!-- <div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txturlname" class="">URL Name <span class="text-danger">*</span></label>
								<input name="txturlname" id="txturlname" type="text" value="<?php echo $txturlname; ?>" class="form-control">
							</div>
						</div> -->
													<div class="col-md-4">
														<div class="position-relative form-group">
															<label for="cmbtype" class="">Type <span class="text-danger">*</span></label>
															<?php echo FillCombo($cmbtype, 'cmbtype', 'COMBO', '-2', $TYPE_ARR); ?>
														</div>
													</div>
													<!-- <div class="col-md-2">
                          <div class="position-relative form-group">
                            <label for="cmbtran" class="">Transmission <span class="text-danger">*</span></label>
                            <?php echo FillCombo($cmbtran, 'cmbtran', 'COMBO', '-3', $TRAN_ARR); ?>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="position-relative form-group">
                            <label for="cmbfuel" class="">Fuel <span class="text-danger">*</span></label>
                            <?php echo FillCombo($cmbfuel, 'cmbfuel', 'COMBO', '-4', $FUEL_ARR); ?>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="position-relative form-group">
                            <label for="cmbowner" class="">Owner <span class="text-danger">*</span></label>
                            <?php echo FillCombo($cmbowner, 'cmbowner', 'COMBO', '-1', $OWNER_ARR); ?>
                          </div>
                        </div> -->
												
												
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-row">
													<div class="col-md-2">
														<div class="position-relative form-group">
															<label for="txtdesc" class="">Seats</label>
															<input type="text" name="txtseats" id="txtseats" class="form-control" onkeypress="numbersonly(event);" value="<?php echo $txtseats; ?>">

														</div>
													</div>
													<div class="col-md-4">
														<div class="position-relative form-group">
															<label for="cmbcat" class="">Category <span class="text-danger">*</span></label>
															<?php echo FillMultipleData($cmbcat, 'cmbcat', 0, 'Y', ' iVCatID, vName ', 'gen_vehicle_category', ' cStatus!="X" ', 'iVCatID', ''); ?>
														</div>
													</div>
												</div>

											</div>
											<!-- <div class="col-md-12">
                      <div class="form-row">
                        <div class="col-md-4">
                          <div class="position-relative form-group">
                            <label for="txtdesc" class="">Description</label>
							<textarea name="txtdesc" id="txtdesc" class="form-control"><?php echo $txtdesc; ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="position-relative form-group">
                            <label for="txtsafe" class="">Safety</label>
							<textarea name="txtsafe" id="txtsafe" class="form-control"><?php echo $txtsafe; ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="position-relative form-group">
                            <label for="txtcont" class="">Terms and Conditions</label>
							<textarea name="txtcont" id="txtcont" class="form-control"><?php echo $txtcont; ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div> -->
											<div class="form-row">
												<div class="avatar-icon-wrapper btn-hover-shine mb-2">
													<label for="file_pic" class="">Logo</label>
													<div class="avatar-icon rounded" style="width: 200px; height: 200px;">
														<?php
														$src = NOIMAGE;
														if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
															$src = VEHICLE_IMG_PATH . $file_pic;
														?>
														<img id="imgDiv" src="<?php echo $src; ?>" alt="Avatar" style="width: 100%;">
													</div>
												</div>
											</div>



											<div class="form-group">
												<?php
												if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD) && $sess_user_type != 4) {
												?>
													<button type="button" onClick="SubmitIncludeForm('<?php echo $edit_url; ?>','DELPIC','<?php echo $txtid; ?>','Vehicle Image');" class="mt-2 btn btn-danger">Remove</button>
												<?php
												}
												?>
												<label for="file_pic" class="custom-file-upload mt-3 btn btn-warning"> <i class="fa fa-cloud-upload"></i> Browse </label>
												<input id="file_pic" name="file_pic" type="file" class="file-upload form-control-file" onChange="ValidateFileUpload('file_pic','P'); PreviewImage(this)">
											</div>

											<div class="col-md-12">
												<div class="form-row">
													<div class="col-md-4">
														<div class="position-relative form-group">
															<label for="rdstatus" class="">Status</label>
															<?php echo FillRadios($rdstatus, 'rdstatus', $STATUS_ARR); ?>
														</div>
													</div>
														<div class="col-md-4">
														<div class="position-relative form-group">
															<label for="cmbairbag" class="">Air Bags <span class="text-danger">*</span></label>
															<?php echo FillRadios($cmbairbag, 'cmbairbag', $YES_ARR, 'form-control'); ?>
														</div>
													</div>
													<div class="col-md-4">
														<div class="position-relative form-group">
															<label for="cmbrecmed" class="">Recommended <span class="text-danger">*</span></label>
															<?php echo FillRadios($cmbrecmed, 'cmbrecmed',  $YES_ARR, 'form-control'); ?>
														</div>
													</div>
												</div>
												<button type="button" onClick="location.href='<?php echo $disp_url; ?>';" class="mt-2 btn btn-secondary">Back</button>
												<button type="submit" class="mt-2 btn btn-success">Save</button>
												<?php
												if ($mode == 'E')
													echo '<button type="button" onclick="ConfirmDelete(\'Vehicle List\',\'' . $edit_url . '?mode=D&id=' . $txtid . '\');" class="mt-2 btn btn-danger">Delete</button>';
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
		$(document).ready(function() {
			$(".input-mask-trigger").inputmask();
			$('#cmbcat').multiselect();
		});

		//form validation
		$(document).ready(function() {
			$("#stateForm").submit(function() {
				err = 0;
				err_arr = new Array();
				ret_val = true;

				var txtname = $(this).find('#txtname');
				var txturlname = $(this).find('#txturlname');
				var cmbtype = $(this).find('#cmbtype');
				//var cmbtran = $(this).find('#cmbtran');
				//var cmbfuel = $(this).find('#cmbfuel');
				//var cmbowner = $(this).find('#cmbowner');
				var cmbairbag = $(this).find('#cmbairbag');
				var cmbrecmed = $(this).find('#cmbrecmed');
				var cmbcat = $(this).find('#cmbcat');
				var txtseats=$(this).find('#txtseats');

				if (txtname.val() == 0 || txtname.val() === '') {
					ShowError(txtname, "Please enter Name");
					err_arr[err] = txtname;
					err++;
				} else HideError(txtname);

				if(txtseats.val() == 0 || txtseats.val() === '') {
					ShowError( txtseats, "Please enter number of seats");
					err_arr[err] = txtseats;
					err ++;
				} else HideError(txtseats);

				if (cmbtype.val() == 0 || cmbtype.val() === '') {
					ShowError(cmbtype, "Please select Type");
					err_arr[err] = cmbtype;
					err++;
				} else HideError(cmbtype);

				// if(cmbtran.val() == 0 || cmbtran.val() === '') {
				// 	ShowError( cmbtran, "Please select Transmission");
				// 	err_arr[err] = cmbtran;
				// 	err ++;
				// } else HideError(cmbtran);

				// if(cmbfuel.val() == 0 || cmbfuel.val() === '') {
				// 	ShowError( cmbfuel, "Please select Fuel");
				// 	err_arr[err] = cmbfuel;
				// 	err ++;
				// } else HideError(cmbfuel);

				// if(cmbowner.val() == 0 || cmbowner.val() === '') {
				// 	ShowError( cmbowner, "Please select Owner");
				// 	err_arr[err] = cmbowner;
				// 	err ++;
				// } else HideError(cmbowner);

				if (cmbairbag.val() == 0 || cmbairbag.val() === '') {
					ShowError(cmbairbag, "Please select Air Bags");
					err_arr[err] = cmbairbag;
					err++;
				} else HideError(cmbairbag);

				if (cmbrecmed.val() == 0 || cmbrecmed.val() === '') {
					ShowError(cmbrecmed, "Please select Recommended");
					err_arr[err] = cmbrecmed;
					err++;
				} else HideError(cmbrecmed);

				if (cmbcat.val().length == 0) {
					ShowError(cmbcat, "Please select Category");
					err_arr[err] = cmbcat;
					err++;
				} else HideError(cmbcat);

				if (err > 0) {
					ret_val = false;
				}

				return ret_val;
			});
		});
	</script>
</body>

</html>