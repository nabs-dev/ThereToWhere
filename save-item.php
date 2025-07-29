<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['type']) || !isset($_GET['id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$type = $_GET['type'];
$id = (int)$_GET['id'];

$column = '';
if ($type == 'destination') $column = 'destination_id';
elseif ($type == 'package') $column = 'package_id';
elseif ($type == 'blog') $column = 'blog_post_id';
else {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO saved_items (user_id, $column) VALUES (?, ?)");
if ($stmt->execute([$user_id, $id])) {
    echo "<script>window.location.href='$type.php?id=$id';</script>";
} else {
    echo "<script>alert('Failed to save item.'); window.location.href='$type.php?id=$id';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saving Item - ThereToWhere</title>
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
        <h2>Saving Item...</h2>
        <p>Please wait while we save your item.</p>
    </div>
</body>
</html>
