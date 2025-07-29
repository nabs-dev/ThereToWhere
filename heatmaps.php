<?php
session_start();
require_once 'db.php';

$stmt = $pdo->query("SELECT h.*, d.name, d.image_url FROM heatmaps h JOIN destinations d ON h.destination_id = d.id ORDER BY h.views DESC");
$heatmaps = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destination Heatmaps - ThereToWhere</title>
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
        .heatmaps {
            max-width: 1200px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 0 1rem;
        }
        .heatmap-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .heatmap-card:hover {
            transform: translateY(-5px);
        }
        .heatmap-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .heatmap-card h3 {
            margin: 1rem;
            color: #333;
        }
        .heatmap-card p {
            margin: 0 1rem 1rem;
            color: #555;
        }
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }
        @media (max-width: 600px) {
            .heatmaps {
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
            <?php endif; ?>
        </nav>
    </header>
    <section class="heatmaps">
        <h2 style="text-align: center; color: #333;">Popular Destinations</h2>
        <?php foreach ($heatmaps as $heatmap): ?>
            <div class="heatmap-card">
                <img src="<?php echo $heatmap['image_url'] ?: 'https://source.unsplash.com/random/300x200/?destination'; ?>" alt="<?php echo $heatmap['name']; ?>">
                <h3><?php echo $heatmap['name']; ?></h3>
                <p>Views: <?php echo $heatmap['views']; ?></p>
            </div>
        <?php endforeach; ?>
    </section>
    <footer>
        <p>© 2025 ThereToWhere. All rights reserved.</p>
    </footer>
</body>
</html>
