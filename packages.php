<?php
session_start();
require_once 'db.php';

$filters = [];
$query = "SELECT p.*, d.name AS destination_name FROM packages p JOIN destinations d ON p.destination_id = d.id";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['price'])) $filters[] = "p.price <= " . (int)$_POST['price'];
    if (!empty($_POST['duration'])) $filters[] = "p.duration <= " . (int)$_POST['duration'];
    if (!empty($_POST['type'])) $filters[] = "p.type = '" . $_POST['type'] . "'";
    if ($filters) $query .= " WHERE " . implode(" AND ", $filters);
}
$stmt = $pdo->query($query);
$packages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Packages - ThereToWhere</title>
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
        .filters {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 1rem;
        }
        .filters input, .filters select {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            flex: 1;
        }
        .filters button {
            padding: 0.75rem 1.5rem;
            background: #ff6f61;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        .filters button:hover {
            background: #de6262;
        }
        .packages {
            max-width: 1200px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 0 1rem;
        }
        .package-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .package-card:hover {
            transform: translateY(-5px);
        }
        .package-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .package-card h3 {
            margin: 1rem;
            color: #333;
        }
        .package-card p {
            margin: 0 1rem 1rem;
            color: #555;
        }
        .package-card a {
            display: block;
            margin: 1rem;
            padding: 0.75rem;
            background: #ff6f61;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .package-card a:hover {
            background: #de6262;
        }
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }
        @media (max-width: 600px) {
            .filters {
                flex-direction: column;
                margin: 1rem;
            }
            .packages {
                grid-template-columns: 1fr;
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
                <a href="javascript:void(0)" onclick="window.location.href='signup.php'">Sign Up</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="filters">
        <form method="POST" style="display: flex; gap: 1rem; width: 100%;">
            <input type="number" name="price" placeholder="Max Price" step="100">
            <input type="number" name="duration" placeholder="Max Duration (days)">
            <select name="type">
                <option value="">Select Type</option>
                <option value="adventure">Adventure</option>
                <option value="relaxation">Relaxation</option>
                <option value="cultural">Cultural</option>
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>
    <section class="packages">
        <?php foreach ($packages as $package): ?>
            <div class="package-card">
                <img src="https://source.unsplash.com/random/300x200/?travel" alt="<?php echo $package['title']; ?>">
                <h3><?php echo $package['title']; ?> (<?php echo $package['destination_name']; ?>)</h3>
                <p><?php echo substr($package['description'], 0, 100) . '...'; ?></p>
                <p>Price: $<?php echo $package['price']; ?> | Duration: <?php echo $package['duration']; ?> days</p>
                <a href="javascript:void(0)" onclick="window.location.href='package.php?id=<?php echo $package['id']; ?>'">View Package</a>
            </div>
        <?php endforeach; ?>
    </section>
    <footer>
        <p>© 2025 ThereToWhere. All rights reserved.</p>
    </footer>
</body>
</html>
