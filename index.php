<?php
// index.php
session_start();
include 'config.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enrollment = $_POST['enrollment'];
    $mobile = $_POST['mobile'];

    // Generate a fake OTP (e.g., 123456)
    $otp = rand(100000, 999999);

    // Insert or update student record
    $sql = "INSERT INTO students (enrollment_no, mobile_no, otp, otp_verified)
            VALUES ('$enrollment', '$mobile', '$otp', 0)
            ON DUPLICATE KEY UPDATE otp='$otp', otp_verified=0";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['enrollment'] = $enrollment;
        $msg = "OTP sent successfully (Simulated OTP: $otp)";
        // In real scenario, send OTP via SMS gateway
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>College Fee Payment Portal</title>
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
            background: #5c2d91;
            color: white;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Online Fee Payment</h2>
        <form method="POST">
            <input type="text" name="enrollment" placeholder="Enrollment No / PIN" required><br>
            <input type="text" name="mobile" placeholder="Mobile Number" required><br>
            <input type="submit" value="Verify Mobile & Send OTP">
        </form>
        <p style="color:green;"><?php echo $msg; ?></p>
        <a href="verify_otp.php">Already got OTP? Verify here</a>
    </div>
</body>
</html>
