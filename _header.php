<?php
if(URL_REWRITTING=='ON') $URL_CARLISTING = SITE_ADDRESS.'hire-cars-in-goa.html';
else $URL_CARLISTING = SITE_ADDRESS.'car_listing.php';

if(URL_REWRITTING=='ON') $URL_COACHLISTING = SITE_ADDRESS.'coach-hire-in-goa.html';
else $URL_COACHLISTING = SITE_ADDRESS.'coach_listing.php';


if(URL_REWRITTING=='ON') $URL_CARLISTING = SITE_ADDRESS.'hire-cars-in-goa.html';
else $URL_CARLISTING = SITE_ADDRESS.'car_listing.php';


?>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TZ76TBFM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light desk-dis" id="ftco-navbar">
	<div class="container">
		<a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Royal-holidays-logo"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="oi oi-menu"></span> Menu
		</button>
		<div class="collapse navbar-collapse" id="ftco-nav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item index_active"><a href="index.php" class="nav-link index_active">Home</a></li>
				<li class="nav-item abtus_active"><a href="about_us.php" class="nav-link abtus_active">About</a></li>
				<li class="nav-item car_active"><a href="<?php echo $URL_CARLISTING;?>" class="nav-link car_active">Cars</a></li>
				<li class="nav-item coach_active"><a href="<?php echo $URL_COACHLISTING;?>" class="nav-link coach_active">Coaches</a></li>
				<li class="nav-item disposal_active"><a href="disposal.php" class="nav-link disposal_active">Disposals</a></li>
				<li class="nav-item help_active"><a href="tnc.php" class="nav-link help_active">Privacy Policy</a></li>
				<!--<li class="nav-item"><a href="cart.php" class="nav-link pd-r"><span class="flaticon-cart"></span>cart</a></li>-->
				<li class="nav-item"><a href="contact_us.php" class="nav-link"><span class="contact-btn">Contact us</span></a></li>
			</ul>
		</div>
	</div>
</nav>

<section class="ftco_navbar ftco-navbar-light mob-dis" id="ftco-navbar">
	<div class="container">
		<a class="navbar-brand" href="index.php"><img src="images/logo.png"  alt="Royal-holidays-logo"></a>
	</div>
	<nav>
		<div class="nav-mobile">
			<a id="navbar-toggle" href="#!"><span></span></a>
			<a href="tel:9823370597"><span class="flaticon-call"></span></a>
		</div>
		<ul class="nav-list ml-auto">
			<li class="nav-item index_active"><a href="index.php" class="nav-link index_active">Home</a></li>
			<li class="nav-item abtus_active"><a href="about_us.php" class="nav-link abtus_active">About</a></li>
			<li class="nav-item car_active"><a href="<?php echo $URL_CARLISTING;?>" class="nav-link car_active">Cars</a></li>
			<li class="nav-item coach_active"><a href="<?php echo $URL_COACHLISTING;?>" class="nav-link coach_active">Coaches</a></li>
			<li class="nav-item disposal_active"><a href="disposal.php" class="nav-link disposal_active">Disposals</a></li>
			<!--<li class="nav-item help_active"><a href="help.php" class="nav-link help_active">Help</a></li>-->
			<li class="nav-item"><a href="contact_us.php" class="nav-link">Contact us</a></li>
		</ul>
	</nav>
</section>