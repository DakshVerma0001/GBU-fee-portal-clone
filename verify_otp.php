<?php
// verify_otp.php
session_start();
include 'config.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enrollment = $_POST['enrollment'];
    $otp_input = $_POST['otp'];

    // Check if the OTP matches for the enrollment number
    $sql = "SELECT * FROM students WHERE enrollment_no='$enrollment' AND otp='$otp_input'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows == 1) {
        // Mark OTP as verified
        $update = "UPDATE students SET otp_verified = 1 WHERE enrollment_no='$enrollment'";
        $conn->query($update);

        $_SESSION['enrollment'] = $enrollment;
        header("Location: dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        $msg = "Invalid OTP or Enrollment Number!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; text-align: center; }
        .container { margin-top: 80px; background: white; padding: 30px; width: 400px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
        input[type=text], input[type=number] {
            padding: 10px;
            width: 90%;
            margin: 10px 0;
        }
        input[type=submit] {
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        <form method="POST">
            <input type="text" name="enrollment" placeholder="Enrollment No" required><br>
            <input type="text" name="otp" placeholder="Enter OTP" required><br>
            <input type="submit" value="Verify">
        </form>
        <p style="color:red;"><?php echo $msg; ?></p>
    </div>
</body>
</html>
