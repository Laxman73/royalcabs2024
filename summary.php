<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "includes/common_front.php";

$PAGE_TITLE2 = 'Booking Summary';
$PAGE_TITLE .= $PAGE_TITLE2;


//cmbfrom=48&cmbto=17&txtdate=2024-01-13&cmbtime=12:00%20AM&cmbpasses=2


$cmbfrom = (isset($_GET['cmbfrom'])) ? db_input2($_GET['cmbfrom']) : '';
$vehicle_id = (isset($_GET['vehicle_id'])) ? db_input2($_GET['vehicle_id']) : '';
$cmbto = (isset($_GET['cmbto'])) ? db_input2($_GET['cmbto']) : '';
$cmbtime = (isset($_GET['cmbtime'])) ? db_input2($_GET['cmbtime']) : '';
$cmbpasses = (isset($_GET['cmbpasses'])) ? db_input2($_GET['cmbpasses']) : '';
$txtdate = (isset($_GET['txtdate'])) ? db_input2($_GET['txtdate']) : '';

$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' ", '3');
$subtotal = $total = $Loc_ds = 0;




if (!empty($cmbfrom) && !empty($cmbto)) {
	//$cartArr['data']['location']['cmbfrom']=$cmbfrom;
	//$cartArr['data']['location']['cmbto']=$cmbto;
	$Loc_ds = GetTotalDistance($cmbfrom, $cmbto, 28);
}
$subtotal = GetFinalPrice($Loc_ds, $vehicle_id, $TIME_CAR_ARR[$cmbtime]);


$CAR_DETAILS = GetDataFromID('vehicle', 'iVehicleID', $vehicle_id, " and cStatus='A' ");
$file_pic = $CAR_DETAILS[0]->vPic;
$src = NOIMAGE;
if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
	$src = VEHICLE_IMG_PATH . $file_pic;
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Hire a Car | Bus Rental Service | Royal Holidays Goa</title>
	<meta name="description" content="Royal Holidays offers car/coach/bus rental services in Goa. Rent a vehicle & enjoy comfortable and convenient transportation with our well-equipped vehicles." />
	<meta name="keywords" content="coach rental goa,  coach rental prices, rent coach, rent a bus, bus rental goa, goa bus rental,  royal holidays goa">
	<?php include '_load_header.php'; ?>
	<script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>

	<div class="bg-blue">
		<?php include '_header.php'; ?>
	</div>
	<form id="booking" method="post" action="save_booking.php">
		<input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $vehicle_id; ?>">
		<input type="hidden" name="cmbfrom" id="cmbfrom" value="<?php echo $cmbfrom; ?>">
		<input type="hidden" name="cmbto" id="cmbto" value="<?php echo $cmbto; ?>">
		<input type="hidden" name="cmbtime" id="cmbtime" value="<?php echo $cmbtime; ?>">
		<input type="hidden" name="cmbpasses" id="cmbpasses" value="<?php echo $cmbpasses; ?>">
		<input type="hidden" name="txtdate" id="txtdate" value="<?php echo $txtdate; ?>">
		<section class="ftco-section contact-section">

			<div class="container mt-6">
				<div class="d-flex mb-5 contact-info c-end">



					<div class="col-md-12">

						<div class="text-center heading-section">
							<h2 class="mb-3 text-black">Summary</h2>
						</div>


						<div class="card mx-100">



							<div class="d-flex">

								<img src="<?php echo $src; ?>" class="mt-10">

								<div class="container">

									<br>

									<span class="card-tag1">Recommended</span>

									<span class="card-tag2">Special offer</span>


									<br><br>

									<span class="card-head"><?php echo $CAR_DETAILS[0]->vName; ?></span>

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

									<!--<s class="strike-text1">RS.6000</s> -->
									<br>
									<span class="card-head1">RS.<?php echo GetFinalPrice($Loc_ds, $vehicle_id, $TIME_CAR_ARR[$cmbtime]); ?></span>
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
									<input type="text" value="<?php echo $LOC_ARR[$cmbfrom]; ?>" readonly>
									<!-- <div class="inputWithIcon">
							<select id="cmbfrom" name="cmbfrom" class="from-control selectTime">
										<option value="0">Select</option>
										<optgroup class="arrival" label="Arrival Point">
											<?php
											foreach ($LOC_ARR as $key => $value) {
												$selected = ($cmbfrom == $key) ? 'selected' : '';
												echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
											}
											?>
										</optgroup>
										
									</select>
						</div> -->
								</div>

								<div class="w-30">
									<label class="form-label text-black">To</label>
									<input type="text" value="<?php echo $LOC_ARR[$cmbto]; ?>" readonly>
									<!-- <div class="inputWithIcon">
							<?php //echo //FillCombo($cmbto, 'cmbto', 'COMBO', '0', $LOC_ARR, '', ' selectTime'); 
							?>
						</div> -->
								</div>

								<div class="w-20">
									<label class="form-label text-black">Date</label>

									<!-- <div class="inputWithIcon"> -->
									<input type="date" value="<?php echo $txtdate; ?>" name="date" placeholder="DD/MM/YYYY" readonly>
									<!--<i class="date"></i>-->
									<!-- </div> -->
								</div>

								<div class="w-20">
									<label class="form-label text-black">Time</label>
									<input type="text" value="<?php echo $TIME_CAR_ARR[$cmbtime]; ?>" readonly>
									<!-- <div class="inputWithIcon"> -->
									<?php //echo FillCombo($cmbtime, 'cmbtime', 'COMBO', '0', $TIME_CAR_ARR, '', ' selectTime'); 
									?>
									<!--<i class="time"></i>-->
									<!-- </div> -->
								</div>

								<div class="w-20">
									<label class="form-label text-black">Pax</label>
									<input type="text" value="<?php echo $C_PASS_ARR[$cmbpasses]; ?>" readonly>
									<!-- <div class="inputWithIcon"> -->
									<?php //echo FillCombo($cmbpasses, 'cmbpasses', 'COMBO', '', $PASS_ARR, '', 'from-control selectTime'); 
									?>
									<!-- </div> -->
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
									<input type="text" maxlength="10" onkeypress="return numbersonly(event);" id="mobile" name="mobile_num" placeholder="Enter mobile number" required>
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


						<hr>



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
										<?php echo $subtotal; ?>
									</div>

								</section>

								<section class="div-2 border-b">

									<div class="flx">
										Taxes: 5% GST
									</div>
									<div class="flx-r">
										<?php echo ($subtotal * 5 / 100); ?>
									</div>

								</section>

								<section class="div-2 ">

									<div class="flx">
										<span class="bold-text">TOTAL</span>
									</div>
									<div class="flx-r">
										<span class="bold-text"><?php echo $subtotal + ($subtotal * 5 / 100); ?></span>
									</div>

								</section>


							</div>

						</div>


						<div class="text-center">
							<!-- <button class="search-btn wpx-165 mt-2">make payment</button> -->
							<button class="g-recaptcha search-btn wpx-165 mt-2" data-sitekey="6LfUmlQpAAAAABdkarT4wS3wvMFNsYIh-SbrHoNA" data-callback='onSubmit' data-action='submit'>make payment</button>
						</div>


					</div>








				</div>
			</div>
		</section>
	</form>


	<?php include '_footer.php'; ?>


	<?php include '_load_footer.php'; ?>
	<script src="scripts/common.js"></script>
	<script>
		function onSubmit(token) {
			var err = 0;
			var return_val = true;
			var fname = $('#fname');
			var mobile = $('#mobile');
			var email = $('#email');
			if ($.trim(fname.val()) == '') {
				ShowError(fname, "please enter the name ");
				err++; //return false;
			} else {
				HideError(fname);
			}


			if ($.trim(mobile.val()) == '') {
				ShowError(mobile, "please enter the mobile number ");
				err++; //return false;
			} else {
				HideError(mobile);
			}

			if ($.trim(email.val()) == '') {
				ShowError(email, "please enter the your email");
				err++; //return false;
			} else {
				HideError(email);
			}



			if (err > 0) {
				return_val = false;
			}
			if (return_val) {
				document.getElementById("booking").submit();

			}
		}
	</script>



</body>

</html>