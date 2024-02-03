<?php
include_once "includes/common_front.php";

$PAGE_TITLE2 = 'Booking Summary';
$PAGE_TITLE .= $PAGE_TITLE2;


$cmbfrom=(isset($_POST['cmbfrom']))?db_input2($_POST['cmbfrom']):'';
$vehicle_id=(isset($_POST['vehicle_id']))?db_input2($_POST['vehicle_id']):'';
$cmbto=(isset($_POST['cmbto']))?db_input2($_POST['cmbto']):'';
$cmbtime=(isset($_POST['cmbtime']))?db_input2($_POST['cmbtime']):'';
$cmbpasses=(isset($_POST['cmbpasses']))?db_input2($_POST['cmbpasses']):'';
$txtdate=(isset($_POST['txtdate']))?db_input2($_POST['txtdate']):'';

$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' ", '3');
$subtotal=$total=$Loc_ds=0;




if (!empty($cmbfrom) && !empty($cmbto)){
//$cartArr['data']['location']['cmbfrom']=$cmbfrom;
//$cartArr['data']['location']['cmbto']=$cmbto;
$Loc_ds=GetTotalDistance($cmbfrom,$cmbto,28);
}
$subtotal=GetFinalPrice($Loc_ds,$vehicle_id);


$CAR_DETAILS=GetDataFromID('vehicle','iVehicleID',$vehicle_id," and cStatus='A' ");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include '_load_header.php';?>  
    </head>
	<body>
    
	<div class="bg-blue">
		<?php include '_header.php';?>
    </div>
<form id="booking" method="post" action="save_booking.php">
	<input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $vehicle_id;?>">
    <section class="ftco-section contact-section">
	
      <div class="container mt-6">
        <div class="d-flex mb-5 contact-info c-end">

		  
		  
        <div class="col-md-12">
		
			<div class="text-center heading-section">
				<h2 class="mb-3 text-black">Summary</h2>
			</div>

			
			<div class="card mx-100">
							

				
				<div class="d-flex">
								
					<img src="images/car-1.png" class="mt-10">
								
					<div class="container">
					
					    <br>
						
						<span class="card-tag1">Recommended</span>
					
						<span class="card-tag2">Special offer</span>
					
					
					    <br><br>
									
						<span class="card-head"><?php echo $CAR_DETAILS[0]->vName;?></span> 
									
						<div class="row">
							<div class="column1 pd ">
								<i class="seat"></i><span>4 seaters</span>
							</div>
							<div class="column1 pd">
								<i class="car-small"></i><span>Sedan</span>
							</div>
						</div>
						<div class="row">
							<div class="column1 pd">
								<i class="fuel-pump"></i><span>Electic</span>
							</div>
							<div class="column1 pd">
								<i class="airbag"></i><span>Air bags</span>
							</div>
						</div>
									
						<br>
										
					</div>
				

				
					<div class="text-right">
					
					<br>
					
						<s class="strike-text1">RS.6000</s> 
						<br>
						<span class="card-head1">RS.<?php echo GetFinalPrice($Loc_ds,$vehicle_id);?></span> 
						<br>		
						<span class="card-p">Price for night differs</span>					
						<!-- <a href="car_display.php"><button class="search-btn wpx-165 mt-2">view details</button></a> -->
					</div>
				
				
				</div>
								
			</div>
			
			<hr>
			
			<div class="mx-100">
			
				<span class="card-head">Booking Details</span>
			

            <div class="d-flex gap-10 mt-2">

					<div class="w-30">
						<label class="form-label text-black">From</label>
						<div class="inputWithIcon">
							<select id="cmbfrom" name="cmbfrom" class="from-control selectTime">
										<option value="0">Select</option>
										<optgroup class="arrival" label="Arrival Point">
											<?php
											foreach ($LOC_ARR as $key => $value){
												$selected=($cmbfrom==$key)?'selected':'';
												echo '<option value="' . $key .'" '.$selected.'>' . $value . '</option>';
											}
											?>
										</optgroup>
										
									</select>
						</div>
					</div>	

					<div class="w-30">
						<label class="form-label text-black">To</label>
						<div class="inputWithIcon">
							<?php echo FillCombo($cmbto, 'cmbto', 'COMBO', '0', $LOC_ARR, '', ' selectTime'); ?>
						</div>
					</div>			
					
					<div class="w-20">
						<label class="form-label text-black">Date</label>
						<div class="inputWithIcon">
							<input type="date" name="date" value="<?php echo $txtdate;?>" name="date" placeholder="DD/MM/YYYY">
							<!--<i class="date"></i>-->
						</div>
					</div>	
						
					<div class="w-20">						
						<label class="form-label text-black">Time</label>
						<div class="inputWithIcon">
							<?php echo FillCombo($cmbtime, 'cmbtime', 'COMBO', '0', $TIME_CAR_ARR, '', ' selectTime'); ?>
							<!--<i class="time"></i>-->
						</div>
					</div>
							
					<div class="w-20">	
						<label class="form-label text-black">Pax</label>
						<div class="inputWithIcon">
							<?php echo FillCombo($cmbpasses, 'cmbpasses', 'COMBO', '', $PASS_ARR, '', 'from-control selectTime'); ?>
						</div>
					</div>
						

					
			</div>
		   
		    </div>

			
			<hr>
			
			<div class="mx-100">
			
				<span class="card-head">Personal Details</span>
			
				<div class="d-flex gap-10 mt-2">

						<div>
							<label class="form-label text-black">Full name</label>
							<input type="text" name="fname" id="fname" placeholder="Enter full name" required>
						</div>	

						<div>
							<label class="form-label text-black">Mobile number</label>
							<input type="text" id="mobile" name="mobile_num" placeholder="Enter mobile number" required>
						</div>			
						
						<div>
							<label class="form-label text-black">Email</label>
							<input type="email" name="email" id="email" placeholder="Enter email" required>
						</div>	
							
			
						
				</div>
		   
		    </div>
			
            
			<div class="text-center">
				<!-- <a href="#"><button class="btn-orange">Edit</button></a> -->
			</div>
			
			<br>
			<hr>
			<br>
			
			
			<div class="mx-100">
			
				<div class="border-bx">
				
					<span class="card-head">Payment Details</span>
					
					<section class="div-2">
					
						<!-- <div class="flx">
							Car name
						</div>
						<div class="flx-r">
							16000
						</div> -->
						
					</section>
					
					<!-- <section class="div-2 border-b">
					
						<div class="flx">
							Promo code: CARDISCOUNT
						</div>
						<div class="flx-r">
							-3000
						</div>
						
					</section> -->
					
					<section class="div-2 border-b">
					
						<div class="flx">
							Sub total
						</div>
						<div class="flx-r">
							<?php echo $subtotal;?>
						</div>
						
					</section>
					
					<section class="div-2 border-b">
					
						<div class="flx">
							Taxes: 18% GST
						</div>
						<div class="flx-r">
							<?php echo ($subtotal*18/100);?>
						</div>
						
					</section>
					
					<section class="div-2 ">
					
						<div class="flx">
							<span class="bold-text">TOTAL</span>
						</div>
						<div class="flx-r">
							<span class="bold-text"><?php echo $subtotal+($subtotal*18/100);?></span>
						</div>
						
					</section>
				
					
				</div>
		   
		    </div>
			
			
			<div class="text-center">
				<button class="search-btn wpx-165 mt-2">make payment</button>
			</div>
				
		
        </div>
		  
		  
		  

		  
		  
		  
		  
        </div>
      </div>
    </section>
	</form>
	
		
    <?php include '_footer.php';?>

  
    <?php include '_load_footer.php';?>
    


</body>
</html>