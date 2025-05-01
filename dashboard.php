<?php
session_start();
if (!isset($_SESSION['enrollment'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e8f0fe;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
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
        .info {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .buttons {
            text-align: center;
        }
        .buttons a {
            text-decoration: none;
            background-color: #003366;
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            margin: 10px;
            display: inline-block;
        }
        .buttons a:hover {
            background-color: #002244;
        }
        .logout {
            text-align: right;
            margin-top: -20px;
        }
        .logout a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <h2>Welcome to Your Dashboard</h2>

    <div class="info">
        <strong>Enrollment No:</strong> <?php echo $_SESSION['enrollment']; ?>
    </div>

    <div class="buttons">
        <a href="pay_fee.php">Pay Fee</a>
        <a href="track_transaction.php">Track Transactions</a>
        <a href="update_profile.php">Update Profile</a>
    </div>
</div>

</body>
</html>
