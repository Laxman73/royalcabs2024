<?php
include "../includes/common.php";

$PAGE_TITLE2 = 'SEO Settings';

$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'seo_set_disp.php';

if(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode ='A';

$modalTITLE = $PAGE_TITLE2;

if($mode=='A')
{
	$dataArr = GetDataFromCOND("seo_settings");
	$txtSEOTitle = db_output($dataArr[0]->vSEOTitle);
	$txtSEOKeywords = db_output($dataArr[0]->vSEOKeywords);
	$txtSEODesc = db_output($dataArr[0]->vSEODesc);
}
else if($mode=='U')
{
	$txtSEOTitle = db_input_default($_POST['txtSEOTitle'], 'v');
	$txtSEOKeywords = db_input_default($_POST['txtSEOKeywords'], 'v');
	$txtSEODesc = db_input_default($_POST['txtSEODesc'], 'v');

	sql_query("UPDATE seo_settings SET vSEOTitle=$txtSEOTitle, vSEOKeywords=$txtSEOKeywords, vSEODesc=$txtSEODesc", "seo_set_disp.E.001");

	$_SESSION[PROJ_SESSION_ID]->success_info = "SEO Settings Successfully Updated";
	header("location: $disp_url");
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
  <div class="app-main">
    <?php include "load.menu.php"?>
    <!-- load side menu: end -->
    <div class="app-main__outer">
      <div class="app-main__inner">
        <div id="LBL_INFO"><?php echo $sess_info_str; ?></div>
        <div class="row col-md-12">
          <div class="main-card mb-3 card col-md-12">
            <div class="card-header-tab card-header">
              <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-browser mr-3 text-muted opacity-6"> </i><?php echo $modalTITLE; ?> </div>
            </div>
            <div class="card-body">
              <form id="chngpass_frm" name="chngpass_frm" method="post" action="<?php echo $disp_url; ?>">
                <input type="hidden" name="mode" id="txtid" value="U">
                <div class="col-md-12">
                  <div class="form-row">
                    <div class="col-md-12">
                      <div class="position-relative form-group">
                        <label for="txtSEOTitle" class="">SEO Title</label><b></b>
                        <input name="txtSEOTitle" id="txtSEOTitle" type="text" value="<?php echo $txtSEOTitle; ?>" class="form-control">
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtSEOKeywords" class="">SEO Keywords</label><b></b>
						<textarea name="txtSEOKeywords" id="txtSEOKeywords" class="form-control"><?php echo $txtSEOKeywords; ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtSEODesc" class="">SEO Description</label><b></b>
						<textarea name="txtSEODesc" id="txtSEODesc" class="form-control"><?php echo $txtSEODesc; ?></textarea>
                      </div>
                    </div>
                  </div>

                  <button type="button" onClick="location.href='<?php echo $disp_url; ?>';" class="mt-2 btn btn-secondary">Back</button>
                  <button type="submit" value="submit" class="mt-2 btn btn-success">Save</button>
                </div>
              </form>
            </div>
          </div>
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
<script type="text/javascript" src="../scripts/ajax.js"></script>
<script type="text/javascript" src="../scripts/common.js"></script>
<script type="text/javascript" src="../scripts/md5.js"></script>
<script type="text/javascript">
</script>
</body>
</html>
