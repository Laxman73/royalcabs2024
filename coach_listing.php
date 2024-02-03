<?php
include_once "includes/common_front.php";
date_default_timezone_set('Asia/Kolkata');

$PAGE_TITLE2 = 'Coach List';
$PAGE_TITLE .= $PAGE_TITLE2;


// Get the current time
$current_time = strtotime(date('h:i A'));

// Get the time one hour from now
$one_hour_later = strtotime('+2 hour', $current_time);

if (URL_REWRITTING == 'ON') $disp_url = SITE_ADDRESS . 'coach-hire-in-goa.html';
else $disp_url = SITE_ADDRESS . 'coach_listing.php';

//$DIPOSAL_ID = GetXFromYID("select iVCatID from gen_vehicle_category where cStatus!='X' and vName like '%disposals%'");
$DIPOSAL_ID = 3;
$DISP_CAT_ID = 2; // Coach

$OWNER_ARR = GetXArrFromYID('select iOwnerID, vName from owner where cStatus!="X" order by iOwnerID', '3');
$TYPE_ARR = GetXArrFromYID('select iVTypeID, CONCAT(vName, " (", vSeats, ")") from gen_vehicle_type where cStatus!="X" and iVCatID=' . $DISP_CAT_ID . ' order by iVTypeID', '3');
$TRAN_ARR = GetXArrFromYID('select iVTransID, vName from gen_vehicle_transmission where cStatus!="X" order by iVTransID', '3');
$FUEL_ARR = GetXArrFromYID('select iVFuelID, vName from gen_vehicle_fuel where cStatus!="X" order by iVFuelID', '3');

$LOC_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' and cArivalpoint!='Y'   order by vName ", '3');
// DFA($LOC_ARR);
//DFA($LOC_ARR);
$HOTSPOT_ARR = GetXArrFromYID("select iLocationID,vName from location where cStatus='A' and cArivalpoint='Y'  order by vName ", '3');

$execute_query = false;
$cmbtime = $cmbpasses = $cmbfrom = $txtdate = $cmbto = $filter = $coachtype = $carfuel = $cartran = $sort = $txtkeyword = '';
$Loc_ds = 0;

$dataArray = array();
$cond = "";




if (isset($_POST['srch_mode']) && $_POST['srch_mode'] == 'SUBMIT') {
	// DFA($_POST);
	// exit;
	$cmbfrom = $_POST['cmbfrom'];
	$txtkeyword = isset($_POST['txtkeyword']) ? db_input2($_POST['txtkeyword']) : '';
	$txtdate = $_POST['txtdate'];
	$cmbto = $_POST['cmbto'];
	$cmbtime = $_POST['cmbtime'];
	$cmbpasses = $_POST['cmbpasses'];
	$filter = $_POST['filter'];
	$coachtype = $_POST['coachtype'];
	$carfuel = $_POST['carfuel'];
	$cartran = $_POST['cartran'];
	$sort = $_POST['sort'];

	$params = '&txtkeyword=' . $txtkeyword . '&cmbfrom=' . $cmbfrom . '&cmbto=' . $cmbto . '&cmbtime=' . $cmbtime . '&cmbpasses=' . $cmbpasses . '&filter=' . $filter . '&coachtype=' . $coachtype . '&carfuel=' . $carfuel . '&cartran=' . $cartran . '&sort=' . $sort . '&txtdate=' . $txtdate;
	header('location: ' . $disp_url . '?srch_mode=QUERY' . $params);
} else if (isset($_GET['srch_mode']) && $_GET['srch_mode'] == 'QUERY') {
	$is_query = true;

	if (isset($_GET['txtkeyword'])) $txtkeyword = $_GET['txtkeyword'];
	if (isset($_GET['cmbfrom'])) $cmbfrom = $_GET['cmbfrom'];
	if (isset($_GET['cmbto'])) $cmbto = $_GET['cmbto'];
	if (isset($_GET['cmbtime'])) $cmbtime = $_GET['cmbtime'];

	if (isset($_GET['txtdate'])) $txtdate = $_GET['txtdate'];

	if (isset($_GET['cmbpasses'])) $cmbpasses = $_GET['cmbpasses'];
	if (isset($_GET['filter'])) $filter = $_GET['filter'];
	if (isset($_GET['coachtype'])) $coachtype = $_GET['coachtype'];

	if (isset($_GET['carfuel'])) $carfuel = $_GET['carfuel'];
	if (isset($_GET['cartran'])) $cartran = $_GET['cartran'];
	if (isset($_GET['sort'])) $cartran = $_GET['sort'];

	$params2 = '?&txtkeyword=' . $txtkeyword . '&cmbfrom=' . $cmbfrom . '&cmbto=' . $cmbto . '&cmbtime=' . $cmbtime . '&cmbpasses=' . $cmbpasses . '&filter=' . $filter . '&coachtype=' . $coachtype . '&carfuel=' . $carfuel . '&cartran=' . $cartran . '&sort=' . $sort . '&txtdate=' . $txtdate;
} else if (isset($_GET['srch_mode']) && $_GET['srch_mode'] == 'MEMORY')
	SearchFromMemory($MEMORY_TAG, $disp_url);

if (!empty($txtkeyword)) {
	$txtkeyword = strtolower($txtkeyword);
	$cond .= " and (LOWER(v.vName) LIKE '%" . $txtkeyword . "%')";
	$execute_query = true;
}

if (!empty($cmbfrom)) {
	$execute_query = true;
}

if (!empty($cmbto)) {
	$execute_query = true;
}

if (!empty($coachtype)) {
	$cond .= " and gvt.iVTypeID='$coachtype' ";
	$execute_query = true;
}




if (!empty($cmbfrom) && !empty($cmbto)) {
	//$cartArr['data']['location']['cmbfrom']=$cmbfrom;
	//$cartArr['data']['location']['cmbto']=$cmbto;
	$Loc_ds = GetTotalDistance($cmbfrom, $cmbto, 28);
	//$Loc_ds = 100;
}




$q = "SELECT v.*, gvt.vName AS TypeName, gvt.vSeats, tar.fBaseFare, CONCAT('~',GROUP_CONCAT(vca.iVCatID SEPARATOR '~'),'~') AS VCatIDs 
FROM vehicle AS v 
LEFT JOIN vehicle_cat_assoc AS vca ON (vca.iVehicleID=v.iVehicleID) 
LEFT JOIN gen_vehicle_type AS gvt ON (gvt.iVTypeID=v.iVTypeID) 
LEFT JOIN tariff AS tar ON (tar.iVehicleID=v.iVehicleID AND tar.iVCatID=$DISP_CAT_ID) 
WHERE 1 $cond 
GROUP BY v.iVehicleID 
HAVING VCatIDs LIKE '%~$DISP_CAT_ID~%' 
ORDER BY v.iVehicleID DESC ";





$r = sql_query($q, "ERR1");
$dataArray = sql_num_rows($r) > 0 ? sql_get_data($r) : $dataArray;
//var_dump($dataArray);exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Rent a Bus | Bus/Coaches Rental Service | Royal Holidays Goa</title>
	<meta name="description" content="Royal Holidays offers coach & bus rental services in Goa. Rent a coach or bus & enjoy comfortable and convenient transportation with our well-equipped vehicles." />
	<meta name="keywords" content="coach rental goa,  coach rental prices, rent coach, rent a bus, bus rental goa, goa bus rental,  royal holidays goa">
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Rent a Bus | Bus/Coaches Rental Service | Royal Holidays Goa" />
	<meta property="og:description" content="Royal Holidays offers coach & bus rental services in Goa. Rent a coach or bus & enjoy comfortable and convenient transportation with our well-equipped vehicles." />
	<meta property="og:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png">
	<meta property="og:url" content="https://royalcabsgoa.com/coach-hire-in-goa.html" />
	<meta property="og:site_name" content="Royal Holidays" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="Rent a Bus | Bus/Coaches Rental Service | Royal Holidays Goa" />
	<meta name="twitter:description" content="Royal Holidays offers coach & bus rental services in Goa. Rent a coach or bus & enjoy comfortable and convenient transportation with our well-equipped vehicles." />
	<meta name="twitter:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png" />
	<link rel="canonical" href="https://royalcabsgoa.com/coach-hire-in-goa.html" />
	<?php include '_load_header.php'; ?>
	<style>
		.coach_active {
			color: var(--yellow) !important;
		}
	</style>
</head>

<body>

	<?php include '_header.php'; ?>
	<form class="" name="carList" id="carList" action="" onsubmit="return ValidateForm();" method="post">
		<input type="hidden" name="srch_mode" id="srch_mode" value="SUBMIT" />

		<div class="hero-wrap1 ftco-degree-bg" style="background-image: url('images/coach-listing-banner.png');" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row  no-gutters slider-text1 justify-content-start align-items-center justify-content-center">


					<div class="text-center heading-section mt-170">
						<h2 class="text-white">Rent a perfect coach</h2>
					</div>

					<div class="abt-form">

						<div class="d-flex gap-10">

							<div class="w-30">
								<label class="form-label text-black">From</label>
								<div class="inputWithIcon">
									<!-- <input type="text" placeholder="Pick-up Location">
							<i class="loc"></i> -->
									<select id="cmbfrom" name="cmbfrom" class="from-control selectTime" onchange="getTOlocation();">
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
							</div>

							<div class="w-30">
								<label class="form-label text-black">To</label>
								<div class="inputWithIcon">
									<!-- <input type="text" placeholder="Drop-of Location">
							<i class="loc"></i> -->
									<?php echo FillCombo($cmbto, 'cmbto', 'COMBO', '', $LOC_ARR, '', ' selectTime'); ?>
								</div>
							</div>

							<div class="w-20">
								<label class="form-label text-black">Date</label>
								<div class="inputWithIcon">
									<input type="date" name="txtdate" min="<?php echo TODAY; ?>" onchange="GetTimeDropdown();" value="<?php echo $txtdate; ?>" id="txtdate" placeholder="DD/MM/YYYY">
									<!--<i class="date"></i>-->
								</div>
							</div>

							<div class="w-20">
								<label class="form-label text-black">Time</label>
								<div class="inputWithIcon">
									<?php //echo FillCombo($cmbtime, 'cmbtime', 'COMBO', '0', $TIME_CAR_ARR, '', ' selectTime'); ?>
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
								<label class="form-label text-black">Pax</label>
								<div class="inputWithIcon">
									<?php echo FillCombo($cmbpasses, 'cmbpasses', 'COMBO', '0', $PASS_ARR_COACH, '', 'from-control selectTime'); ?>
								</div>
							</div>

							<div>
								<br>
								<button type="submit" name="filter" value="1" class="search-btn">SEARCH</button>
							</div>

						</div>

					</div>

				</div>
			</div>
		</div>




		<section class="ftco-section contact-section pd-26">
			<div class="container">
				<div class="row d-flex mb-5 contact-info c-end">
					<div class="row col-md-3">
						<div class="col-md-12 p-xl-0">
							<div class="w-100 mb-2 listing-card">

								<div class="w-100 p-w  border-bottom">
									<span class="float-left card-head">Filter</span>
								<span class="float-right text-yellow"><a href="<?php echo $disp_url;?>">Clear all filters</a></span>
								</div>



								<div class="w-100 p-3 mb-2 border-bottom">
									<span class="float-left normal-text">Price</span>
									<div class="price-input">
										<div>Rs.<input class="input-min" value="00"></div>
										<div class="text-right">Rs.<input class="input-max" value="10000"></div>
									</div>

									<div class="slider">
										<div class="progress"></div>
									</div>
									<div class="range-input">
										<input type="range" onchange="ApplyrangeFilter();" id="from_r" class="range-min" min="0" max="10000" value="00" step="100">
										<input type="range" onchange="ApplyrangeFilter();" id="to_r" class="range-max" min="0" max="10000" value="10000" step="100">
									</div>

								</div>



								<div class="w-100 p-3 mb-2 ">

									<span class="float-left normal-text">Coach type</span> <br>


									<input type="radio" id="coachtype_all" name="coachtype" value="" checked>
									<label for="coachtype_all">&nbsp;&nbsp;&nbsp;All</label><br>
									<?php
									foreach ($TYPE_ARR as $id => $name) {
									?>
										<input type="radio" id="coachtype_<?php echo ($id); ?>" name="coachtype" value="<?php echo ($id); ?>">
										<label for="coachtype_<?php echo ($id); ?>">&nbsp;&nbsp;&nbsp;<?php echo ($name); ?></label><br>
									<?php
									}
									?>

								</div>

								<!-- <div  class="w-100 p-3 mb-2 border-bottom">		
						
							<span class="float-left normal-text">Fuel Type</span> <br>
							

							<input type="radio" id="coachfuel_all" name="coachfuel" value="" checked>
							<label for="coachfuel_all">&nbsp;&nbsp;&nbsp;All</label><br>
							<?php
							foreach ($FUEL_ARR as $id => $name) {
							?>
								<input type="radio" id="coachfuel_<?php echo ($id); ?>" name="coachfuel" value="<?php echo ($id); ?>">
								<label for="coachfuel_<?php echo ($id); ?>">&nbsp;&nbsp;&nbsp;<?php echo ($name); ?></label><br>
								<?php
							}
								?>

						</div>
						
						
						<div class="w-100 p-3 mb-2 border-bottom">		
						
							<span class="float-left normal-text">Special features</span> <br>

							  <input type="radio" id="accessibility" name="features" value="accessibility">
							  <label for="accessibility">Wheelchair accessibility</label><br>
							  <input type="radio" id="storage" name="features" value="storage">
							  <label for="storage">Luggage storage</label>

						</div>
						
						
					
						<div  class="w-100 p-3 mb-2 ">		
						
							<span class="float-left normal-text">Seating capacity</span>
							<div class="price-input1">
								<div><input class="input-min1" value="0"></div>
								<div class="text-right"><input class="input-max1" value="40"></div>
							</div>
						  
							<div class="slider1">
								<div class="progress1"></div>
							</div>
							<div class="range-input1">
								<input type="range" class="range-min1" min="0" max="40" value="0" step="5">
								<input type="range" class="range-max1" min="0" max="40" value="40" step="5">
							</div>
							
						</div> -->


							</div>
						</div>


					</div>


					<div class="col-md-9">

						<div class="d-flex gap-10 mt-10">

							<div class="pd-10 w-30">
								<span class="card-head">Available Coaches</span>
								<br>
								<span class="text-blue-small"><?php echo (count($dataArray)); ?> Coaches available</span>
							</div>

							<div class="abt-form1 w-50 pd-10">

								<div class="d-flex1 gap-10 just-center">

									<div class="inputWithIcon inputWithIcon1">
										<input type="text" name="txtkeyword" id="txtkeyword" onkeyup="getCoaches();" value="<?php echo $txtkeyword; ?>" placeholder="Find a vehicle" class="border-0 input-1">
										<i class="search"></i>
									</div>

									<button type="submit" name="filter" value="1" class="search-btn">SEARCH </button>

								</div>
							</div>
							<div class="abt-form1 pdx-1 w-30">
								<label for="Sort">Sort by:</label>
								<select name="sort" id="sort" onclick="ChangePriceFilter();" class="border-0">
									<option value="1">Price high to low</option>
									<option value="2">Price low to high </option>
								</select>
							</div>
						</div>
						<div id="cars_card">

							<?php
							foreach ($dataArray as $i => $row) {
								$cats = explode("~", $row->VCatIDs);
								$cats = array_values(array_filter($cats));
								$file_pic = $row->vPic;
        						$src = NOIMAGE;
        						if (IsExistFile($file_pic, VEHICLE_IMG_UPLOAD))
        							$src = VEHICLE_IMG_PATH . $file_pic;
								$price = $row->fBaseFare;
								if ($execute_query) {
									$price = GetFinalPrice($Loc_ds, $row->iVehicleID,$TIME_CAR_ARR[$cmbtime]);
								}
								if (URL_REWRITTING == 'ON') $URL_COACHLISTING = 'summary.php';
								//if (URL_REWRITTING == 'ON') $URL_COACHLISTING = SITE_ADDRESS . $row->vUrlName . '-coach-hire-goa.html';
								else $URL_COACHLISTING = SITE_ADDRESS . 'coach_display.php?id=' . $row->iVehicleID;

							?>
								<div class="card mt-40">
									<?php if (in_array($DIPOSAL_ID, $cats)) { ?><div class="card-tag"><i class="Car-Key"></i><span class="tag-text">Available for disposal</span></div><?php } ?>
									<div class="d-flex">
										<img src="<?php echo $src; ?>" class="mt-10">
										<div class="container">
											<br>
											<?php if ($row->cRecommended == 'Y') { ?><span class="card-tag1">Recommended</span><?php } ?>
											<?php if (false) { ?><span class="card-tag2">Special offer</span><?php } ?>
											<br><br>
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
											</div> -->
											</div>
											<br>
										</div>
										<div class="rate-div">
											<?php if (false) { ?><s class="strike-text1">RS.&nbsp;16000</s> <?php } else echo ('&nbsp;'); ?>
											<br>
											<?php if ($Loc_ds != '0') { ?>
											<span class="card-head1">Rs.&nbsp;<?php echo $price; ?></span>
											<br>
											<span class="card-p">Price for night differs</span>
											<a href="<?php echo $URL_COACHLISTING . '?cmbfrom=' . $cmbfrom . '&cmbto=' . $cmbto . '&txtdate=' . $txtdate . '&cmbtime=' . $cmbtime . '&cmbpasses=' . $cmbpasses.'&vehicle_id='.$row->iVehicleID; ?>"><button type="button" class="search-btn wpx-165 mt-2">view details</button></a>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php
							}
							?>
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
		function GetTimeDropdown() {
			var sdate = $('#txtdate').val();
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

		function ApplyrangeFilter() {
			var from_r = $('#from_r').val();
			var to_r = $('#to_r').val();
			var sort = $('#sort').val();
			//console.log(sort);
			var cmbfrom = $('#cmbfrom').val();
			var cmbto = $('#cmbto').val();
			var txtdate = $('#txtdate').val();
			var cmbtime = $('#cmbtime').val();
			var cmbpasses = $('#cmbpasses').val();
			var cartype = $('input[name="cartype"]:checked').val();
			var txtkeyword = $('#txtkeyword').val();
			console.log(from_r);
			console.log(to_r);

			if(ValidateForm()){
				$.ajax({
					url: '_getCoaches.php',
					method: 'POST',
					data: {
						response: 'APPLY_PRICE_FILTER',
						from_r: from_r,
						to_r: to_r,
						cmbfrom: cmbfrom,
						cmbto: cmbto,
						txtdate: txtdate,
						cmbtime: cmbtime,
						cmbpasses: cmbpasses,
						cartype: cartype,
						txtkeyword: txtkeyword
					},
					success: function(res) {
						//console.log(res);
						$('#cars_card').html(res);
	
					}
				});

			}

		}



		function ValidateForm() {
			var cmbfrom = $('#cmbfrom');
			var cmbto = $('#cmbto');
			var txtdate = $('#txtdate');
			var cmbtime = $('#cmbtime');
			var cmbpasses = $('#cmbpasses');

			var err = 0;
			var ret_val = true;

			if ($.trim(cmbfrom.val()) == '') {
				ShowError(cmbfrom, "Please select  the from location");
				err++;
			}

			if ($.trim(cmbto.val()) == '') {
				ShowError(cmbto, "Please select  the to location");
				err++;
			}

			if (!(txtdate.val())) {
				ShowError(txtdate, "Please select  the date");
				err++;
			}

			if ($.trim(cmbtime.val()) == '') {
				ShowError(cmbtime, "Please select  the time");
				err++;
			}

			if ($.trim(cmbpasses.val()) == '') {
				ShowError(cmbpasses, "Please select  the number of pssengers");
				err++;
			}

			if (err > 0) {
				ret_val = false;
			}

			return ret_val;


		}



		function getCoaches() {
			var cmbfrom = $('#cmbfrom').val();
			var cmbto = $('#cmbto').val();
			var txtdate = $('#txtdate').val();
			var cmbtime = $('#cmbtime').val();
			var cmbpasses = $('#cmbpasses').val();
			var cartype = $('input[name="cartype"]:checked').val();
			var txtkeyword = $('#txtkeyword').val();

			$.ajax({
				url: "_getCoaches.php",
				method: 'POST',
				data: {
					cmbfrom: cmbfrom,
					cmbto: cmbto,
					txtdate: txtdate,
					cmbtime: cmbtime,
					cmbpasses: cmbpasses,
					cartype: cartype,
					txtkeyword: txtkeyword

				},
				success: function(res) {
					//console.log(res);
					$('#cars_card').html(res);

				}


			});

		}


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


		function ChangePriceFilter() {
			var sort = $('#sort').val();
			//console.log(sort);
			var cmbfrom = $('#cmbfrom').val();
			var cmbto = $('#cmbto').val();
			var txtdate = $('#txtdate').val();
			var cmbtime = $('#cmbtime').val();
			var cmbpasses = $('#cmbpasses').val();
			var cartype = $('input[name="cartype"]:checked').val();
			var txtkeyword = $('#txtkeyword').val();

			$.ajax({
				url: "_getCoaches.php",
				method: 'POST',
				data: {
					cmbfrom: cmbfrom,
					cmbto: cmbto,
					txtdate: txtdate,
					cmbtime: cmbtime,
					cmbpasses: cmbpasses,
					cartype: cartype,
					txtkeyword: txtkeyword,
					sort: sort

				},
				success: function(res) {
					//console.log(res);
					$('#cars_card').html(res);

				}


			});
		}



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

		const rangeInput1 = document.querySelectorAll(".range-input1 input"),
			priceInput1 = document.querySelectorAll(".price-input1 input"),
			range1 = document.querySelector(".slider1 .progress1");
		let priceGap1 = 5;

		priceInput1.forEach((input) => {
			input.addEventListener("input", (e) => {
				let minPrice1 = parseInt(priceInput1[0].value),
					maxPrice1 = parseInt(priceInput1[1].value);

				if (maxPrice1 - minPrice1 >= priceGap1 && maxPrice1 <= rangeInput1[1].max) {
					if (e.target.className === "input-min1") {
						rangeInput1[0].value = minPrice1;
						range1.style.left = (minPrice1 / rangeInput1[0].max) * 100 + "%";
					} else {
						rangeInput1[1].value = maxPrice1;
						range1.style.right = 100 - (maxPrice1 / rangeInput1[1].max) * 100 + "%";
					}
				}
			});
		});

		rangeInput1.forEach((input) => {
			input.addEventListener("input", (e) => {
				let minVal = parseInt(rangeInput1[0].value),
					maxVal = parseInt(rangeInput1[1].value);

				if (maxVal - minVal < priceGap1) {
					if (e.target.className === "range-min1") {
						rangeInput1[0].value = maxVal - priceGap1;
					} else {
						rangeInput1[1].value = minVal + priceGap1;
					}
				} else {
					priceInput1[0].value = minVal;
					priceInput1[1].value = maxVal;
					range1.style.left = (minVal / rangeInput1[0].max) * 100 + "%";
					range1.style.right = 100 - (maxVal / rangeInput1[1].max) * 100 + "%";
				}
			});
		});
	</script>

</body>

</html>