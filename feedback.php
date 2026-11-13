
<?php
require_once 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_name = trim($_POST['student_name']);
    $email = trim($_POST['email']);
    $feedback = trim($_POST['message']);

    $stmt = $conn->prepare(
        "INSERT INTO feedback (student_name, email, message)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param("sss", $student_name, $email, $feedback);

    if ($stmt->execute()) {
        $message = "Feedback submitted successfully.";
    } else {
        $message = "Unable to submit feedback.";
    }

    $stmt->close();
}

$result = $conn->query(
    "SELECT student_name, email, message, submitted_at
     FROM feedback
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Feedback</title>
    <style>
        body {
            font-family: Arial;
            background: #f1f5f9;
            margin: 30px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }
        input, textarea, button {
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
        .entry {
            border-top: 1px solid #ddd;
            padding: 12px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Student Feedback Form</h2>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST" action="feedback.php">
        <input type="text" name="student_name"
               placeholder="Student Name" required>

        <input type="email" name="email"
               placeholder="Email Address" required>

        <textarea name="message"
                  placeholder="Enter your feedback"
                  rows="4" required></textarea>

        <button type="submit">Submit Feedback</button>
    </form>

    <h2>Submitted Feedback</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="entry">
            <strong>
                <?php echo htmlspecialchars($row['student_name']); ?>
            </strong>
            <p><?php echo htmlspecialchars($row['email']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
            <small><?php echo htmlspecialchars($row['submitted_at']); ?></small>
        </div>
    <?php endwhile; ?>

    <p><a href="dashboard.php">Return to Dashboard</a></p>
</div>
</body>
</html>
