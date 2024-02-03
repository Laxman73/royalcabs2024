<?php
include_once "includes/common_front.php";

$PAGE_TITLE2 = 'Car List';
$PAGE_TITLE .= $PAGE_TITLE2;

//$DIPOSAL_ID = GetXFromYID("select iVCatID from gen_vehicle_category where cStatus!='X' and vName like '%disposals%'");
$DIPOSAL_ID = 3;
$DISP_CAT_ID = 1; // Car

$OWNER_ARR = GetXArrFromYID('select iOwnerID, vName from owner where cStatus!="X" order by iOwnerID','3');
$TYPE_ARR = GetXArrFromYID('select iVTypeID, CONCAT(vName, " (", vSeats, ")") from gen_vehicle_type where cStatus!="X" and iVCatID='.$DISP_CAT_ID.' order by iVTypeID','3');
$TRAN_ARR = GetXArrFromYID('select iVTransID, vName from gen_vehicle_transmission where cStatus!="X" order by iVTransID','3');
$FUEL_ARR = GetXArrFromYID('select iVFuelID, vName from gen_vehicle_fuel where cStatus!="X" order by iVFuelID','3');

$dataArray = array();
$cond = "";
$r = sql_query(
	"SELECT v.*, gvt.vName AS TypeName, gvt.vSeats, tar.fBaseFare, CONCAT('~',GROUP_CONCAT(vca.iVCatID SEPARATOR '~'),'~') AS VCatIDs 
		FROM vehicle AS v 
		LEFT JOIN vehicle_cat_assoc AS vca ON (vca.iVehicleID=v.iVehicleID) 
		LEFT JOIN gen_vehicle_type AS gvt ON (gvt.iVTypeID=v.iVTypeID) 
		LEFT JOIN tariff AS tar ON (tar.iVTypeID=v.iVTypeID AND tar.iVCatID=$DISP_CAT_ID) 
		WHERE 1 $cond 
		GROUP BY v.iVehicleID 
		HAVING VCatIDs LIKE '%~$DISP_CAT_ID~%' 
		ORDER BY v.iVehicleID DESC "
);
$dataArray = sql_num_rows($r)>0?sql_get_data($r):$dataArray;
//var_dump($dataArray);exit;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include '_load_header.php';?>
		<style>
		.car_active {
			color: var(--yellow)!important;
		}
		</style>
    </head>
	<body>
    
    <?php include '_header.php';?>
	<form class="" name="carList" id="carList" action="" method="get">
	
	<div class="hero-wrap1 ftco-degree-bg" style="background-image: url('images/car-listing-banner.png');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
	<div class="row no-gutters slider-text1 justify-content-start align-items-center justify-content-center">

			<div class="text-center heading-section mt-170">
				<h2 class="text-white">Rent a perfect car</h2>
			</div>

			<div class="abt-form">

            <div class="d-flex gap-10">

					<div class="w-30">
						<label class="form-label text-black">From</label>
						<div class="inputWithIcon">
							<input type="text" placeholder="Pick-up Location">
							<i class="loc"></i>
						</div>
					</div>	

					<div class="w-30">
						<label class="form-label text-black">To</label>
						<div class="inputWithIcon">
							<input type="text" placeholder="Drop-of Location">
							<i class="loc"></i>
						</div>
					</div>			
					
					<div class="w-20">
						<label class="form-label text-black">Date</label>
						<div class="inputWithIcon">
							<input type="date" placeholder="DD/MM/YYYY">
							<!--<i class="date"></i>-->
						</div>
					</div>	
						
					<div class="w-20">						
						<label class="form-label text-black">Time</label>
						<div class="inputWithIcon">
							<?php echo FillCombo($cmbtime,'cmbtime','COMBO','',$TIME_CAR_ARR,'','from-control'); ?>
							<!--<i class="time"></i>-->
						</div>
					</div>
							
					<div class="w-20">	
						<label class="form-label text-black">Pax</label>
						<div class="inputWithIcon">
							<input type="number" placeholder="00">
							<i class="person pdx-2"></i>
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
				
						<div  class="w-100 p-w  border-bottom">		
							<span class="float-left card-head" >Filter</span>
							<span class="float-right text-yellow">Clear all filters</span>
						</div>
						
						
						
						<div  class="w-100 p-3 mb-2 border-bottom">		
							<span class="float-left normal-text">Price</span>
							

						  <div class="price-input">
						 
							  <div>Rs.<input class="input-min" value="00"></div>
							  
							  <div class="text-right">Rs.<input class="input-max" value="10000"></div>
							
						 
						  </div>
						  
						  <div class="slider">
							<div class="progress"></div>
						  </div>
						  <div class="range-input">
							<input type="range" class="range-min" min="0" max="10000" value="00" step="100">
							<input type="range" class="range-max" min="0" max="10000" value="10000" step="100">
						  </div>
							
						</div>
						
						
						
						<div  class="w-100 p-3 mb-2 border-bottom">		
						
							<span class="float-left normal-text">Car type</span> <br>
							

							<input type="radio" id="cartype_all" name="cartype" value="" checked>
							<label for="cartype_all">&nbsp;&nbsp;&nbsp;All</label><br>
							<?php
							foreach ($TYPE_ARR as $id => $name)
							{
								?>
								<input type="radio" id="cartype_<?php echo($id); ?>" name="cartype" value="<?php echo($id); ?>">
								<label for="cartype_<?php echo($id); ?>">&nbsp;&nbsp;&nbsp;<?php echo($name); ?></label><br>
								<?php
							}
							?>

						</div>
						
						<div  class="w-100 p-3 mb-2 border-bottom">		
						
							<span class="float-left normal-text">Fuel Type</span> <br>
							

							<input type="radio" id="carfuel_all" name="carfuel" value="" checked>
							<label for="carfuel_all">&nbsp;&nbsp;&nbsp;All</label><br>
							<?php
							foreach ($FUEL_ARR as $id => $name)
							{
								?>
								<input type="radio" id="carfuel_<?php echo($id); ?>" name="carfuel" value="<?php echo($id); ?>">
								<label for="carfuel_<?php echo($id); ?>">&nbsp;&nbsp;&nbsp;<?php echo($name); ?></label><br>
								<?php
							}
							?>

						</div>
						
						
						<div  class="w-100 p-3 mb-2">		
						
							<span class="float-left normal-text">Transmission</span> <br>

							<input type="radio" id="cartran_all" name="cartran" value="" checked>
							<label for="cartran_all">&nbsp;&nbsp;&nbsp;All</label><br>
							<?php
							foreach ($TRAN_ARR as $id => $name)
							{
								?>
								<input type="radio" id="cartran_<?php echo($id); ?>" name="cartran" value="<?php echo($id); ?>">
								<label for="cartran_<?php echo($id); ?>">&nbsp;&nbsp;&nbsp;<?php echo($name); ?></label><br>
								<?php
							}
							?>

						</div>
						
						
					
				<!--<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">-->
				
					
			        </div>
		          </div>
		        
		       
          </div>
		  
		  
        <div class="col-md-9">
		
			<div class="d-flex gap-10 mt-10">

                <div class="pd-10 w-20">
					<span class="card-head">Available cars</span> 
					<br>
					<span class="text-blue-small"><?php echo(count($dataArray)); ?> cars available</span> 
				</div>
				
				<div class="abt-form1 w-50 pd-10">

					<div class="d-flex1 gap-10 just-center">

						<div class="inputWithIcon inputWithIcon1">
							<input type="text" placeholder="Find a vehicle" class="border-0 input-1">
							<i class="search"></i>
						</div>
						
						<button type="submit" name="filter" value="1" class="search-btn">SEARCH </button>
							
					</div>
				</div>
				<div class="abt-form1 pdx-1 w-30">
						<label for="sort">Sort by:</label>
						<select name="sort" id="sort" class="border-0">
						  <option value="1">Price high to low</option>
						  <option value="2">Price low to high </option>
						</select>
				</div>
			</div>

			<?php
			foreach ($dataArray as $i => $row)
			{
				$cats = explode("~",$row->VCatIDs);
				$cats = array_values(array_filter($cats));
				?>
				<div class="card mt-40">
					<?php if (in_array($DIPOSAL_ID, $cats)) { ?><div class="card-tag"><i class="Car-Key"></i><span class="tag-text">Available for disposal</span></div><?php } ?>
					<div class="d-flex">
						<img src="images/car-1.png" class="mt-10">
						<div class="container">
							<br>
							<?php if ($row->cRecommended=='Y') { ?><span class="card-tag1">Recommended</span><?php } ?>
							<?php if (false) { ?><span class="card-tag2">Special offer</span><?php } ?>
							<br><br>
							<span class="card-head"><?php echo($row->vName); ?></span>
							<div class="row">
								<div class="column-res">
									<i class="seat"></i><span><?php echo($row->vSeats); ?> seaters</span>
								</div>
								<div class="column-res">
									<i class="car-small"></i><span><?php echo($row->TypeName); ?></span>
								</div>
							</div>
							<div class="row">
								<div class="column-res">
									<i class="fuel-pump"></i><span><?php echo(!empty($FUEL_ARR[$row->iVFuelID])?$FUEL_ARR[$row->iVFuelID]:'- Na -'); ?></span>
								</div>
								<div class="column-res">
									<?php if ($row->cAirBags=='Y') { ?><i class="airbag"></i><span>Air bags</span><?php } ?>
								</div>
							</div>
							<br>
						</div>
						<div class="rate-div">
							<?php if (false) { ?><s class="strike-text1">RS.&nbsp;6000</s> <?php } else echo('&nbsp;'); ?>
							<br>
							<span class="card-head1">RS.&nbsp;<?php echo($row->fBaseFare); ?></span> 
							<br>
							<span class="card-p">Price for night differs</span>
							<a href="car_display.php?id=<?php echo($row->iVehicleID); ?>"><button type="button" class="search-btn wpx-165 mt-2">view details</button></a>
						</div>
					</div>
				</div>
				<?php
			}
			?>

        </div>

        </div>
      </div>
    </section>
	</form>

    <?php include '_footer.php';?>
    <?php include '_load_footer.php';?>
    
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

</body>
</html>