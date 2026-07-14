<?php
// Adjust path if necessary. If this file is in the root folder, 'db/connection.php' is correct.
include '../Db/connection.php';

$msg = "";
$mock_email_view = ""; 

if (isset($_POST['send_password'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $query = "SELECT * FROM user_tb WHERE email='$email' LIMIT 1";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $password = $row['password'];
        $username = $row['name']; 

        // --- HTML EMAIL TEMPLATE ---
        $email_body = "
        <div style='font-family: Arial, sans-serif; max-width: 100%; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #fff;'>
            <div style='background-color: #1a73e8; padding: 15px; text-align: center; color: #ffffff;'>
                <h2 style='margin: 0;'> PLANIFY</h2>
            </div>
            <div style='padding: 20px; color: #333;'>
                <p>Hello <strong>$username</strong>,</p>
                <p>Your password recovery request was received.</p>
                <div style='background-color: #f1f3f4; padding: 15px; margin: 15px 0; border-left: 4px solid #1a73e8;'>
                    <p style='margin:0; font-size:12px; color:#555;'>Your Password:</p>
                    <h3 style='margin:5px 0 0; color:#222;'>$password</h3>
                </div>
                <p style='font-size: 12px; color: #888;'>If you didn't ask for this, ignore this email.</p>
            </div>
        </div>";

        // --- SUCCESS MESSAGE ---
        $msg = "<div class='alert-success'>✔ Email sent to $email</div>";
        $mock_email_view = $email_body;

    } else {
        // --- ERROR MESSAGE ---
        $msg = "<div class='alert-error'>✘ Email not found</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
      /* Additional styles specifically for this page to match your theme */
      body {
          display: flex;
          flex-direction: column; /* Allows the Mock Inbox to sit below the wrapper */
          align-items: center;
          justify-content: center;
          min-height: 100vh;
          background: linear-gradient(-135deg, #c850c0, #4158d0);
          padding: 20px;
      }
      
      /* Simple Alert Styles */
      .alert-success {
          background: #d4edda; color: #155724; padding: 10px;
          border-radius: 5px; margin-bottom: 15px; text-align: center;
          border: 1px solid #c3e6cb; font-size: 14px;
      }
      .alert-error {
          background: #f8d7da; color: #721c24; padding: 10px;
          border-radius: 5px; margin-bottom: 15px; text-align: center;
          border: 1px solid #f5c6cb; font-size: 14px;
      }

      /* Mock Inbox Styling */
      .mock-inbox-container {
          margin-top: 30px;
          width: 100%;
          max-width: 500px;
          background: rgba(255, 255, 255, 0.9);
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0px 10px 20px rgba(0,0,0,0.2);
          border: 2px dashed #4158d0;
          position: relative;
      }
      .mock-badge {
          background: #28a745; color: white; padding: 4px 8px;
          font-size: 11px; border-radius: 3px; text-transform: uppercase;
          font-weight: bold; display: inline-block; margin-bottom: 10px;
      }
  </style>
</head>
<body>

    <div class="wrapper">
      <div class="title-text">
        <div class="title">Recover Password</div>
      </div>
      
      <div class="form-container">
        <div class="form-inner">
          <form method="POST" action="">
            
            <?php echo $msg; ?>

            <?php if(empty($mock_email_view)): ?>
                <div class="field">
                  <input type="email" name="email" placeholder="Enter your registered email" required>
                </div>
                
                <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" name="send_password" value="Get Password">
                </div>
            <?php endif; ?>

            <div class="signup-link" style="margin-top: 20px;">
                Back to <a href="login/login.php">Login</a>
            </div>

          </form>
        </div>
      </div>
    </div>

    <?php if(!empty($mock_email_view)): ?>
    <div class="mock-inbox-container">
        <div class="mock-badge">Developer Mode: Mock Inbox</div>
        <div style="font-size: 13px; color: #666; margin-bottom: 10px;">
            (Since you are on localhost, the email appears here instead of your real inbox.)
        </div>
        <hr style="border: 0; border-top: 1px solid #ccc; margin: 10px 0;">
        <?php echo $mock_email_view; ?>
    </div>
    <?php endif; ?>

</body>
</html>