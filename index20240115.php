<?php
include_once "includes/common_front.php";
date_default_timezone_set('Asia/Kolkata');

$cmbtime = $cmbpasses = $cmbfrom = $txtdate = $cmbto = '';

$DIPOSAL_ID = 3;
$DISP_CAT_ID = 1; // Car

$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' and cArivalpoint!='Y'   order by vName ", '3');
// DFA($LOC_ARR);
//DFA($LOC_ARR);
$HOTSPOT_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' and cArivalpoint='Y'  order by vName ", '3');

$OWNER_ARR = GetXArrFromYID('select iOwnerID, vName from owner where cStatus!="X" order by iOwnerID', '3');
$TYPE_ARR = GetXArrFromYID('select iVTypeID, CONCAT(vName, " (", vSeats, ")") from gen_vehicle_type where cStatus!="X" and iVCatID=' . $DISP_CAT_ID . ' order by iVTypeID', '3');
$TRAN_ARR = GetXArrFromYID('select iVTransID, vName from gen_vehicle_transmission where cStatus!="X" order by iVTransID', '3');
$FUEL_ARR = GetXArrFromYID('select iVFuelID, vName from gen_vehicle_fuel where cStatus!="X" order by iVFuelID', '3');

$PAGE_TITLE2 = 'Home';
$PAGE_TITLE .= $PAGE_TITLE2;

$dataArray = array();

$q = "SELECT v.*, gvt.vName AS TypeName, gvt.vSeats, tar.fBaseFare,vca.iVCatID AS VCatIDs FROM vehicle AS v LEFT JOIN
vehicle_cat_assoc AS vca ON (vca.iVehicleID=v.iVehicleID) LEFT JOIN gen_vehicle_type AS gvt ON (gvt.iVTypeID=v.iVTypeID) LEFT JOIN tariff AS tar ON (tar.iVTypeID=v.iVTypeID)
WHERE 1 and v.cStatus='A' GROUP BY v.iVehicleID  ORDER BY v.iVehicleID DESC ";

$r = sql_query($q, "ERRQ1");
$dataArray = sql_num_rows($r) > 0 ? sql_get_data($r) : $dataArray;
// DFA($dataArray);




// Get the current time
$current_time = strtotime(date('h:i A'));

// Get the time one hour from now
$one_hour_later = strtotime('+2 hour', $current_time);

// Loop through the time array and create the select options
//echo '<select name="time">';

//echo '</select>';



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Hire a Car | Car & Bus/Coaches Rentals Goa | Royal Holidays</title>
	<meta name="description" content="Royal Holidays offers Reliable self-drive car rentals & coaches/bus rental services in Goa allowing you to explore at your own pace and travel comfortably." />
	<meta name="keywords" content="Hire a car, rent a car goa, car rental goa, luxury bus hire, rent coach, bus rental goa, coach rental goa, coach rental prices">
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Hire a Car | Car & Bus/Coaches Rentals Goa | Royal Holidays" />
	<meta property="og:description" content="Hire a car in Goa with Royal Holidays. We offer Reliable car & coaches/bus rental services in Goa allowing you to explore at your own pace & travel comfortably." />
	<meta property="og:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png">
	<meta property="og:url" content="https://royalcabsgoa.com/" />
	<meta property="og:site_name" content="Royal Holidays" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:description" content="Hire a car in Goa with Royal Holidays. We offer Reliable car & coaches/bus rental services in Goa allowing you to explore at your own pace & travel comfortably." />
	<meta name="twitter:title" content="Hire a Car | Car & Bus/Coaches Rentals Goa | Royal Holidays" />
	<meta name="twitter:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png" />
	<link rel="canonical" href="https://royalcabsgoa.com/" />
	<?php include '_load_header.php'; ?>
	<style>
		.index_active {
			color: var(--yellow) !important;
		}
	</style>

	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Organization",
			"name": "Royal Holidays",
			"description": "Royal Holidays offers Reliable self-drive car rentals & coaches/bus rental services in Goa allowing you to explore at your own pace and travel comfortably.",
			"url": "https://royalcabsgoa.com/",
			"logo": "https://royalcabsgoa.com/images/logo.png",
			"alternateName": "Car Rental Goa",
			"address": {
				"@type": "PostalAddress",
				"streetAddress": "MG Road, below Clube National",
				"addressLocality": "Altinho, panjim",
				"addressRegion": "Goa",
				"postalCode": "403001",
				"addressCountry": "IN"
			},

			"areaServed": {
				"@type": "State",
				"name": "Goa"
			},
			"contactPoint": [{
				"@type": "ContactPoint",
				"telephone": "9823370397",
				"contactType": "customer service"

			}]
		}
	</script>
</head>

<body>

	<?php include '_header.php'; ?>

	<div class="hero-wrap ftco-degree-bg" style="background-image: url('images/index-banner.png');" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row  no-gutters slider-text justify-content-start align-items-center justify-content-center">

				<div class="column mt-50">
					<div class="text w-100 mb-md-5 pb-md-5">
						<h1 class="mb-4">Explore Goa <br> on Wheels:<br> Hire a Car Today!</h1>
					</div>
				</div>

				<div class="column">

					<input type="radio" name="test" id="test-1" class="radio-test" checked="checked" />
					<input type="radio" name="test" id="test-2" class="radio-test" />

					<div class="labels">
						<!-- <label for="test-1" id="label-test-1" class="label">CAR </label>
						<label for="test-2" id="label-test-2" class="label">COACH</label> -->
					</div>
					<div class="content content-test-1" id="content-test-1">
						<form action="car_listing.php" method="get" id="enqform" name="enqform">
							<input type="hidden" name="srch_mode" id="srch_mode" value="QUERY" />

							<label class="form-label">From</label>
							<div class="inputWithIcon">
								<select id="cmbfrom" name="cmbfrom" class="from-control selectTime" onchange="getTOlocation();" required>
									<option value="">Select</option>
									<optgroup class="arrival" label="Arrival Point">
										<?php
										foreach ($HOTSPOT_ARR as $key => $value) {
											$selected = ($cmbfrom == $key) ? 'selected' : '';
											echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
										}
										?>
									</optgroup>
									<optgroup class="arrival" label="Locations">
										<?php
										foreach ($LOC_ARR as $key => $value) {
											$selected = ($cmbfrom == $key) ? 'selected' : '';
											echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
										}
										?>
									</optgroup>

								</select>
							</div>

							<label class="form-label">To</label>
							<div class="inputWithIcon">
								<?php echo FillCombo($cmbto, 'cmbto', 'COMBO', '', $LOC_ARR, 'required', ' selectTime'); ?>
							</div>

							<label class="form-label">Vehicle Type</label>
							<div class="inputWithIcon">
								<select name="vtype" id="vtype" class="selectTime">
									<option value="1">Car</option>
									<option value="2">Coaches</option>
								</select>
							</div>



							<div class="d-flex gap-10">

								<div class="w-40">
									<label class="form-label">Date</label>
									<div class="inputWithIcon">
										<input type="date" name="txtdate" onchange="GetTimeDropdown();" min="<?php echo TODAY; ?>" value="<?php echo $txtdate; ?>" id="txtdate" placeholder="DD/MM/YYYY" required>
										<!--<i class="date"></i>-->
									</div>
								</div>

								<div class="w-20">
									<label class="form-label">Time</label>
									<div class="inputWithIcon">
										<?php //echo FillCombo($cmbtime, 'cmbtime', 'COMBO', '0', $TIME_CAR_ARR, 'required', ' selectTime'); 
										?>
										<select name="cmbtime" id="cmbtime" class="selectTime">

											<?php
											foreach ($TIME_CAR_ARR as $time_value) {
												$time_stamp = strtotime($time_value);
												if ($time_stamp > $one_hour_later) {
													echo '<option value="' . $time_value . '">' . $time_value . '</option>';
												} else {
													//echo '<option value="' . $time_value . '" disabled>' . $time_value . '</option>';
												}
											}

											?>

										</select>
										<!--<i class="time"></i>-->
									</div>
								</div>

								<div class="w-20">
									<label class="form-label">Pax</label>
									<div class="inputWithIcon">
										<?php echo FillCombo($cmbpasses, 'cmbpasses', 'COMBO', '', $PASS_ARR, 'required', 'from-control selectTime'); ?>
									</div>
								</div>

								<div>
									<br>
									<button type="submit" class="search-btn">SEARCH </button>
								</div>

							</div>

						</form>
					</div>


					<!-- 	<div class="content content-test-2" id="content-test-2">

					<form action="coach_listing.php" method="get">
							<input type="hidden" name="srch_mode" id="srch_mode" value="QUERY" />

							<label class="form-label">From</label>
							<div class="inputWithIcon">
								<select id="cmbfromc" name="cmbfrom" class="from-control selectTime" onchange="getTOlocationC();" required>
									<option value="">Select</option>
									<optgroup class="arrival" label="Arrival Point">
										<?php
										foreach ($HOTSPOT_ARR as $key => $value) {
											$selected = ($cmbfrom == $key) ? 'selected' : '';
											echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
										}
										?>
									</optgroup>
									<optgroup class="arrival" label="Locations">
										<?php
										foreach ($LOC_ARR as $key => $value) {
											$selected = ($cmbfrom == $key) ? 'selected' : '';
											echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
										}
										?>
									</optgroup>

								</select>
							</div>

							<label class="form-label">To</label>
							<div class="inputWithIcon">
								<?php echo FillCombo($cmbto, 'cmbtoc', 'COMBO', '', $LOC_ARR, 'required', ' selectTime'); ?>
							</div>

							<div class="d-flex gap-10">

								<div class="w-40">
									<label class="form-label">Date</label>
									<div class="inputWithIcon">
										<input type="date" name="txtdate" value="<?php echo $txtdate; ?>" id="txtdate" placeholder="DD/MM/YYYY" required>
										
									</div>
								</div>

								<div class="w-20">
									<label class="form-label">Time</label>
									<div class="inputWithIcon">
										
										<select name="cmbtime" id="cmbtime" class="selectTime">

										<?php
										foreach ($TIME_CAR_ARR as $time_value) {
											$time_stamp = strtotime($time_value);
											if ($time_stamp > $one_hour_later) {
												echo '<option value="' . $time_value . '">' . $time_value . '</option>';
											} else {
												echo '<option value="' . $time_value . '" disabled>' . $time_value . '</option>';
											}
										}

										?>

										</select>
										
									</div>
								</div>

								<div class="w-20">
									<label class="form-label">Pax</label>
									<div class="inputWithIcon">
										<?php echo FillCombo($cmbpasses, 'cmbpasses', 'COMBO', '', $PASS_ARR, '', 'from-control selectTime'); ?>
									</div>
								</div>

								<div>
									<br>
									<button type="submit" class="search-btn">SEARCH </button>
								</div>

							</div>

						</form> 
					</div>-->

				</div>

			</div>
		</div>
	</div>

	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center mb-5">
				<div class="col-md-7 text-center heading-section ">
					<h2 class="mb-3 text-black">How it works</h2>
				</div>
			</div>
			<div class="row cont-center">
				<div class="col-md-3">
					<div class="services services-2 w-100 text-center">
						<div class="icon d-flex1 align-items-center justify-content-center"><span class="flaticon-location"></span></div>
						<div class="text w-100">
							<h3 class="heading mb-2">Choose location</h3>
							<p>Make your trip to Goa memorable from the moment you arrive. Choose a location to have your car dropped to you.</p>
						</div>
					</div>
				</div>
				<div class="col-md-1 mob-col">
					<br>
					<span class="flaticon-arrow"></span>
					<br>
				</div>
				<div class="col-md-3">
					<div class="services services-2 w-100 text-center">
						<div class="icon d-flex1 align-items-center justify-content-center"><span class="flaticon-date"></span></div>
						<div class="text w-100">
							<h3 class="heading mb-2">Pick date</h3>
							<p>Choose the date when you would prefer to have your car delivered to you and a time that is of utmost convenience.</p>
						</div>
					</div>
				</div>
				<div class="col-md-1 mob-col">
					<br>
					<span class="flaticon-arrow"></span>
					<br>
				</div>
				<div class="col-md-3">
					<div class="services services-2 w-100 text-center">
						<div class="icon d-flex1 align-items-center justify-content-center"><span class="flaticon-car"></span></div>
						<div class="text w-100">
							<h3 class="heading mb-2">Book your vehicle</h3>
							<p>Choose from our vast collection of vehicles to make your holiday in Goa one you will cherish for a lifetime.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="ftco-section" style="background-image: url('images/about-us.png');background-size: cover;background-repeat: no-repeat; background-position: 50% 0px;">
		<div class="container">
			<div class="row justify-content-center mb-5">
				<div class="col-md-7 text-center heading-section">
					<h2 class="mb-3 text-white">About us</h2>
					<p class="text-white">Experience an extraordinary vacation in Goa with Royal Holidays. As the premier vehicle rental company in the coastal state, we provide top-notch vehicles and deliver exceptional service to enhance your holiday experience.
					</p>
					<p class="text-white">Whether you want to explore the sandy beaches, visit popular attractions, or immerse yourself in the vibrant culture of Goa, our fleet of well-maintained and comfortable vehicles will cater to all your sight-seeing needs. </p>
					<br>
					<!--<button class="trans-btn">read more</button>-->
				</div>
			</div>
		</div>
	</section>

	<section class="ftco-section ">
		<div class="container">

			<div class="row justify-content-center mb-5">
				<div class="col-md-7 text-center heading-section">
					<h2 class="mb-3 ">Featured Vehicles</h2>
					<p>Browse our top-notch car and coach selection for an extraordinary vacation in Goa with Royal Holidays.</p>
				</div>
			</div>

			<div class="row justify-content-center mb-5">

				<input type="radio" name="abt" id="abt-1" class="radio-abt" checked="checked" />
				<input type="radio" name="abt" id="abt-2" class="radio-abt" />
				<input type="radio" name="abt" id="abt-3" class="radio-abt" />
				<input type="radio" name="abt" id="abt-4" class="radio-abt" />

				<div class="abt-labels">
					<label for="abt-1" id="label-abt-1" class="abt-label">ALL </label>
					<label for="abt-2" id="label-abt-2" class="abt-label">CAR</label>
					<label for="abt-3" id="label-abt-3" class="abt-label">COACH</label>
					<!--<label for="abt-4" id="label-abt-4" class="abt-label">DISPOSALS</label>-->
				</div>

				<div class="content-abt content-abt-1" id="content-abt-1">

					<div class="row">
						<?php
						foreach ($dataArray as $i => $row) {
							$file_pic = $row->vPic;
							$src = NOIMAGE;
							if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
								$src = VEHICLE_IMG_PATH . $file_pic;
							$rurl = '';
							if ($row->VCatIDs == 1) {
								$rurl = 'car_display.php';
							} elseif ($row->VCatIDs == 2) {
								$rurl = 'coach_display.php';
							}
						?>
							<div class="column1">
								<div class="card">

									<!-- <div class="card-tag">
										<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
									</div> -->

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
											<!-- <div class="flx4"><span class="card-head">RS.<?php echo $row->fBaseFare; ?></span> <s class="strike-text">RS.6000</s></div> -->
											<!-- <div class="flx5"><a href="<?php echo $rurl . '?id=' . $row->iVehicleID ?>"><button type="button" class="search-btn wpx-165 mt-2">view details</button></a></div> -->
										</div>


									</div>

								</div>
							</div>
						<?php	}


						?>


						<!-- <div class="column1">
							<div class="card">

								<div class="card-tag">
									<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
								</div>

								<img src="images/car-1.png" class="mt-10">

								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>

							</div>
						</div>


						<div class="column1">
							<div class="card">

								<img src="images/car-2.png" class="mt-10">

								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>




							</div>
						</div>

						<div class="column1">
							<div class="card">

								<div class="card-tag">
									<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
								</div>

								<img src="images/car-3.png" class="mt-10">

								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>
							</div>
						</div>

						<div class="column1">
							<div class="card">
								<img src="images/car-4.png" class="mt-10">
								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>
							</div>
						</div> -->

					</div>

					<!-- <br><br>

					<div class="row">

						<div class="column1">
							<div class="card">
								<img src="images/car-5.png" class="mt-10">
								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>
							</div>
						</div>


						<div class="column1">
							<div class="card">
								<img src="images/car-6.png" class="mt-10">
								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>
							</div>
						</div>

						<div class="column1">
							<div class="card">

								<div class="card-tag">
									<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
								</div>


								<img src="images/car-7.png" class="mt-10">
								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>
							</div>
						</div>

						<div class="column1">
							<div class="card">

								<div class="card-tag">
									<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
								</div>

								<img src="images/car-8.png" class="mt-10">
								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>
							</div>
						</div>


					</div> -->



					<div class="text-center mt-40">
						<!-- <button class="yellow-btn">load more</button> -->
					</div>

				</div>

				<div class="content-abt content-abt-2" id="content-abt-2">
					<div class="row">
						<?php
						foreach ($dataArray as $i => $row) {
							$file_pic = $row->vPic;
							$src = NOIMAGE;
							if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
								$src = VEHICLE_IMG_PATH . $file_pic;
							if ($row->VCatIDs == 1) {
								# code...

						?>
								<div class="column1">
									<div class="card">

										<!-- <div class="card-tag">
										<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
									</div> -->

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
												<!-- <div class="flx4"><span class="card-head">RS.<?php echo $row->fBaseFare; ?></span> <s class="strike-text">RS.6000</s></div> -->
												<!-- <div class="flx5"><a href="car_display.php?id=<?php echo $row->iVehicleID ?>"><button type="button" class="search-btn wpx-165 mt-2">view details</button></a></div> -->
											</div>


										</div>

									</div>
								</div>
						<?php }
						}


						?>




						<!-- <div class="column1">
							<div class="card">

								<img src="images/car-2.png" class="mt-10">

								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>




							</div>
						</div>

						<div class="column1">
							<div class="card">

								<div class="card-tag">
									<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
								</div>

								<img src="images/car-3.png" class="mt-10">

								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>
							</div>
						</div>

						<div class="column1">
							<div class="card">
								<img src="images/car-4.png" class="mt-10">
								<div class="container">

									<span class="card-head">Vehicle name</span>

									<div class="row">
										<div class="column-res">
											<i class="seat"></i><span>4 seaters</span>
										</div>
										<div class="column-res">
											<i class="car-small"></i><span>Sedan</span>
										</div>
									</div>
									<div class="row">
										<div class="column-res">
											<i class="fuel-pump"></i><span>Electic</span>
										</div>
										<div class="column-res">
											<i class="airbag"></i><span>Air bags</span>
										</div>
									</div>

									<br>

									<div class="mob-div">
										<div class="flx4"><span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s></div>
										<div class="flx5"><button class="search-btn wpx-165">view details</button></div>
									</div>


								</div>
							</div>
						</div> -->

					</div>
				</div>
				<div class="content-abt content-abt-3" id="content-abt-3">
					<?php

					foreach ($dataArray as $i => $row) {
						$file_pic = $row->vPic;
						$src = NOIMAGE;
						if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
							$src = VEHICLE_IMG_PATH . $file_pic;
						if ($row->VCatIDs == 2) {
					?>
							<div class="column1">
								<div class="card">

									<!-- <div class="card-tag">
										<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
									</div> -->

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
											<!-- <div class="flx4"><span class="card-head">RS.<?php echo $row->fBaseFare; ?></span> <s class="strike-text">RS.6000</s></div> -->
											<!-- <div class="flx5"><a href="coach_display.php?id=<?php echo $row->iVehicleID ?>"><button type="button" class="search-btn wpx-165 mt-2">view details</button></div> -->
										</div>


									</div>

								</div>
							</div>
					<?php }
					}


					?>
				</div>
				<div class="content-abt content-abt-4" id="content-abt-4"></div>

			</div>
		</div>
	</section>



	<section class="ftco-section ftco-about bg-blue desk-dis">
		<div class="container">
			<div class="row no-gutters">

				<div class="col-md-6 wrap-about ftco-animate">
					<div class="heading-section heading-section-white pl-md-5">

						<br><br>
						<h2 class="mb-3 text-white">Outbound vehicle</h2>
						<p class="text-white">Traveling inter-state and prefer not to switch vehicles? We got you covered with our collection of outbound cars and coaches.</p>

						<br><br><br>
						<a href="disposal.php"><button class="search-btn wpx-165 mt-2">outbound</button></a>
						<br><br>

					</div>
				</div>

				<div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(images/outbound.png);"></div>

			</div>
		</div>
	</section>



	<div class="mob-dis">
		<section class="bg-blue">
			<div class="container">
				<div class="row no-gutters">

					<div class="col-md-6 wrap-about ftco-animate">
						<div class="heading-section heading-section-white pl-md-5">

							<br><br>
							<h2 class="mb-3 text-white">Outbound vehicle</h2>
							<p class="text-white">Traveling inter-state and prefer not to switch vehicles? We got you covered with our collection of outbound cars and coaches.</p>

							<a href="outbound.php"><button class="search-btn wpx-165 mt-2">outbound</button></a>
							<br><br>

						</div>
					</div>

				</div>
			</div>
		</section>
		<section class="ftco-about">
			<div class="container">
				<img src="images/outbound.png" width="100%">
			</div>
		</section>
	</div>





	<section class="testimonial text-center">
		<div class="container">

			<div class="row justify-content-center">
				<div class="col-md-7 text-center heading-section">
					<h2 class="mb-3">Client Testimonials</h2>
					<img src="images/quote.png" class="mt-10">
				</div>
			</div>
			<div id="testimonial4" class="carousel slide testimonial4_indicators testimonial4_control_button thumb_scroll_x swipe_x" data-ride="carousel" data-pause="hover" data-interval="5000" data-duration="2000">

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
				<a class="carousel-control-prev" href="#testimonial4" data-slide="prev">
					<span class="carousel-control-prev-icon"></span>
				</a>
				<a class="carousel-control-next" href="#testimonial4" data-slide="next">
					<span class="carousel-control-next-icon"></span>
				</a>
			</div>
		</div>
	</section>

	<!--<section class="ftco-section">
		<div class="container">
		
			<div class="row justify-content-center mb-5">
				<div class="col-md-7 text-center heading-section">
					<h2 class="mb-3">Client Testimonials</h2>
					<img src="images/quote.png" class="mt-10">
				</div>  
			</div>
				
			
			<div id="carousel">
				<div class="btn-bar">
					<div id="buttons"><a id="prev" class="left" href="#">←</a><a id="next" class="right" href="#">→</a> </div>
				</div>
		
				<div id="slides">
					<ul>
						<li class="slide">
							<div class="quoteContainer">
								<p class="quote-phrase"><span class="quote-marks">"</span>I had an amazing experience renting a car from this company during my trip to Goa. The car was in excellent condition and very well-maintained, and it made exploring the beautiful sights and beaches of Goa so much easier and convenient. The staff were friendly and professional, and they provided me with all the information I needed to make the rental process smooth and hassle-free. I would definitely recommend this company to anyone looking for a reliable and affordable car rental service in Goa. Thank you for making my trip so memorable!<span class="quote-marks">"</span>

								</p>
							</div>
							<div class="authorContainer mt-10">
								<p class="quote-author">- Jay sean</p>
							</div>
						</li>
						<li class="slide">
							<div class="quoteContainer">
								<p class="quote-phrase"><span class="quote-marks">"</span>I had an amazing experience renting a car from this company during my trip to Goa. The car was in excellent condition and very well-maintained, and it made exploring the beautiful sights and beaches of Goa so much easier and convenient. The staff were friendly and professional, and they provided me with all the information I needed to make the rental process smooth and hassle-free. I would definitely recommend this company to anyone looking for a reliable and affordable car rental service in Goa. Thank you for making my trip so memorable!<span class="quote-marks">"</span>

								</p>
							</div>
							<div class="authorContainer mt-10">
								<p class="quote-author">- Jay sean 1</p>
							</div>
						</li>
						<li class="slide">
							<div class="quoteContainer">
								<p class="quote-phrase"><span class="quote-marks">"</span>I had an amazing experience renting a car from this company during my trip to Goa. The car was in excellent condition and very well-maintained, and it made exploring the beautiful sights and beaches of Goa so much easier and convenient. The staff were friendly and professional, and they provided me with all the information I needed to make the rental process smooth and hassle-free. I would definitely recommend this company to anyone looking for a reliable and affordable car rental service in Goa. Thank you for making my trip so memorable!<span class="quote-marks">"</span>

								</p>
							</div>
							<div class="authorContainer mt-10">
								<p class="quote-author">- Jay sean 2</p>
							</div>
						</li>
					</ul>
				</div>
				
			</div>		
				
		</div>	
	</section>-->



	<section class="ftco-section ftco-intro" style="background-image: url(images/get-in-touch.png);padding: 4em 0;">
		<div class="container">

			<div class="row d-flex  contact-info">
				<div class="col-md-4">

					<div class="heading-section ftco-animate text-white">
						<h2 class="text-white">Get in Touch</h2>
					</div>


					<div class="row mb-5 mt-40">
						<div class="col-md-12">
							<div class=" w-100 rounded mb-2 d-flex1">
								<div class="icon mr-3">
									<span class="icon-map-o"></span>
								</div>
								<p class="footer-p">Royal Holidays India,Below Club National,Waglo Building,MG Road, Panjim,Goa - 403001</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="w-100  rounded mb-2 d-flex1">
								<div class="icon mr-3">
									<span class="icon-mobile-phone"></span>
								</div>
								<p class="footer-p"><a href="tel:+91 9823370597" class="text-white">+91 9823370597</a> / <a href="tel:+91 9822388666" class="text-white">+91 9822388666</a></p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="w-100 rounded mb-2 d-flex1">
								<div class="icon mr-3">
									<span class="icon-envelope-o"></span>
								</div>
								<p class="footer-p">info@royalcabsgoa.com</p>
							</div>
						</div>
					</div>

				</div>

				<div class="col-md-8 block-9">
					<form action="contact_mail.php" method="post" id="contact_form" class="p-5 contact-form b card-over">
						<div class="form-group">
							<input type="text" name="name" id="name" class="form-control" placeholder="Enter full name">
						</div>

						<div class="form-group">
							<input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
						</div>

						<div class="form-group">
							<input type="text" maxlength="10" onKeyPress="return numbersonly(event);" name="mobile" id="mobile" class="form-control" placeholder="Enter mobile number">
						</div>

						<div class="form-group">
							<textarea class="form-control" name="msg" id="msg" placeholder="Enter message"></textarea>
						</div>

						<div class="form-group">
							<input type="submit" value="submit" class="btn btn-primary px-5">
						</div>
					</form>

				</div>

			</div>

		</div>
	</section>

	<?php include '_footer.php'; ?>


	<?php include '_load_footer.php'; ?>

	<!--testimonial-->
	<script>
		function getTOlocation() {
			var cmbfrom = $('#cmbfrom').val();

			$.ajax({
				url: 'includes/ajax.inc.php',
				method: 'POST',
				data: {
					cmbfrom: cmbfrom,
					response: 'GET_TO_LOCATIONS'
				},
				success: function(res) {
					//console.log(res);
					$('#cmbto').html(res);

				}
			})
			//console.log(cmbfrom);
		}


		function GetTimeDropdown(){
			var sdate=$('#txtdate').val();
			$.ajax({
				url: 'includes/ajax.inc.php',
				method: 'POST',
				data: {
					sdate: sdate,
					response: 'GET_TIME_DROPDOWN'
				},
				success: function(res) {
					//console.log(res);
					$('#cmbtime').html(res);

				}
			})

		}


		$('#enqform').submit(function() {
			//alert('hii');
			var url='';
			var frm = document.enqform;
			console.log(frm);
			//frm.mec_mode.value = 'SEND_ADMISSION_LETTER';
			
			var vtype=$('#vtype');
			//console.log(vtype);
			if(vtype.val()=='1'){
				frm.action = 'car_listing.php';
			}else if (vtype.val()=='2') {
				frm.action = 'coach_listing.php';
			}
			frm.submit();

			return false;
			
		});




		function getTOlocationC() {
			var cmbfrom = $('#cmbfromc').val();

			$.ajax({
				url: 'includes/ajax.inc.php',
				method: 'POST',
				data: {
					cmbfrom: cmbfrom,
					response: 'GET_TO_LOCATIONS'
				},
				success: function(res) {
					//console.log(res);
					$('#cmbtoc').html(res);

				}
			})
		}



		function ShowError(element, mesg) {
			var spanID = element + "_span";

			if ($(element).hasClass("is-invalid")) {

			} else {
				$(element).addClass("is-invalid");
				$('<span id="' + spanID + '";" class="invalid-feedback em">' + mesg + '</span>').insertAfter(element);
			}
		}

		function HideError(element) {
			var elemID = $(element).attr('id');
			var spanID = elemID + "_span";

			$(element).removeClass("is-invalid");
			$('#' + spanID).remove();
		}
		$('#contact_form').submit(function() {
			//alert('hiii');

			var err = 0;
			var txtname = $("#name");
			var email = $("#email");
			var mobile = $("#mobile");
			var message = $("#msg");

			if ($.trim(txtname.val()) == '') {
				ShowError(txtname, 'Please enter the name');
				err++;
			}

			if ($.trim(email.val()) == '') {
				ShowError(email, 'Please enter the email');
				err++;
			}

			if ($.trim(mobile.val()) == '') {
				ShowError(mobile, 'Please enter the mobile');
				err++;
			}

			if ($.trim(message.val()) == '') {
				ShowError(message, 'Please enter the message');
				err++;
			}

			if (err > 0) {
				return false;
			}
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
	</script>




</body>

</html>