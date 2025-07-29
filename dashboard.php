<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM bookings b JOIN packages p ON b.package_id = p.id WHERE b.user_id = ?");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT d.* FROM saved_items s JOIN destinations d ON s.destination_id = d.id WHERE s.user_id = ?");
$stmt->execute([$user_id]);
$saved_destinations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ThereToWhere</title>
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
        .dashboard {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        .section {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .booking-card, .saved-card {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid #ddd;
        }
        .booking-card img, .saved-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        .booking-card h3, .saved-card h3 {
            margin: 0;
            color: #333;
        }
        .booking-card p, .saved-card p {
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
            .booking-card, .saved-card {
                flex-direction: column;
            }
            .booking-card img, .saved-card img {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="javascript:void(0)" onclick="window.location.href='index.php'">Home</a>
            <a href="javascript:void(0)" onclick="window.location.href='destinations.php'">Destinations</a>
            <a href="javascript:void(0)" onclick="window.location.href='blog.php'">Blog</a>
            <a href="javascript:void(0)" onclick="window.location.href='logout.php'">Logout</a>
        </nav>
    </header>
    <div class="dashboard">
        <h2>Welcome to Your Dashboard</h2>
        <div class="section">
            <h3>Your Bookings</h3>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card">
                    <img src="https://source.unsplash.com/random/100x100/?travel" alt="Booking">
                    <div>
                        <h3><?php echo $booking['title']; ?></h3>
                        <p>Status: <?php echo $booking['status']; ?></p>
                        <p>Date: <?php echo $booking['booking_date']; ?></p>
                        <a href="javascript:void(0)" onclick="window.location.href='booking.php?id=<?php echo $booking['id']; ?>'">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section">
            <h3>Saved Destinations</h3>
            <?php foreach ($saved_destinations as $dest): ?>
                <div class="saved-card">
                    <img src="<?php echo $dest['image_url'] ?: 'https://source.unsplash.com/random/100x100/?destination'; ?>" alt="<?php echo $dest['name']; ?>">
                    <div>
                        <h3><?php echo $dest['name']; ?></h3>
                        <p><?php echo substr($dest['description'], 0, 100) . '...'; ?></p>
                        <a href="javascript:void(0)" onclick="window.location.href='destination.php?id=<?php echo $dest['id']; ?>'">Explore</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
