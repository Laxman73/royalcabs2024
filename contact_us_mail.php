<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "includes/common_front.php";
include "includes/_send_mail.php";


// Google reCAPTCHA API keys settings 
$secretKey     = '6LfUmlQpAAAAAJoTthQc6mEoCWaW26TD-rDYb0_2'; 

$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' and cArivalpoint!='Y'   order by vName ", '3');
$LOC_ARR2 = GetXArrFromYID("select iLocationID,vName from location where cStatus='A'    order by vName ", '3');
$VEHILCLE_ARR=array('1'=>'Car','2'=>'Coaches');

$cmbfrom=(isset($_POST['cmbfrom']))?db_input2($_POST['cmbfrom']):'';
$cmbpasses=(isset($_POST['cmbpasses2']))?db_input2($_POST['cmbpasses2']):'';
$vtype=(isset($_POST['vtype']))?db_input2($_POST['vtype']):'';
$cmbto=(isset($_POST['cmbto2']))?db_input2($_POST['cmbto2']):'';
$txtdate=(isset($_POST['txtdate']))?db_input2($_POST['txtdate']):'';
$email=(isset($_POST['email']))?db_input2($_POST['email']):'';
$name=(isset($_POST['name']))?db_input2($_POST['name']):'';
$mobile=(isset($_POST['mobile']))?db_input2($_POST['mobile']):'';
$msg=(isset($_POST['msg']))?db_input2($_POST['msg']):'';


if(!empty($_POST['g-recaptcha-response'])){ 
    // Google reCAPTCHA verification API Request 
    $api_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $resq_data = array( 
        'secret' => $secretKey, 
        'response' => $_POST['g-recaptcha-response'], 
        'remoteip' => $_SERVER['REMOTE_ADDR'] 
    ); 

    $curlConfig = array( 
        CURLOPT_URL => $api_url, 
        CURLOPT_POST => true, 
        CURLOPT_RETURNTRANSFER => true, 
        CURLOPT_POSTFIELDS => $resq_data, 
        CURLOPT_SSL_VERIFYPEER => false 
    ); 

    $ch = curl_init(); 
    curl_setopt_array($ch, $curlConfig); 
    $response = curl_exec($ch); 
    if (curl_errno($ch)) { 
        $api_error = curl_error($ch); 
    } 
    curl_close($ch); 

    // Decode JSON data of API response in array 
    $responseData = json_decode($response); 

    // If the reCAPTCHA API response is valid 
    if(!empty($responseData) && $responseData->success){
        
$to = "info@royalcabsgoa.com";
$subject = "Contact us enquiry";

$message = "<div style='font-family: Arial;font-size: 12px;padding-left: 10px;padding-right: 10px;color: #000000;text-align: justify;line-height: 20px;'>";
$message .= "<b>Email: </b>$email<br>";
$message .= "<b>Name: </b>$name<br>";
$message .= "<b>Mobile: </b>$mobile<br>";
$message .= "<b>Message: </b>$msg<br>";

$message .= "</div>";

// echo $message;
// exit;

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: Royal Holidays<darshan@teaminertia.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";
//Send_mail($from,$fromName,$to,$replyto,$CC_str="",$BCC_str="",$subject="",$str="",$subject_user="",$replystr="",$page="",$FILES="")

if(Send_mail('','',$to,'',$email,"darshan@teaminertia.com,vernon@teaminertia.com,shreya@teaminertia.com",$subject,$message,"","","","")){
echo "<script>
window.location.href='http://royalcabsgoa.com/thankyou.php';
</script>";
    exit;
}else{
   
    echo "<script>
alert('Sorry some error occured !!!');
window.location.href='http://royalcabsgoa.com/index.php';
</script>";
    exit;
}

    }else{
      echo "<script>alert('Google recaptcha Error !!!');window.location.href='http://royalcabsgoa.com/index.php';</script>";
      //header('location:index.php');
      exit;
    }

}else{
echo "<script>
alert('Google recaptcha Error !!!');window.location.href='http://royalcabsgoa.com/index.php';</script>";
//header('location:index.php');
exit;
}



 
?>


