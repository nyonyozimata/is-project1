
<?php
session_start();
require_once 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT id, full_name, username, password
         FROM users
         WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['username'] = $user['username'];

            header("Location: dashboard.php");
            exit;
        }
    }

    $message = "Invalid username or password.";
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f1f5f9;
        }
        .container {
            width: 350px;
            margin: 60px auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        button {
            background: #2563eb;
            color: white;
            border: 0;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Login</h2>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST" action="login.php">
        <input type="text" name="username"
               placeholder="Username" required>

        <input type="password" name="password"
               placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account?
       <a href="signup.php">Register here</a>
    </p>
</div>
</body>
</html>
