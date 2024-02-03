<?php
$NO_REDIRECT = 1;
require_once('../includes/common.php');

$PAGE_TITLE .= 'Login';

$done ='';
if(isset($_GET['err']) && is_numeric($_GET['err']))
{
    $done = $_GET['err'];
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo $PAGE_TITLE; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
<link href="dist/assets/css/base.min.css" rel="stylesheet">
</head>
<body>
<div class="app-container app-theme-white body-tabs-shadow">
  <div class="app-container">
    <div class="h-100">
      <div class="h-100 no-gutters row">
        <div class="d-none d-lg-block col-lg-4">
          <div class="slider-light">
            <div class="slick-slider">
              <div>
                <div class="position-relative h-100 d-flex justify-content-center align-items-center" tabindex="-1">
                  <div class="slide-img-bg" style="background-image: url('../images/ctrl-bg.png');"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
          <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
            <div class="app-logo" style="background: url(../images/ctrl-logo.png) no-repeat; height: 100px; width: auto; margin-bottom: unset;"></div>
            <h4 class="mb-0">
              <div id="LBL_INFO"><?php echo $sess_info_str; ?></div>
              <span>Please sign in to your account.</span> </h4>
            <div class="divider row"></div>
            <div>
              <form class="" id="login" method="post" action="auth.php">
                <div class="form-row">
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label for="exampleEmail" class="">Username</label>
                      <input name="txtusername" id="txtusername" placeholder="Username here..." type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="position-relative form-group">
                      <label for="examplePassword" class="">Password</label>
                      <input name="txtpassword" id="txtpassword" placeholder="Password here..." type="password" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="divider row"></div>
                <div class="d-flex align-items-center">
                  <div class="ml-auto">
                    <!-- <a href="javascript:void(0);" class="btn-lg btn btn-link">Recover Password</a> -->
                    <button type="submit" class="btn btn-success btn-lg">Login to Dashboard</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="../scripts/jquery-3.4.1.js"></script>
<?php include "scripts.php"; ?>
<script type="text/javascript" src="../scripts/ajax.js"></script>
<script type="text/javascript" src="../scripts/common.js"></script>
<script type="text/javascript" src="../scripts/md5.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	$('#txtusername').focus();
	done = "<?php echo $done; ?>";

	if(done !='')
		$('#LBL_INFO').html(NotifyThis('Invalid Username or Password','error'));

	$('#login').submit(function(){
		err = 0;
		ret_val = true;

		var u = $(this).find('#txtusername');
		if($.trim(u.val()) == '') {
			ShowError( u, "Username cannot be empty");
			err++;
		}

		var p = $(this).find('#txtpassword');
		if($.trim(p.val()) == '') {
			ShowError( p, "Password cannot be empty");
			err++;
		}
		else
		{
			p_str = GenerateNewPass(b64_md5(p.val()));
			p.val(p_str);
		}

		if(err > 0)
		{
			ret_val = false;
		}

		return ret_val;
	});
});
</script>
</body>
</html>
