<?php
// track_transaction.php
session_start();
include 'config.php';

if (!isset($_SESSION['enrollment'])) {
    header("Location: index.php");
    exit();
}

$enrollment = $_SESSION['enrollment'];

// Get student ID
$sql = "SELECT id FROM students WHERE enrollment_no = '$enrollment'";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "Student not found!";
    exit();
}

$student = $result->fetch_assoc();
$student_id = $student['id'];

// Fetch transactions
$payment_sql = "SELECT * FROM payments WHERE student_id = $student_id ORDER BY txn_date DESC";
$payment_result = $conn->query($payment_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; text-align: center; }
        .container { width: 700px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
        th { background: #007bff; color: white; }
        .back-btn {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Transaction History</h2>
        <?php if ($payment_result && $payment_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Amount (₹)</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                </tr>
                <?php while ($row = $payment_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['txn_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No transactions found.</p>
        <?php endif; ?>
        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
</body>
</html>
