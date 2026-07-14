<?php
include "../Db/connection.php";

// Fetch all hotels with place names
$query = "SELECT a.*, p.name as place_name FROM ac_tb a LEFT JOIN place_tb p ON a.place = p.id";
$result = mysqli_query($con, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travels</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/contact.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <style>
        .destination-card {
            margin-bottom: 30px;
            transition: transform 0.3s;
            height: 100%;
        }
        .destination-card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .rating-stars {
            color: #ffc107;
        }
    </style>
</head>
<body>

<div class="main_desti clearfix position-relative">
    <!-- Your existing modal and header content remains the same -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none; top:0;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
                </div>
                <div class="modal-body p-0">
                    <div class="search_1">
                        <div class="input-group">
                            <input type="text" class="form-control bg-transparent border-0" placeholder="Type your keyword..">
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
        <!-- Your existing header content remains the same -->
        <section id="top" class="pt-3 pb-3">
            <div class="container-xl">
                <div class="row top_1">
                    <div class="col-md-4">
                        <div class="top_1l">
                            <span class="d-inline-block bg_red  rounded-circle float-start me-2 text-center"><a href="#"><i class="fa fa-phone text-white"></i></a></span>
                            <h6 class="mb-0 lh-base font_14"><a class="text-white" href="#"><b class="col_blue">For Further Inquires :</b> <br>
                            +(000) 345 67 89</a></h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="top_1m text-center mt-2">
                            <h3 class="mb-0"><a class="text-white logo" href="index.php"><i class="fa fa-plane text-white"></i> <span class="logo_col">planify</span> <span class="logo_col"></span></a></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="top_1r mt-2 text-end">
                            <span class="d-inline-block text-center rounded-circle"><a  class="text-white d-block" data-bs-target="#exampleModal2" data-bs-toggle="modal" href="#"><i class="fa fa-search"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="header">
            <nav class="navbar navbar-expand-md navbar-light pt-3 pb-3" id="navbar_sticky">
                <div class="container-xl">
                    <a class="navbar-brand fs-3 p-0 fw-bold text-white  text-uppercase" href="index.php"><i class="fa fa-plane"></i> Travels </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php">Home</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="about.php">About </a>
                            </li> -->
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Packages
                                </a>
                                <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="package.html"> Packages</a></li>
                                    <li><a class="dropdown-item border-0" href="detail.html"> Package Detail</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Blog
                                </a>
                                <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="blog.html"> Blog</a></li>
                                    <li><a class="dropdown-item border-0" href="blog_detail.html"> Blog Detail</a></li>
                                </ul>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link active" href="destination.php"></a>
                            </li>
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Pages
                                </a>
                                <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="services.html"> Services</a></li>
                                    <li><a class="dropdown-item border-0" href="contact.html"> Contact</a></li>
                                </ul>
                            </li> -->
                        </ul>
                        <!-- <ul class="navbar-nav mb-0 ms-auto">
                            <li class="nav-item">
                                <a class="nav-link button" href="#">BOOK NOW </a>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </nav>
        </section>
    </div>
    
    <div class="main_2 clearfix">
        <section id="center" class="centre_o bg_back">
            <div class="container-xl">
                <div class="row centre_o1 text-center">
                    <div class="col-md-12">
                        <h1 class="text-white text-uppercase font_60">ACCOMODATION</h1>
                        <h6 class="mb-0 text-white fw-bold"><a class="text-white" href="#">HOME</a> <span class="mx-1 text-white-50">|</span> ACCOMODATION</h6>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Destination Cards Section - Replaced your original content with the card layout -->
<section id="popular" class="p_3">
    <div class="container-xl">
        <div class="row">
            <?php while($hotel = mysqli_fetch_assoc($result)): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card destination-card h-100">
                    <img src="../<?= $hotel['photo'] ?>" class="card-img-top rounded_10" alt="<?= $hotel['name'] ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary"><?= $hotel['place_name'] ?></span>
                            <div class="rating-stars">
                                <?= str_repeat('<i class="fa fa-star"></i>', (int)$hotel['rating']) ?>
                            </div>
                        </div>
                        <h4 class="card-title text-uppercase"><?= $hotel['name'] ?></h4>
                        <p class="card-text"><?= $hotel['h_description'] ?></p>
                    </div>
                    <div class="card-footer bg-white">
                        <small class="text-muted"><?= $hotel['distance'] ?> km away</small>
                        <a href="<?= $hotel['map'] ?>" target="_blank" class="btn btn-sm btn-primary float-end">View Map</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Keep your stats section if you like -->
        <!-- ... -->
    </div>
</section>


<!-- Rest of your existing content (sub section and footer) remains exactly the same -->
<section id="sub" class="pt-5 pb-5 bg_red">
    <!-- ... your existing sub section content ... -->
</section>

<section id="footer" class="p_3 bg_dark">
    <!-- ... your existing footer content ... -->
</section>

<script>
window.onscroll = function() {myFunction()};
var navbar_sticky = document.getElementById("navbar_sticky");
var sticky = navbar_sticky.offsetTop;
var navbar_height = document.querySelector('.navbar').offsetHeight;
function myFunction() {
    if (window.pageYOffset >= sticky + navbar_height) {
        navbar_sticky.classList.add("sticky")
    } else {
        navbar_sticky.classList.remove("sticky");
        document.body.style.paddingTop = '0'
    }
}
</script>

</body>
</html>

<?php
mysqli_close($con);
?>