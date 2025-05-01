<?php
// process_payment.php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];

    // Basic validation
    if (!is_numeric($amount) || $amount <= 0) {
        die("Invalid payment amount.");
    }

    // Insert payment (simulated)
    $sql = "INSERT INTO payments (student_id, amount, status)
            VALUES ('$student_id', '$amount', 'Paid')";

    if ($conn->query($sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
