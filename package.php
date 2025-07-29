<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo "<script>window.location.href='packages.php';</script>";
    exit;
}

$package_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, d.name AS destination_name FROM packages p JOIN destinations d ON p.destination_id = d.id WHERE p.id = ?");
$stmt->execute([$package_id]);
$package = $stmt->fetch();

if (!$package) {
    echo "<script>window.location.href='packages.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $package['title']; ?> - ThereToWhere</title>
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
        .package-details {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .package-details img {
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
            .package-details {
                margin: 1rem;
                padding: 1rem;
            }
            .package-details img {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="javascript:void(0)" onclick="window.location.href='index.php'">Home</a>
            <a href="javascript:void(0)" onclick="window.location.href='packages.php'">Packages</a>
            <a href="javascript:void(0)" onclick="window.location.href='blog.php'">Blog</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="javascript:void(0)" onclick="window.location.href='dashboard.php'">Dashboard</a>
                <a href="javascript:void(0)" onclick="window.location.href='logout.php'">Logout</a>
            <?php else: ?>
                <a href="javascript:void(0)" onclick="window.location.href='login.php'">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="package-details">
        <img src="https://source.unsplash.com/random/800x300/?travel" alt="<?php echo $package['title']; ?>">
        <h2><?php echo $package['title']; ?> (<?php echo $package['destination_name']; ?>)</h2>
        <p><?php echo $package['description']; ?></p>
        <p><strong>Price:</strong> $<?php echo $package['price']; ?></p>
        <p><strong>Duration:</strong> <?php echo $package['duration']; ?> days</p>
        <p><strong>Type:</strong> <?php echo ucfirst($package['type']); ?></p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <button onclick="window.location.href='book-package.php?id=<?php echo $package['id']; ?>'">Book Now</button>
            <button onclick="window.location.href='save-item.php?type=package&id=<?php echo $package['id']; ?>'">Save to Wishlist</button>
        <?php else: ?>
            <button onclick="window.location.href='login.php'">Login to Book</button>
        <?php endif; ?>
    </div>
</body>
</html>
