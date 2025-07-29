<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $password])) {
        echo "<script>window.location.href='login.php';</script>";
    } else {
        $error = "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - ThereToWhere</title>
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
        .signup-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 1.5rem;
        }
        input {
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background: #ff6f61;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #de6262;
        }
        .error {
            color: red;
            margin-top: 1rem;
        }
        a {
            color: #ff6f61;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .signup-container {
                padding: 1rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <p>Already have an account? <a href="javascript:void(0)" onclick="window.location.href='login.php'">Login</a></p>
    </div>
</body>
</html>
