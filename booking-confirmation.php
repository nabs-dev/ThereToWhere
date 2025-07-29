<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$booking_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT b.*, p.title, p.description, u.email FROM bookings b JOIN packages p ON b.package_id = p.id JOIN users u ON b.user_id = u.id WHERE b.id = ? AND b.user_id = ?");
$stmt->execute([$booking_id, $_SESSION['user_id']]);
$booking = $stmt->fetch();

if (!$booking) {
    echo "<script>window.location.href='dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - ThereToWhere</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background: #f4f4f4;
        }
        header {
            background: linear-gradient(135deg, #ff6f61, #de6262);
            color: white;
            padding: 1rem;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 1rem;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .confirmation {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #555;
            margin: 0.5rem 0;
        }
        button {
            padding: 0.75rem 1.5rem;
            background: #ff6f61;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #de6262;
        }
        @media (max-width: 600px) {
            .confirmation {
                margin: 1rem;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="javascript:void(0)" onclick="window.location.href='index.php'">Home</a>
            <a href="javascript:void(0)" onclick="window.location.href='dashboard.php'">Dashboard</a>
            <a href="javascript:void(0)" onclick="window.location.href='logout.php'">Logout</a>
        </nav>
    </header>
    <div class="confirmation">
        <h2>Booking Confirmation</h2>
        <p><strong>Package:</strong> <?php echo $booking['title']; ?></p>
        <p><strong>Description:</strong> <?php echo $booking['description']; ?></p>
        <p><strong>Booking Date:</strong> <?php echo $booking['booking_date']; ?></p>
        <p><strong>Status:</strong> <?php echo $booking['status']; ?></p>
        <p><strong>Email Confirmation Sent To:</strong> <?php echo $booking['email']; ?></p>
        <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
    </div>
</body>
</html>
