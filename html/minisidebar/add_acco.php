<?php
// Include the sidebar which contains the database connection ($con)
include 'sidebar.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted
if (isset($_POST['submit'])) {

    // --- 1. Retrieve and Sanitize Form Data ---

    // IMPORTANT: Your 'ac_tb' table has a 'name' column that is 'NOT NULL',
    // but your 'addModal' form does NOT have an input field for 'name'.
    // You MUST add a field like <input type="text" name="name" class="form-control" placeholder="Hotel Name" required>
    // to your 'addModal' form for this to work. I am assuming you will add it.
    
    $name = mysqli_real_escape_string($con, $_POST['name']); // Assumes you add this field to your form
    $h_type = mysqli_real_escape_string($con, $_POST['h_type']);
    $r_type = mysqli_real_escape_string($con, $_POST['r_type']);
    $no_of_people = mysqli_real_escape_string($con, $_POST['no_of_people']);
    $facilities = mysqli_real_escape_string($con, $_POST['facilities']);
    $place = mysqli_real_escape_string($con, $_POST['place']);
    $rating = mysqli_real_escape_string($con, $_POST['rating']);
    $distance = mysqli_real_escape_string($con, $_POST['distance']);
    $h_description = mysqli_real_escape_string($con, $_POST['h_description']);
    $map = mysqli_real_escape_string($con, $_POST['map']);

    // Handle 'place' if it's empty, as the column allows NULL
    $place_val = !empty($place) ? "'$place'" : "NULL";

    // --- 2. Handle File Upload ---
    $photo_path_db = ""; // This is the path to be stored in the database
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        
        // Path to store in DB (e.g., "uploads/image.jpg")
        $db_path_prefix = "uploads/"; 
        
        // Physical upload directory (based on your view file's src attribute "../../../")
        $upload_dir = "../../../uploads/"; 

        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES["photo"]["name"]);
        $target_file = $upload_dir . $file_name; // Full path to move the file
        $db_file_path = $db_path_prefix . $file_name; // Path to store in DB
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.'); window.history.back();</script>";
            exit;
        }

        // Check file size (e.g., 5MB limit)
        if ($_FILES["photo"]["size"] > 5000000) {
            echo "<script>alert('Sorry, your file is too large.'); window.history.back();</script>";
            exit;
        }

        // Allow only specific file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "<script>alert('Sorry, only JPG, JPEG, & PNG files are allowed.'); window.history.back();</script>";
            exit;
        }
        
        // To prevent overwriting, append a number if file already exists
        $counter = 1;
        $new_file_name = $file_name;
        while (file_exists($target_file)) {
            $new_file_name = pathinfo($file_name, PATHINFO_FILENAME) . "_" . $counter . "." . $imageFileType;
            $target_file = $upload_dir . $new_file_name;
            $db_file_path = $db_path_prefix . $new_file_name;
            $counter++;
        }

        // Try to move the uploaded file
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo_path_db = $db_file_path; // Set the DB path on successful upload
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
            exit;
        }
    } else {
        // The form has 'required' on the photo, but as a fallback
        echo "<script>alert('Photo is required.'); window.history.back();</script>";
        exit;
    }

    // --- 3. Build and Execute INSERT Query ---
    
    // Note: The column order matches your form and DB structure
    $sql = "INSERT INTO ac_tb (name, h_type, place, r_type, no_of_people, facilities, h_description, photo, rating, map, distance) 
            VALUES (
                '$name', 
                '$h_type', 
                $place_val, 
                '$r_type', 
                '$no_of_people', 
                '$facilities', 
                '$h_description', 
                '$photo_path_db', 
                '$rating', 
                '$map', 
                '$distance'
            )";

    if (mysqli_query($con, $sql)) {
        // Success: Redirect back to the accommodation list page
        // (Assuming the page is named 'accommodation.php', change if needed)
        echo "<script>alert('New accommodation added successfully!'); window.location.href = 'accomodation.php';</script>";
    } else {
        // Failure: Show error and go back
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.history.back();</script>";
    }

} else {
    // If accessed directly without form submission, redirect
    echo "<script>alert('Invalid Access.'); window.location.href = 'accomodation.php';</script>";
}
?>