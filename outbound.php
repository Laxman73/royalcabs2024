<?php
include_once "includes/common_front.php";

$PAGE_TITLE2 = 'Outbound';
$PAGE_TITLE .= $PAGE_TITLE2;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include '_load_header.php';?> 
		<style>
		.disposal_active {
			color: var(--yellow)!important;
		}
		</style>		
    </head>
	<body>
    
    <?php include '_header.php';?>

	
	<div class="hero-wrap1 ftco-degree-bg" style="background-image: url('images/disposal-ban.png');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
	<div class="row  no-gutters slider-text1 justify-content-start align-items-center justify-content-center">

			    

			<div class="text-center heading-section mt-170">
				<h2 class="text-white">Vehicles available for disposal</h2>
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
							<input type="time" placeholder="00:00">
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
						<button class="search-btn">SEARCH </button>
					</div>
					
			</div>

			</div>
					
		

 
    </div>
    </div>
    </div>
	
	
	
	
    <section class="ftco-section contact-section">
      <div class="container">
	  
	  
        <div class="row d-flex contact-info c-end mtr">
     
		
		  
        <div class="col-md-12">
		
			
			<div class="d-flex gap-10 mb-5 mt-10">

                <div class="pd-10 w-20">
					<span class="card-head">Available cars</span> 
					<br>
					<span class="text-blue-small">50 cars available</span> 
				</div>
				
				<div class="abt-form1 w-40 pd-10">

					<div class="d-flex1 gap-10 just-center">

						<div class="inputWithIcon inputWithIcon1">
							<input type="text" placeholder="Find a vehicle" class="border-0 input-1">
							<i class="search"></i>
						</div>
						
						<button class="search-btn">SEARCH </button>
							
					</div>

				</div>
				
				<div class="abt-form1 pdx-1 w-20">
						<label for="Sort">Sort by:</label>

						<select name="Sort" id="Sort" class="border-0">
						  <option value="1">Price high to low</option>
						  <option value="2">Price low to high </option>
						</select>
                  
				</div>
				
				<div class="abt-form1 pdx-1 w-20">
						<label for="Sort">Vehicle type:</label>

						<select name="Sort" id="Sort" class="border-0">
						  <option value="1">All</option>
						</select>
				</div>

			</div>
			
			
			
			
		<h3 class="card-head-b ml-2">Cars</h3>  	
			
		<div class="row mtr">
		
		
					
			<div class="column1">
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
								
						<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
									
						<button class="search-btn wpx-165 mt-2">view details</button>
									
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
							<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
							<button class="search-btn wpx-165 mt-2">view details</button>
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
							<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
							<button class="search-btn wpx-165 mt-2">view details</button>
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
						<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
						<button class="search-btn wpx-165 mt-2">view details</button>
								
					</div>
				</div>
			</div>
						  
		</div>
		
		
		
				<div class="row mtr">
		
		
					
			<div class="column1">
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
								
						<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
									
						<button class="search-btn wpx-165 mt-2">view details</button>
									
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
							<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
							<button class="search-btn wpx-165 mt-2">view details</button>
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
							<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
							<button class="search-btn wpx-165 mt-2">view details</button>
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
						<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
						<button class="search-btn wpx-165 mt-2">view details</button>
								
					</div>
				</div>
			</div>
						  
		</div>
		
		
		
		<div class="text-center mt-5 mb-5">
			<a href="#" ><button class="btn-yellow">Load More</button></a>
		</div>
		
		
		
		<hr>
		
		
		
		<h3 class="card-head-b mt-5 mb-4 ml-2">Coaches</h3>  	
			
		<div class="row mtr">
		
		
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
								<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
								<button class="search-btn wpx-165 mt-2">view details</button>
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
								<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
								<button class="search-btn wpx-165 mt-2">view details</button>
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
								<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
								<button class="search-btn wpx-165 mt-2">view details</button>
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
								<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
								<button class="search-btn wpx-165 mt-2">view details</button>
							  </div>
							</div>
						  </div>
						  
						  
					
						  
		</div>
		
		<div class="row mtr">
					
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
								<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
								<button class="search-btn wpx-165 mt-2">view details</button>
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
								<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
								<button class="search-btn wpx-165 mt-2">view details</button>
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
								<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
								<button class="search-btn wpx-165 mt-2">view details</button>
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
								<span class="card-head">RS.3000</span> <s class="strike-text">RS.6000</s> 
								<button class="search-btn wpx-165 mt-2">view details</button>
							  </div>
							</div>
						  </div>
						  
						  
					</div>
		
		
		
		<div class="text-center mt-5 mb-5">
			<a href="#" ><button class="btn-yellow">Load More</button></a>
		</div>
		
		
		
		
		
		
		
        </div>
		
		
		
		  
		  
		  

		  
		  
		  
		  
        </div>
      </div>
    </section>
	
	
		
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