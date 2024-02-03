<?php
include_once "includes/common_front.php";

$PAGE_TITLE2 = 'Cart';
$PAGE_TITLE .= $PAGE_TITLE2;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Rent a Car/Bus Goa | Self-Drive Car rentals | Royal Holidays</title>
<meta name="description" content="Experience the beauty of Goa with Royal Holidays. Rent a coach or bus from our extensive fleet and enjoy hassle-free travel in goa. "/>
<meta name="keywords" content="coach rental goa,  coach rental prices, rent coach, rent a bus, bus rental goa, goa bus rental, royal holidays goa">
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Rent a Car/Bus Goa | Self-Drive Car rentals | Royal Holidays" />
<meta property="og:description" content="Experience the beauty of Goa with Royal Holidays. Rent a coach or bus from our extensive fleet and enjoy hassle-free travel in goa." />
<meta property="og:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png">
<meta property="og:url" content="https://royalcabsgoa.com/cart.php" />
<meta property="og:site_name" content="Royal Holidays" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="Rent a Car/Bus Goa | Self-Drive Car rentals | Royal Holidays" />
<meta name="twitter:description" content="Experience the beauty of Goa with Royal Holidays. Rent a coach or bus from our extensive fleet and enjoy hassle-free travel in goa." />
<meta name="twitter:image" content="https://royalcabsgoa.com/images/Royal-holidays-og-image.png" />
<link rel="canonical" href="https://royalcabsgoa.com/cart.php" />
		<?php include '_load_header.php';?>  	
    </head>
	<body>
    
	<div class="bg-blue">
		<?php include '_header.php';?>
    </div>

    <section class="ftco-section contact-section">
	
      <div class="container mt-6">
        <div class="d-flex mb-5 contact-info c-end">

		  
		  
        <div class="col-md-12">
		
			<div class="text-center heading-section">
				<h2 class="mb-3 text-black">My cart</h2>
			</div>

			
			<div class="card mx-100">
							

				
				<div class="d-flex">
								
					<img src="images/car-1.png" alt="car-rental" class="responsive mt-10">
								
					<div class="container">
					
					    <br>
						
						<span class="card-tag1">Recommended</span>
					
						<span class="card-tag2">Special offer</span>
					
					
					    <br><br>
									
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
										
					</div>
				

				
					<div class="rate-div">
						<s class="strike-text1">RS.6000</s> 
						<br>
						<span class="card-head1">RS.3000</span> 
						<br>		
						<span class="card-p">Price for night differs</span>					
						<a href="car_display.php"><button class="search-btn-o wpx-165 mt-2">remove</button></a>
					</div>
				
				
				</div>
								
			</div>
			
			<hr>
			
			<div class="mx-100">
			
				<span class="card-head">Personal Details</span>
			
				<div class="d-flex gap-10 mt-2">

						<div>
							<label class="form-label text-black">Full name</label>
							<input type="text" placeholder="Enter full name">
						</div>	

						<div>
							<label class="form-label text-black">Mobile number</label>
							<input type="text" placeholder="Enter mobile number">
						</div>			
						
						<div>
							<label class="form-label text-black">Email</label>
							<input type="text" placeholder="Enter email">
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
						

					
			</div>
		   
		    </div>
			
			<hr>
			<br>
			
			<div class="text-center">
				<a href="summary.php"><button class="search-btn wpx-165 mt-2">SUBMIT</button></a>
			</div>
				
		
        </div>
		  
		  
		  

		  
		  
		  
		  
        </div>
      </div>
    </section>
	
	
		
    <?php include '_footer.php';?>

  
    <?php include '_load_footer.php';?>
    


</body>
</html>