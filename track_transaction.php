<?php
session_start();
include "header.php"
require_once "config.php";

if (!isset($_SESSION['enrollment'])) {
    header("Location: index.php");
    exit();
}

$enrollment = $_SESSION['enrollment'];

// Get student ID
$stmt = $conn->prepare("SELECT id FROM students WHERE enrollment_no = ?");
$stmt->bind_param("s", $enrollment);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$student_id = $row['id'] ?? 0;

// Fetch transactions
$transactions = [];
if ($student_id) {
    $stmt = $conn->prepare("SELECT * FROM payments WHERE student_id = ? ORDER BY txn_date DESC");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $transactions = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Track Transactions</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e8f0fe;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            background-color: white;
            margin: 60px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #bbb;
        }
        th, td {
            padding: 12px;
            text-align: center;
            font-size: 15px;
        }
        th {
            background-color: #003366;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back {
            margin-top: 25px;
            text-align: center;
        }
        .back a {
            background-color: #003366;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 4px;
        }
        .back a:hover {
            background-color: #002244;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Transaction History</h2>

    <?php if ($transactions && $transactions->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $transactions->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>₹<?php echo number_format($row['amount'], 2); ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo date('d M Y, h:i A', strtotime($row['txn_date'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No transactions found.</p>
    <?php endif; ?>

    <div class="back">
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
