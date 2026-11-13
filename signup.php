
<?php
require_once 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users (full_name, username, email, password)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssss", $full_name, $username, $email, $password);

    if ($stmt->execute()) {
        $message = "Registration successful. You can now log in.";
    } else {
        $message = "Registration failed. Username or email may already exist.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body { font-family: Arial; background: #f1f5f9; }
        .container {
            width: 350px; margin: 60px auto; padding: 25px;
            background: white; border-radius: 10px;
        }
        input, button {
            width: 100%; padding: 10px; margin: 8px 0;
            box-sizing: border-box;
        }
        button { background: #2563eb; color: white; border: 0; }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Signup</h2>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST" action="signup.php">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
