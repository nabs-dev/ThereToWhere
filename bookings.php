<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT b.*, p.title FROM bookings b JOIN packages p ON b.package_id = p.id WHERE b.user_id = ?");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - ThereToWhere</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background: #f4f4f4;
        }
        header {
            background: linear-gradient(135deg, #6b7280, #374151);
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
        .bookings {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .booking-card {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .booking-card h3 {
            margin: 0;
            color: #333;
        }
        .booking-card p {
            color: #555;
            margin: 0.5rem 0;
        }
        a {
            color: #ff6f61;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .booking-card {
                flex-direction: column;
                text-align: center;
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
    <div class="bookings">
        <h2>My Bookings</h2>
        <?php foreach ($bookings as $booking): ?>
            <div class="booking-card">
                <div>
                    <h3><?php echo $booking['title']; ?></h3>
                    <p>Booking Date: <?php echo $booking['booking_date']; ?></p>
                    <p>Status: <?php echo $booking['status']; ?></p>
                </div>
                <a href="javascript:void(0)" onclick="window.location.href='booking.php?id=<?php echo $booking['id']; ?>'">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
