<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "includes/common_front.php";
include "includes/_send_mail.php";

// DFA($_POST);
// exit;

// Array
// (
//     [srch_mode] => QUERY
//     [name] => Laxman Kubal
//     [email] => darshan@teaminertia.com
//     [mobile] => 7350807077
//     [vtype] => 1
//     [cmbfrom] => 48
//     [cmbto2] => 33
//     [txtdate] => 2024-01-23
//     [cmbpasses2] => 3
//     [msg] => tgfryhrgf
//     [g-recaptcha-response] => 03AFcWeA4v6ZbNzRMV2cLitTHJ6wG0WG9fWJgfpMYJXmexsM7k_Tyk-smFul-jDBSg0dvoGrwNGAThO_a6mKhHLC2BMRjJx7pjMl522i9cunrg6ZJuVTVtXguUE3XfRgGMJRdzQO238SZNAnVtGHwVN3L0-QCbxFQM6htTfCZo2lJq9WjzSqHWxsfvB_TbbCfnX09LrzlBhUW8IrrzX2YDUYuc0KMUaac5rvIUk9eorpscpEc9ve0v4j4h7xdggxJb6r6ttajWiB1ZfOwEcGrHzafdj7cJwcFhM5zyGGMqDrWRry8Oc7K-pf2GFhLWd8qe6Hhf0sRmc-1DK1Mg4MPJn-Kuo1edQdUfPHE9UiIZX2ryd3e4RmVvbi7Z0F9TnjGt7OQ8Yi1cVYohzq6cMlGaIQJaDBifqm7lt0k_gS3xALXgs5ijU7P1rzr1ny0A-2CvBV4ctk1lDBNPXbWDZVkP_KKXwd3U3fuq8iHiZ47Dx3RFu7BDsbnn5C4Y1m_KdHaFzIkTxiZIo2E6mvDPUO8I2DGKL9l_L0iQAMZLozCFWpcvOEvMIiY9H4aQmiieIudWXagCuoZ9YcX2qw9kp7I5_JxyHeDcEAzs68YhmW9aujlSF7_hfgjmrg7ZYXXRdTcemO-y7wNfNBbAm0NtTtdoJuTYOQoHxgGMI_gYsLUpTbkaAamIJvV6Qmfom1gyPS2M5O6v5k-M2EAC8vhESkFjReQ8CRj-IgShU9ZkfPDVoBJG4K4X1PhodXNjGqMbJ5-7iaCqxpjie0Wxcu1-MbIGZl8tNDO2Y04dnoZUHnuxCZNHXm4HRZyub-veUQdH9dZLMIfpZGxYgXxjOlsCiTMCaAlX5_zz4SRFhvC9GQLaotJVgOEDOXCS8GiXspsaIDi9xJkcHiNHDZq4hA69wFqNoiObc_aCRhDmWi_faUFie1NV8dIEFhvNE8GGpZU-9LUFJ7pAWmapYtFZssqHIe1OB9mlW8ylLd-rnXxvKOgSQt2Smy2mQbHqdi2cfJCL-BQUJH0jz8RbnkIf_bK3yLvbgr39i8BxiooXjV4XNetLBRmhqEfvTkiFAO_MnIDGc1qvbVEfRIUiP4rwbUNs6pGE9s_sM2XzCpFq9MSdt4RViZjGyTBSAnZrfpiHYkSIBz4vqWpWPMYR0Aoj4Kwm5zl_rYg6zRyhchaDN4hPKeNgAEGt68eiopzTSRscyUKvCEvk6QepkDWXLEEF_hj6h8Av7fI5v0aLCkzoq2nL8g4Ozk_fstLYeO5pgDNRiYd3jhIZ71P7St7x12Sd0v3cFTTQe-Djf2fxgxBcHq-XLYZvIx5a-lm1YV9F2MFNWJobdOIuWiWZSzXrSYv05819AcIkXNQf0aiOhhAYPZmF3u-7dsuiIvYdc8fHTKhdS4ADKE9Ts3QiYYkol6thd556OiEIHwsaDVKdQdw9WNUQlFExWsHbOGAGp8JhoeRxxb8pM1xv8oORjnuwiCpnwJwhRppBlg_UQe_kmDx_3C2kDxcoTzirNzUmOkQGpXZLCAjfLGB_4kGC6qHD5PWz8V8-AzPZiG3WtLfFXIb2x3NiY7saq-U4CAJ3Goimito
// )

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
$message .= "<b>Vehicle: </b>$VEHILCLE_ARR[$vtype]<br>";
$message .= "<b>From: </b>$LOC_ARR2[$cmbfrom]<br>";
$message .= "<b>Pax: </b>$PASS_ARR[$cmbpasses]<br>";
$message .= "<b>To: </b>$LOC_ARR[$cmbto]<br>";
$message .= "<b>Date: </b>$txtdate<br>";
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


