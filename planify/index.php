<?php
session_start();
include "../Db/connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Planify</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>

</head>

<body>

	<div class="main clearfix position-relative">
		<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
			style="display: none; top:0;" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content bg-transparent border-0">
					<div class="modal-header border-0">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
								class="fa fa-close"></i></button>
					</div>
					<div class="modal-body p-0">
						<div class="search_1">
							<div class="input-group">
								<input type="text" class="form-control bg-transparent border-0"
									placeholder="Type your keyword..">
								<span class="input-group-btn">
									<button class="btn btn-primary bg-transparent border-0" type="button">
										<i class="fa fa-search"></i></button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="main_1 clearfix position-absolute top-0 w-100">
			<section id="top" class="pt-3 pb-3">
				<div class="container-xl">
					<div class="row top_1">
						<div class="col-md-4">
							<div class="top_1l">
								<span class="d-inline-block bg_red  rounded-circle float-start me-2 text-center"><a
										href="#"><i class="fa fa-phone text-white"></i></a></span>
								<h6 class="mb-0 lh-base font_14"><a class="text-white" href="#"><b class="col_blue">For
											Further Inquires :</b> <br>
										+91 9074030490</a></h6>
							</div>
						</div>
						<div class="col-md-4">
							<div class="top_1m text-center mt-2">
								<h3 class="mb-0"><a class="text-white logo" href="index.php"><i
											class="fa fa-plane text-white"></i> <span class="logo_col">PLANIFY</span>
										<span class="logo_col"></span></a></h3>
							</div>
						</div>

						
					</div>
				</div>
			</section>
			<section id="header">
				<nav class="navbar navbar-expand-md navbar-light pt-3 pb-3" id="navbar_sticky">
					<div class="container-xl">
						<a class="navbar-brand fs-3 p-0 fw-bold text-white  text-uppercase" href="index.php"><i
								class="fa fa-plane"></i> Planify </a>
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
							data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
							aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav mb-0">

								<li class="nav-item">
									<a class="nav-link active" aria-current="page" href="index.php">Home</a>
								</li>

								<!-- <li class="nav-item">
									<a class="nav-link" href="about.php">About </a>
								</li> -->

								

								

								<li class="nav-item">
									<a class="nav-link" href="destination.php">Destination</a>
								</li>


								
							</ul>
							<ul class="navbar-nav mb-0 ms-auto">
								<li class="nav-item">
									<?php
									   if (isset($_SESSION['id'])) {
									?>
									<a class="nav-link button" href="user_my_plans.php">My Plans</a>
									<?php
									   } else {
									?>
									<a class="nav-link button" href="reg.php">LOGIN </a>
									<?php
									   }
									?>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</section>
		</div>
		<div class="main_2 clearfix">
			<section id="center" class="center_home">
				<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
							class="active" aria-label="Slide 1" aria-current="true"></button>
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
							aria-label="Slide 2" class=""></button>
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
							aria-label="Slide 3" class=""></button>
					</div>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="https://www.realitypremedia.com/blog/wp-content/uploads/2016/01/Image-processing-for-Travel-website-849x450.jpg"
								class="d-block w-100" alt="...">
							<div class="carousel-caption d-md-block">
								<h1 class="font_60 text-uppercase"><span class="logo_col">Beautiful</span> Place <br> to
									Visit</h1>
								<p class="text-white mt-3">A simple way to plan your trip.
									Find places, hotels, and activities that fit your time and needs.</p>
								
							</div>
						</div>
						<div class="carousel-item">
							<img src="https://plus.unsplash.com/premium_photo-1721652937934-9cc168ca5dbe?q=80&w=1465&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
								class="d-block w-100" alt="...">
							<div class="carousel-caption d-md-block">
								<h1 class="font_60 text-uppercase">Journey to <br> <span class="logo_col">explore</span>
									world</h1>
								<p class="text-white mt-3">Plan your dream trip effortlessly. We make travel easier.</p>
								
							</div>
						</div>
						<div class="carousel-item">
							<img src="https://images.pexels.com/photos/2174656/pexels-photo-2174656.jpeg"
								class="d-block w-100" alt="...">
							<div class="carousel-caption d-md-block">
								<h1 class="font_60 text-uppercase">Plan your <span class="col_blue"> <br> journey
									</span> <br> with ease</h1>
								<p class="text-white mt-3">Explore beautiful destinations and personalized packages made
									just for you.</p>
								
							</div>
						</div>
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
						data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
						data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</section>
		</div>

	</div>

	<section id="book" class="pt-5 pb-5 bg_red">
		<form class="container-xl" method="post" action="find.php">
			<div class="row book_1 align-items-end">
				<div class="col-md-9">
					<div class="book_1l">
						<div class="book_1li d-flex flex-wrap gap-3"> <!-- Single row, flex layout -->


							<div class="book_1li1" style="flex: 1 1 12%;">
								<h6 class="text-white mb-3">No. of People</h6>
								<input placeholder="No. of People" class="form-control rounded_30 border-0 font_14"
									type="text" name="no" required>
							</div>

							<div class="book_1li1" style="flex: 1 1 15%;">
								<h6 class="text-white mb-3">Starting Date</h6>
								<input class="form-control rounded_30 border-0 font_14" type="date" name="sdate"
									required>
							</div>
							<div class="book_1li1" style="flex: 1 1 15%;">
								<h6 class="text-white mb-3">Ending Date</h6>
								<input class="form-control rounded_30 border-0 font_14" type="date" name="edate"
									required>
							</div>

							<div class="book_1li1" style="flex: 1 1 15%;">
								<h6 class="text-white mb-3">Time</h6>
								<input class="form-control rounded_30 border-0 font_14" type="time" name="timefrom"
									required>
							</div>

							<div class="book_1li1" style="flex: 1 1 15%;">
								<h6 class="text-white mb-3">UpTo</h6>
								<input class="form-control rounded_30 border-0 font_14" type="time" name="timeto"
									required>
							</div>
							<div class="book_1li1" style="flex: 1 1 16%;">
								<h6 class="text-white mb-3">Select Place</h6>
								<select class="form-control rounded_30 border-0 font_14" name="place">
									<option disabled selected>Select Place</option>
									<?php
					$sql = mysqli_query($con, "SELECT * FROM `place_tb`");
					while ($p = mysqli_fetch_assoc($sql)) {
					?>
									<option value="<?php echo $p['id']; ?>">
										<?php echo $p['name']; ?>
									</option>
									<?php } ?>
								</select>
							</div>

						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="book_1r">
						<h6 class="mb-0">
							<button class="button_blue text-uppercase d-block text-center fw-bold w-100" name="find"
								type="submit">Find Your Plan</button>
						</h6>
					</div>
				</div>
			</div>
		</form>
	</section>


	<section id="popular" class="p_3">
		<div class="container-xl">
			<div class="row popular_1 text-center mb-4">
				<div class="col-md-12">
					
					<h1>POPULAR <span class="col_red">DESTINATION</span></h1>
					<p class="mb-0">"Explore beautiful places with the perfect mix of peace, adventure, and local charm.
						<br> Plan your next memorable trip with ease."</p>
				</div>
			</div>
			<div class="row popular_2  mb-4">

				<?php
				$sql = mysqli_query($con, "SELECT * FROM `dest_tb` where rating >= 4 ORDER BY RAND() LIMIT 3");
				while ($destination = mysqli_fetch_assoc($sql)) {
					$placeId = $destination['place'];
					$place= mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `place_tb` WHERE id = '$placeId'"))['name'];

				?>
				<div class="col-md-4">
					<div class="popular_2m position-relative">
						<div class="popular_2m1">
							<img src="../<?php echo $destination['photo']; ?>" class="w-100 rounded_10" alt="imagee" style="height: 550px; object-fit: cover;">
						</div>
						<div class="popular_2m2 rounded_10 bg-white p-4 position-absolute">
							<h6 class="col_blue font_14"><?php echo $place; ?></h6>
							<h4 class="text-uppercase"><a target="_blank" href="<?php echo $destination['map']; ?>"><?php echo $destination['destination']; ?></a></h4>
							<p class="mb-0"><?php echo $destination['description']; ?></p>
						</div>
						<div class="popular_2m3 top-0 position-absolute w-100 text-end">
							<span class="bg_red rounded_30 d-inline-block text-white p-1 px-2 font_14">
								<?php for ($i = 1; $i <= 5; $i++) {
									if ($i <= $destination['rating']) {
										echo '<i class="fa fa-star"></i>';
									} else {
										echo '<i class="fa fa-star-o"></i>';
									}
								} ?>
							</span>
						</div>
					</div>
				</div>

				<?php } ?>


			</div>
			<div class="row popular_1 text-center">
				<div class="col-md-12">
					<h6 class="mb-0"><a class="button" href="destination.php">MORE DESTINATION</a></h6>
				</div>
			</div>
		</div>
	</section>
	<section id="popular" class="p_3">
		<div class="container-xl">
			<div class="row popular_1 text-center mb-4">
				<div class="col-md-12">
					
					<h1>POPULAR <span class="col_red">HOTELS</span></h1>
					<p class="mb-0">"Explore beautiful places with the perfect mix of peace, adventure, and local charm.
						<br> Plan your next memorable trip with ease."</p>
				</div>
			</div>
			<div class="row popular_2  mb-4">

			<?php
			$sql = mysqli_query($con, "SELECT * FROM `ac_tb` WHERE rating >= 4 ORDER BY RAND() LIMIT 3");
			if (mysqli_num_rows($sql) == 0) {
				echo '<div class="col-md-12"><p class="text-muted">No popular hotels found.</p></div>';
			}
			while ($hotel = mysqli_fetch_assoc($sql)) {
				$placeId = $hotel['place'];
				$place = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `place_tb` WHERE id = '$placeId'"))['name'];
			?>
				<div class="col-md-4">
					<div class="popular_2m position-relative">
						<div class="popular_2m1">
							<img src="../<?php echo $hotel['photo']; ?>" class="w-100 rounded_10" alt="imagee" style="height: 550px; object-fit: cover;">
						</div>
						<div class="popular_2m2 rounded_10 bg-white p-4 position-absolute">
							<h6 class="col_blue font_14"><?php echo $place; ?></h6>
							<h4 class="text-uppercase"><a href="<?php echo $hotel['map']; ?>"><?php echo $hotel['name']; ?></a></h4>
							<p class="mb-0"><?php echo $hotel['h_description']; ?></p>
						</div>
						<div class="popular_2m3 top-0 position-absolute w-100 text-end">
							<span class="bg_red rounded_30 d-inline-block text-white p-1 px-2 font_14">
								<?php for ($i = 1; $i <= 5; $i++) {
									if ($i <= $hotel['rating']) {
										echo '<i class="fa fa-star"></i>';
									} else {
										echo '<i class="fa fa-star-o"></i>';
									}
								} ?>
							</span>
						</div>
					</div>
				</div>
			<?php } ?>

			</div>
			<!-- <div class="row popular_1 text-center">
				<div class="col-md-12">
					<h6 class="mb-0"><a class="button" href="hotels.php">MORE HOTELS</a></h6>
				</div>
			</div> -->
		</div>
	</section>


	<div class="main_om position-relative">
		
		<!-- <div class="main_om2 position-absolute w-100">
			<section id="spec_o">
				<div class="container-xl">
					<div class="row spec_o_1 bg-white shadow_box rounded_30 p-5 px-3">
						<div class="col-md-3 col-sm-6">
							<div class="spec_o_1i">
								<h1>55K+</h1>
								<h6 class="mb-0 col_blue">SATISFIED CUSTOMER</h6>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="spec_o_1i">
								<h1>22+</h1>
								<h6 class="mb-0 col_blue">ACTIVE MEMBERS</h6>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="spec_o_1i">
								<h1>125+</h1>
								<h6 class="mb-0 col_blue">TOUR DESTINATION</h6>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="spec_o_1i border-0">
								<h1>39+</h1>
								<h6 class="mb-0 col_blue">TRAVEL GUIDES</h6>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div> -->



	</div>

	<!-- <section id="disc" class="p_3">
		<div class="container-xl">
			
			<div class="row disc_1">
				
				
			</div>
			<div class="row popular_1 text-center mt-4">
				
			</div>
		</div>
	</section> -->

	

	

	<section id="footer" class="p_3 bg_dark">
		<div class="container-xl">
			<div class="row footer_1">
				<div class="col-md-8">
					
				</div>
				<div class="col-md-3">
					
				</div>

				<div class="col-md-3">
					
							</div>
							
							</div>
						</div>
						<div class="footer_1i1 row mt-3">
							<div class="col-md-4 col-4 pe-0">
								<div class="footer_1i1l">
									
								</div>
							</div>
							<div class="col-md-8 col-8">
								
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="footer_2r">
						<h5 class="text-white">CONTACT US</h5>
						<hr class="line mb-4">
						<p class="text-white">Feel free to contact and
							reach us !!</p>
						<h6 class="text-light"><i class="fa fa-phone-square col_blue me-1"></i> Office: +91 8590666643
						</h6>
						<h6 class="text-light mt-3"><i class="fa fa-envelope col_blue me-1"></i> planify@gmail.com</h6>
						</h6>
					</div>
				</div>
				
					
				</div>
				<div class="col-md-3">
					<div class="footer_2r">
						<ul class="social_tag">
							<li class="d-inline-block"><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li class="d-inline-block"><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li class="d-inline-block"><a href="#"><i class="fa fa-youtube-play"></i></a></li>
							<li class="d-inline-block"><a href="#"><i class="fa fa-instagram"></i></a></li>
							<li class="d-inline-block"><a href="#"><i class="fa fa-linkedin"></i></a></li>
						</ul>
						<ul class="mb-0  font_14 tags">
							<li class="d-inline-block"><a href="#">Privacy Policy</a></li>
							<li class="d-inline-block mx-2 text-muted">|</li>
							<li class="d-inline-block"><a href="#">Term & Condition</a></li>
							<li class="d-inline-block mx-2 text-muted">|</li>
							<li class="d-inline-block"><a href="#">FAQ</a></li>
						</ul>
					</div>
				</div>
			</div>
			<hr class="mt-4 mb-4 hr_bg">
			<div class="row footer_3 text-center">
				
			</div>
		</div>
	</section>

	<script>
		window.onscroll = function () { myFunction() };
		var navbar_sticky = document.getElementById("navbar_sticky");
		var sticky = navbar_sticky.offsetTop;
		var navbar_height = document.querySelector('.navbar').offsetHeight;
		function myFunction() {
			if (window.pageYOffset >= sticky + navbar_height) {
				navbar_sticky.classList.add("sticky")
				//document.body.style.paddingTop = navbar_height + 'px';
			} else {
				navbar_sticky.classList.remove("sticky");
				document.body.style.paddingTop = '0'
			}
		}
	</script>

</body>

</html>