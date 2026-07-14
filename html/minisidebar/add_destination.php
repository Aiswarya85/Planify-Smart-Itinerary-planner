<?php
include '../../../Db/connection.php'; // Adjust path if needed

if (isset($_POST['submit'])) {
    $place = $_POST['place'];
    $destination = $_POST['destination'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $activities = $_POST['activities'];
    $map = $_POST['map'];
    $distance = $_POST['distance'];

    $image = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];

    // Define your upload directory properly
    $upload_dir = "../../../uploads/";  // Make sure this path is correct relative to your script

    // Then use it consistently
    $image_path_for_db = "uploads/" . basename($image);
    $upload_path = $upload_dir . basename($image);
    if (!file_exists($upload_dir)) {
        die("Upload directory doesn't exist");
    }
    if (!is_writable($upload_dir)) {
        die("Upload directory is not writable");
    }
    // Upload image with error handling
    if (move_uploaded_file($tmp_name, "../../../uploads/".basename($image))) {
        $query = "INSERT INTO dest_tb (place, destination, description, photo, rating, activities, map, distance)
                  VALUES ('$place', '$destination', '$description', '$image_path_for_db', '$rating', '$activities', '$map', '$distance')";
        $insert = mysqli_query($con, $query);

        if ($insert) {
            echo "<script>alert('Destination added successfully!'); window.location.href='destination.php';</script>";
        } else {
            die('❌ Database Insert Failed: ' . mysqli_error($con));
        }
    } else {
    
        $error_code = $_FILES['photo']['error'];
        echo "../../../uploads/".basename($image);
        echo "\n".$tmp_name;
        echo "<script>alert('Image upload failed! Error code: $error_code');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Destination</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="p-5">
<div class="container">
    <h3>Add Destination</h3>
    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Select Place:</label>
            <select name="place" class="form-control" required>
                <option value="">-- Select Place --</option>
                <?php
                $place_result = mysqli_query($con, "SELECT * FROM place_tb");
                if ($place_result && mysqli_num_rows($place_result) > 0) {
                    while ($row = mysqli_fetch_assoc($place_result)) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                } else {
                    echo "<option disabled>No places found</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Destination:</label>
            <input type="text" name="destination" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Photo:</label>
            <input type="file" name="photo" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Rating:</label>
            <input type="number" name="rating" min="1" max="5" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Select Activity:</label>
            <select name="activities" class="form-control" required>
                <option value="">-- Select Activity --</option>
                <?php
                $act_result = mysqli_query($con, "SELECT * FROM activity_tb");
                if ($act_result && mysqli_num_rows($act_result) > 0) {
                    while ($act = mysqli_fetch_assoc($act_result)) {
                        echo "<option value='{$act['id']}'>{$act['activity']}</option>";
                    }
                } else {
                    echo "<option disabled>No activities found</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Map Embed:</label>
            <textarea name="map" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label>Distance:</label>
            <input type="text" name="distance" class="form-control" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Destination</button>
    </form>
</div>
</body>
</html>
