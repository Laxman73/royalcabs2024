<?php
include "../includes/common.php";
$PAGE_TITLE2 = 'Bookings';
$MEMORY_TAG = "BOOKINGS";

$PAGE_TITLE .= $PAGE_TITLE2;
$DEC_PLACE = 2;

$disp_url = 'bookings_disp.php';
$edit_url = 'locations_edit.php';

$execute_query = $is_query = true;
$txtkeyword = $cond = $params = $params2 = '';
$cmbstatus='A';
$srch_style = 'display:none;';

$COUNTRY_ARR = GetXArrFromYID('select iCountryID, vName from country where cStatus!="X" order by iCountryID', '3');
$VEHICLE_ARR = GetXArrFromYID('select iVehicleID, vName from vehicle where cStatus!="X" order by iVehicleID', '3');
$STATE_ARR = GetXArrFromYID('select iStateID, vName from state where cStatus!="X" order by iStateID', '3');
$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' ", '3');

if (isset($_POST['srch_mode']) && $_POST['srch_mode'] == 'SUBMIT') {
  $txtkeyword = $_POST['txtkeyword'];
  $cmbstatus = $_POST['cmbstatus'];

  $params = '&keyword=' . $txtkeyword.'&cmbstatus='.$cmbstatus;
  header('location: ' . $disp_url . '?srch_mode=QUERY' . $params);
} else if (isset($_GET['srch_mode']) && $_GET['srch_mode'] == 'QUERY') {
  $is_query = true;

  if (isset($_GET['keyword'])) $txtkeyword = $_GET['keyword'];
  if (isset($_GET['cmbstatus'])) $cmbstatus = $_GET['cmbstatus'];

  $params2 = '?keyword=' . $txtkeyword.'&cmbstatus='.$cmbstatus;
} else if (isset($_GET['srch_mode']) && $_GET['srch_mode'] == 'MEMORY')
  SearchFromMemory($MEMORY_TAG, $disp_url);

if (!empty($txtkeyword)) {
  $cond .= " and (vName LIKE '%" . $txtkeyword . "%')";
  $execute_query = true;
}

if (!empty($cmbstatus)) {
  $cond .= " and cStatus='$cmbstatus'";
  $execute_query = true;
}

if ($execute_query)
  $srch_style = '';

$dataArr = array();
if ($execute_query) {
  $dataArr = GetDataFromCOND('booking', " $cond order by iBookingID desc ");
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
    <?php //include "loadtheme.settings.php"; 
    ?>
    <div class="app-main">
      <?php include "load.menu.php" ?>
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
                      <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                        <input type="text" name="txtkeyword" id="txtkeyword" value="<?php echo $txtkeyword; ?>" placeholder="Keywords" class="form-control" />
                      </div>
                      <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                        <?php echo FillCombo2022('cmbstatus',$cmbstatus,$STATUS_ARR,'payment status');?>
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
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-map-marker mr-3 text-muted opacity-6"> </i><?php echo $PAGE_TITLE2; ?> </div>
                <div class="btn-actions-pane-right actions-icon-btn">
                  <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-alternate" onClick="ToggleVisibility('SEARCH_RECORDS');" style="display:none;"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-search fa-w-20"></i> </span> Search </button>
                  <!-- <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info" onClick="GoToPage('<?php echo $edit_url; ?>');"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-plus fa-w-20"></i> </span> Add New </button> -->
                </div>
              </div>
              <div class="card-body">
                <table style="width: 100%;" id="stateTable" class="table table-hover table-striped table-bordered">
                  <thead style="position: sticky; top:60px; z-index:9;" class="bg-white">
                    <tr>
                      <th width="5%">#.</th>
                      <th>Date Requested</th>
                      <th>Time</th>
                      <th>Vehicle</th>
                      <th width="15%">Customer</th>
                      <th width="10%">Email</th>
                      <th>Mobile</th>
                      <th>From</th>
                      <th>TO</th>
                      <th>Pax</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($execute_query) {
                      if (!empty($dataArr)) {
                        $i = 0;
                        foreach ($dataArr as $row) {
                          $i++;
                          //DFA($row);
                          $x_id = $row->iBookingID;
                          $x_vid = $row->iVehicleID;
                          $x_cname = $row->vFname;
                          $x_email = $row->vEmail;
                          $x_mobile = $row->vMobile;
                          $x_time = $row->iHours;
                          $x_pax = $row->iPax;
                          $x_stat = $row->cStatus;
                          $x_LocFrom = $row->iLocationID_pick;
                          $x_LocTo = $row->iLocationID_drop;
                          $x_date = $row->dtFrom;
                          $x_total = $row->fPayable;


                          // $x_pincode = $row["PINCODE"];
                          // $x_sr = $row["SR"];

                          // $x_status_str = GetStatusImageString('LOCATION', $x_stat, $x_id, false);
                          // $url = $edit_url.'?mode=E&id='.$x_id;
                    ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($x_date)); ?></td>
                            <td><?php echo $TIME_CAR_ARR[$x_time]; ?></td>
                            <td style="text-align:center;"><?php echo $VEHICLE_ARR[$x_vid]; ?></td>
                            <td style="text-align:center;"><?php echo $x_cname; ?></td>
                            <td style="text-align:center;"><?php echo $x_email; ?></td>
                            <td style="text-align:center;"><?php echo $x_mobile; ?></td>
                            <td style="text-align:center;"><?php echo $LOC_ARR[$x_LocFrom]; ?></td>
                            <td style="text-align:center;"><?php echo $LOC_ARR[$x_LocTo]; ?></td>
                            <td style="text-align:center;"><?php echo $PASS_ARR[$x_pax]; ?></td>
                            <td style="text-align:center;"><?php echo $x_total; ?></td>
                          </tr>
                    <?php
                        }
                      }
                    } else
                      echo '<tr class="odd"><td colspan="4" class="dataTables_empty" valign="top">Please select search criteria...</td></tr>';
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
    $(document).ready(function() {
      $('#stateTable').DataTable({
        responsive: true,
        searching: true,
      });
    });
  </script>
</body>

</html>