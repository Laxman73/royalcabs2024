<?php

//print_r($_POST);

?>

<html>	
	<head>
		<script>
			window.onload = function() {
          		document.forms['pine1'].submit();
			};
		</script>
	</head>
	
	<?php
		global $formdata;
		global $hash;

		$secret_key = "2CT71BH69U05FNVWYCQZW6P1YZMVQ992";	
					
	function Hex2String($hex){
    // Remove spaces if the hex string has spaces
    $hex = str_replace(' ', '', $hex);
    return hex2bin($hex);
}
					
		$secret_key=Hex2String($secret_key);
		
		

		//$ppc_UniqueMerchantTxnID =(int) uniqid(); 
		//echo $ppc_UniqueMerchantTxnID;

		$ppc_MerchantReturnURL ="https://royalcabsgoa.com/pine/ResponsePage.php";
		
		$ppc_DIA_SECRET_TYPE="SHA256" ;  

		if(isset($_POST["ppc_MerchantID"]) && isset($_POST["ppc_Amount"]) && isset($_POST["ppc_MerchantAccessCode"]) && isset($_POST["ppc_UniqueMerchantTxnID"]))// && isset($_POST["ppc_LPC_SEQ"]))
		{
			$formdata = array(	'ppc_MerchantID'			=>	$_POST['ppc_MerchantID'],
								'ppc_Amount'				=>	$_POST['ppc_Amount'],
								'ppc_MerchantAccessCode'	=>	$_POST['ppc_MerchantAccessCode'],
								'ppc_UniqueMerchantTxnID'	=>	$_POST['ppc_UniqueMerchantTxnID'],
								'ppc_NavigationMode'		=>	'2',
								'ppc_TransactionType'		=>	'1',
								'ppc_LPC_SEQ'				=>	'1',
								'ppc_MerchantReturnURL'		=>	$ppc_MerchantReturnURL,
								'ppc_Product_Code'			=>	$_POST['ppc_Product_Code'],
								'ppc_PayModeOnLandingPage'	=>	$_POST['ppc_PayModeOnLandingPage'],
								'ppc_CustomerEmail' 		=>	$_POST['ppc_CustomerEmail'],
								'ppc_CustomerMobile' 		=> 	$_POST['ppc_CustomerMobile'],

						//You can use custom values for the following key parameters:

								'ppc_MerchantProductInfo' 	=> 	'Test_MerchantProductInfo',
								'ppc_CustomerFirstName' 	=> 	'Test_CustomerFirstName',
								'ppc_CustomerLastName' 		=> 	'Test_CustomerLastName',
								'ppc_CustomerAddress1' 		=> 	'Test_CustomerAddress1',
								'ppc_CustomerAddress2' 		=> 	'Test_CustomerAddress2',
								'ppc_CustomerCity' 			=> 	'Noida',
								'ppc_CustomerState' 		=> 	'Uttar Pradesh',
								'ppc_CustomerCountry' 		=> 	'India',
								'ppc_CustomerAddressPIN' 	=> 	'201309',
								'ppc_ShippingFirstName' 	=> 	'Test_ShippingFirstName',
								'ppc_ShippingLastName' 		=> 	'Test_ShippingLastName',
								'ppc_ShippingAddress1' 		=> 	'Test_ShippingAddress1',
								'ppc_ShippingAddress2' 		=> 	'Test_ShippingAddress2',
								'ppc_ShippingCity' 			=> 	'Noida',
								'ppc_ShippingState' 		=> 	'Uttar Pradesh',
								'ppc_ShippingCountry' 		=> 	'India',
								'ppc_ShippingZipCode' 		=> 	'201309',
								'ppc_ShippingPhoneNumber' 	=> 	'1234567890'	
							);
							   
			//sort formdata according to key value
			ksort($formdata);

			$strFormdata="";

			// convert formdata key and value to a single string variable
			foreach ($formdata as $key => $val) {
				 $strFormdata .= $key . "=" . $val . "&"; 
			}
			 
			 // trim last character from string
		   	$strFormdata = substr($strFormdata, 0, -1);
		//	echo $strString."<br />";
			
			
			$hash = strtoupper(hash_hmac('sha256', $strFormdata, $secret_key));
			echo "<br />";
	 //echo "$hash";
		}
	?>
    <!-- test.pinepg.in -->
	<body>
		<form name ="pine1" action="https://uat.pinepg.in/PinePGRedirect/index"  id="pine1" method="POST">
			<div style="margin: =-20px 40px 10px 130px;text-align: center;color: blue">		
				<input type="hidden" name="ppc_MerchantID" value="<?php echo $formdata['ppc_MerchantID']?>" />
				<input type="hidden" name="ppc_Amount" value="<?php echo $formdata['ppc_Amount']?>" />
				<input type="hidden" name="ppc_UniqueMerchantTxnID" value="<?php echo $formdata['ppc_UniqueMerchantTxnID']?>" />
				<input type="hidden" name="ppc_MerchantAccessCode" value="<?php echo $formdata['ppc_MerchantAccessCode']?>" />	
				<input type="hidden" name="ppc_TransactionType" value="<?php echo $formdata['ppc_TransactionType'] ?>" />
				<input type="hidden" name="ppc_NavigationMode" value="<?php echo $formdata['ppc_NavigationMode'] ?>" />
				<input type="hidden" name="ppc_LPC_SEQ" value="<?php echo $formdata['ppc_LPC_SEQ'] ?>" />
				<input type="hidden" name="ppc_MerchantReturnURL" value="<?php echo $formdata['ppc_MerchantReturnURL'] ?>" />	
				<input type="hidden" name="ppc_DIA_SECRET" value="<?php echo $hash ?>" />
				<input type="hidden" name="ppc_Product_Code" value="<?php echo $formdata['ppc_Product_Code']  ?>" />
				<input type="hidden" name="ppc_PayModeOnLandingPage" value="<?php echo $formdata['ppc_PayModeOnLandingPage']  ?>" />
				<input type="hidden" name="ppc_DIA_SECRET_TYPE" value="<?php echo $ppc_DIA_SECRET_TYPE ?>" />	
			    <input type="hidden" name="ppc_MerchantProductInfo" value="<?php echo $formdata['ppc_MerchantProductInfo'] ?>" />	
			    <input type="hidden" name="ppc_CustomerFirstName" value="<?php echo $formdata['ppc_CustomerFirstName']?>" />
			    <input type="hidden" name="ppc_CustomerLastName" value="<?php echo $formdata['ppc_CustomerLastName']?>" />
			    <input type="hidden" name="ppc_CustomerMobile" value="<?php echo $formdata['ppc_CustomerMobile']?>" />
			    <input type="hidden" name="ppc_CustomerEmail" value="<?php echo $formdata['ppc_CustomerEmail']?>" />
			    <input type="hidden" name="ppc_CustomerAddress1" value="<?php echo $formdata['ppc_CustomerAddress1']?>" />
			    <input type="hidden" name="ppc_CustomerAddress2" value="<?php echo $formdata['ppc_CustomerAddress2']?>" />
			    <input type="hidden" name="ppc_CustomerAddressPIN" value="<?php echo $formdata['ppc_CustomerAddressPIN']?>" />
			    <input type="hidden" name="ppc_CustomerCity" value="<?php echo $formdata['ppc_CustomerCity']?>" />
			    <input type="hidden" name="ppc_CustomerState" value="<?php echo $formdata['ppc_CustomerState']?>" />
			    <input type="hidden" name="ppc_CustomerCountry" value="<?php echo $formdata['ppc_CustomerCountry']?>" />
			    <input type="hidden" name="ppc_ShippingFirstName" value="<?php echo $formdata['ppc_ShippingFirstName']?>" />
			    <input type="hidden" name="ppc_ShippingLastName" value="<?php echo $formdata['ppc_ShippingLastName']?>" />
			    <input type="hidden" name="ppc_ShippingAddress1" value="<?php echo $formdata['ppc_ShippingAddress1']?>" />
			    <input type="hidden" name="ppc_ShippingAddress2" value="<?php echo $formdata['ppc_ShippingAddress2']?>" />
			    <input type="hidden" name="ppc_ShippingCity" value="<?php echo $formdata['ppc_ShippingCity']?>" />
			    <input type="hidden" name="ppc_ShippingState" value="<?php echo $formdata['ppc_ShippingState']?>" />
			    <input type="hidden" name="ppc_ShippingCountry" value="<?php echo $formdata['ppc_ShippingCountry']?>" />
			    <input type="hidden" name="ppc_ShippingZipCode" value="<?php echo $formdata['ppc_ShippingZipCode']?>" />
			    <input type="hidden" name="ppc_ShippingPhoneNumber" value="<?php echo $formdata['ppc_ShippingPhoneNumber']?>" />      
			</div>
		</form>
    </body>
</html>