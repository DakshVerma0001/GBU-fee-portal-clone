<?php
session_start();
include "header.php"
require_once "config.php";

if (!isset($_SESSION['enrollment'])) {
    header("Location: index.php");
    exit();
}

$enrollment = $_SESSION['enrollment'];
$success = "";
$error = "";

// Fetch student info
$stmt = $conn->prepare("SELECT mobile_no FROM students WHERE enrollment_no = ?");
$stmt->bind_param("s", $enrollment);
$stmt->execute();
$stmt->bind_result($mobile_no);
$stmt->fetch();
$stmt->close();

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_mobile = trim($_POST['mobile']);

    if (preg_match('/^[6-9]\d{9}$/', $new_mobile)) {
        $stmt = $conn->prepare("UPDATE students SET mobile_no = ? WHERE enrollment_no = ?");
        $stmt->bind_param("ss", $new_mobile, $enrollment);
        if ($stmt->execute()) {
            $success = "Mobile number updated successfully.";
            $mobile_no = $new_mobile;
        } else {
            $error = "Failed to update mobile number.";
        }
        $stmt->close();
    } else {
        $error = "Invalid mobile number format.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e8f0fe;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 70px auto;
            background: white;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 25px;
        }
        label {
            font-weight: bold;
            margin-bottom: 6px;
            display: block;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #003366;
            color: white;
            padding: 12px;
            border: none;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #002244;
        }
        .message {
            text-align: center;
            font-weight: bold;
            color: green;
        }
        .error {
            text-align: center;
            font-weight: bold;
            color: red;
        }
        .back {
            margin-top: 20px;
            text-align: center;
        }
        .back a {
            color: #003366;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Mobile Number</h2>

    <?php if ($success): ?>
        <div class="message"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="mobile">Mobile Number</label>
        <input type="text" name="mobile" id="mobile" value="<?php echo htmlspecialchars($mobile_no); ?>" required>

        <input type="submit" value="Update">
    </form>

    <div class="back">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
