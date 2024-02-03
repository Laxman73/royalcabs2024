<?php
include_once "includes/common_front.php";

$PAGE_TITLE2 = 'About Us';
$PAGE_TITLE .= $PAGE_TITLE2;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include '_load_header.php';?> 
		<style>
		.index_active {
			color: var(--yellow)!important;
		}
		</style>		
    </head>
	<body>
    
    <?php include '_header.php';?>
    
    <div class="hero-wrap ftco-degree-bg" style="background-image: url('images/index-banner.png');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
	<div class="row  no-gutters slider-text justify-content-start align-items-center justify-content-center">
    
		<div class="column">
			<div class="text w-100 mb-md-5 pb-md-5">
				<h1 class="mb-4">Explore Goa <br> on Wheels:<br> Rent a Car Today!</h1>
			</div>
		</div>

		<div class="column">
			  
			<input type="radio" name="test" id="test-1" class="radio-test" checked="checked"/>
			<input type="radio" name="test" id="test-2" class="radio-test" />
				
			<div class="labels">
				<label for="test-1" id="label-test-1" class="label">CAR </label>
				<label for="test-2" id="label-test-2" class="label">COACH</label>
			</div>
				
			<div class="content content-test-1" id="content-test-1">

                <label class="form-label">From</label>
				<div class="inputWithIcon">
					<input type="text" placeholder="Pick-up Location">
					<i class="loc"></i>
				</div>

				<label class="form-label">To</label>
				<div class="inputWithIcon">
					<input type="text" placeholder="Drop-of Location">
				    <i class="loc"></i>
				</div>
						
				<div class="d-flex gap-10">
						
					<div class="w-30">
						<label class="form-label">Date</label>
						<div class="inputWithIcon">
							<input type="date" placeholder="DD/MM/YYYY">
							<!--<i class="date"></i>-->
						</div>
					</div>	
						
					<div class="w-20">						
						<label class="form-label">Time</label>
						<div class="inputWithIcon">
							<input type="time" placeholder="00:00">
							<!--<i class="time"></i>-->
						</div>
					</div>
							
					<div class="w-20">	
						<label class="form-label">Pax</label>
						<div class="inputWithIcon">
							<input type="number" placeholder="00">
							<i class="person pd-15"></i>
						</div>
					</div>
						
					<div class="w-30">	
						<br>
						<button class="search-btn">SEARCH </button>
					</div>
					
				</div>

			</div>
					
					
			<div class="content content-test-2" id="content-test-2">
					
                <label class="form-label">From</label>
				<div class="inputWithIcon">
					<input type="text" placeholder="Pick-up Location">
					<i class="loc"></i>
				</div>

				<label class="form-label">To</label>
				<div class="inputWithIcon">
					<input type="text" placeholder="Drop-of Location">
				    <i class="loc"></i>
				</div>
						
				<div class="d-flex gap-10">
						
					<div class="w-30">
						<label class="form-label">Date</label>
						<div class="inputWithIcon">
							<input type="date" placeholder="DD/MM/YYYY">
							<!--<i class="date"></i>-->
						</div>
					</div>	
						
					<div class="w-20">						
						<label class="form-label">Time</label>
						<div class="inputWithIcon">
							<input type="time" placeholder="00:00">
							<!--<i class="time"></i>-->
						</div>
					</div>
							
					<div class="w-20">	
						<label class="form-label">Pax</label>
						<div class="inputWithIcon">
							<input type="number" placeholder="00">
							<i class="person pd-15"></i>
						</div>
					</div>
						
					<div class="w-30">	
						<br>
						<button class="search-btn">SEARCH </button>
					</div>
					
				</div>
					
			</div>  
	 
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
			<div class="row">
				<div class="col-md-3">
					<div class="services services-2 w-100 text-center">
						<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-location"></span></div>
						<div class="text w-100">
							<h3 class="heading mb-2">Choose location</h3>
							<p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
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
					<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-date"></span></div>
					<div class="text w-100">
						<h3 class="heading mb-2">Pick date</h3>
						<p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
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
					<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-car"></span></div>
					<div class="text w-100">
						<h3 class="heading mb-2">Book your vehicle</h3>
						<p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
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
				<p class="text-white">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				<p class="text-white">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				<br>
				<button class="trans-btn">read more</button>
			</div>
			</div>
		</div>	
	</section>
		
	<section class="ftco-section ">
		<div class="container">
		
			<div class="row justify-content-center mb-5">
				<div class="col-md-7 text-center heading-section">
					<h2 class="mb-3 ">Featured Vehicles</h2>
					<p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
			</div>
				
			<div class="row justify-content-center mb-5">
			  
				<input type="radio" name="abt" id="abt-1" class="radio-abt" checked="checked"/>
				<input type="radio" name="abt" id="abt-2" class="radio-abt" />
				<input type="radio" name="abt" id="abt-3" class="radio-abt" />
				<input type="radio" name="abt" id="abt-4" class="radio-abt" />
				
				<div class="abt-labels">
				  <label for="abt-1" id="label-abt-1" class="abt-label">ALL </label>
				  <label for="abt-2" id="label-abt-2" class="abt-label">CAR</label>
				  <label for="abt-3" id="label-abt-3" class="abt-label">COACH</label>
				  <label for="abt-4" id="label-abt-4" class="abt-label">DISPOSALS</label>
				</div>
					
				<div class="content-abt content-abt-1" id="content-abt-1">

					<div class="row">
					
						<div class="column1">
							<div class="card">
							
							 	<div class="card-tag">
									<i class="Car-Key"></i><span class="tag-text">Available for disposal</span>
								</div>
								
								<img src="images/car-1.png" class="mt-10" >
								
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
							
							    <img src="images/car-2.png" class="mt-10" >
							 
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
						</div>
						  
					</div>
					
					<br><br>

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
						  
						  
					</div>
					
					
					
					<div class="text-center mt-40">
						<button class="yellow-btn">load more</button>
					</div>

				</div>
					
				<div class="content-abt content-abt-2" id="content-abt-2"></div>
				<div class="content-abt content-abt-3" id="content-abt-3"></div>
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
						<p class="text-white">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
			            
						<br><br><br>
						<a href="outbound.php"><button class="search-btn wpx-165 mt-2">outbound</button></a>
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
							<p class="text-white">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>

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
		
		
		
		
	<section class="ftco-section">
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
	</section>
		
		
		
	<section class="ftco-section ftco-intro" style="background-image: url(images/get-in-touch.png);padding: 4em 0;">
		<div class="container">
			
        <div class="row d-flex  contact-info">
        	<div class="col-md-4">
					
				<div class="heading-section ftco-animate text-white">
					<h2 class="text-white">Get in Touch</h2>
				</div>
				
			
        		<div class="row mb-5 mt-40">
		          <div class="col-md-12">
		          	<div class=" w-100 rounded mb-2 d-flex">
			          	<div class="icon mr-3">
			          		<span class="icon-map-o"></span>
			          	</div>
			            <p class="footer-p">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint.</p>
			          </div>
		          </div>
		          <div class="col-md-12">
		          	<div class="w-100  rounded mb-2 d-flex">
			          	<div class="icon mr-3">
			          		<span class="icon-mobile-phone"></span>
			          	</div>
			            <p class="footer-p">+91 12345 67890</p>
			          </div>
		          </div>
		          <div class="col-md-12">
		          	<div class="w-100 rounded mb-2 d-flex">
			          	<div class="icon mr-3">
			          		<span class="icon-envelope-o"></span>
			          	</div>
			            <p class="footer-p">name@email.com</p>
			          </div>
		          </div>
		        </div>
				
            </div>
			
			<div class="col-md-8 block-9">
				<form action="#" class="p-5 contact-form b card-over">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Enter full name">
					</div>
					
					<div class="form-group">
						<input type="email" class="form-control"  placeholder="Enter email">
					</div>
					
					<div class="form-group">
						<input type="tel" class="form-control" placeholder="Enter mobile number">
					</div>
				
					<div class="form-group">
						<textarea class="form-control" placeholder="Enter message"></textarea>
					</div>
					
					<div class="form-group">
						<input type="submit" value="submit" class="btn btn-primary px-5">
					</div>
				</form>
			  
			</div>
		
        </div>
			  
		</div>
	</section>
		
    <?php include '_footer.php';?>

  
    <?php include '_load_footer.php';?>
    
<!--testimonial-->	
<script>
$(document).ready(function () {
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
    
    $('#buttons a').click(function (e) {
        //slide the item
        
        if (container.is(':animated')) {
            return false;
        }
        if (e.target.id == previous) {
            container.stop().animate({
                'left': 0
            }, 500, function () {
                container.find(elm + ':first').before(container.find(elm + ':last'));
                resetSlides();
            });
        }
        
        if (e.target.id == next) {
            container.stop().animate({
                'left': item_width * -2
            }, 500, function () {
                container.find(elm + ':last').after(container.find(elm + ':first'));
                resetSlides();
            });
        }
        
        //cancel the link behavior            
        return false;
        
    });
    
    //if mouse hover, pause the auto rotation, otherwise rotate it    
    container.parent().mouseenter(function () {
        clearInterval(run);
    }).mouseleave(function () {
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