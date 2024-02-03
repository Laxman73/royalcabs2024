<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once "includes/common_front.php";

include 'includes/_send_mail.php';

$success_url='success.php';

$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' ", '3');

$Loc_ds=0;

$vehicle_id=(isset($_POST['vehicle_id']))?db_input2($_POST['vehicle_id']):'';
$cmbfrom=(isset($_POST['cmbfrom']))?db_input2($_POST['cmbfrom']):'';
$cmbto=(isset($_POST['cmbto']))?db_input2($_POST['cmbto']):'';
$date=(isset($_POST['date']))?db_input2($_POST['date']):'';
$cmbtime=(isset($_POST['cmbtime']))?db_input2($_POST['cmbtime']):'';
$cmbpasses=(isset($_POST['cmbpasses']))?db_input2($_POST['cmbpasses']):'';
$fname=(isset($_POST['fname']))?db_input2($_POST['fname']):'';
$mobile_num=(isset($_POST['mobile_num']))?db_input2($_POST['mobile_num']):'';
$email=(isset($_POST['email']))?db_input2($_POST['email']):'';


// Google reCAPTCHA API keys settings 
$secretKey     = '6LfUmlQpAAAAAJoTthQc6mEoCWaW26TD-rDYb0_2'; 


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


            }else{
              header('location:index.php');
              exit;
            }

}else{
  header('location:index.php');
  exit;
}



$VEHICLE_TARIFF_ARR=GetDataFromID('tariff','iVehicleID',$vehicle_id," and cStatus='A' ");	
$base_distance_KM=$VEHICLE_TARIFF_ARR[0]->fBaseDistanceInKM;
$base_distance_rate=$VEHICLE_TARIFF_ARR[0]->fBaseFare;
$base_additional_KM=$VEHICLE_TARIFF_ARR[0]->fAdditionalPerKM;

if (!empty($cmbfrom) && !empty($cmbto)){
//$cartArr['data']['location']['cmbfrom']=$cmbfrom;
//$cartArr['data']['location']['cmbto']=$cmbto;
$Loc_ds=GetTotalDistance($cmbfrom,$cmbto,28);
}
$subtotal=GetFinalPrice($Loc_ds,$vehicle_id,$TIME_CAR_ARR[$cmbtime]);
$total=$subtotal+($subtotal*5/100);
$r = sql_query(
		"SELECT v.*, gvt.vName AS TypeName, gvt.vSeats, tar.fBaseFare, CONCAT('~',GROUP_CONCAT(vca.iVCatID SEPARATOR '~'),'~') AS VCatIDs, own.vName AS OwnName, own.vContactMobile, own.vContactMobile2 
			FROM vehicle AS v 
			LEFT JOIN vehicle_cat_assoc AS vca ON (vca.iVehicleID=v.iVehicleID) 
			LEFT JOIN gen_vehicle_type AS gvt ON (gvt.iVTypeID=v.iVTypeID) 
			LEFT JOIN tariff AS tar ON (tar.iVehicleID=v.iVehicleID AND tar.iVCatID=1) 
			LEFT JOIN owner AS own ON (own.iOwnerID=v.iOwnerID) 
			WHERE v.iVehicleID=$vehicle_id 
			GROUP BY v.iVehicleID 
			HAVING VCatIDs LIKE '%~1~%' 
			ORDER BY v.iVehicleID DESC "
	);
	$vehData = sql_num_rows($r)>0?sql_fetch_object($r):$vehData;
// 	DFA($vehData);
// 	exit;

LockTable('booking');
$BID=NextID('iBookingID','booking');
$_q="insert into booking(iBookingID,iVehicleID,iVCatID,dtFrom,dtTo,iLocationID_pick,iLocationID_drop,fDistance,fBookingValue,fBaseDistance,fAdditionalPerKM,cWaiting,iWaitingHours,fDiscount,fSGST,fCGST,fPayable,dtBooking,vFname,vEmail,cPaid,vMobile,iHours,iPax,cStatus) 
values('$BID','$vehicle_id','1','$date','$date','$cmbfrom','$cmbto','$Loc_ds','$subtotal','$base_distance_KM','$base_additional_KM',0,0,NULL,'9','9','$total',NOW(),'$fname','$email','N','$mobile_num','$cmbtime','$cmbpasses','D')";
$_r=sql_query($_q,"INSERT_BOOKING_ERR!");
UnlockTable();

$amonut_inPaise=$total*100;

$vehicle_name=$vehData->vName;

// Compose email content
$to = "info@royalcabs.com"; // Replace with your email address

//Subject for admin
$subject = 'Rental Booking for ' . $vehData->vName . ' ' . date("d-m-Y", strtotime($date)); // any subject
//subject fro user
$subject_user = 'Thank You for booking on Royal Cabs Goa';
//Message for admin
$str = "<div style='font-family: Arial;font-size: 12px;padding-left: 10px;padding-right: 10px;color: #000000;text-align: justify;line-height: 20px;'>";
$str .= "Sir/Madam,<br><br>The following are the details of your booking.<br><br>";
$str .= "<b>Customer Details </b><br>";
$str .= "<b>Name: </b>" . $fname;
$str .= "<br>";
$str .= "<b>Email: </b>" . $email;
$str .= "<br>";
$str .= "<b>Contact No: </b>" . $mobile_num;
$str .= "<br><br>";

$str .= "<b>Your Booking Details</b><br>";
$str .= "<b>Pickup Details: </b>";
$str .= "<br>";
$str .= "" . $LOC_ARR[$cmbfrom];
$str .= "<br>";
$str .= "" . date("d-m-Y", strtotime($date)) . " " . $TIME_CAR_ARR[$cmbtime];
$str .= "<br><br>";

$str .= "<b>Drop off Details: </b>";
$str .= "<br>";
$str .= "" . $LOC_ARR[$cmbto];
$str .= "<br>";
//$str .= "" . date("d-m-Y", strtotime($date)) . " " . $time_drop;
$str .= "<br><br>";

$str .= "<b>Vehicle Name</b>";
$str .= "<br>";
$str .= "" . $vehData->vName;
$str .= "<br>";

//message for user
$replystr = "<div>Hi, $fname, <br>Thank you for booking with us. Following are your booking details:<br><b>Vehicle Name: </b> $vehicle_name <br><b>Pick Up Details</b><br><b>Location: </b> $LOC_ARR[$cmbfrom] <br><b>Date: </b> ".date('d-m-Y', strtotime($date))." <br><b>Time: </b> $TIME_CAR_ARR[$cmbtime] <br><br><b>Drop Off Details</b> <br><b>Location: </b> $LOC_ARR[$cmbto] <br><br><br>Regards,<br><br>Royal Cabs Goa</div>";



//Send_mail('info@royalcabs.com','Royal Cabs','info@royalcabs.com',$email,'','',$subject,$str,$subject_user,$replystr,'success.php','');
//echo $replystr;
//   exit;
				

//subject fro user
//$subject_user = 'Thank You for booking on Bikes For Rent';

// header('location:'.$success_url);
// exit;

global $hash;

$secret_key = "12BDCC6A131F4D0292F336C2E2D785E1";
$access_code="103774d5-d771-4e37-83ac-2d70abfa980e";              
                                          
function Hex2String($hex)
{
    $string='';
    
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    
    return $string;
}
                                          

$data = [
  "merchant_data"=> [
      "merchant_id"=> "325765",
      "merchant_access_code"=> "$access_code",
      "merchant_return_url"=> "https://royalcabsgoa.com/webhook_plural.php",
      "unique_merchant_txn_id"=> "$BID"
    ],
    "payment_data"=> [
      "amount_in_paisa"=> $amonut_inPaise
      
    ],
    "customer_data"=> [
      "mobile_number"=> "7350807077",
      "email_id"=> "darshan@teaminertia.com"
    ],
    "txn_data"=> [
    "navigation_mode"=> 2,
    "payment_mode"=> "1,3,10",
    "transaction_type"=> 1
    ]
  
];

$jsonRequest = json_encode($data);

$base64EncodedRequest = base64_encode($jsonRequest);

//echo $base64EncodedRequest;

//echo '<br>';

$request=array('request'=>$base64EncodedRequest);
$JSON_REQUEST=json_encode($request);

$secret_key=Hex2String($secret_key);
$strFormdata = $base64EncodedRequest;
$hash = strtoupper(hash_hmac('sha256', $strFormdata, $secret_key));//creating Hash

//echo 'x/verify '.$hash;
//exit;


// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://pinepg.in/api/v2/accept/payment');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $JSON_REQUEST);
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Cache-Control: no-cache';
$headers[] = 'X-Verify:'. $hash;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$decodeJson = json_decode($result);
//DFA($decodeJson);

if($decodeJson->response_code=='1')
{
  header('location:'.$decodeJson->redirect_url);
  exit;
}else{

exit;
}



?>