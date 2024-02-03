<?php
include "../includes/common.php";

$PAGE_TITLE2 = 'Owners';
$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'owners_disp.php';
$edit_url = 'owners_edit.php';

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
	$txtphone = '';
	$txtaddress = '';
	$txtpic = '';
	$rdstatus = 'A';

	$modalTITLE = 'New '.$PAGE_TITLE2;
	$form_mode ='I';
}
else if($mode=='I')
{
	$txtname = db_input_default($_POST['txtname'], 'v');
	$txtphone = db_input_default($_POST['txtphone'], 'v');
	$txtaddress = db_input_default($_POST['txtaddress'], 'v');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');

	LockTable('owner');
	$txtid = NextID('iOwnerID', 'owner');
	$q = "INSERT INTO owner (iOwnerID, vName, vImage, vPhone, vAddress, vContactName, vContactMobile, vContactMobile2, vContactLandline, vContactEmail, vBankName, vBranchName, vAccountNo, vIFSCCode, dDateReg, iRating, cStatus) 
			VALUES ($txtid, $txtname, NULL, $txtphone, $txtaddress, vContactName, vContactMobile, vContactMobile2, vContactLandline, vContactEmail, vBankName, vBranchName, vAccountNo, vIFSCCode, dDateReg, iRating, $rdstatus)";
	$r = sql_query($q, "owners_edit.E.38");
	UnLockTable();

	$_SESSION[PROJ_SESSION_ID]->success_info = "Owners Details Successfully Inserted";
}
else if($mode=='E')
{
	$dataArr = GetDataFromID("owner", "iOwnerID", $txtid);
	
	$txtid = $dataArr[0]->iOwnerID;
	$txtname = db_output($dataArr[0]->vName);
	$txtphone = db_output($dataArr[0]->vPhone);
	$txtaddress = db_output($dataArr[0]->vAddress);
	$txtpic = db_output($dataArr[0]->vImage);
	$rdstatus = $dataArr[0]->cStatus;

	$modalTITLE = 'Edit '.$PAGE_TITLE2;
	$form_mode ='U';
}
else if($mode=='U')
{
	$txtname = db_input_default($_POST['txtname'], 'v');
	$txtphone = db_input_default($_POST['txtphone'], 'v');
	$txtaddress = db_input_default($_POST['txtaddress'], 'v');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');
	
	$q = "UPDATE owner SET vName=$txtname, vPhone=$txtphone, vAddress=$txtaddress, vContactName, vContactMobile, vContactMobile2, vContactLandline, vContactEmail, vBankName, vBranchName, vAccountNo, vIFSCCode, dDateReg, iRating, cStatus=$rdstatus WHERE iOwnerID=$txtid ";
	$r = sql_query($q, "owners_edit.E.68");
	$_SESSION[PROJ_SESSION_ID]->success_info = "Owners Details Successfully Updated";
}
elseif($mode=='D')
{
	$txtid = $_GET['id'];
	$loc_str = $edit_url . "?mode=E&id=$txtid"; 
	
	$chk_arr = array();
	//$chk_arr['Appointments'] = GetXFromYID('select count(*) from  where iOwnerID='.$txtid.' and cStatus!="X"');
	$chk = array_sum($chk_arr);
	
	if(!$chk)
	{
		$q3 = "UPDATE owner SET cStatus='X' WHERE iOwnerID=$txtid";
		$r3 = sql_query($q3, 'owners_edit.D.87');
		
		$_SESSION[PROJ_SESSION_ID]->success_info = "Owners Details Successfully Deleted";
		$loc_str = $disp_url;
	}
	else $_SESSION[PROJ_SESSION_ID]->alert_info = "Owners Details Could Not Be Deleted Because of Existing ".(CHK_ARR2Str($chk_arr))." Dependencies";
	
	header("location: $loc_str");
	exit;
}

if($mode=='I' || $mode=='U')
{
	if(is_uploaded_file($_FILES["txtpic"]["tmp_name"]))
	{
		$uploaded_pic = $_FILES["txtpic"]["name"];
		$name = basename($_FILES['txtpic']['name']);
		$file_type = $_FILES['txtpic']['type'];
		$size = $_FILES['txtpic']['size'];
		$extension = substr($name, strrpos($name, '.') + 1);

		$pic_name = GetXFromYID('select vImage from owner where iOwnerID='.$txtid);
		if(!empty($pic_name)) DeleteFile($pic_name,SLIDER_DESKTOP_UPLOAD);

		if(RANDOMIZE_FILENAME==0) {
			$newname = NormalizeFilename($uploaded_pic); // normalize the file name
			$pic_name = "owner_img_" . $newname;
		} else {
			$pic_name = 'owner_img_'.$txtid.NOW3.'.'.$extension;
		}

		$tmp_name = "TMP_". $pic_name;
		$dir = opendir(SLIDER_DESKTOP_UPLOAD);
		copy($_FILES["txtpic"]["tmp_name"], SLIDER_DESKTOP_UPLOAD . $pic_name);
		DeleteFile($tmp_name, SLIDER_DESKTOP_UPLOAD); //delete the tmp file
		closedir($dir);		// close the directory

		$q = "update owner set vImage='$pic_name' where iOwnerID=$txtid";
		$r = sql_query($q, 'owners_edit.002');
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
								<label for="txtname" class="">Name <span class="text-danger">*</span></label>
								<input name="txtname" id="txtname" type="text" value="<?php echo $txtname; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtphone" class="">Phone</label>
								<input name="txtphone" id="txtphone" type="text" value="<?php echo $txtphone; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label for="txtaddress" class="">Address</label>
								<input name="txtaddress" id="txtaddress" type="text" value="<?php echo $txtaddress; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-1">
							<div class="position-relative form-group">
								<label for="txtaddress" class="">Address</label>
								<input name="txtaddress" id="txtaddress" type="text" value="<?php echo $txtaddress; ?>" class="form-control">
							</div>
						</div>
                      </div>
                      <div class="form-row">
						<div class="col-md-12">
							<div class="position-relative form-group">
								<label for="txtpic" class="">Image <span class="text-danger">*</span></label>
								<?php if(IsExistFile($txtpic, SLIDER_DESKTOP_UPLOAD)){ ?> <br><img class="img-fluid mb-1" src="<?php echo SLIDER_DESKTOP_PATH.$txtpic ?>" alt="Desktop Pic" /><?php } ?>
								<input name="txtpic" id="txtpic" accept="image/jpeg, image/png" type="file" class="form-control-file" placeholder="Desktop Pic">
								<small class="form-text text-muted">Allowed File Types: .jpg, .jpeg, .png</small>
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
					echo '<button type="button" onclick="ConfirmDelete(\'Owners\',\''.$edit_url.'?mode=D&id='.$txtid.'\');" class="mt-2 btn btn-danger">Delete</button>';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
// Toggle On change of Time Bound
function toggleOnTimeBound()
{
	var rdtimebound = $('[name="rdtimebound"]:checked');
	var txtfrom = $('#txtfrom');
	var txtto = $('#txtto');

	txtfrom.parent().hide();
	txtto.parent().hide();

	switch (rdtimebound.val()) {
		case 'Y':
			txtfrom.parent().show();
			txtto.parent().show();
		break;
	}
}

// Forms Input Mask
$( document ).ready(function() {
	toggleOnTimeBound();
	$('[name="rdtimebound"]').on('input', function(){
		toggleOnTimeBound();
	});
	$(".datepickers").datepicker({
		dateFormat: 'yy-mm-dd',
		autoHide: true,
	});
    $(".input-mask-trigger").inputmask();
});

//form validation
$( document ).ready(function() {
	$("#stateForm").submit( function() {
		err = 0;
		err_arr = new Array();
		ret_val = true;

		var txtname = $(this).find('#txtname');

		if(txtname.val() == 0 || txtname.val() === '') {
			ShowError( txtname, "Please enter Title");
			err_arr[err] = txtname;
			err ++;
		} else HideError(txtname);

		if(err > 0) {
			ret_val = false;
		}

		return ret_val;
	});
});
</script>
</body>
</html>
