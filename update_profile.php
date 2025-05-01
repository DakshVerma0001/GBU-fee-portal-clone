<?php
// update_profile.php
session_start();
include 'config.php';

if (!isset($_SESSION['enrollment'])) {
    header("Location: index.php");
    exit();
}

$enrollment = $_SESSION['enrollment'];
$msg = "";

// Fetch current student data
$sql = "SELECT * FROM students WHERE enrollment_no = '$enrollment'";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "Student not found!";
    exit();
}

$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_mobile = $_POST['mobile'];

    // Basic mobile validation
    if (preg_match('/^[0-9]{10}$/', $new_mobile)) {
        $update = "UPDATE students SET mobile_no = '$new_mobile' WHERE enrollment_no = '$enrollment'";
        if ($conn->query($update)) {
            $msg = "Mobile number updated successfully!";
            $student['mobile_no'] = $new_mobile;
        } else {
            $msg = "Error updating mobile number.";
        }
    } else {
        $msg = "Invalid mobile number format.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; text-align: center; }
        .container { background: white; padding: 30px; width: 400px; margin: 60px auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
        input[type=text] {
            padding: 10px;
            width: 90%;
            margin: 10px 0;
        }
        input[type=submit] {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .back-btn {
            margin-top: 15px;
            display: inline-block;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <form method="POST">
            <label>Enrollment No: </label>
            <p><strong><?php echo htmlspecialchars($student['enrollment_no']); ?></strong></p>

            <label>Current Mobile Number:</label><br>
            <input type="text" name="mobile" value="<?php echo htmlspecialchars($student['mobile_no']); ?>" required><br>

            <input type="submit" value="Update">
        </form>
        <p style="color:green;"><?php echo $msg; ?></p>
        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
</body>
</html>
