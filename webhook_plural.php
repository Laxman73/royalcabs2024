<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once "includes/common_front.php";
include 'includes/_send_mail.php';
date_default_timezone_set('Asia/Kolkata');
$success_url='success.php';
$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' ", '3');
//DFA($_POST);

// Array
// (
//     [pine_pg_transaction_id] => 251029742
//     [amount_in_paisa] => 1000
//     [merchant_id] => 325765
//     [unique_merchant_txn_id] => Rddd887823
//     [pine_pg_txn_status] => 4
//     [txn_response_code] => 1
//     [txn_completion_date_time] => 25/11/2023 10:46:05 AM
//     [payment_mode] => 10
//     [txn_response_msg] => SUCCESS
//     [merchant_access_code] => 103774d5-d771-4e37-83ac-2d70abfa980e
//     [acquirer_name] => KOTAK_SETU
//     [captured_amount_in_paisa] => 1000
//     [refund_amount_in_paisa] => 0
//     [udf_field_1] => 
//     [udf_field_2] => 
//     [udf_field_3] => 
//     [udf_field_4] => 
//     [rrn] => 1700889330713434512
//     [Acquirer_Response_Code] => SUCCESS
//     [Acquirer_Response_Message] => SUCCESS
//     [parent_txn_status] => 
//     [parent_txn_response_code] => 
//     [parent_txn_response_message] => 
//     [dia_secret] => E0D5406CE55EBDCB16B674ED8990EFF232148296F4B1487523C1DDEF66C8AE2A
//     [dia_secret_type] => SHA256
// )


$response=$_POST['txn_response_code'];
$pine_pg_transaction_id=$_POST['pine_pg_transaction_id'];
$unique_merchant_txn_id=$_POST['unique_merchant_txn_id'];
$amount_in_paise=$_POST['captured_amount_in_paisa'];
$AMT=$amount_in_paise/100;
if($response==1)
{
    LockTable('payments');
    $PID=NextID('iPayID','payments');
    $_q="INSERT INTO payments(iPayID, iBookingID, fAmount, dtAdded, vPine_pg_transaction_id, iPaymode, cStatus) VALUES ('$PID','$unique_merchant_txn_id','$AMT',NOW(),'$pine_pg_transaction_id','1','A')";
    $_r=sql_query($_q,"");
    UnlockTable();
    $_q2="select * from booking where iBookingID='$unique_merchant_txn_id' ";
    $_r2=sql_query($_q2,"");
    if(sql_num_rows($_r2))
    {
         sql_query("update booking set cPaid='Y',cStatus='A' where iBookingID='$unique_merchant_txn_id' ");
         $BOOKING_DATA=GetDataFromCOND('booking'," and iBookingID='$unique_merchant_txn_id' ");
         $vehicle_id=$BOOKING_DATA[0]->iVehicleID;
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
        $Bdate=$BOOKING_DATA[0]->dtBooking;
        $fname=$BOOKING_DATA[0]->vFname;
        $email=$BOOKING_DATA[0]->vEmail;
        $mobile_num=$BOOKING_DATA[0]->vMobile;
        $cmbfrom=$BOOKING_DATA[0]->iLocationID_pick;
        $cmbto=$BOOKING_DATA[0]->iLocationID_drop;
        $cmbtime=$BOOKING_DATA[0]->iHours;
        $PickUpdate=$BOOKING_DATA[0]->dtFrom;

        
        // Compose email content
        $to = "info@royalcabs.com"; // Replace with your email address

        //Subject for admin
        $subject = 'Rental Booking for ' . $vehData->vName . ' ' . date("d-m-Y", strtotime($Bdate)); // any subject
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
        $str .= "" . date("d-m-Y", strtotime($PickUpdate)) . " " . $TIME_CAR_ARR[$cmbtime];
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
        $replystr = "<div>Hi, $fname, <br>Thank you for booking with us. Following are your booking details:<br><b>Vehicle Name: </b> $vehData->vName <br><b>Pick Up Details</b><br><b>Location: </b> $LOC_ARR[$cmbfrom] <br><b>Date: </b> ".date('d-m-Y', strtotime($Bdate))." <br><b>Time: </b> $TIME_CAR_ARR[$cmbtime] <br><br><b>Drop Off Details</b> <br><b>Location: </b> $LOC_ARR[$cmbto] <br><br><br>Regards,<br><br>Royal Cabs Goa</div>";

        Send_mail('info@royalcabs.com','Royal Cabs','info@royalcabs.com',$email,'','',$subject,$str,$subject_user,$replystr,'','');

    }
    header('location:'.$success_url);
    exit;
    
}else{
    header('location:failure.php');
    exit;
}

?>