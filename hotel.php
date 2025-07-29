<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo "<script>window.location.href='hotels.php';</script>";
    exit;
}

$hotel_id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->execute([$hotel_id]);
$hotel = $stmt->fetch();

if (!$hotel) {
    echo "<script>window.location.href='hotels.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $hotel['name']; ?> - ThereToWhere</title>
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
        .hotel-details {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .hotel-details img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #555;
            margin: 0.5rem 0;
        }
        .amenities {
            margin-top: 1rem;
        }
        .amenities ul {
            list-style: none;
            padding: 0;
        }
        .amenities li {
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
            margin-top: 1rem;
        }
        button:hover {
            background: #de6262;
        }
        @media (max-width: 600px) {
            .hotel-details {
                margin: 1rem;
                padding: 1rem;
            }
            .hotel-details img {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="javascript:void(0)" onclick="window.location.href='index.php'">Home</a>
            <a href="javascript:void(0)" onclick="window.location.href='destinations.php'">Destinations</a>
            <a href="javascript:void(0)" onclick="window.location.href='hotels.php'">Hotels</a>
            <a href="javascript:void(0)" onclick="window.location.href='blog.php'">Blog</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="javascript:void(0)" onclick="window.location.href='dashboard.php'">Dashboard</a>
                <a href="javascript:void(0)" onclick="window.location.href='logout.php'">Logout</a>
            <?php else: ?>
                <a href="javascript:void(0)" onclick="window.location.href='login.php'">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="hotel-details">
        <img src="<?php echo $hotel['image_url'] ?: 'https://source.unsplash.com/random/800x300/?hotel'; ?>" alt="<?php echo $hotel['name']; ?>">
        <h2><?php echo $hotel['name']; ?></h2>
        <p><strong>Location:</strong> <?php echo $hotel['location']; ?></p>
        <p><strong>Price per Night:</strong> $<?php echo $hotel['price_per_night']; ?></p>
        <p><?php echo $hotel['description']; ?></p>
        <div class="amenities">
            <h3>Amenities</h3>
            <ul>
                <?php
                $amenities = $hotel['amenities'] ? explode(',', $hotel['amenities']) : ['Wi-Fi', 'Breakfast', 'Parking'];
                foreach ($amenities as $amenity) {
                    echo "<li>$amenity</li>";
                }
                ?>
            </ul>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <button onclick="window.location.href='book-hotel.php?id=<?php echo $hotel['id']; ?>'">Book Now</button>
            <button onclick="window.location.href='save-item.php?type=hotel&id=<?php echo $hotel['id']; ?>'">Save to Wishlist</button>
        <?php endif; ?>
    </div>
</body>
</html>
