<html>
	<head>
    </head>
    <body>
		<div>      
			<td>
				<a style="margin: 20px -10px 10px 570px ;color:blue;font-weight: bold" href="index.php">Return To Transaction Page</a>
			</td>
		</div>
		<h1 style="text-align: center;color: #333">Response Parameters</h1>    
        
        <?php
			$secret_key = "2CT71BH69U05FNVWYCQZW6P1YZMVQ992";	
				
			function Hex2String($hex)
			{
				$string='';
		
				for ($i=0; $i < strlen($hex)-1; $i+=2)
				{
					$string .= chr(hexdec($hex[$i].$hex[$i+1]));
				}
		
				return $string;
			}

			$secret_key = Hex2String($secret_key);
				 
			ksort($_POST);

			$strPostData = "";
			
			foreach($_POST as  $key => $value)
			{
				echo "$key => $value" . "<br />";

				if($key != "ppc_DIA_SECRET" && $key!= "ppc_DIA_SECRET_TYPE")
				{
					$strPostData.=$key."=".$value."&";
				}
			}

			// trim last character from string
			$strPostData = substr($strPostData, 0, -1);

			$responseHash = strtoupper(hash_hmac('sha256', $strPostData, $secret_key));

			echo "<br />";

			if ($responseHash == $_POST['ppc_DIA_SECRET'])
			{
				if (isset($_POST['ppc_PinePGTxnStatus']) && $_POST['ppc_PinePGTxnStatus'] == '4'
					&& isset($_POST['ppc_TxnResponseCode']) && $_POST['ppc_TxnResponseCode'] == '1')
				{
					$amount = floatval($_POST['ppc_Amount']) / 100.0;
					$txnId = $_POST['ppc_UniqueMerchantTxnID'];

					$msg = "Thank you for shopping with us. Your account has been charged and your transaction is successful with the following order details:<br /> Transaction Id: " . $txnId . "<br /> Amount: " . $amount . " <br />We will process your order soon.";
				}
				elseif ($_POST['ppc_TxnResponseCode'] == '-10') 
				{					
					$msg = "Thank you for shopping with us. However, the transaction has been cancelled.";
				}
				else
				{				
					$msg = "Thank you for shopping with us. However, the payment failed.";
				}
			}
			else
			{
				//tampered
				$msg = "Thank you for shopping with us. However, the payment failed.";
			}

			echo "<strong>$msg</strong>";
  
        ?>
    </body>
</html>