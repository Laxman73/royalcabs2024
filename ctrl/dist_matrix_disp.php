<?php
include "../includes/common.php";
$PAGE_TITLE2 = 'Dist. Matrix';
$MEMORY_TAG = "DIST_MAT";

$PAGE_TITLE .= $PAGE_TITLE2;
$DEC_PLACE = 2;

$disp_url = 'dist_matrix_disp.php';
$edit_url = 'dist_matrix_edit.php';

$execute_query = $is_query = true;
$txtkeyword = $cond = $params = $params2 = '';
$srch_style = 'display:none;';

if(isset($_POST['srch_mode']) && $_POST['srch_mode']=='SUBMIT')
{
	//$txtkeyword = $_POST['txtkeyword'];

	$params = '&keyword='.$txtkeyword;
	header('location: '.$disp_url.'?srch_mode=QUERY'.$params);
}
else if(isset($_GET['srch_mode']) && $_GET['srch_mode']=='QUERY')
{
	$is_query = true;
	
	//if(isset($_GET['keyword'])) $txtkeyword = $_GET['keyword'];

	$params2 = '?keyword='.$txtkeyword;
}
else if(isset($_GET['srch_mode']) && $_GET['srch_mode']=='MEMORY')
	SearchFromMemory($MEMORY_TAG, $disp_url);

/*if(!empty($txtkeyword))
{
	$cond .= " and (lfr.vName LIKE '%".$txtkeyword."%' OR lto.vName LIKE '%".$txtkeyword."%')";
	$execute_query = true;
}*/

/*if($execute_query)
	$srch_style = '';*/

$cond .= " and ld.cStatus='A'";

$LOC_ARR = GetLocLocalityArr(" and cStatus='A' ");


$matrix = array();
//if (isset($_POST['srch_mode']) || isset($_GET['srch_mode'])) {
	$r = sql_query("SELECT ld.iLocDistanceID, lfr.vName AS lfrom, ld.iLocID_From, lto.vName AS lto, ld.iLocID_To, ld.fDistanceInKM FROM location_distance as ld LEFT JOIN location as lfr on lfr.iLocationID=ld.iLocID_From LEFT JOIN location as lto on lto.iLocationID=ld.iLocID_To WHERE 1 $cond order by lfr.vName ");
	$dataArr = sql_get_data($r);
	foreach ($dataArr as $row)
	{
		$matrix[$row->iLocID_From][$row->iLocID_To] = array('id'=>$row->iLocDistanceID, 'dist'=>$row->fDistanceInKM, 'from'=>$row->lfrom, 'to'=>$row->lto);
		//$matrix[$row->iLocID_To][$row->iLocID_From] = array('id'=>$row->iLocDistanceID, 'dist'=>$row->fDistanceInKM, 'from'=>$row->lto, 'to'=>$row->lfrom);
	}
//}


//DFA($matrix);
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
                    <!-- <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                      <input type="text" name="txtkeyword" id="txtkeyword" value="<?php //echo $txtkeyword; ?>" placeholder="Keywords"  class="form-control" />
                    </div> -->
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
              <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-graph1 mr-3 text-muted opacity-6"> </i><?php echo $PAGE_TITLE2; ?> </div>
              <div class="btn-actions-pane-right actions-icon-btn">
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-alternate" onClick="ToggleVisibility('SEARCH_RECORDS');" style="display:none;"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-search fa-w-20"></i> </span> Search </button>
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info" onClick="GoToPage('<?php echo $edit_url; ?>');"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-plus fa-w-20"></i> </span> Add New </button>
              </div>
            </div>
            <div class="card-body">
                  <?php
				if($execute_query)
				{
					if(!empty($dataArr))
					{
						?>
			<table style="width: 100%;" id="stateTable" class="table table-hover table-striped table-bordered">
				<thead style="position: sticky; top:60px; z-index:9;" class="bg-white">
					<tr>
						<th>from\to</th>
						<?php
						foreach ($LOC_ARR as $id => $name)
						{
							echo("<th>$name</th>");
						}
						?>
					</tr>
				</thead>
				<tbody>
						<?php
						foreach ($LOC_ARR as $from => $name_from)
						{
							echo("<tr>");
							echo("<th>$name_from</th>");
							foreach ($LOC_ARR as $to => $name_to)
							{
								if (!empty($matrix[$from][$to]) && $from != $to) {
									$id = $matrix[$from][$to]['id'];
									$url = "'$edit_url?mode=E&id=$id'";
									echo("<td style='text-align:center;'><b class='text-success'>".$matrix[$from][$to]['dist']."</b> <a type='button' class='btn btn-primary btn-sm float-right' href=$url><i class='fa fa-pencil-alt fa-fw'></i></a></td>");
								} else if($from != $to) {
									$url = "'$edit_url?mode=N&cmbfrom=$from&cmbto=$to'";
									echo("<td style='text-align:center;'><i class='fa fa-times fa-fw text-danger'></i> <a type='button' class='btn btn-primary btn-sm float-right' href=$url><i class='fa fa-plus fa-fw'></i></a></td>");
								} else {
									echo("<td style='text-align:center;'>- NA -</td>");
								}
							}
							echo("</tr>");
						}
						?>
				</tbody>
			</table>
						<?php
					}
				}
				?>
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
/*$( document ).ready(function() {
	$('#stateTable').DataTable({
		responsive: true,
		searching: true,
	});
});*/
</script>
</body>
</html>
