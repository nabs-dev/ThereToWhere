<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo "<script>window.location.href='blog.php';</script>";
    exit;
}

$post_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    echo "<script>window.location.href='blog.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?> - ThereToWhere</title>
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
        .post-details {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .post-details img {
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
            line-height: 1.6;
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
            .post-details {
                margin: 1rem;
                padding: 1rem;
            }
            .post-details img {
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
    <div class="post-details">
        <img src="<?php echo $post['image_url'] ?: 'https://source.unsplash.com/random/800x300/?travel'; ?>" alt="<?php echo $post['title']; ?>">
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo nl2br($post['content']); ?></p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <button onclick="window.location.href='save-item.php?type=blog&id=<?php echo $post['id']; ?>'">Save to Wishlist</button>
        <?php endif; ?>
    </div>
</body>
</html>
