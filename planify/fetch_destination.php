<?php
include "../Db/connection.php";

// Fetch all destinations with place names
$query = "SELECT d.*, p.name as place_name FROM dest_tb d JOIN place_tb p ON d.place = p.id";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Travel Destinations</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <style>
        .destination-card {
            margin-bottom: 30px;
            transition: transform 0.3s;
        }
        .destination-card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .rating-stars {
            color: #ffc107;
        }
    </style>
</head>
<body>

<!-- Navigation (same as your original) -->

<div class="container py-5">
    <h1 class="text-center mb-5">Our Destinations</h1>
    
    <div class="row">
        <?php while($destination = mysqli_fetch_assoc($result)): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card destination-card h-100">
                <img src="<?= $destination['photo'] ?>" class="card-img-top" alt="<?= $destination['destination'] ?>">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary"><?= $destination['place_name'] ?></span>
                        <div class="rating-stars">
                            <?= str_repeat('<i class="fa fa-star"></i>', (int)$destination['rating']) ?>
                        </div>
                    </div>
                    <h4 class="card-title"><?= $destination['destination'] ?></h4>
                    <p class="card-text"><?= $destination['description'] ?></p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><?= $destination['distance'] ?> km away</small>
                    <a href="#" class="btn btn-sm btn-primary float-end">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Footer (same as your original) -->

<?php mysqli_close($con); ?>
</body>
</html>