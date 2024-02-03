<?php
include_once "includes/common_front.php";

$PAGE_TITLE2 = 'Booking Successful';
$PAGE_TITLE .= $PAGE_TITLE2;
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

    <section class="ftco-section contact-section">
	
      <div class="container mt-6">
        <div class="d-flex mb-5 contact-info c-end">

		  
		  
        <div class="col-md-12">
		

					<div class="container mt-5">
						<div class="section-heading text-center">
						
						<div class="svg-container">    
							<svg class="ft-green-tick" xmlns="http://www.w3.org/2000/svg" height="100" width="100" viewBox="0 0 48 48" aria-hidden="true">
								<circle class="circle" fill="#5bb543" cx="24" cy="24" r="22"/>
								<path class="tick" fill="none" stroke="#FFF" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M14 27l5.917 4.917L34 17"/>
							</svg>
						</div>


						<div class="text-center heading-section mt-4">
							<h2 class="text-black">Booking Successful</h2>
						</div>
							
						<!--<p class="pd-s mt-4">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>-->
                        <br>
							
						<a href="index.php"><button class="search-btn wpx-165 mt-2">back home</button></a>

						</div>
					</div>
	

        </div>
		  
		  
		  

		  
		  
		  
		  
        </div>
      </div>
    </section>
	
	
		
    <?php include '_footer.php';?>

  
    <?php include '_load_footer.php';?>
    

	<script>
	let path = document.querySelector(".tick");
	let length = path.getTotalLength();

	console.log(length); 
	</script>

</body>
</html>