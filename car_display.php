<?php
include_once "includes/common_front.php";

if (URL_REWRITTING == 'ON') $URL_CARLISTING = SITE_ADDRESS . 'hire-cars-in-goa.html';
else $URL_CARLISTING = SITE_ADDRESS . 'car_listing.php';

//DFA($_SESSION);
$cmbtime = $cmbpasses = '';
if (URL_REWRITTING == 'ON') {
	$qCode = (isset($_GET['qCode'])) ? $_GET['qCode'] : '';
	$id = '';
	if (!empty($qCode)) {
		$id = GetXFromYID("select iVehicleID from vehicle where vUrlName='$qCode' and cStatus='A' ");
	}
} else {

	$id = !empty($_GET['id']) ? $_GET['id'] : '';
}
if (empty($id)) {
	header('location:' . $URL_CARLISTING);
	exit;
}

$cmbfrom = !empty($_GET['cmbfrom']) ? $_GET['cmbfrom'] : '';
$cmbto = !empty($_GET['cmbto']) ? $_GET['cmbto'] : '';
$cmbtime = !empty($_GET['cmbtime']) ? $_GET['cmbtime'] : '';
$cmbpasses = !empty($_GET['cmbpasses']) ? $_GET['cmbpasses'] : '';
$txtdate = !empty($_GET['txtdate']) ? $_GET['txtdate'] : '';

if (empty($cmbfrom) && empty($cmbto) && empty($cmbtime) && empty($cmbpasses) && empty($txtdate)) {
	header('location:car_listing.php');
	exit;
}

$params = "?cmbfrom=$cmbfrom&cmbto=$cmbto&txtdate=$txtdate&cmbtime=$cmbtime&cmbpasses=$cmbpasses";

$submit_url = "car_display.php?id=";

$Loc_ds = 0;

//$OWNER_ARR = GetXArrFromYID('select iOwnerID, vName from owner where cStatus!="X" order by iOwnerID','3');
$TYPE_ARR = GetXArrFromYID('select iVTypeID, CONCAT(vName, " (", vSeats, ")") from gen_vehicle_type where cStatus!="X" order by iVTypeID', '3');
$TRAN_ARR = GetXArrFromYID('select iVTransID, vName from gen_vehicle_transmission where cStatus!="X" order by iVTransID', '3');
$FUEL_ARR = GetXArrFromYID('select iVFuelID, vName from gen_vehicle_fuel where cStatus!="X" order by iVFuelID', '3');
$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' order by vName ", '3');
$TARIFF_ARR = GetDataFromID('tariff', 'iVehicleID', $id);
//DFA($TARIFF_ARR);
$DEC_PLACE = 2;

//$DIPOSAL_ID = GetXFromYID("select iVCatID from gen_vehicle_category where cStatus!='X' and vName like '%disposals%'");
$DIPOSAL_ID = 3;
$DISP_CAT_ID = 1; // Car

//DFA($_SESSION);

$vehData = (object) array();
$dataArray = array();
if (!empty($id)) {
	$r = sql_query(
		"SELECT v.*, gvt.vName AS TypeName, gvt.vSeats, tar.fBaseFare, CONCAT('~',GROUP_CONCAT(vca.iVCatID SEPARATOR '~'),'~') AS VCatIDs, own.vName AS OwnName, own.vContactMobile, own.vContactMobile2 
			FROM vehicle AS v 
			LEFT JOIN vehicle_cat_assoc AS vca ON (vca.iVehicleID=v.iVehicleID) 
			LEFT JOIN gen_vehicle_type AS gvt ON (gvt.iVTypeID=v.iVTypeID) 
			LEFT JOIN tariff AS tar ON (tar.iVehicleID=v.iVehicleID AND tar.iVCatID=$DISP_CAT_ID) 
			LEFT JOIN owner AS own ON (own.iOwnerID=v.iOwnerID) 
			WHERE v.iVehicleID=$id 
			GROUP BY v.iVehicleID 
			HAVING VCatIDs LIKE '%~1~%' 
			ORDER BY v.iVehicleID DESC "
	);
	$vehData = sql_num_rows($r) > 0 ? sql_fetch_object($r) : $vehData;
	$file_pic = $vehData->vPic;
	$src = NOIMAGE;
	if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
		$src = VEHICLE_IMG_PATH . $file_pic;
	$cats = explode("~", $vehData->VCatIDs);
	$cats = array_values(array_filter($cats));
	$submit_url = $id;
	//var_dump($vehData,$cats);exit;

	$r = sql_query(
		"SELECT v.*, gvt.vName AS TypeName, gvt.vSeats, tar.fBaseFare, CONCAT('~',GROUP_CONCAT(vca.iVCatID SEPARATOR '~'),'~') AS VCatIDs 
			FROM vehicle AS v 
			LEFT JOIN vehicle_cat_assoc AS vca ON (vca.iVehicleID=v.iVehicleID) 
			LEFT JOIN gen_vehicle_type AS gvt ON (gvt.iVTypeID=v.iVTypeID) 
			LEFT JOIN tariff AS tar ON (tar.iVehicleID=v.iVehicleID AND tar.iVCatID=$DISP_CAT_ID) 
			WHERE v.iVehicleID!=$id 
			GROUP BY v.iVehicleID 
			HAVING VCatIDs LIKE '%~$DISP_CAT_ID~%' 
			ORDER BY v.iVehicleID DESC "
	);
	$dataArray = sql_num_rows($r) > 0 ? sql_get_data($r) : $dataArray;
	//var_dump($dataArray);exit;
}

$PAGE_TITLE2 = 'Car Display';
$PAGE_TITLE .= $PAGE_TITLE2;





if (!empty($cmbfrom) && !empty($cmbto)) {
	//$cartArr['data']['location']['cmbfrom']=$cmbfrom;
	//$cartArr['data']['location']['cmbto']=$cmbto;
	$Loc_ds = GetTotalDistance($cmbfrom, $cmbto, 28);
}

//$Loc_ds = 100;




// $cartArr = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : array('data' => array('location'=>array('cmbfrom' =>'','cmbto'=>'') , 'users_details' => array()));
//  DFA($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title> <?php echo ($vehData->vName); ?> Self Drive Car Rentals | Rent a Car in Goa | Royal Holidays</title>
	<meta name="description" content="Royal Holidays, the trusted self-drive car rental service in Goa, offers <?php echo ($vehData->vName); ?> car for rent. Make your travel in Goa hassle-free with us." />
	<meta name="keywords" content="self drive car rental in goa, self drive cars in goa, rent a car goa, car rental goa, rent coach, bus rental goa, coach rental goa, coach rental prices">
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php echo ($vehData->vName); ?> Self Drive Car Rentals | Rent a Car in Goa | Royal Holidays" />
	<meta property="og:description" content="Royal Holidays, the trusted self-drive car rental service in Goa, offers <?php echo ($vehData->vName); ?> car for rent. Make your travel in Goa hassle-free with us." />
	<meta property="og:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png">

	<meta property="og:site_name" content="Royal Holidays" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="<?php echo ($vehData->vName); ?> Self Drive Car Rentals | Rent a Car in Goa | Royal Holidays" />
	<meta name="twitter:description" content="Royal Holidays, the trusted self-drive car rental service in Goa, offers <?php echo ($vehData->vName); ?> car for rent. Make your travel in Goa hassle-free with us." />
	<meta name="twitter:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png" />
	<link rel="canonical" href="https://royalcabsgoa.com/car_display.php" />
	<?php include '_load_header.php'; ?>
	<style>
		.car_active {
			color: var(--yellow) !important;
		}
	</style>
</head>

<body>

	<?php include '_header.php'; ?>


	<div class="hero-wrap1 ftco-degree-bg" style="background-image: url('images/car-listing-banner.png');" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row  no-gutters slider-text1 justify-content-start align-items-center justify-content-center">



				<div class="text-center heading-section">
					<h2 class="text-white">Rent a perfect car</h2>
				</div>


			</div>
		</div>
	</div>




	<section class="ftco-section contact-section">
		<div class="container">
			<div class="row d-flex mb-5 contact-info c-end">
				<div class="row col-md-4">
					<div class="col-md-12">
						<!-- <form id="confirm_booking" method="get" action=""> -->
						<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
						<div class="w-100 mb-2 listing-card">


							<div class="w-100 p-4  border-bottom">

								<?php if ($vehData->cRecommended == 'Y') { ?><span class="card-tag1">Recommended</span><?php } ?>
								<?php if (false) { ?><span class="card-tag2">Special offer</span><?php } ?>
								<br><br>
								<?php if (false) { ?><s class="strike-text1">RS.&nbsp;6000</s> <?php } ?>
								<br>
								<span class="card-head1">Rs.&nbsp;<?php echo GetFinalPrice($Loc_ds, $id,$TIME_CAR_ARR[$cmbtime]); ?></span>
								<br>
								<span class="card-p">Price for night differs</span>

							</div>



							<div class="w-100 p-4 mb-2 ">

								<div>
									<label class="form-label text-black">From</label>
									<div class="inputWithIcon">
										<input type="text" value="<?php echo $LOC_ARR[$cmbfrom]; ?>" readonly>
										<!-- <select id="cmbfrom" name="cmbfrom" class="from-control selectTime" required>
											<option value="0">Select</option>
											<optgroup class="arrival" label="Arrival Point">
												<?php
												foreach ($LOC_ARR as $key => $value) {
													$selected = ($cmbfrom == $key) ? 'selected' : '';
													echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
												}
												?>
											</optgroup>

										</select> -->
									</div>
								</div>

								<div>
									<label class="form-label text-black">To</label>
									<div class="inputWithIcon">
										<?php //echo FillCombo($cmbto, 'cmbto', 'COMBO', '0', $LOC_ARR, 'required', ' selectTime'); 
										?>
										<input type="text" value="<?php echo $LOC_ARR[$cmbto]; ?>" readonly>
									</div>
								</div>

								<div>
									<label class="form-label text-black">Date</label>
									<div class="inputWithIcon">
										<!-- <input type="date" name="txtdate" value="<?php echo $txtdate; ?>" placeholder="DD/MM/YYYY" required> -->
										<input type="date" value="<?php echo $txtdate; ?>" name="date" placeholder="DD/MM/YYYY" readonly>
										<!--<i class="date"></i>-->
									</div>
								</div>


								<div class="d-flex gap-10">
									<div class="w-60">
										<label class="form-label text-black">Time</label>
										<div class="inputWithIcon">
											<input type="text" value="<?php echo $TIME_CAR_ARR[$cmbtime]; ?>" readonly>
											<?php //echo FillCombo($cmbtime, 'cmbtime', 'COMBO', '0', $TIME_CAR_ARR, 'required', ' selectTime'); 
											?>
											<!--<i class="time"></i>-->
										</div>
									</div>

									<div class="w-40">
										<label class="form-label text-black">Pax</label>
										<div class="inputWithIcon">
											<input type="text" value="<?php echo $PASS_ARR[$cmbpasses]; ?>" readonly>
											<?php //echo FillCombo($cmbpasses, 'cmbpasses', 'COMBO', '', $PASS_ARR, 'required', 'from-control selectTime'); 
											?>
										</div>
									</div>
								</div>

							</div>



							<!-- <div class="w-100 p-4 mb-2 border-bottom">

									<span class="float-left normal-text">Have a coupon?</span> <br>


									<div class="d-flex gap-10">
										<div class="w-70"><input type="text" placeholder="CARDISCOUNT"></div>
										<div class="w-30"><input type="submit" value="APPLY" class="btn btn-primary w-100"></div>
									</div>

								</div> -->

							<div class="w-100 p-4 mb-2">
								

								<!-- <button class="search-btn">Search</button> -->

							</div>

						</div>
						<!-- </form> -->

						<br>

						<div class="w-100 mb-2 listing-card">

							<div class="w-100 p-4 mb-2">

								<span class="float-left card-text-2">Need help for booking?</span> <br>

								<p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.</p>

								<a href="contact_us.php"><button class="abt-label mt-10 m-0">contact us</button></a>

							</div>

						</div>



					</div>


				</div>




				<div class="col-md-8">


					<img src="<?php echo $src; ?>" class="responsive mt-10 mb-4">

					<?php if (in_array($DIPOSAL_ID, $cats)) { ?><div class="card-tag"><i class="Car-Key"></i><span class="tag-text">Available for disposal</span></div><?php } ?>

					<br><br>

					<h3 class="card-head-b"><?php echo ($vehData->vName); ?></h3>

					<div class="row">
						<div class="column1 pd">
							<i class="seat"></i><span><?php echo ($vehData->vSeats); ?> seaters</span>
						</div>
						<div class="column1 pd">
							<i class="car-small"></i><span><?php echo ($vehData->TypeName); ?></span>
						</div>
						<!-- <div class="column1 pd">
					<i class="fuel-pump"></i><span><?php //echo(!empty($FUEL_ARR[$vehData->iVFuelID])?$FUEL_ARR[$vehData->iVFuelID]:'- Na -'); 
													?></span>
				</div> -->
						<div class="column1 pd">
							<?php if ($vehData->cAirBags == 'Y') { ?><i class="airbag"></i><span>Air bags</span><?php } ?>
						</div>
					</div>
					<hr>
					<!-- <span class="card-head">Car Desription</span> 
			<p><?php //echo($vehData->vDesc); 
				?></p>
			<hr>
			<span class="card-head">Safety</span> 
			<p><?php //echo($vehData->vSafety); 
				?></p>
			<hr>
			<span class="card-head">Terms & Conditions</span> 
			<p><?php //echo($vehData->vTermsConditions); 
				?></p>
			<hr> -->
					<!-- <section class="desk-dis">
			<div class="div-2">
				<div class="flx1">
					<img src="images/contact-person.png" alt="">
				</div>
				
				<div class="flx2">
					<span><?php //echo($vehData->OwnName); 
							?></span><br>
					<span><?php //echo($vehData->vContactMobile.(!empty($vehData->vContactMobile2)?" / $vehData->vContactMobile2":'')); 
							?></span>
				</div>
				
				<div class="flx3">
					<a href="contact_us.php" ><button class="btn-orange">contact us</button></a>
				</div>
			</div>	
			</section> -->


					<!-- <section class="mob-dis">
			<div class="mob-div-2">
				<div class="mob-flx1">
					<img src="images/contact-person.png" alt="">
				</div>
				
				<div class="mob-flx2">
					<span><?php //echo($vehData->OwnName); 
							?></span><br>
					<span><?php //echo($vehData->vContactMobile.(!empty($vehData->vContactMobile2)?" / $vehData->vContactMobile2":'')); 
							?></span>
				</div>
			</div>
				<div class="text-center">
					<a href="contact_us.php" ><button class="btn-orange">contact us</button></a>
				</div>
			</section> -->



					<!-- <hr> -->

					<!-- <span class="card-head">Client Review</span>  -->



					<!-- <div id="testimonial4" class="carousel slide testimonial4_indicators testimonial4_control_button thumb_scroll_x swipe_x" data-ride="carousel" data-pause="hover" data-interval="5000" data-duration="2000">
             
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <div class="testimonial4_slide">
                            <p>"I had an amazing experience renting a car from this company during my trip to Goa. The car was in excellent condition and very well-maintained, and it made exploring the beautiful sights and beaches of Goa so much easier and convenient. The staff were friendly and professional, and they provided me with all the information I needed to make the rental process smooth and hassle-free. I would definitely recommend this company to anyone looking for a reliable and affordable car rental service in Goa. Thank you for making my trip so memorable!"</p>
                            <h4 class="author">- Jay sean</h4>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
						    <p>"I had an amazing experience renting a car from this company during my trip to Goa. The car was in excellent condition and very well-maintained, and it made exploring the beautiful sights and beaches of Goa so much easier and convenient. The staff were friendly and professional, and they provided me with all the information I needed to make the rental process smooth and hassle-free. I would definitely recommend this company to anyone looking for a reliable and affordable car rental service in Goa. Thank you for making my trip so memorable!"</p>
							<h4 class="author">Client 2</h4>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial4_slide">
                            <p>"I had an amazing experience renting a car from this company during my trip to Goa. The car was in excellent condition and very well-maintained, and it made exploring the beautiful sights and beaches of Goa so much easier and convenient. The staff were friendly and professional, and they provided me with all the information I needed to make the rental process smooth and hassle-free. I would definitely recommend this company to anyone looking for a reliable and affordable car rental service in Goa. Thank you for making my trip so memorable!"</p>
							<h4 class="author">Client 3</h4>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev bottom" href="#testimonial4" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next bottom" href="#testimonial4" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>	 -->

					<ul>
						

					</ul>

					<div class="col-md-12">
<form action="summary.php" method="post" id="confirm_frm">
									<input type="hidden" name="cmbfrom" id="cmbfrom2" value="<?php echo $cmbfrom; ?>">
									<input type="hidden" name="vehicle_id" id="vehicle_id2" value="<?php echo $id; ?>">
									<input type="hidden" name="cmbto" id="cmbto2" value="<?php echo $cmbto; ?>">
									<input type="hidden" name="cmbtime" id="cmbtime2" value="<?php echo $cmbtime; ?>">
									<input type="hidden" name="cmbpasses" id="cmbpasses2" value="<?php echo $cmbpasses; ?>">
									<input type="hidden" name="txtdate" id="txtdate2" value="<?php echo $txtdate; ?>">


									<button type="submit" class="search-btn">Book Now</button>

								</form>
					</div>

				</div>



			</div>


			<hr>

			<div class="text-center mt-4 mb-2">
				<span class="card-head-b">Similar cars</span>
			</div>
			<div class="row">
				<?php
				foreach ($dataArray as $i => $row) {
					$cats = explode("~", $row->VCatIDs);
					$cats = array_values(array_filter($cats));
					$file_pic = $row->vPic;
					$src = NOIMAGE;
					if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
						$src = VEHICLE_IMG_PATH . $file_pic;
					$price = GetFinalPrice($Loc_ds, $row->iVehicleID,$TIME_CAR_ARR[$cmbtime]);
					if (URL_REWRITTING == 'ON') $URL_CARLDISPLAY = SITE_ADDRESS . $row->vUrlName . '-hire-a-cab-goa.html';
					else $URL_CARLDISPLAY = SITE_ADDRESS . 'car_display.php?id=' . $row->iVehicleID;

				?>
					<div class="column1">
						<div class="card">
							<?php if (in_array($DIPOSAL_ID, $cats)) { ?><div class="card-tag"><i class="Car-Key"></i><span class="tag-text">Available for disposal</span></div><?php } ?>
							<img src="<?php echo $src; ?>" class="mt-10">
							<div class="container">
								<span class="card-head"><?php echo ($row->vName); ?></span>
								<div class="row">
									<div class="column-res">
										<i class="seat"></i><span><?php echo ($row->vSeats); ?> seaters</span>
									</div>
									<div class="column-res">
										<i class="car-small"></i><span><?php echo ($row->TypeName); ?></span>
									</div>
								</div>
								<div class="row">
									<!-- <div class="column-res">
										<i class="fuel-pump"></i><span><?php echo (!empty($FUEL_ARR[$row->iVFuelID]) ? $FUEL_ARR[$row->iVFuelID] : '- Na -'); ?></span>
									</div>
									<div class="column-res">
										<?php if ($row->cAirBags == 'Y') { ?><i class="airbag"></i><span>Air bags</span><?php } ?>
									</div> -->
								</div>
								<br>
								<div class="mob-div">
									<div class="flx4"><span class="card-head">Rs.&nbsp;<?php echo $price; ?></span> <?php if (false) { ?><s class="strike-text">RS.&nbsp;6000</s><?php } ?></div>
									<div class="flx5"><a href="<?php echo $URL_CARLDISPLAY . $params; ?>"><button type="button" class="search-btn wpx-165">view details</button></a></div>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
				?>

			</div>

			<!-- <div class="text-center mt-4">
			<a href="#" ><button class="btn-yellow">view all</button></a>
		</div> -->


		</div>
	</section>



	<?php include '_footer.php'; ?>


	<?php include '_load_footer.php'; ?>
	<script src="scripts/common.js"></script>


	<script>
		const rangeInput = document.querySelectorAll(".range-input input"),
			priceInput = document.querySelectorAll(".price-input input"),
			range = document.querySelector(".slider .progress");
		let priceGap = 1000;

		priceInput.forEach((input) => {
			input.addEventListener("input", (e) => {
				let minPrice = parseInt(priceInput[0].value),
					maxPrice = parseInt(priceInput[1].value);

				if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
					if (e.target.className === "input-min") {
						rangeInput[0].value = minPrice;
						range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
					} else {
						rangeInput[1].value = maxPrice;
						range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
					}
				}
			});
		});

		rangeInput.forEach((input) => {
			input.addEventListener("input", (e) => {
				let minVal = parseInt(rangeInput[0].value),
					maxVal = parseInt(rangeInput[1].value);

				if (maxVal - minVal < priceGap) {
					if (e.target.className === "range-min") {
						rangeInput[0].value = maxVal - priceGap;
					} else {
						rangeInput[1].value = minVal + priceGap;
					}
				} else {
					priceInput[0].value = minVal;
					priceInput[1].value = maxVal;
					range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
					range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
				}
			});
		});
	</script>

	<!--testimonial-->
	<script>
		$('#confirm_frm').submit(function() {
			var err = 0;
			var err_arr = new Array();
			var ret_val = true;
			var id = ('#id');
			var cmbfrom = $('#cmbfrom');
			var cmbto = $('#cmbto');
			var txtdate = $('#txtdate');
			var cmbtime = $('#cmbtime');
			var cmbpasses = $('#cmbpasses');
			if (cmbfrom.val() == 0 || cmbfrom.val() === '') {
				ShowError(cmbfrom, "Please select Pick up point");
				err_arr[err] = cmbfrom;
				err++;
			} else HideError(cmbfrom);

			if (cmbto.val() == 0 || cmbto.val() === '') {
				ShowError(cmbto, "Please select drop of point");
				err_arr[err] = cmbto;
				err++;
			} else HideError(cmbto);

			if (txtdate.val() == 0 || txtdate.val() === '') {
				ShowError(txtdate, "Please select the date");
				err_arr[err] = txtdate;
				err++;
			} else HideError(txtdate);

			if (cmbtime.val() == 0 || cmbtime.val() === '') {
				ShowError(cmbtime, "Please select the time");
				err_arr[err] = cmbtime;
				err++;
			} else HideError(cmbtime);

			if (cmbpasses.val() == 0 || cmbpasses.val() === '') {
				ShowError(cmbpasses, "Please select the number of passengers");
				err_arr[err] = cmbpasses;
				err++;
			} else HideError(cmbpasses);

			if (err > 0) {
				//console.log(err_arr[0]);
				err_arr[0].focus();
				ret_val = false;
			}


			if (ret_val) {
				// $('#cmbfrom2').val(cmbfrom.val());
				// $('#vehicle_id2').val(id.val());
				// $('#cmbto2').val(cmbto.val());
				// $('#cmbtime2').val(cmbtime.val());
				// $('#cmbpasses2').val(cmbpasses.val());
				// $('#txtdate2').val(txtdate.val());
			}






			return ret_val;
		});

		$(document).ready(function() {
			//rotation speed and timer
			var speed = 5000;

			var run = setInterval(rotate, speed);
			var slides = $('.slide');
			var container = $('#slides ul');
			var elm = container.find(':first-child').prop("tagName");
			var item_width = container.width();
			var previous = 'prev'; //id of previous button
			var next = 'next'; //id of next button
			slides.width(item_width); //set the slides to the correct pixel width
			container.parent().width(item_width);
			container.width(slides.length * item_width); //set the slides container to the correct total width
			container.find(elm + ':first').before(container.find(elm + ':last'));
			resetSlides();


			//if user clicked on prev button

			$('#buttons a').click(function(e) {
				//slide the item

				if (container.is(':animated')) {
					return false;
				}
				if (e.target.id == previous) {
					container.stop().animate({
						'left': 0
					}, 500, function() {
						container.find(elm + ':first').before(container.find(elm + ':last'));
						resetSlides();
					});
				}

				if (e.target.id == next) {
					container.stop().animate({
						'left': item_width * -2
					}, 500, function() {
						container.find(elm + ':last').after(container.find(elm + ':first'));
						resetSlides();
					});
				}

				//cancel the link behavior            
				return false;

			});

			//if mouse hover, pause the auto rotation, otherwise rotate it    
			container.parent().mouseenter(function() {
				clearInterval(run);
			}).mouseleave(function() {
				run = setInterval(rotate, speed);
			});


			function resetSlides() {
				//and adjust the container so current is in the frame
				container.css({
					'left': -1 * item_width
				});
			}

		});
		//a simple function to click next link
		//a timer will call this function, and the rotation will begin

		function rotate() {
			$('#next').click();
		}



		$('#confirm_booking').submit(function() {

			//alert('hiiii');
			//return false;
		});
	</script>

</body>

</html>