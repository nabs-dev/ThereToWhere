<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo "<script>window.location.href='destinations.php';</script>";
    exit;
}

$destination_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM destinations WHERE id = ?");
$stmt->execute([$destination_id]);
$destination = $stmt->fetch();

if (!$destination) {
    echo "<script>window.location.href='destinations.php';</script>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM packages WHERE destination_id = ?");
$stmt->execute([$destination_id]);
$packages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $destination['name']; ?> - ThereToWhere</title>
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
        .destination-details {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .destination-details img {
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
        .packages {
            margin-top: 2rem;
        }
        .package-card {
            background: #f9f9f9;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        .package-card a {
            color: #ff6f61;
            text-decoration: none;
        }
        .package-card a:hover {
            text-decoration: underline;
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
            .destination-details {
                margin: 1rem;
                padding: 1rem;
            }
            .destination-details img {
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
            <a href="javascript:void(0)" onclick="window.location.href='blog.php'">Blog</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="javascript:void(0)" onclick="window.location.href='dashboard.php'">Dashboard</a>
                <a href="javascript:void(0)" onclick="window.location.href='logout.php'">Logout</a>
            <?php else: ?>
                <a href="javascript:void(0)" onclick="window.location.href='login.php'">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="destination-details">
        <img src="<?php echo $destination['image_url'] ?: 'https://source.unsplash.com/random/800x300/?destination'; ?>" alt="<?php echo $destination['name']; ?>">
        <h2><?php echo $destination['name']; ?></h2>
        <p><?php echo $destination['description']; ?></p>
        <p><strong>Price:</strong> Starting from $<?php echo $destination['price']; ?></p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <button onclick="window.location.href='save-item.php?type=destination&id=<?php echo $destination['id']; ?>'">Save to Wishlist</button>
        <?php endif; ?>
        <div class="packages">
            <h3>Available Packages</h3>
            <?php foreach ($packages as $package): ?>
                <div class="package-card">
                    <h4><?php echo $package['title']; ?></h4>
                    <p><?php echo substr($package['description'], 0, 100) . '...'; ?></p>
                    <p>Price: $<?php echo $package['price']; ?> | Duration: <?php echo $package['duration']; ?> days</p>
                    <a href="javascript:void(0)" onclick="window.location.href='package.php?id=<?php echo $package['id']; ?>'">View Package</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
