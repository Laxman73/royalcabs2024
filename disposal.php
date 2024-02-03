<?php
include_once "includes/common_front.php";

$CAR_ARR = GetXArrFromYID("select iVehicleID,vName from vehicle where cStatus='A'  order by vName ", '3');

$PAGE_TITLE2 = 'Disposal';
$PAGE_TITLE .= $PAGE_TITLE2;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Outstation Vehicle Rentals | Hire outstation cabs/bus | Goa</title>
<meta name="description" content="Royal Holidays offers outstation vehicle rentals in Goa. Choose from our fleet of cars, & buses to embark on memorable journeys to your desired destinations."/>
<meta name="keywords" content="hire a car goa, car rental goa, rent coach, bus rental goa, coach rental goa, coach rental prices">
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Outstation Vehicle Rentals | Hire outstation cabs/bus | Goa" />
<meta property="og:description" content="Royal Holidays offers outstation vehicle rentals in Goa. Choose from our fleet of cars, & buses to embark on memorable journeys to your desired destinations." />
<meta property="og:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png">
<meta property="og:url" content="https://royalcabsgoa.com/disposal.php" />
<meta property="og:site_name" content="Royal Holidays" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="Royal Holidays offers outstation vehicle rentals in Goa. Choose from our fleet of cars, & buses to embark on memorable journeys to your desired destinations." />
<meta name="twitter:title" content="Outstation Vehicle Rentals | Hire outstation cabs/bus | Goa" />
<meta name="twitter:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png" />
<link rel="canonical" href="https://royalcabsgoa.com/disposal.php" />
	<?php include '_load_header.php'; ?>
	<style>
		.disposal_active {
			color: var(--yellow) !important;
		}
	</style>
</head>

<body>

	<?php include '_header.php'; ?>


	<div class="hero-wrap1 ftco-degree-bg" style="background-image: url('images/disposal-ban.png');" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>

	</div>




	<section class="ftco-section contact-section">
		<div class="container">

			<div class="row d-flex contact-info">
				<div class="col-md-4">

					<div class="heading-section ftco-animate text-white">
						<h2 class="text-black">Get a Quote</h2>
					</div>


					<div class="row mb-5 mt-40">
						<div class="col-md-12">
							<div class=" w-100 rounded mb-2 d-flex1">
								<div class="icon mr-3">
									<span class="icon-map-o"></span>
								</div>
								<p class="m-0">Royal Holidays India,Below Club National,Waglo Building,MG Road, Panjim,Goa - 403001</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="w-100 rounded mb-2 d-flex1">
								<div class="icon mr-3">
									<span class="icon-mobile-phone"></span>
								</div>
								<p class="m-0"><a href="tel:+91 9823370597" class="">+91 9823370597</a> / <a href="tel:+91 9822388666" class="">+91 9822388666</a></p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="w-100 rounded mb-2 d-flex1">
								<div class="icon mr-3">
									<span class="icon-envelope-o"></span>
								</div>
								<p class="m-0">info@royalcabsgoa.com</p>
							</div>
						</div>
					</div>

				</div>

				<div class="col-md-8 block-9">
					<form action="send_enq.php" id="enq_form" method="post" class="p-5 contact-form b card-over1">
						<div class="form-group">
							<input type="text" name="name" id="name" class="form-control" placeholder="Enter full name">
						</div>

						<div class="form-group">
							<input type="text" id="email" name="email" class="form-control" placeholder="Enter email">
						</div>

						<div class="form-group">
							<input type="text" id="mobile" onkeypress="return numbersonly(event);" maxlength="10" name="mobile" class="form-control" placeholder="Enter mobile number">
						</div>
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" id="from" name="from" class="form-control" placeholder="From">
								</div>

							</div>
							<div class="col-md-6">

								<div class="form-group">
									<input type="text" id="to" name="to" class="form-control" placeholder="To">
								</div>
							</div>
						</div>


						<div class="form-group">
							<input type="date" name="date" id="date" min="<?php echo date("Y-m-d", strtotime('+5 days' . TODAY)); ?>" class="form-control" placeholder="TO">
						</div>
						<div class="form-group">
							<select name="vehicle_type" onchange="GetVehicleOptions();" id="vehicle_type" class="form-control" >
								<option value="">--Please select the type of vehicle --</option>
								<option value="1">Car</option>
								<option value="2">Coach</option>

							</select>
						</div>
						<div class="form-group">
							<select name="vehicleid" id="vehicleid" class="form-control" >
							<option value="">--Please select the  vehicle --</option>


							</select>
						</div>


						<div class="form-group">
							<textarea id="message" name="message" class="form-control" placeholder="Enter message"></textarea>
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
	<script src="includes/common.php"></script>


	<script>
	function validateEmail(email) {
			const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			return emailPattern.test(email);
		}
		function GetVehicleOptions() {
			var catID = $('#vehicle_type').val();
			$.ajax({
				url: '_getVehicles.php',
				method: 'POST',
				data: {
					vehicle_type: catID
				},
				success: function(res) {
					//console.log(res);
					var select = $("#vehicleid");

					// Clear existing options
					select.empty();

					// Add new options based on the object data
					$.each(res, function(key, value) {
						var option = $("<option>", {
							value: key,
							text: value
						});

						select.append(option);
					});

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


		function ShowError(element, mesg) {
		    var elemID = $(element).attr('id');
			var spanID = elemID + "_span";

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




		$(document).ready(function() {

			$('#enq_form').submit(function() {
				//alert('hiii');
				var txtname = $("#name");
				var email = $("#email");
				var mobile = $("#mobile");
				var message = $("#message");
				var from = $("#from");
				var to = $("#to");
				var date = $('#date');
				var vehicle_type = $('#vehicle_type');
				var vehicleid=$('#vehicleid');
				//txtnumber = $("#txtnumber").val();
				var err = 0;
				var ret_val=true;

				if ($.trim(txtname.val()) == '') {
					ShowError(txtname, 'Please enter the name');
					err++;
				}else{
				    	HideError(txtname);
				}


				if ($.trim(vehicle_type.val()) == '') {
					ShowError(vehicle_type, 'Please select  the vehicle type');
					err++;
				}else{
				    	HideError(vehicle_type);
				}
				    

				if ($.trim(vehicleid.val()) == '') {
					ShowError(vehicleid, 'Please select  the vehicle ');
					err++;
				}else{
				    HideError(vehicleid);
				}

				if (!validateEmail($.trim(email.val()))) {
					ShowError(email, "Please enter the valid email");
					err++;
				} else{
				    	HideError(email);
				}

				if ($.trim(mobile.val()) == '') {
					ShowError(mobile, 'Please enter the mobile');
					err++;
				}else{
				    	HideError(mobile);
				}

				if ($.trim(message.val()) == '') {
					ShowError(message, 'Please enter the message');
					err++;
				}else{
				    HideError(message);
				}

				if ($.trim(from.val()) == '') {
					ShowError(from, 'Please enter the from location');
					err++;
				}else{
				    HideError(from);
				}

				if ($.trim(to.val()) == '') {
					ShowError(to, 'Please enter the to location');
					err++;
				}else{
				    HideError(to);
				}

				if (!(date.val())) {
					ShowError(date, 'Please select the date');
					err++;
				}else{
				    HideError(date);
				}





				if (err > 0) {
					ret_val= false;
				}
				
				return ret_val;


			});


		});
	</script>

</body>

</html>