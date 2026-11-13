
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>

    <p>You have successfully logged in.</p>

    <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>

    <a href="logout.php">Logout</a>
</body>
</html>
