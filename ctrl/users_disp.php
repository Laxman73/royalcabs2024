<?php
include "../includes/common.php";
$PAGE_TITLE2 = 'Users';
$MEMORY_TAG = "USERS";

$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'users_disp.php';
$edit_url = 'users_edit.php';

$execute_query = $is_query = true;
$txtkeyword = $cond = $params = $params2 = '';
$srch_style = 'display:none;';

if(isset($_POST['srch_mode']) && $_POST['srch_mode']=='SUBMIT')
{
	$txtkeyword = $_POST['txtkeyword'];

	$params = '&keyword='.$txtkeyword;
	header('location: '.$disp_url.'?srch_mode=QUERY'.$params);
}
else if(isset($_GET['srch_mode']) && $_GET['srch_mode']=='QUERY')
{
	$is_query = true;
	
	if(isset($_GET['keyword'])) $txtkeyword = $_GET['keyword'];

	$params2 = '?keyword='.$txtkeyword;
}
else if(isset($_GET['srch_mode']) && $_GET['srch_mode']=='MEMORY')
	SearchFromMemory($MEMORY_TAG, $disp_url);


if(!empty($txtkeyword))
{
	$cond .= " and (vName LIKE '%".$txtkeyword."%')";
	$execute_query = true;
}

//if($execute_query)
	//$srch_style = '';

$cond .= " and cStatus!='X'";
$dataArr = GetDataFromCOND("users", $cond.' order by iLevel');
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
              <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-users mr-3 text-muted opacity-6"> </i><?php echo $PAGE_TITLE2; ?> </div>
              <div class="btn-actions-pane-right actions-icon-btn">
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-alternate" onClick="ToggleVisibility('SEARCH_RECORDS');" style="display:none;"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-search fa-w-20"></i> </span> Search </button>
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info" onClick="GoToPage('<?php echo $edit_url; ?>');"> <span class="btn-icon-wrapper pr-2 opacity-7"> <i class="fa fa-plus fa-w-20"></i> </span> Add New </button>
              </div>
            </div>
            <div class="card-body">
            <table style="width: 100%;" id="usersTable" class="table table-hover table-striped table-bordered">
              <thead style="position: sticky; top:60px; z-index:9;" class="bg-white">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Level</th>
                  <th>Last Login</th>
                  <!-- <th>Status</th> -->
                  <th>Access</th>
                </tr>
              </thead>
              <tbody>
                <?php 
				if(!empty($dataArr))
				{
					for ($u=0; $u < sizeof($dataArr); $u++) 
					{ 
						$i=$u+1;
						$x_id =  !empty($dataArr[$u]->iUserID)?db_output($dataArr[$u]->iUserID):'- Na -';
						$x_name = !empty($dataArr[$u]->vName)?db_output($dataArr[$u]->vName):'- Na -';
						$x_email = !empty($dataArr[$u]->vEmail)?db_output($dataArr[$u]->vEmail):'- Na -';
						$x_phone =  !empty($dataArr[$u]->vPhone)?db_output($dataArr[$u]->vPhone):'- Na -';
						$x_level =  $dataArr[$u]->iLevel;
						$dt_login =  $dataArr[$u]->dtLastLogin;
						$ses_stat =  !empty($dataArr[$u]->cActive)?db_output($dataArr[$u]->cActive):'- Na -';
						$stat = $dataArr[$u]->cStatus;
						
						$x_level_str = $USER_LEVEL_ARR[$x_level];
						$ses_stat_str= !empty($ses_stat)?$ONLINE_ARR[$ses_stat]: '- Na -';
						$status_str = GetStatusImageString('USERS', $stat, $x_id, $ajax_flag=true);
						
						if($ses_stat=='Y') $style = 'success';
						else $style = 'danger';
						
						
						$url = $edit_url.'?mode=E&id='.$x_id;
						?>
						<tr>
							<td><?php echo $i ?></td>
							<td><a href="<?php echo $url; ?>"><?php echo $x_name; ?></a></td>
							<td><?php echo $x_email; ?></td>
							<td><?php echo $x_phone; ?></td>
							<td><?php echo $x_level_str; ?></td>
							<td><?php echo $dt_login; ?></td>
							<td><?php echo $status_str; ?></td>
						</tr>
						<?php
					}
				}
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
	$('#usersTable').DataTable({
		responsive: true,
		searching: true,
	});
});
</script>
</body>
</html>
