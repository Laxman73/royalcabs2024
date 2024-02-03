<?php
include "../includes/common.php";
include "../includes/thumbnail.php";
require_once('../includes/ti-salt.php');

$PAGE_TITLE2 = 'Users';

$PAGE_TITLE .= $PAGE_TITLE2;

$disp_url = 'users_disp.php';
$edit_url = 'users_edit.php';

if(isset($_GET['mode'])) $mode = $_GET['mode'];
elseif(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode ='A';

if(isset($_GET['id'])) $txtid = $_GET['id'];
elseif(isset($_POST['txtid'])) $txtid = $_POST['txtid'];
else $mode ='A';

if($mode=='A')
{
	$txtid ='0';
	$txtname ='';
	$txtemail ='';
	$txtphone ='';
	$txtusername='';
	$txtpassword='';
	$file_pic  = "";
	$cmblevel = '4';
	$rdstatus = 'A';

	$modalTITLE ='New '.$PAGE_TITLE2;
	$form_mode ='I';
	$code_flag = '0';
}
else if($mode=='I')
{
	$txtid = NextID('iUserID', 'users');
	$txtname = db_input($_POST['txtname']);
	$txtemail = db_input($_POST['txtemail']);
	$txtphone = db_input($_POST['txtphone']);
	$txtusername= db_input($_POST['txtusername']);
	$txtpassword = db_input(htmlspecialchars_decode($_POST['txtpassword']));
	$cmblevel= db_input($_POST['cmblevel']);
	$rdstatus =  db_input($_POST['rdstatus']);

	$code_flag = IsUniqueEntry('iUserID', $txtid, 'vUName', $txtusername, 'users');
	if(!$code_flag) $txtusername = SetCode($txtname,'B');

	$q = "INSERT INTO users (iUserID, vName, vUName, vPassword, vEmail, vPhone, vPic, vSignature, iLevel, dtLastLogin, vLastLoginIP, cStatus, vToken, cActive) 
	VALUES ($txtid, '$txtname', '$txtusername', '$txtpassword', '$txtemail', '$txtphone', '', '', '$cmblevel', NULL, '', '$rdstatus', '', 'N')";
	$r = sql_query($q, "USERS.123");

	$_SESSION[PROJ_SESSION_ID]->success_info = "User Details Successfully Inserted";
}
else if($mode=='E')
{
	$dataArr = GetDataFromID("users", "iUserID", $txtid);
	if(empty($dataArr))
	{
		header("location: $disp_url");
		exit;
	}
	
	$txtname = db_output($dataArr[0]->vName);
	$txtemail = db_output($dataArr[0]->vEmail);
	$txtphone = db_output($dataArr[0]->vPhone);
	$txtusername= db_output($dataArr[0]->vUName);
	$txtpassword= db_output($dataArr[0]->vPassword);
	$cmblevel= db_output($dataArr[0]->iLevel);
	$file_pic = db_output($dataArr[0]->vPic);
	$rdstatus= db_output($dataArr[0]->cStatus);

	$modalTITLE ='Edit '.$PAGE_TITLE2;
	$form_mode ='U';
	$code_flag = '1';
}
else if($mode=='U')
{
	$pass='';
	$txtid = db_input($_POST['txtid']);
	$txtname = db_input($_POST['txtname']);
	$txtemail = db_input($_POST['txtemail']);
	$txtphone = db_input($_POST['txtphone']);
	$txtusername= db_input($_POST['txtusername']);
	$txtpassword = htmlspecialchars_decode($_POST['txtpassword']);
	$cmblevel= db_input($_POST['cmblevel']);
	$rdstatus =  db_input($_POST['rdstatus']);

	$code_flag = IsUniqueEntry('iUserID', $txtid, 'vUName', $txtusername, 'users');
	if(!$code_flag) $txtusername = SetCode($txtname,'B');

	if(!empty($txtpassword))
		$pass = " , vPassword='".$txtpassword."'";

	$values = " vName='$txtname', vUName='$txtusername', vEmail='$txtemail', vPhone='$txtphone', iLevel='$cmblevel', cStatus='$rdstatus' ".$pass;
	$QUERY = UpdataData('users',$values, "iUserID=$txtid");
	$_SESSION[PROJ_SESSION_ID]->success_info = "User Details Successfully Updated";
}
elseif($mode=='DELIMG')
{
	$txtid = $_GET['id'];
	$file_name = GetXFromYID("select vPic from users where iUserID=$txtid");

	if(!empty($file_name))
		DeleteFile($file_name, USER_UPLOAD);

	UpdateField('users', 'vPic', '', "iUserID=$txtid");
	$_SESSION[PROJ_SESSION_ID]->success_info = "Image Deleted Successfully";
	
	header("location: $edit_url?mode=E&id=$txtid");
	exit;
}
if($mode == "I" || $mode == "U")
{
	if(is_uploaded_file($_FILES["file_pic"]["tmp_name"]))
	{
		$uploaded_pic = $_FILES["file_pic"]["name"];
		$name = basename($_FILES['file_pic']['name']);
		$file_type = $_FILES['file_pic']['type'];
		$size = $_FILES['file_pic']['size'];
		$extension = substr($name, strrpos($name, '.') + 1);

		if(IsValidFile($file_type, $extension, 'P') && $size<=3000000)
		{
			$pic_name = GetXFromYID('select vPic from users where iUserID='.$txtid);

			if(!empty($pic_name))
				DeleteFile($pic_name, USER_UPLOAD);

			if(RANDOMIZE_FILENAME==0)
			{
				$newname = NormalizeFilename($uploaded_pic); // normalize the file name
				$pic_name = $txtid. "_UserProfile".$newname;
			}
			else
				$pic_name = $txtid.'_UserProfile'.NOW3.'.'.$extension;

			$tmp_name = "TMP_". $pic_name;

			$dir = opendir(USER_UPLOAD);
			copy($_FILES["file_pic"]["tmp_name"], USER_UPLOAD.$tmp_name);
			ThumbnailImage($tmp_name,$pic_name, USER_UPLOAD, 640, 480);
			DeleteFile($tmp_name, USER_UPLOAD);
			closedir($dir);   // close the directory

			$q = "update users set vPic='$pic_name' where iUserID=$txtid"; 
			$r = sql_query($q, 'User.E.126');
		}
		else
		{
			if($size>3000000)
				$_SESSION[PROJ_SESSION_ID]->error_info = "Profile Image Could Not Be Uploaded as the File Size is greate then 3MB";
			elseif(!in_array($extension,$IMG_TYPE))
				$_SESSION[PROJ_SESSION_ID]->error_info = "Please only upload files that end in types: ".implode(',',$IMG_TYPE).". Please select a new file to upload and submit again.";
		}
	}

	header("location: $edit_url?mode=E&id=$txtid");
	exit;
}
if($mode=='D')
{
	$txtid = $_GET['id'];

	$QUERY = DeleteData("users", "iUserID", $txtid);
	$_SESSION[PROJ_SESSION_ID]->success_info = "User Details Deleted Successfully";
	
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
  <?php //include "loadtheme.settings.php"; ?>
  <div class="app-main">
    <?php include "load.menu.php"?>
    <!-- load side menu: end -->
    <div class="app-main__outer">
      <div class="app-main__inner">
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
        <div class="row col-md-12">
          <div class="main-card mb-3 card col-md-12">
            <div class="card-header-tab card-header">
              <div class="card-header-title font-size-lg text-capitalize font-weight-normal"> <i class="header-icon pe-7s-users mr-3 text-muted opacity-6"> </i><?php echo $modalTITLE; ?> </div>
            </div>
            <div class="card-body">
              <form class="" id="users_frm" method="post" action="<?php echo $edit_url; ?>" enctype="multipart/form-data">
                <input type="hidden" name="txtid" id="txtid" value="<?php echo $txtid; ?>">
                <input type="hidden" name="code_flag" id="code_flag" value="<?php echo $code_flag; ?>">
                <input type="hidden" name="mode" id="mode" value="<?php echo $form_mode; ?>">
                <div class="col-md-12">
                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtname" class="">Name</label>
                        <input name="txtname" id="txtname" type="text" value="<?php echo $txtname; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtemail" class="">Email</label>
                        <input name="txtemail" id="txtemail" type="email" value="<?php echo $txtemail; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtusername" class="">Username</label>
                        <input name="txtusername" id="txtusername" onKeyUp="IsCodeUnique(<?php echo $txtid; ?>, this, 'USERS');" onBlur="IsCodeUnique(<?php echo $txtid; ?>, this, 'USERS');" type="text" value="<?php echo $txtusername; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtpassword" class="">Password</label>
                        <input name="txtpassword" id="txtpassword"  type="password" value="" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="txtphone" class="">Phone</label>
                        <input name="txtphone" id="txtphone" type="text" onKeyPress="return numbersonly(event);" value="<?php echo $txtphone; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="cmblevel" class="">Level</label>
                        <?php echo FillCombo($cmblevel, 'cmblevel', 'COMBO', 'Y', $USER_LEVEL_ARR, 'onchange="ShowReference(this.value);"', 'form-control'); ?> </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <div class="position-relative form-group">
                        <label for="rdstatus" class="">Status</label>
                        <?php echo FillRadios($rdstatus, 'rdstatus', $STATUS_ARR); ?> </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="avatar-icon-wrapper btn-hover-shine mb-2">
                      <label for="file_pic" class="">Profile Image</label>
                      <div class="avatar-icon rounded" style="width: 200px; height: 200px;">
                        <?php 
						if(IsExistFile($file_pic, USER_UPLOAD))
						{
							$src = USER_PATH.$file_pic;
						}
						else
						{
						  	$src = NOIMAGE;
						}
						?>
                        <img id="imgDiv" src="<?php echo $src; ?>" alt="Avatar"> </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <?php 
					if(IsExistFile($file_pic, USER_UPLOAD))
					{
					  echo '<button type="button" onclick="ConfirmDelete(\'Profile Image\',\''.$edit_url.'?mode=DELIMG&id='.$txtid.'\');" class="mt-2 btn btn-danger">Remove</button>';
					}
                    ?>
                    <label for="file-upload" class="custom-file-upload mt-3 btn btn-warning"> <i class="fa fa-cloud-upload"></i> Browse </label>
                    <input id="file-upload" name="file_pic" type="file" class="form-control-file" onChange="PreviewImage(this)">
                  </div>
                  <button type="button" onClick="location.href='<?php echo $disp_url; ?>';" class="mt-2 btn btn-secondary">Back</button>
                  <button type="submit" class="mt-2 btn btn-success">Save</button>
                  <?php 
					if($mode=='E') {
					  echo '<button type="button" onclick="ConfirmDelete(\'User\',\''.$edit_url.'?mode=D&id='.$txtid.'\');" class="mt-2 btn btn-danger">Delete</button>';
					}
				?>
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
$( document ).ready(function() {
	$("#users_frm").submit(function(){
		var ret = true;
		var md = "<?php echo $mode ?>";
		var n = $(this).find('#txtname');
		var e = $(this).find('#txtemail');

		var u = $(this).find('#txtusername');
		var p = $(this).find('#txtpassword');
		var code = $(this).find('#code_flag');

		if($.trim(n.val()) == '')
		{
			ShowError(n,"Please enter name");
			ret= false;
		}

		if($.trim(u.val()) == '')
		{
			ShowError(u,"Please enter username");
			ret= false;
		}

		if($.trim(e.val()) == '')
		{
			ShowError(e,"Please enter email");
			ret= false;
		}

		if(md!='E')
		{
			if($.trim(p.val()) == '')
			{
				ShowError(p,"Please enter password");
				ret= false;
			}
		}

		if($.trim(p.val()) != '')
		{
			p_str = GenerateNewPass(b64_md5(p.val()));
			p.val(p_str);
		}

		if(code.val()=='0' && $.trim(u.val())!='')
		{
			ShowError( u, "Username already taken, <br>Please select another username")
			ret= false;
		}

		return ret;
	});

	level = "<?php echo $cmblevel; ?>";
	if(level=='2')
		$('#refDiv').show();
	else
		$('#refDiv').hide();
	
});

function ShowReference(lvlVal)
{
	if(lvlVal=='2')
		$('#refDiv').show();
	else
		$('#refDiv').hide();
}
</script>
</body>
</html>
