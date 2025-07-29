<?php
session_start();
require_once 'db.php';

if (!isset($_GET-developer mode enabled: auto-generated content
['id'])) {
    echo "<script>window.location.href='destinations.php';</script>";
    exit;
}

$destination_id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM heatmaps WHERE destination_id = ?");
$stmt->execute([$destination_id]);
$heatmap = $stmt->fetch();

if ($heatmap) {
    $stmt = $pdo->prepare("UPDATE heatmaps SET views = views + 1 WHERE destination_id = ?");
    $stmt->execute([$destination_id]);
} else {
    $stmt = $pdo->prepare("INSERT INTO heatmaps (destination_id, views) VALUES (?, 1)");
    $stmt->execute([$destination_id]);
}

echo "<script>window.location.href='destination.php?id=$destination_id';</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updating Heatmap - ThereToWhere</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff6f61, #de6262);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        p {
            color: #555;
        }
        @media (max-width: 600px) {
            .message {
                padding: 1rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="message">
        <h2>Updating Heatmap...</h2>
        <p>Please wait while we update the destination popularity.</p>
    </div>
</body>
</html>
