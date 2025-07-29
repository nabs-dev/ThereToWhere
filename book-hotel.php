<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$hotel_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];
$check_in_date = $_POST['check_in_date'] ?? date('Y-m-d', strtotime('+1 week'));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, hotel_id, booking_date, status) VALUES (?, ?, ?, 'confirmed')");
    if ($stmt->execute([$user_id, $hotel_id, $check_in_date])) {
        $booking_id = $pdo->lastInsertId();
        echo "<script>window.location.href='hotel-booking-confirmation.php?id=$booking_id';</script>";
    } else {
        echo "<script>alert('Booking failed.'); window.location.href='hotel.php?id=$hotel_id';</script>";
    }
}

$stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->execute([$hotel_id]);
$hotel = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo $hotel['name']; ?> - ThereToWhere</title>
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
        .booking-form {
            max-width: 600px;
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
        label {
            color: #555;
            display: block;
            margin: 0.5rem 0;
        }
        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 1rem;
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
            .booking-form {
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
            <a href="javascript:void(0)" onclick="window.location.href='hotels.php'">Hotels</a>
            <a href="javascript:void(0)" onclick="window.location.href='dashboard.php'">Dashboard</a>
            <a href="javascript:void(0)" onclick="window.location.href='logout.php'">Logout</a>
        </nav>
    </header>
    <div class="booking-form">
        <h2>Book <?php echo $hotel['name']; ?></h2>
        <form method="POST">
            <label for="check_in_date">Check-in Date:</label>
            <input type="date" id="check_in_date" name="check_in_date" value="<?php echo $check_in_date; ?>" required>
            <button type="submit">Confirm Booking</button>
        </form>
    </div>
</body>
</html>
