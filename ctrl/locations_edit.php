<?php
include "../includes/common.php";

$PAGE_TITLE2 = 'Location';
$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'locations_disp.php';
$edit_url = 'locations_edit.php';

if(isset($_GET['mode'])) $mode = $_GET['mode'];
elseif(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode ='A';

if(isset($_GET['id'])) $txtid = $_GET['id'];
elseif(isset($_POST['txtid'])) $txtid = $_POST['txtid'];
else $mode ='A';

$COUNTRY_ARR = GetXArrFromYID('select iCountryID, vName from country where cStatus!="X" order by iCountryID','3');
$STATE_ARR = GetXArrFromYID('select iStateID, vName from state where cStatus!="X" order by iStateID','3');

//$cmbstate = GetXFromYID("SELECT iStateID FROM state WHERE cStatus='A' AND vName LIKE '%goa%'");
$cmbstate = 1;
$cmbpid = 0;

if($mode=='A')
{
	$txtid = '';
	$txtname = '';
	$txturlname = '';
	//$cmbstate = '';
	//$cmbpid = 0;
	$txtpincode = '';
	$txtlatitude = '';
	$txtlongitude = '';
	$txtrank = '';
	$rdstatus = 'A';
	$rdarivalpoint='I';

	$modalTITLE = 'New '.$PAGE_TITLE2;
	$form_mode ='I';
}
else if($mode=='I')
{
	$rdarivalpoint=db_input2($_POST['rdarivalpoint']);
	$txtname = db_input2($_POST['txtname']);
	$txturlname = strtolower(GetUrlName($txtname));
	//$cmbstate = db_input_default($_POST['cmbstate'], 'i');
	//$cmbpid = db_input_default(((isset($_POST['cmbpid']) && is_numeric($_POST['cmbpid']))?$_POST['cmbpid']:0), 'i', "'", 0);
	$txtpincode = db_input2($_POST['txtpincode']);
	$txtlatitude = db_input2($_POST['txtlatitude']);
	$txtlongitude = db_input2($_POST['txtlongitude']);
	$rdstatus = db_input2($_POST['rdstatus']);

	$country = GetXFromYID("SELECT iCountryID FROM state WHERE iStateID=$cmbstate");

	LockTable('location');
	$txtid = NextID('iLocationID', 'location');
	$txtrank = GetMaxRank('location','iParentID='.$cmbpid);
	list($ancestorid, $level) = GetTableTreeDetails($cmbpid, $txtid, 'location', 'iLocationID');
	$q = "INSERT INTO location (iLocationID, iStateID, iCountryID, vName, vUrlName, cPinCode, iLatitude, iLongitude, iParentID, iAncestorID, iLevel, iRank, cStatus,cArivalpoint) 
			VALUES ('$txtid', '$cmbstate', '$country', '$txtname', '$txturlname', '$txtpincode', '$txtlatitude', '$txtlongitude', '$cmbpid', '$ancestorid', '$level', '$txtrank', '$rdstatus','$rdarivalpoint')";
	$r = sql_query($q, "locations_edit.E.38");
	UnLockTable();

	$_SESSION[PROJ_SESSION_ID]->success_info = "Location Details Successfully Inserted";
}
else if($mode=='E')
{
	$dataArr = GetDataFromID("location", "iLocationID", $txtid);
	
	$txtid = $dataArr[0]->iLocationID;
	$txtname = db_output($dataArr[0]->vName);
	$txturlname = strtolower(GetUrlName($txtname));
	//$cmbstate = db_output($dataArr[0]->iCountryID);
	//$cmbpid = db_output($dataArr[0]->iParentID);
	$txtpincode = db_output($dataArr[0]->cPinCode);
	$txtlatitude = db_output($dataArr[0]->iLatitude);
	$txtlongitude = db_output($dataArr[0]->iLongitude);
	$rdarivalpoint=db_output($dataArr[0]->cArivalpoint);
	$rdstatus = $dataArr[0]->cStatus;

	$modalTITLE = 'Edit '.$PAGE_TITLE2;
	$form_mode ='U';
}
else if($mode=='U')
{
	$txtname = db_input2($_POST['txtname']);
	$txturlname = strtolower(GetUrlName($txtname));
	$rdarivalpoint=db_input2($_POST['rdarivalpoint']);
	//$cmbstate = db_input_default($_POST['cmbstate'], 'i');
	//$cmbpid = db_input_default(((isset($_POST['cmbpid']) && is_numeric($_POST['cmbpid']))?$_POST['cmbpid']:0), 'i', "'", 0);
	//if($cmbpid==$txtid) $cmbpid = 0;
	$txtpincode = db_input2($_POST['txtpincode']);
	$txtlatitude = db_input2($_POST['txtlatitude']);
	$txtlongitude = db_input2($_POST['txtlongitude']);
	$rdstatus = db_input2($_POST['rdstatus']);

	$country = GetXFromYID("SELECT iCountryID FROM state WHERE iStateID=$cmbstate");
	list($ancestorid, $level) = GetTableTreeDetails($cmbpid, $txtid, 'location', 'iLocationID');
	
	$q = "UPDATE location SET iStateID='$cmbstate', iCountryID='$country', vName='$txtname', vUrlName='$txturlname', cPinCode='$txtpincode', 
			iLatitude='$txtlatitude', iLongitude='$txtlongitude', iParentID='$cmbpid', iAncestorID='$ancestorid', iLevel='$level', cStatus='$rdstatus',cArivalpoint='$rdarivalpoint' WHERE iLocationID=$txtid ";
	$r = sql_query($q, "locations_edit.E.68");
	$_SESSION[PROJ_SESSION_ID]->success_info = "Location Details Successfully Updated";
}
elseif($mode=='D')
{
	$txtid = $_GET['id'];
	$loc_str = $edit_url . "?mode=E&id=$txtid"; 
	
	$chk_arr = array();

	//$chk_arr['Parent Location'] = GetXFromYID('select count(*) from location where iParentID='.$txtid);
	$chk = array_sum($chk_arr);
	
	if(!$chk)
	{
		$q3 = "UPDATE location SET cStatus='X' WHERE iLocationID=$txtid";
		$r3 = sql_query($q3, 'locations_edit.D.87');
		
		$_SESSION[PROJ_SESSION_ID]->success_info = "Location Details Successfully Deleted";
		$loc_str = $disp_url;
	}
	else $_SESSION[PROJ_SESSION_ID]->alert_info = "Location Details Could Not Be Deleted Because of Existing ".(CHK_ARR2Str($chk_arr))." Dependencies";
	
	header("location: $loc_str");
	exit;
}

if($mode=='I' || $mode=='U')
{
	// update ancestor_id for all sub-locations...
	$arr = array();
	$arr = GetTreeArr('location', 'iLocationID', 0, $txtid, $arr, '3');

	if(count($arr))
	{
		$q = "update location set iAncestorID=$ancestorid where iLocationID in (".implode(',', $arr).")";
		$r = sql_query($q, 'locations_edit.111');
	}

	SortTreeStruct('location', 'iLocationID');

	header("location: $edit_url?mode=E&id=$txtid");
	exit;
}

if(empty($txtlatitude)) $txtlatitude = '15.4987085';
if(empty($txtlongitude)) $txtlongitude = '73.8236824';

?>
<!doctype html>
<html lang="en">
<head>
<?php include "load.links.php"; ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false&key=<?php echo GMAP_KEY; ?>" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
var geocoder;
var map;
var marker;
function initialize(canvas, latitude, longitude)
{
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(document.getElementById(latitude).value,document.getElementById(longitude).value);

	var myOptions = {
	  zoom: 15,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(document.getElementById(canvas),myOptions);

	marker = new google.maps.Marker({
      map: map,
      draggable: true,
      position: latlng
    });

	google.maps.event.addListener(marker, 'dragend', function() {  	
		var point = marker.getPosition();
		res=String(point);
		res = res.replace("(","");
		res = res.replace(")","");
		resarr=res.split(", ");
		document.getElementById(latitude).value=resarr[0];
		document.getElementById(longitude).value=resarr[1];
  	});
}

function showOnMap(latitude, longitude)
{
	var latlng = new google.maps.LatLng(document.getElementById(latitude).value,document.getElementById(longitude).value);

	marker.setMap(null);
	marker = new google.maps.Marker({
      map: map,
      draggable: true,
      position: latlng
    });
}

function showAddress(address, latitude, longitude)
{
	address = document.getElementById(address).value;
    geocoder.geocode( {'address': address}, function(results, status) 
	{
     	if (status == google.maps.GeocoderStatus.OK) 
	  	{
			res=String(results[0].geometry.location);
			res = res.replace("(","");
			res = res.replace(")","");
			resarr=res.split(", ");
			document.getElementById(latitude).value=resarr[0];
			document.getElementById(longitude).value=resarr[1];
			map.setCenter(results[0].geometry.location);
			marker.setMap(null);
			marker = new google.maps.Marker({
				map: map,
				draggable:true,
				position: results[0].geometry.location
			});
		}
		else 
			alert("Geocode was not successful for the following reason: " + status);
    });
}
</script>
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
                  <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-map-marker mr-3 text-muted opacity-6"> </i><?php echo $modalTITLE; ?> </div>
                </div>
                <div class="card-body">
                  <form class="" name="stateForm" id="stateForm" method="post" action="<?php echo $edit_url; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
                    <input type="hidden" name="user_token" id="user_token" value="<?php echo $sess_user_token; ?>">
                    <div class="col-md-12">
                      <div class="form-row">
						<!-- <div class="col-md-2">
							<div class="position-relative form-group">
								<label for="cmbstate" class="">State <span class="text-danger">*</span></label>
								<?php //echo FillCombo($cmbstate, 'cmbstate', 'COMBO', 'State', $STATE_ARR); ?>
							</div>
						</div> -->
						<input type="hidden" name="cmbstate" id="cmbstate" value="<?php echo $cmbstate; ?>">
						<!-- <div class="col-md-3">
							<div class="position-relative form-group">
								<label for="cmbcountry" class="">Parent Location</label>
								<?php //echo FillTreeData($cmbpid, 'cmbpid', 'COMBO2', '0', 'iLocationID,vName', 'location', '1'); ?>
							</div>
						</div> -->
						<input type="hidden" name="cmbpid" id="cmbpid" value="<?php echo $cmbpid; ?>">
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label for="txtname" class="">Name <span class="text-danger">*</span></label>
								<input name="txtname" id="txtname" type="text" value="<?php echo $txtname; ?>" class="form-control">
							</div>
						</div>
						<!-- <div class="col-md-4">
							<div class="position-relative form-group">
								<label for="txturlname" class="">URL Name <span class="text-danger">*</span></label>
								<input name="txturlname" id="txturlname" type="text" value="<?php echo $txturlname; ?>" class="form-control">
							</div>
						</div> -->
						<div class="col-md-4">
							<div class="position-relative form-group">
								<label for="txtpincode" class="">PIN Code <span class="text-danger">*</span></label>
								<input name="txtpincode" id="txtpincode" type="text" maxlength="6" value="<?php echo $txtpincode; ?>" class="form-control">
							</div>
						</div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-row">
						<div class="col-md-12">
							<div class="position-relative form-group">
								<label for="txtaddress" class="">Location On Map</label>
								<div class="form-inline float-right">
									<input name="txtaddress" id="txtaddress" type="text" value="" class="form-control form-control-sm">
									<button type="button" class="btn btn-sm btn-primary ml-2" onClick="showAddress('txtaddress','txtlatitude','txtlongitude');">Search</button>
								</div>
								<div id="map_canvas" style="width:100%; height:500px;"> </div>
							</div>
						</div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-row">
						<div class="col-md-5">
							<div class="position-relative form-group">
								<label for="txtlatitude" class="">Latitude <span class="text-danger">*</span></label>
								<input name="txtlatitude" id="txtlatitude" type="text" value="<?php echo $txtlatitude; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-5">
							<div class="position-relative form-group">
								<label for="txtlongitude" class="">Longitude <span class="text-danger">*</span></label>
								<input name="txtlongitude" id="txtlongitude" type="text" value="<?php echo $txtlongitude; ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative form-group">
								<label for="" class="" style="display: block;">&nbsp;</label>
								<button type="button" class="btn btn-primary float-right" onClick="showOnMap('txtlatitude','txtlongitude');">Show on Map</button>
							</div>
						</div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-row">
						<div class="col-md-12">
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
                      <div class="form-row">
                        <div class="col-md-12">
                          <div class="position-relative form-group">
                            <label for="rdstatus" class="">Arival point</label>
                            <?php echo FillRadios($rdarivalpoint, 'rdarivalpoint', $YES_ARR); ?>
						  </div>
                        </div>
                      </div>
                      <button type="button" onClick="location.href='<?php echo $disp_url; ?>';" class="mt-2 btn btn-secondary">Back</button>
                      <button type="submit" class="mt-2 btn btn-success">Save</button>
                      <?php 
				if($mode=='E')
					echo '<button type="button" onclick="ConfirmDelete(\'Location\',\''.$edit_url.'?mode=D&id='.$txtid.'\');" class="mt-2 btn btn-danger">Delete</button>';
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
	initialize('map_canvas','txtlatitude','txtlongitude');
    $(".input-mask-trigger").inputmask();
});

//form validation
$( document ).ready(function() {
	$("#stateForm").submit( function() {
		err = 0;
		err_arr = new Array();
		ret_val = true;

		//var cmbstate = $(this).find('#cmbstate');
		var txtname = $(this).find('#txtname');
		// var txturlname = $(this).find('#txturlname');
		// var txturlname = $(this).find('#txturlname');
		var txtpincode = $(this).find('#txtpincode');
		var txtlatitude = $(this).find('#txtlatitude');
		var txtlongitude = $(this).find('#txtlongitude');

		/*if(cmbstate.val() == 0 || cmbstate.val() === '') {
			ShowError( cmbstate, "Please select Country");
			err_arr[err] = cmbstate;
			err ++;
		} else HideError(cmbstate);*/

		if(txtname.val() == 0 || txtname.val() === '') {
			ShowError( txtname, "Please enter Name");
			err_arr[err] = txtname;
			err ++;
		} else HideError(txtname);

		// if(txturlname.val() == 0 || txturlname.val() === '') {
		// 	ShowError( txturlname, "Please enter URL Name");
		// 	err_arr[err] = txturlname;
		// 	err ++;
		// } else HideError(txturlname);

		if(txtpincode.val() == 0 || txtpincode.val() === '') {
			ShowError( txtpincode, "Please enter PIN code");
			err_arr[err] = txtpincode;
			err ++;
		} else HideError(txtpincode);

		if(txtlatitude.val() == 0 || txtlatitude.val() === '') {
			ShowError( txtlatitude, "Please enter Latitude");
			err_arr[err] = txtlatitude;
			err ++;
		} else HideError(txtlatitude);

		if(txtlongitude.val() == 0 || txtlongitude.val() === '') {
			ShowError( txtlongitude, "Please enter Longitude");
			err_arr[err] = txtlongitude;
			err ++;
		} else HideError(txtlongitude);

		if(err > 0) {
			ret_val = false;
		}

		return ret_val;
	});
});
</script>
</body>
</html>
