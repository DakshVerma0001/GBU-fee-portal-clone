<?php
// dashboard.php
session_start();
include 'config.php';

// If student not logged in via session, redirect to login
if (!isset($_SESSION['enrollment'])) {
    header("Location: index.php");
    exit();
}

$enrollment = $_SESSION['enrollment'];

// Get student info
$sql = "SELECT id, enrollment_no, mobile_no FROM students WHERE enrollment_no = '$enrollment' AND otp_verified = 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "Access denied. Please verify your OTP again.";
    session_destroy();
    exit();
}

$student = $result->fetch_assoc();
$student_id = $student['id'];

// Check payment status
$payment_sql = "SELECT * FROM payments WHERE student_id = $student_id ORDER BY txn_date DESC LIMIT 1";
$payment_result = $conn->query($payment_sql);
$payment = $payment_result->num_rows > 0 ? $payment_result->fetch_assoc() : null;

$status = $payment ? $payment['status'] : "Not Paid";
$amount = $payment ? $payment['amount'] : "0.00";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; text-align: center; }
        .container { background: white; padding: 30px; width: 500px; margin: 50px auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
        .status-box { margin: 20px 0; font-size: 18px; }
        .pay-btn {
            padding: 10px 20px;
            background: #5c2d91;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($student['enrollment_no']); ?></h2>
        <p>Mobile No: <?php echo htmlspecialchars($student['mobile_no']); ?></p>

        <div class="status-box">
            <strong>Fee Payment Status:</strong> <?php echo htmlspecialchars($status); ?><br>
            <strong>Amount:</strong> ₹<?php echo htmlspecialchars($amount); ?>
        </div>

        <?php if ($status !== 'Paid'): ?>
            <form method="POST" action="process_payment.php">
                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                <input type="number" name="amount" placeholder="Enter amount (e.g., 5000)" required><br><br>
                <button type="submit" class="pay-btn">Pay Now</button>
            </form>
        <?php else: ?>
            <p style="color:green;"><strong>Payment Completed ✅</strong></p>
        <?php endif; ?>

        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
