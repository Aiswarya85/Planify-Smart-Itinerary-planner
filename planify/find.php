<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit();
}
$userid= $_SESSION['id'];
include "../Db/connection.php";
if(isset($_POST['find'])) {
    $place_id = $_POST['place'];
    $no_of_people = $_POST['no'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $time_from = $_POST['timefrom'];
    $time_to = $_POST['timeto'];

    $date = $sdate;

    // Combine date and time to get full datetime strings
    $start = new DateTime($sdate . ' ' . $time_from);
    $end = new DateTime($edate . ' ' . $time_to);

    // Calculate duration in hours (including minutes as a fraction)
    $interval = $start->diff($end);
    $duration = ($interval->days * 24) + $interval->h + ($interval->i / 60);

    // Optional: Round to 2 decimal places
    $duration = round($duration, 2);

    // Get place name
    $place_query = mysqli_query($con, "SELECT name FROM place_tb WHERE id = $place_id");
    $place_name = mysqli_fetch_assoc($place_query)['name'];

    // Get hotels
	$hotel_query = "SELECT a.*, a.distance as hotel_distance, h.type as hotel_type, 
					r.r_type as r_type, f.f_type as facility_type, 
					r.r_type as r_type, a.no_of_people as room_capacity
					FROM ac_tb a
					JOIN hotel_tb h ON a.h_type = h.hid
					JOIN room_tb r ON a.r_type = r.r_id
					JOIN facility_tb f ON a.facilities = f.f_id
					WHERE a.place = $place_id";

    $hotel_result = mysqli_query($con, $hotel_query);

    // Get destinations
    $dest_query = "SELECT d.*, a.activity as activity_name 
                   FROM dest_tb d
                   JOIN activity_tb a ON d.activities = a.id
                   WHERE d.place = $place_id";
    $dest_result = mysqli_query($con, $dest_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Package Offers</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/contact.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="main_2 clearfix">
    <section id="center" class="centre_o bg_back">
        <div class="container-xl">
            <div class="row centre_o1 text-center">
                <div class="col-md-12">
                    <h1 class="text-white text-uppercase font_60">PLANNER</h1>
                    <h6 class="mb-0 text-white fw-bold"><a class="text-white" href="#">HOME</a> <span class="mx-1 text-white-50">|</span> PACKAGE OFFER</h6>
                </div>
            </div>
        </div>
    </section>
</div>

<section id="disc_o" class="p_3">
    <div class="container-xl">
        <!-- Search Summary -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="p-4 rounded_30 bg_light">
                    <h4 class="col_blue mb-3">Your Travel Plan to <?php echo $place_name; ?></h4>
                    <div class="d-flex flex-wrap">
                        <div class="me-4 mb-2">
                            <i class="fa fa-calendar col_blue me-2"></i>
                            <strong>Date:</strong> <?php echo date('F j, Y', strtotime($date)); ?>
                        </div>
                        <div class="me-4 mb-2">
                            <i class="fa fa-clock-o col_blue me-2"></i>
                            <strong>Time:</strong> <?php echo date('g:i A', strtotime($time_from)); ?> - <?php echo date('g:i A', strtotime($time_to)); ?>
                        </div>
                        <div class="me-4 mb-2">
                            <i class="fa fa-users col_blue me-2"></i>
                            <strong>People:</strong> <?php echo $no_of_people; ?>
                        </div>
                        <div class="mb-2">
                            <i class="fa fa-hourglass-half col_blue me-2"></i>
                            <strong>Duration:</strong> <?php echo $duration; ?> hours
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Hotels -->
        <h2 class="text-center mb-4 font_russo">AVAILABLE HOTELS</h2>
        <div class="row disc_1">
            <?php if(mysqli_num_rows($hotel_result) > 0): ?>
                <?php while($hotel = mysqli_fetch_assoc($hotel_result)): 
                    $hotel_distance_km = $hotel['hotel_distance'];

                    // Calculate travel times
                    $hotel_one_way_time = $hotel_distance_km / 40; 
                    $hotel_travel_time = $hotel_one_way_time * 2; 
                    if ($hotel_travel_time >= $duration) continue; 

                    $hotel_travel_time_mins = round($hotel_one_way_time * 60);
                    $rooms_needed = ceil($no_of_people / $hotel['room_capacity']);
                    $discount = rand(10, 25);
                ?>
        
                <div class="col-md-6">
                    <div class="disc_1l position-relative">
                        <div class="disc_1l1">
                            <img src="../<?php echo $hotel['photo']; ?>" class="w-100 rounded_30" alt="<?php echo $hotel['name']; ?>" style="height: 550px; object-fit: cover;">
                        </div>
                        <div class="disc_1l2 position-absolute text-end top-0 w-100 p-4">
                            <h6 class="bg_red rounded_30 d-inline-block text-white p-2 px-3 font_14">UPTO <?php echo $discount; ?>% OFF</h6>
                        </div>
                        <div class="disc_1l3 rounded_30 position-absolute bg_light p-4">
                            <h6 class="font_14">
                                <i class="fa fa-building col_blue me-1"></i> <?php echo $hotel['hotel_type']; ?>
                                <span class="mx-2 text-muted">|</span>
                                <i class="fa fa-bed col_blue me-1"></i> <?php echo $hotel['r_type']; ?>
                                <span class="mx-2 text-muted">|</span>
                                <i class="fa fa-snowflake-o col_blue me-1"></i> <?php echo $hotel['facility_type']; ?>
                            </h6>
                            
                            <h5 class="mt-3"><a href="#"><?php echo $hotel['name']; ?></a></h5>
                            
                            <p class="mb-2"><?php echo $hotel['h_description']; ?></p>
                            <p class="mb-2"><i class="fa fa-star col_blue me-1"></i> Rating: <?php echo $hotel['rating']; ?>/5</p>
                            <p class="mb-2"><i class="fa fa-users col_blue me-1"></i> 
                                Capacity: <?php echo $hotel['room_capacity']; ?> people per room
                                (<?php echo $rooms_needed; ?> room<?php echo $rooms_needed > 1 ? 's' : ''; ?> needed)
                            </p>
                            <p class="mb-2"><i class="fa fa-location-arrow col_blue me-1"></i> Distance: <?php echo $hotel_distance_km; ?> km</p>
                            <p class="mb-2"><i class="fa fa-car col_blue me-1"></i> Travel Time (one way): ~<?php echo $hotel_travel_time_mins; ?> mins</p>
                            
                            <h6 class="mb-0 mt-3">
                                <a class="button" href="<?php echo $hotel['map']; ?>">Visit</a>
                                <a class="button ms-2" href="add_to_plan.php?ac_id=<?php echo $hotel['a_id']; ?>" target="_blank">Add To Plan</a>
                            </h6>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-md-12">
                    <div class="alert alert-warning text-center rounded_30">No hotels available matching your criteria.</div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Nearby Attractions -->
        <h2 class="text-center mb-4 mt-5 font_russo">NEARBY ATTRACTIONS</h2>
<div class="row disc_1 mt-4">
    <?php $i=0; if(mysqli_num_rows($dest_result) > 0): ?>
        <?php while($destination = mysqli_fetch_assoc($dest_result)): 
            $distance_km = $destination['distance'];
            
            // Travel time in hours (to and fro)
            $one_way_time = $distance_km / 40; // 40 km/hr average speed
            $travel_time = $one_way_time * 2; // round trip

            // Let's assume average activity takes 2 hours
            $activity_time = 2;

            // Total time required
            $total_time = $travel_time + $activity_time;

            // Skip if total required time > available time
            if ($total_time > $duration) continue;
            $i=$i+1;
            
            // Convert travel_time to minutes for display
            $travel_time_mins = round($one_way_time * 60);
        ?>
        <div class="col-md-6">
            <div class="disc_1l position-relative">
                <div class="disc_1l1">
                    <img src="../<?php echo $destination['photo']; ?>" class="w-100 rounded_30" alt="<?php echo $destination['destination']; ?>" style="height: 550px; object-fit: cover;">
                </div>
                <div class="disc_1l2 position-absolute text-end top-0 w-100 p-4">
                    <h6 class="bg_red rounded_30 d-inline-block text-white p-2 px-3 font_14">
                        ~<?php echo $activity_time; ?> HOURS
                    </h6>
                </div>
                <div class="disc_1l3 rounded_30 position-absolute bg_light p-4">
                    <h6 class="font_14">
                        <i class="fa <?php 
                            switch($destination['activity_name']) {
                                case 'Trekking': echo 'fa-tree'; break;
                                case 'Camping': echo 'fa-fire'; break;
                                case 'Cycling': echo 'fa-bicycle'; break;
                                case 'Beach Activities': echo 'fa-umbrella-beach'; break;
                                default: echo 'fa-map-marker';
                            }
                        ?> col_blue me-1"></i> <?php echo $destination['activity_name']; ?>
                        <span class="mx-2 text-muted">|</span>
                        <i class="fa fa-star col_blue me-1"></i> <?php echo $destination['rating']; ?>/5
                        <span class="mx-2 text-muted">|</span>
                        <i class="fa fa-map-marker col_blue me-1"></i> <?php echo $place_name; ?>
                    </h6>
                    <h5 class="mt-3"><a href="#"><?php echo $destination['destination']; ?></a></h5>
                    <p><?php echo $destination['description']; ?></p>
                    <p><i class="fa fa-location-arrow col_blue me-1"></i> Distance: <?php echo $distance_km; ?> km</p>
                    <p><i class="fa fa-car col_blue me-1"></i> Travel Time (one way): ~<?php echo $travel_time_mins; ?> mins</p>
                    <p><i class="fa fa-clock col_blue me-1"></i> Total Time Needed: ~<?php echo round($total_time, 1); ?> hrs</p>
                    <h6 class="mb-0 mt-3">
                        <a class="button" href="<?php echo $destination['map']; ?>">VIEW DETAILS</a>
                        <a class="button ms-2" href="add_to_plan.php?place_id=<?php echo $destination['id']; ?>">ADD TO PLAN</a>
                    </h6>
                </div>
            </div>
        </div>
        <?php endwhile; if($i<=0){ ?>
                <div class="col-md-12">
                    <div class="alert alert-warning text-center rounded_30">No attractions found matching your time constraints.</div>
                </div>
                <?php } ?>

    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-warning text-center rounded_30">No attractions found in this location.</div>
        </div>
    <?php endif; ?>
</div>
    </div>
</section>

</body>
</html>

<?php
} 
else {
    header("location: index.php");
    exit();
}
?>