<?php
session_start();
if (isset($_SESSION['enrollment'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login - College Fee Portal</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #e8f0fe;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 450px;
            background: white;
            margin: 80px auto;
            border: 1px solid #d2d2d2;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #aaa;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            background: #003366;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #002244;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 25px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Online Fee Payment Portal</h2>
    <form method="POST" action="verify_otp.php">
        <label for="enrollment">Enrollment Number</label>
        <input type="text" name="enrollment" id="enrollment" required>

        <label for="mobile">Registered Mobile Number</label>
        <input type="text" name="mobile" id="mobile" required>

        <input type="submit" value="Generate OTP">
    </form>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> Your College Name. All rights reserved.
    </div>
</div>

</body>
</html>
