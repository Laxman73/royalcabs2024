<?php
include "../includes/common.php";
$PAGE_TITLE2 = 'Vehicle Tariff';
$MEMORY_TAG = "VEHICLE_TARIFF";

$PAGE_TITLE .= $PAGE_TITLE2;
$DEC_PLACE = 2;

$disp_url = 'veh_tariff_disp.php';
$edit_url = 'veh_tariff_edit.php';

$execute_query = $is_query = true;
$cmbtype = $cmbcat = $cmbfuel = $cmbairbag = $cmbseats = $cmbowner = '';
$txtkeyword = $cond = $params = $params2 = '';
$srch_style = 'display:none;';

if(isset($_POST['srch_mode']) && $_POST['srch_mode']=='SUBMIT')
{
	$txtkeyword = $_POST['txtkeyword'];
	$cmbtype = $_POST['cmbtype'];
	$cmbcat = $_POST['cmbcat'];

	$params = '&keyword='.$txtkeyword.'&type='.$cmbtype.'&cat='.$cmbcat;
	header('location: '.$disp_url.'?srch_mode=QUERY'.$params);
}
else if(isset($_GET['srch_mode']) && $_GET['srch_mode']=='QUERY')
{
	$is_query = true;
	
	if(isset($_GET['keyword'])) $txtkeyword = $_GET['keyword'];
	if(isset($_GET['type'])) $cmbtype = $_GET['type'];
	if(isset($_GET['cat'])) $cmbcat = $_GET['cat'];

	$params2 = '?keyword='.$txtkeyword.'&type='.$cmbtype.'&cat='.$cmbcat;
}
else if(isset($_GET['srch_mode']) && $_GET['srch_mode']=='MEMORY')
	SearchFromMemory($MEMORY_TAG, $disp_url);

$TYPE_ARR = GetXArrFromYID('select iVTypeID, CONCAT(vName, " (", vSeats, ")") from gen_vehicle_type where cStatus!="X" order by iVTypeID','3');
$CAT_ARR = GetXArrFromYID('select iVCatID, vName from gen_vehicle_category where cStatus!="X" order by iVCatID','3');

if(!empty($txtkeyword))
{
	$cond .= " and (vName LIKE '%".$txtkeyword."%')";
	$execute_query = true;
}

if(!empty($cmbtype))
{
	$cond .= " and iVTypeID=".$cmbtype;
	$execute_query = true;
}

if(!empty($cmbcat))
{
	$cond .= " and iVCatID=".$cmbcat;
	$execute_query = true;
}

if($execute_query)
	$srch_style = '';

$cond .= " and cStatus!='X'";

$VEHICLE_ARR=GetXArrFromYID("select iVehicleID,vName from vehicle where cStatus='A' ",'3');

$dataArr = array();
if ($execute_query) {
	$dataArr = GetDataFromCOND("tariff", $cond.' order by iVTypeID,iVCatID,iTariffID');
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
          <div id="LBL_INFO"><?php echo $sess_info_str; ?></div>
          <div class="app-inner-layout__header-boxed p-0" id="SEARCH_RECORDS" style="<?php echo $srch_style; ?>">
            <div class="app-inner-layout__header page-title-icon-rounded text-white bg-premium-dark mb-4">
              <div class="app-page-title">
                <div class="page-title-wrapper">
                  <form class="form-inline" name="frmSearch" id="frmSearch" action="<?php echo $disp_url; ?>" method="post">
                    <input type="hidden" name="srch_mode" id="srch_mode" value="SUBMIT" />
                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"> <?php echo FillCombo($cmbtype, 'cmbtype', 'COMBO', '-2', $TYPE_ARR); ?> </div>
                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"> <?php echo FillCombo($cmbcat, 'cmbcat', 'COMBO', 'Category', $CAT_ARR); ?> </div>
                    <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                      <input type="text" name="txtkeyword" id="txtkeyword" value="<?php echo $txtkeyword; ?>" placeholder="Keywords"  class="form-control" />
                    </div>
                    <div class="page-title-actions">
                      <div class="d-inline-block dropdown">
                        <button type="submit" class="btn-shadow btn btn-info"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-search fa-w-20"></i> </span> Search </button>
                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-danger" onClick="GoToPage('<?php echo $disp_url; ?>');"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-times fa-w-20"></i> </span> Reset </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Begin Page Content Here :: -->
          <div class="card mb-3">
            <div class="card-header-tab card-header">
              <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-car mr-3 text-muted opacity-6"> </i><?php echo $PAGE_TITLE2; ?> </div>
              <div class="btn-actions-pane-right actions-icon-btn">
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-alternate" onClick="ToggleVisibility('SEARCH_RECORDS');" style="display:none;"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-search fa-w-20"></i> </span> Search </button>
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info" onClick="GoToPage('<?php echo $edit_url; ?>');"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-plus fa-w-20"></i> </span> Add New </button>
              </div>
            </div>
            <div class="card-body">
              <table style="width: 100%;" id="stateTable" class="table table-hover table-striped table-bordered">
                <thead style="position: sticky; top:60px; z-index:9;" class="bg-white">
                  <tr>
                    <th width="5%">#.</th>
                    <th>Vehicle</th>
                    <th>Type</th>
                    <!-- <th>From</th>
                    <th>To</th> -->
                    <th width="10%">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
				if($execute_query)
				{
					if(!empty($dataArr))
					{
						$group_by_cat = array();
						foreach ($dataArr as $i => $row)
						{
							$x_id = $row->iTariffID;
							$x_vehicleID=$row->iVehicleID;
							$x_type = !empty($TYPE_ARR[$row->iVTypeID])?$TYPE_ARR[$row->iVTypeID]:'- Na -';
							$x_from = FormatDate($row->dFrom, "B");
							$x_to = FormatDate($row->dTo, "B");
							$x_stat = $row->cStatus;
							$x_status_str = GetStatusImageString('VEHICLE_TARIFF', $x_stat, $x_id, false);
							$url = $edit_url.'?mode=E&id='.$x_id;

							if (!isset($group_by_cat[$row->iVCatID])) {
								$group_by_cat[$row->iVCatID] = !empty($CAT_ARR[$row->iVCatID])?$CAT_ARR[$row->iVCatID]:'- Na -';
								?>
								<tr>
								  <td colspan="7" class="text-center bg-warning"><b><?php echo $group_by_cat[$row->iVCatID]; ?></b></td>
								</tr>
								<?php
							}
							?>
						  <tr>
							<td><?php echo $i+1; ?></td>
							<td><?php echo $VEHICLE_ARR[$x_vehicleID]; ?></td>
							<td><a href="<?php echo $url; ?>"><?php echo $x_type; ?></a></td>
							<!-- <td><a href="<?php echo $url; ?>"><?php echo $x_from; ?></a></td>
							<td><a href="<?php echo $url; ?>"><?php echo $x_to; ?></a></td> -->
							<td style="text-align:center;"><?php echo $x_status_str; ?></td>
						  </tr>
						  <?php
						}
					}
				}
				else
					echo '<tr class="odd"><td colspan="7" class="dataTables_empty" valign="top">Please select search criteria...</td></tr>';
				?>
                </tbody>
              </table>
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
<script type="text/javascript">
$( document ).ready(function() {
	$('#stateTable').DataTable({
		responsive: true,
		searching: true,
	});
});
</script>
</body>
</html>
