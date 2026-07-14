<?php
include 'sidebar.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- PRE-FETCH DROPDOWN DATA (Optimization) ---
// Fetching these once is better than fetching them inside the loop 100 times

$accommodation_list = [];
$ac_query = mysqli_query($con, "SELECT a_id, name FROM ac_tb");
while($row = mysqli_fetch_assoc($ac_query)) { 
    $accommodation_list[] = $row; 
}


$hotel_types = [];
$ht_query = mysqli_query($con, "SELECT * FROM hotel_tb");
while($row = mysqli_fetch_assoc($ht_query)) { $hotel_types[] = $row; }

$room_types = [];
$rt_query = mysqli_query($con, "SELECT * FROM room_tb");
while($row = mysqli_fetch_assoc($rt_query)) { $room_types[] = $row; }

$facilities_data = [];
$ft_query = mysqli_query($con, "SELECT * FROM facility_tb");
while($row = mysqli_fetch_assoc($ft_query)) { $facilities_data[] = $row; }
?>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title"><b>Accommodation Table</b></h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                                <i class="mdi mdi-plus"></i> Add New Accommodation
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Hotel Name</th>
                                        <th>Photo</th>
                                        <th>Hotel type</th>
                                        <th>Room type</th>
                                        <th>No of people</th>
                                        <th>Facilities</th>
                                        <th>Description</th>
                                        <th>Rating</th>
                                        <th>Distance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $acco = mysqli_query($con, "SELECT * FROM ac_tb");
                                    // Array to store modals so we can print them AFTER the table
                                    $modals_output = ""; 
                                    
                                    while ($ac = mysqli_fetch_assoc($acco)) {
                                        // Get Names for IDs (using the pre-fetched arrays would be faster, but keeping your logic for now)
                                        $hid = $ac['h_type'];
                                        $rid = $ac['r_type'];
                                        $fac = $ac['facilities'];

                                        // Inline lookups (You can optimize this later using JOINS in the main query)
                                        $p = mysqli_query($con, "select * from hotel_tb where hid='$hid'");
                                        $r = mysqli_query($con, "select * from room_tb where r_id='$rid'");
                                        $f = mysqli_query($con, "select * from facility_tb where f_id='$fac'");

                                        $acc_name = (mysqli_num_rows($p) > 0) ? mysqli_fetch_assoc($p)['type'] : 'N/A';
                                        $room_name = (mysqli_num_rows($r) > 0) ? mysqli_fetch_assoc($r)['r_type'] : 'N/A';
                                        $fac_name = (mysqli_num_rows($f) > 0) ? mysqli_fetch_assoc($f)['f_type'] : 'N/A';
                                    ?>
                                        <tr>
                                            <td><?php echo $ac['a_id']; ?></td>
                                            <td><?php echo $ac['name']; ?></td>
                                            <td>
                                                <?php if(!empty($ac['photo'])): ?>
                                                    <img src="../../../<?php echo $ac['photo']; ?>" alt="Img" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                                <?php else: ?>
                                                    <span>No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $acc_name ?></td>
                                            <td><?php echo $room_name; ?></td>
                                            <td><?php echo $ac['no_of_people']; ?></td>
                                            <td><?php echo $fac_name; ?></td>
                                            <td><?php echo substr($ac['h_description'], 0, 50) . '...'; ?></td>
                                            <td><?php echo $ac['rating']; ?></td>
                                            <td><?php echo $ac['distance']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?php echo $ac['a_id']; ?>">Edit</button>
                                                <a href="delete_acco.php?id=<?php echo $ac['a_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this Destination?');">Delete</a>
                                            </td>
                                        </tr>

                                    <?php
                                        // --- BUILD EDIT MODAL FOR THIS ROW ---
                                        // We concatenate this to a string and print it after the table
                                        ob_start();
                                    ?>
                                        <div class="modal fade" id="editModal<?php echo $ac['a_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <form action="update_acco.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="id" value="<?php echo $ac['a_id']; ?>">
                                                    <input type="hidden" name="old_photo" value="<?php echo $ac['photo']; ?>">
                                                    
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Destination (ID: <?php echo $ac['a_id']; ?>)</h5>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6 form-group">                                                                  
                                                                    <label>Hotel Name</label>
                                                                    <input type="text" name="name" class="form-control" placeholder="Enter hotel name" required>
                                                                </div>

                                                                <div class="col-md-6 form-group">
                                                                    <label>Hotel type</label>
                                                                    <select name="h_type" class="form-control" required>
                                                                        <?php foreach($hotel_types as $ht) { ?>
                                                                            <option value="<?php echo $ht['hid']; ?>" <?php echo ($ht['hid'] == $hid) ? 'selected' : ''; ?>>
                                                                                <?php echo $ht['type']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label>Room Type</label>
                                                                    <select name="r_type" class="form-control" required>
                                                                        <?php foreach($room_types as $rt) { ?>
                                                                            <option value="<?php echo $rt['r_id']; ?>" <?php echo ($rt['r_id'] == $rid) ? 'selected' : ''; ?>>
                                                                                <?php echo $rt['r_type']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label>No of People</label>
                                                                    <input type="number" name="no_of_people" value="<?php echo $ac['no_of_people']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label>Facilities</label>
                                                                    <select name="facilities" class="form-control" required>
                                                                        <?php foreach($facilities_data as $ft) { ?>
                                                                            <option value="<?php echo $ft['f_id']; ?>" <?php echo ($ft['f_id'] == $fac) ? 'selected' : ''; ?>>
                                                                                <?php echo $ft['f_type']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label>Rating</label>
                                                                    <input type="text" name="rating" value="<?php echo $ac['rating']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label>Distance</label>
                                                                    <input type="text" name="distance" value="<?php echo $ac['distance']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-12 form-group">
                                                                    <label>Description</label>
                                                                    <textarea name="h_description" class="form-control" rows="3" required><?php echo $ac['h_description']; ?></textarea>
                                                                </div>
                                                                <div class="col-md-12 form-group">
                                                                    <label>Map Embed Code</label>
                                                                    <textarea name="map" class="form-control" rows="3"><?php echo $ac['map']; ?></textarea>
                                                                </div>
                                                                
                                                                <div class="col-md-12 form-group">
                                                                    <label>Current Image:</label><br>
                                                                    <?php if(!empty($ac['photo'])): ?>
                                                                        <img src="<?php echo $ac['photo']; ?>" width="100" class="mb-2">
                                                                    <?php endif; ?>
                                                                    <br>
                                                                    <label>Upload New Image (Leave empty to keep current)</label>
                                                                    <input type="file" name="photo" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="update" class="btn btn-success">Update</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php
                                        $modals_output .= ob_get_clean();
                                    } // End While Loop
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer text-center">
        All Rights Reserved by Planify.
    </footer>
</div>

<?php
 echo $modals_output; 
 // Add this new query with your other pre-fetch queries
$places_data = [];
$pt_query = mysqli_query($con, "SELECT * FROM place_tb");
while($row = mysqli_fetch_assoc($pt_query)) { $places_data[] = $row; }

?>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="add_acco.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addModalLabel">Add New Accommodation</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label>Hotel Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter hotel name" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Hotel Type</label>
                            <select name="h_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <?php foreach($hotel_types as $ht) { ?>
                                    <option value="<?php echo $ht['hid']; ?>">
                                        <?php echo $ht['type']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Room Type</label>
                            <select name="r_type" class="form-control" required>
                                <option value="">Select Room</option>
                                <?php foreach($room_types as $rt) { ?>
                                    <option value="<?php echo $rt['r_id']; ?>">
                                        <?php echo $rt['r_type']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>No. of People</label>
                            <input type="number" name="no_of_people" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Facilities</label>
                            <select name="facilities" class="form-control" required>
                                <option value="">Select Facilities</option>
                                <?php foreach($facilities_data as $ft) { ?>
                                    <option value="<?php echo $ft['f_id']; ?>">
                                        <?php echo $ft['f_type']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Place / Location</label>
                            <select name="place" class="form-control">
                                <option value="">Select Place</option>
                                <?php foreach($places_data as $pt) { ?>
                                    <option value="<?php echo $pt['id']; ?>">
                                        <?php echo $pt['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Rating</label>
                            <input type="text" name="rating" class="form-control" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Distance</label>
                            <input type="text" name="distance" class="form-control" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Description</label>
                            <textarea name="h_description" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Map Embed Code</label>
                            <textarea name="map" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Upload Photo</label>
                            <input type="file" name="photo" class="form-control" required>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </form>
    </div>
</div>


<script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../dist/js/app.min.js"></script>
<script src="../../dist/js/app.init.mini-sidebar.js"></script>
<script src="../../dist/js/app-style-switcher.js"></script>
<script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="../../dist/js/sidebarmenu.js"></script>
<script src="../../dist/js/custom.min.js"></script>

</body>
</html>