<?php
session_start();
require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distance Matrix - ThereToWhere</title>
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
        .distance-matrix {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #555;
            margin: 0.5rem 0;
        }
        input {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 0.5rem;
            width: calc(50% - 1rem);
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
            .distance-matrix {
                margin: 1rem;
                padding: 1rem;
            }
            input {
                width: 100%;
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
    <div class="distance-matrix">
        <h2>Calculate Distance Between Destinations</h2>
        <p>Enter two destinations to estimate the distance (Note: Requires external API for full functionality).</p>
        <input type="text" id="origin" placeholder="Origin (e.g., Paris)">
        <input type="text" id="destination" placeholder="Destination (e.g., Rome)">
        <button onclick="calculateDistance()">Calculate</button>
        <p id="result">Distance: N/A</p>
    </div>
    <script>
        function calculateDistance() {
            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;
            document.getElementById('result').innerText = `Distance between ${origin} and ${destination}: (API integration required)`;
            // Placeholder: Real implementation would use Google Maps Distance Matrix API
        }
    </script>
</body>
</html>
