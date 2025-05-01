<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['enrollment'])) {
    header("Location: index.php");
    exit();
}

$enrollment = $_SESSION['enrollment'];
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = trim($_POST['amount']);

    if (!is_numeric($amount) || $amount <= 0) {
        $error = "Please enter a valid fee amount.";
    } else {
        // Get student ID
        $stmt = $conn->prepare("SELECT id FROM students WHERE enrollment_no = ?");
        $stmt->bind_param("s", $enrollment);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
        $stmt->close();

        if ($student) {
            $student_id = $student['id'];

            // Simulate payment success (in real-world, redirect to payment gateway)
            $stmt = $conn->prepare("INSERT INTO payments (student_id, amount, status, txn_date) VALUES (?, ?, 'Success', NOW())");
            $stmt->bind_param("id", $student_id, $amount);
            if ($stmt->execute()) {
                $success = "Payment of ₹" . number_format($amount, 2) . " successful!";
            } else {
                $error = "Failed to process payment.";
            }
            $stmt->close();
        } else {
            $error = "Student not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pay Fee</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e8f0fe;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            background-color: white;
            margin: 70px auto;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
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
            font-size: 16px;
            border: none;
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
            text-align: center;
            margin-top: 20px;
        }
        .back a {
            text-decoration: none;
            color: #003366;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pay Fee</h2>

    <?php if ($success): ?>
        <div class="message"><?php echo $success; ?></div>
    <?php elseif ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="amount">Enter Amount (₹)</label>
        <input type="text" name="amount" id="amount" required>

        <input type="submit" value="Pay Now">
    </form>

    <div class="back">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
