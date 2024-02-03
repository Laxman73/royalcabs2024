<?php
include_once "includes/common_front.php";
include "includes/_send_mail.php";

$email=(isset($_POST['email']))?db_input2($_POST['email']):'';
$name=(isset($_POST['name']))?db_input2($_POST['name']):'';
$message=(isset($_POST['message']))?db_input2($_POST['message']):'';
$mobile=(isset($_POST['mobile']))?db_input2($_POST['mobile']):'';
$from=(isset($_POST['from']))?db_input2($_POST['from']):'';
$to=(isset($_POST['to']))?db_input2($_POST['to']):'';
$date=(isset($_POST['date']))?db_input2($_POST['date']):'';
$vehicle_type=(isset($_POST['vehicle_type']))?db_input2($_POST['vehicle_type']):'';
$vehicleid=(isset($_POST['vehicleid']))?db_input2($_POST['vehicleid']):'';


$CAR_ARR = GetXArrFromYID("select v.iVehicleID,v.vName from vehicle v inner join vehicle_cat_assoc vc on v.iVehicleID=vc.iVehicleID and vc.iVCatID=$vehicle_type and v.cStatus='A'", '3');
$VEH_TYPE_ARR=array('1'=>'Car','2'=>'Coach');

//Subject for admin
$subject = 'Disposal Booking for ' . $CAR_ARR[$vehicleid] . ' ' . date("d-m-Y", strtotime($date)); // any subject
//subject fro user
$subject_user = 'Thank You for booking on Royal holidays';
//Message for admin
$str = "<div style='font-family: Arial;font-size: 12px;padding-left: 10px;padding-right: 10px;color: #000000;text-align: justify;line-height: 20px;'>";
$str .= "Sir/Madam,<br><br>The following are the details of your booking.<br><br>";
$str .= "<b>Customer Details </b><br>";
$str .= "<b>Name: </b>" . $name;
$str .= "<br>";
$str .= "<b>Email: </b>" . $email;
$str .= "<br>";
$str .= "<b>Contact No: </b>" . $mobile;
$str .= "<br><br>";

$str .= "<b>Your Booking Details</b><br>";
$str .= "<b>Pickup Details: </b>";
$str .= "<br>";
$str .= "" . $from;
$str .= "<br>";
$str .= "<b>Drop off Details: </b>";
$str .= "<br>";
$str .= "" . $to;
$str .= "<br>";


//message for user
$replystr = "<div>Hi, $name, <br>Thank you for booking with us. Following are your booking details:<br><b> Name: </b> $name <br><b>Vehicle</b>$CAR_ARR[$vehicleid]<br><b>Pick Up Details</b><br><b>Location: </b> $from <br><b>Date: </b> ".date('d-m-Y', strtotime($date))." <br><b>Drop Off Details</b> <br><b>Location: </b> $to <br><br>Regards,<br><br>Royal Holidays</div>";


			
//subject fro user
$subject_user = 'Thank You for booking on Royal Holidays';



// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: Royal Holidays<darshan@teaminertia.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

$toEmail='info@royalcabsgoa.com';

if(Send_mail('','',$toEmail,'',$email,"darshan@teaminertia.com,vernon@teaminertia.com,shreya@teaminertia.com",$subject,$str,"","","","")){
    Send_mail('','',$email,'','',"",$subject_user,$replystr,"","","","");
    //mail($email,$subject_user,$replystr,$headers);
    echo "<script>
    
    window.location.href='http://royalcabsgoa.com/thankyou.php';
    </script>";
    exit;
}else{
    echo "<script>
alert('Sorry some error occured !!!');
window.location.href='http://royalcabsgoa.com/';
</script>";
    exit;
}


?>