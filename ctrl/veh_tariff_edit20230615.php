<?php
include "../includes/common.php";

$PAGE_TITLE2 = 'Vehicle Tariff';
$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'veh_tariff_disp.php';
$edit_url = 'veh_tariff_edit.php';

if(isset($_GET['mode'])) $mode = $_GET['mode'];
elseif(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode ='A';

if(isset($_GET['id'])) $txtid = $_GET['id'];
elseif(isset($_POST['txtid'])) $txtid = $_POST['txtid'];
else $mode ='A';

$TYPE_ARR = GetXArrFromYID('select iVTypeID, CONCAT(vName, " (", vSeats, ")") from gen_vehicle_type where cStatus!="X" order by iVTypeID','3');
$CAT_ARR = GetXArrFromYID('select iVCatID, vName from gen_vehicle_category where cStatus!="X" order by iVCatID','3');
$VEHICLE_ARR=array();

if($mode=='A')
{
	$txtid = '';
	$cmbtype = '';
	$cmbcat = '';
	$cmbvID='';
	$txtdfrom = '';
	$txtdto = '';
	$txtbasedist = '';
	$txtbasehrs = '';
	$txtbasefare = '';
	$txtaddperkm = '';
	$txtaddperhr = '';
	$txtwatchrgperhr = '';
	$txtngtcharges = '';
	$txtngtaddperkm = '';
	$txtngtaddperhr = '';
	$txtngtwatchrgperhr = '';
	$txtdrvchrgfrom = '';
	$txtdrvchrgto = '';
	$txtdrvchrgs = '';
	$rdstatus = 'A';

	$modalTITLE = 'New '.$PAGE_TITLE2;
	$form_mode ='I';
}
else if($mode=='I')
{
	$cmbtype = db_input_default($_POST['cmbtype'], 'i');
	$cmbcat = db_input_default($_POST['cmbcat'], 'i');
	$txtdfrom = db_input_default($_POST['txtdfrom'], 'd');
	$txtdto = db_input_default($_POST['txtdto'], 'd');
	$txtbasedist = db_input_default($_POST['txtbasedist'], 'f');
	$txtbasehrs = db_input_default($_POST['txtbasehrs'], 'f');
	$txtbasefare = db_input_default($_POST['txtbasefare'], 'f');
	$txtaddperkm = db_input_default($_POST['txtaddperkm'], 'f');
	$txtaddperhr = db_input_default($_POST['txtaddperhr'], 'f');
	$txtwatchrgperhr = db_input_default($_POST['txtwatchrgperhr'], 'f');
	$txtngtcharges = db_input_default($_POST['txtngtcharges'], 'f');
	$txtngtaddperkm = db_input_default($_POST['txtngtaddperkm'], 'f');
	$txtngtaddperhr = db_input_default($_POST['txtngtaddperhr'], 'f');
	$txtngtwatchrgperhr = db_input_default($_POST['txtngtwatchrgperhr'], 'f');
	$txtdrvchrgfrom = db_input_default($_POST['txtdrvchrgfrom'], 't');
	$txtdrvchrgto = db_input_default($_POST['txtdrvchrgto'], 't');
	$txtdrvchrgs = db_input_default($_POST['txtdrvchrgs'], 'f');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');
	
	if(strtotime(str_replace("'",'',$txtdto))>strtotime(str_replace("'",'',$txtdfrom)) && strtotime(str_replace("'",'',$txtdrvchrgto))>strtotime(str_replace("'",'',$txtdrvchrgfrom)))
	{
		LockTable('tariff');
		$txtid = NextID('iTariffID', 'tariff');
		$q = "INSERT INTO tariff (iTariffID, iVTypeID, iVCatID, dFrom, dTo, fBaseDistanceInKM, fBaseHours, fBaseFare, 
					fNightCharges, fAdditionalPerKM, fNightAdditionalPerKM, fAdditionalPerHour, fNightAdditionalPerHour, fWaitingChargesPerHour, fNightWaitingChargesPerHour, 
					tDriverChargesFrom, tDriverChargesTo, fDriverCharges, cStatus) 
				VALUES ($txtid, $cmbtype, $cmbcat, $txtdfrom, $txtdto, $txtbasedist, $txtbasehrs, $txtbasefare, 
					$txtngtcharges, $txtaddperkm, $txtngtaddperkm, $txtaddperhr, $txtngtaddperhr, $txtwatchrgperhr, $txtngtwatchrgperhr, $txtdrvchrgfrom, 
					$txtdrvchrgto, $txtdrvchrgs, $rdstatus)";
		$r = sql_query($q, "veh_tariff_edit.E.38");
		UnLockTable();
		$_SESSION[PROJ_SESSION_ID]->success_info = "Tariff Details Successfully Inserted";
	}
	else
	{
		if (!(strtotime(str_replace("'",'',$txtdto))>strtotime(str_replace("'",'',$txtdfrom)))) {
			$_SESSION[PROJ_SESSION_ID]->alert_info = "Tariff Details Could Not Be Updated because From and To dates are Invalid";
		} else if (!(strtotime(str_replace("'",'',$txtdrvchrgto))>strtotime(str_replace("'",'',$txtdrvchrgfrom)))) {
			$_SESSION[PROJ_SESSION_ID]->alert_info = "Tariff Details Could Not Be Updated because From and To time driver charges are Invalid";
		}
	}
}
else if($mode=='E')
{
	$dataArr = GetDataFromID("tariff", "iTariffID", $txtid);
	
	$txtid = $dataArr[0]->iTariffID;
	$cmbtype = db_output($dataArr[0]->iVTypeID);
	$cmbcat = db_output($dataArr[0]->iVCatID);
	$txtdfrom = db_output($dataArr[0]->dFrom);
	$txtdto = db_output($dataArr[0]->dTo);
	$txtbasedist = db_output($dataArr[0]->fBaseDistanceInKM);
	$txtbasehrs = db_output($dataArr[0]->fBaseHours);
	$txtbasefare = db_output($dataArr[0]->fBaseFare);
	$txtaddperkm = db_output($dataArr[0]->fAdditionalPerKM);
	$txtaddperhr = db_output($dataArr[0]->fAdditionalPerHour);
	$txtwatchrgperhr = db_output($dataArr[0]->fWaitingChargesPerHour);
	$txtngtcharges = db_output($dataArr[0]->fNightCharges);
	$txtngtaddperkm = db_output($dataArr[0]->fNightAdditionalPerKM);
	$txtngtaddperhr = db_output($dataArr[0]->fNightAdditionalPerHour);
	$txtngtwatchrgperhr = db_output($dataArr[0]->fNightWaitingChargesPerHour);
	$txtdrvchrgfrom = db_output($dataArr[0]->tDriverChargesFrom);
	$txtdrvchrgto = db_output($dataArr[0]->tDriverChargesTo);
	$txtdrvchrgs = db_output($dataArr[0]->fDriverCharges);
	$rdstatus = $dataArr[0]->cStatus;

	$modalTITLE = 'Edit '.$PAGE_TITLE2;
	$form_mode ='U';
}
else if($mode=='U')
{
	$cmbtype = db_input_default($_POST['cmbtype'], 'i');
	$cmbcat = db_input_default($_POST['cmbcat'], 'i');
	$txtdfrom = db_input_default($_POST['txtdfrom'], 'd');
	$txtdto = db_input_default($_POST['txtdto'], 'd');
	$txtbasedist = db_input_default($_POST['txtbasedist'], 'f');
	$txtbasehrs = db_input_default($_POST['txtbasehrs'], 'f');
	$txtbasefare = db_input_default($_POST['txtbasefare'], 'f');
	$txtaddperkm = db_input_default($_POST['txtaddperkm'], 'f');
	$txtaddperhr = db_input_default($_POST['txtaddperhr'], 'f');
	$txtwatchrgperhr = db_input_default($_POST['txtwatchrgperhr'], 'f');
	$txtngtcharges = db_input_default($_POST['txtngtcharges'], 'f');
	$txtngtaddperkm = db_input_default($_POST['txtngtaddperkm'], 'f');
	$txtngtaddperhr = db_input_default($_POST['txtngtaddperhr'], 'f');
	$txtngtwatchrgperhr = db_input_default($_POST['txtngtwatchrgperhr'], 'f');
	$txtdrvchrgfrom = db_input_default($_POST['txtdrvchrgfrom'], 't');
	$txtdrvchrgto = db_input_default($_POST['txtdrvchrgto'], 't');
	$txtdrvchrgs = db_input_default($_POST['txtdrvchrgs'], 'f');
	$rdstatus = db_input_default($_POST['rdstatus'], 'c');
	
	if(strtotime(str_replace("'",'',$txtdto))>strtotime(str_replace("'",'',$txtdfrom)) && strtotime(str_replace("'",'',$txtdrvchrgto))>strtotime(str_replace("'",'',$txtdrvchrgfrom)))
	{
		$q = "UPDATE tariff SET iVTypeID=$cmbtype, iVCatID=$cmbcat, dFrom=$txtdfrom, dTo=$txtdto, fBaseDistanceInKM=$txtbasedist, fBaseHours=$txtbasehrs, fBaseFare=$txtbasefare, 
		fNightCharges=$txtngtcharges, fAdditionalPerKM=$txtaddperkm, fNightAdditionalPerKM=$txtngtaddperkm, fAdditionalPerHour=$txtaddperhr, fNightAdditionalPerHour=$txtngtaddperhr, fWaitingChargesPerHour=$txtwatchrgperhr, fNightWaitingChargesPerHour=$txtngtwatchrgperhr, 
		tDriverChargesFrom=$txtdrvchrgfrom, tDriverChargesTo=$txtdrvchrgto, fDriverCharges=$txtdrvchrgs, cStatus=$rdstatus WHERE iTariffID=$txtid ";
		$r = sql_query($q, "veh_tariff_edit.E.68");
		$_SESSION[PROJ_SESSION_ID]->success_info = "Tariff Details Successfully Updated";
	}
	else
	{
		if (!(strtotime(str_replace("'",'',$txtdto))>strtotime(str_replace("'",'',$txtdfrom)))) {
			$_SESSION[PROJ_SESSION_ID]->alert_info = "Tariff Details Could Not Be Updated because From and To dates are Invalid";
		} else if (!(strtotime(str_replace("'",'',$txtdrvchrgto))>strtotime(str_replace("'",'',$txtdrvchrgfrom)))) {
			$_SESSION[PROJ_SESSION_ID]->alert_info = "Tariff Details Could Not Be Updated because From and To time driver charges are Invalid";
		}
	}
}
elseif($mode=='D')
{
	$txtid = $_GET['id'];
	$loc_str = $edit_url . "?mode=E&id=$txtid"; 
	
	$chk_arr = array();
	//$chk_arr['Appointments'] = GetXFromYID('select count(*) from  where iTariffID='.$txtid.' and cStatus!="X"');
	$chk = array_sum($chk_arr);
	
	if(!$chk)
	{
		$q3 = "UPDATE tariff SET cStatus='X' WHERE iTariffID=$txtid";
		$r3 = sql_query($q3, 'veh_tariff_edit.D.87');
		
		$_SESSION[PROJ_SESSION_ID]->success_info = "Tariff Details Successfully Deleted";
		$loc_str = $disp_url;
	}
	else $_SESSION[PROJ_SESSION_ID]->alert_info = "Tariff Details Could Not Be Deleted Because of Existing ".(CHK_ARR2Str($chk_arr))." Dependencies";
	
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
                  <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-car mr-3 text-muted opacity-6"> </i><?php echo $modalTITLE; ?> </div>
                </div>
                <div class="card-body">
                  <form class="" name="tariffForm" id="tariffForm" method="post" action="<?php echo $edit_url; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
                    <input type="hidden" name="user_token" id="user_token" value="<?php echo $sess_user_token; ?>">
                    <div class="col-md-12">
                      <div class="form-row">
                        <div class="col-md-2">
                          <div class="position-relative form-group">
                            <label for="cmbcat" class="">Category <span class="text-danger">*</span></label>
                            <?php echo FillCombo($cmbcat, 'cmbcat', 'COMBO', 'Category', $CAT_ARR); ?>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="position-relative form-group">
                            <label for="cmbtype" class="">Type <span class="text-danger">*</span></label>
                            <?php echo FillCombo($cmbtype, 'cmbtype', 'COMBO', '-2', $TYPE_ARR,'onchange="GetVehicleDropdwon();"'); ?>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="position-relative form-group">
                            <label for="cmbtype" class="">Vehicle <span class="text-danger">*</span></label>
                            <?php echo FillCombo($cmbvID, 'cmbvID', 'COMBO', '0', $VEHICLE_ARR,''); ?>
                          </div>
                        </div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtdfrom" class="">Date From <span class="text-danger">*</span></label>
								<input name="txtdfrom" id="txtdfrom" type="text" value="<?php echo $txtdfrom; ?>" class="form-control datepickers">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtdto" class="">Date To <span class="text-danger">*</span></label>
								<input name="txtdto" id="txtdto" type="text" value="<?php echo $txtdto; ?>" class="form-control datepickers">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtbasedist" class="">Base Distance In KM <span class="text-danger">*</span></label>
								<input name="txtbasedist" id="txtbasedist" type="number" step="0.01" value="<?php echo $txtbasedist; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtbasehrs" class="">Base Hours <span class="text-danger">*</span></label>
								<input name="txtbasehrs" id="txtbasehrs" type="number" step="0.01" value="<?php echo $txtbasehrs; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtbasefare" class="">Base Fare <span class="text-danger">*</span></label>
								<input name="txtbasefare" id="txtbasefare" type="number" step="0.01" value="<?php echo $txtbasefare; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtaddperkm" class="">Additional Per KM <span class="text-danger">*</span></label>
								<input name="txtaddperkm" id="txtaddperkm" type="number" step="0.01" value="<?php echo $txtaddperkm; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtaddperhr" class="">Additional Per Hour <span class="text-danger">*</span></label>
								<input name="txtaddperhr" id="txtaddperhr" type="number" step="0.01" value="<?php echo $txtaddperhr; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtwatchrgperhr" class="">Waiting Charges Per Hour <span class="text-danger">*</span></label>
								<input name="txtwatchrgperhr" id="txtwatchrgperhr" type="number" step="0.01" value="<?php echo $txtwatchrgperhr; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtngtcharges" class="">Night Charges <span class="text-danger">*</span></label>
								<input name="txtngtcharges" id="txtngtcharges" type="number" step="0.01" value="<?php echo $txtngtcharges; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtngtaddperkm" class="">Night Additional Per KM <span class="text-danger">*</span></label>
								<input name="txtngtaddperkm" id="txtngtaddperkm" type="number" step="0.01" value="<?php echo $txtngtaddperkm; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtngtaddperhr" class="">Night Additional Per Hour <span class="text-danger">*</span></label>
								<input name="txtngtaddperhr" id="txtngtaddperhr" type="number" step="0.01" value="<?php echo $txtngtaddperhr; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtngtwatchrgperhr" class="">Night Waiting Charges Per Hour <span class="text-danger">*</span></label>
								<input name="txtngtwatchrgperhr" id="txtngtwatchrgperhr" type="number" step="0.01" value="<?php echo $txtngtwatchrgperhr; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtdrvchrgfrom" class="">Driver Charges From <span class="text-danger">*</span></label>
								<input name="txtdrvchrgfrom" id="txtdrvchrgfrom" type="time" value="<?php echo $txtdrvchrgfrom; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtdrvchrgto" class="">Driver Charges To <span class="text-danger">*</span></label>
								<input name="txtdrvchrgto" id="txtdrvchrgto" type="time" value="<?php echo $txtdrvchrgto; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="txtdrvchrgs" class="">Driver Charges <span class="text-danger">*</span></label>
								<input name="txtdrvchrgs" id="txtdrvchrgs" type="number" step="0.01" value="<?php echo $txtdrvchrgs; ?>" class="form-control">
							</div>
						</div>
                      </div>

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
					echo '<button type="button" onclick="ConfirmDelete(\'Vehicle Tariff\',\''.$edit_url.'?mode=D&id='.$txtid.'\');" class="mt-2 btn btn-danger">Delete</button>';
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
function GetVehicleDropdwon(){
	var cmbcat=$('#cmbcat').val();
	var cmbtype=$('#cmbtype').val();
	$.ajax({
		url:'_GetVDropdown.php',
		method:'POST',
		data:{
			catID:cmbcat,cmbType:cmbtype
		},success:function(res){
			//console.log(res);
			for (var i =0;i<res.length;i++) {
				 $('#cmbvID').append($('<option>', {
      value: res[i].id, // Set the option value (optional)
      text: res[i].name // Set the option text
    }));
			
			}

		}

	});
}

// Forms Input Mask
$( document ).ready(function() {
	$(".datepickers").datepicker({
		//dateFormat: 'yy-mm-dd',
		dateFormat: 'dd-mm-yy',
		autoHide: true,
	});
    $(".input-mask-trigger").inputmask();
});

//form validation
$( document ).ready(function() {
	$("#tariffForm").submit( function() {
		err = 0;
		err_arr = new Array();
		ret_val = true;

		$(this).find('input:not([type="hidden"],[type="radio"]),select').each(function(k,el){
			el = $(el);

			if(el.val() == 0 || el.val() === '') {
				var el_lable_txt = $(el).siblings('label').text().replace(' *','');
				ShowError( el, `Please input ${el_lable_txt}`);
				err_arr[err] = el;
				err ++;
			} else HideError(el);
		});

		if(err > 0) {
			err_arr[0].focus();
			ret_val = false;
		}

		return ret_val;
	});
});
</script>
</body>
</html>
