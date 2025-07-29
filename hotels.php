<?php
session_start();
require_once 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM hotels";
if ($search) {
    $query .= " WHERE name LIKE ? OR location LIKE ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query($query);
}
$hotels = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotels - ThereToWhere</title>
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
        .search-bar {
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 1rem;
        }
        .search-bar input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .search-bar button {
            padding: 0.75rem 1.5rem;
            background: #ff6f61;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        .search-bar button:hover {
            background: #de6262;
        }
        .hotels {
            max-width: 1200px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 0 1rem;
        }
        .hotel-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .hotel-card:hover {
            transform: translateY(-5px);
        }
        .hotel-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .hotel-card h3 {
            margin: 1rem;
            color: #333;
        }
        .hotel-card p {
            margin: 0 1rem 1rem;
            color: #555;
        }
        .hotel-card a {
            display: block;
            margin: 1rem;
            padding: 0.75rem;
            background: #ff6f61;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .hotel-card a:hover {
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
            .search-bar {
                flex-direction: column;
                margin: 1rem;
            }
            .hotels {
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
    <div class="search-bar">
        <input type="text" id="search" placeholder="Search hotels by name or location..." value="<?php echo htmlspecialchars($search); ?>">
        <button onclick="window.location.href='hotels.php?search=' + document.getElementById('search').value">Search</button>
    </div>
    <section class="hotels">
        <?php if (empty($hotels)): ?>
            <p style="text-align: center; color: #555;">No hotels found.</p>
        <?php else: ?>
            <?php foreach ($hotels as $hotel): ?>
                <div class="hotel-card">
                    <img src="<?php echo $hotel['image_url'] ?: 'https://source.unsplash.com/random/300x200/?hotel'; ?>" alt="<?php echo $hotel['name']; ?>">
                    <h3><?php echo $hotel['name']; ?></h3>
                    <p><?php echo substr($hotel['description'], 0, 100) . '...'; ?></p>
                    <p><strong>Location:</strong> <?php echo $hotel['location']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $hotel['price_per_night']; ?>/night</p>
                    <a href="javascript:void(0)" onclick="window.location.href='hotel.php?id=<?php echo $hotel['id']; ?>'">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
    <footer>
        <p>© 2025 ThereToWhere. All rights reserved.</p>
    </footer>
</body>
</html>
