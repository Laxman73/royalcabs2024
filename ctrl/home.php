<?php
include "../includes/common.php";
$PAGE_TITLE .= 'Dashboard';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo $PAGE_TITLE; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
<meta name="description" content="This is an example dashboard created using build-in elements and components.">
<!-- Disable tap highlight on IE -->
<meta name="msapplication-tap-highlight" content="no">
<link href="dist/assets/css/base.min.css" rel="stylesheet">
<link href="dist/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
  <!-- page header:: start -->
  <?php include "load.header.php"; ?>
  <!-- page header:: end -->
  <!-- theme settings:: start -->
  <?php //include "loadtheme.settings.php"; ?>
  <!-- theme settings:: end -->
  <div class="app-main">
    <!-- load side menu:: start -->
    <?php include "load.menu.php"?>
    <!-- load side menu: end -->
    <div class="app-main__outer">
      <div class="app-main__inner">
        <div class="app-inner-layout">
          <div class="tabs-animation">
            <div class="row">
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
</body>
</html>
<!--Apex Charts-->
<script type="text/javascript" src="../scripts/common.js"></script>