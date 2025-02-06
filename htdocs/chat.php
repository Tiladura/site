<?php
session_start();
include 'C:/MAMP/htdocs/database/db_connect.php'; // Make sure this path is correct
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    die("You must be logged in to access this page.");
}

// Get the logged-in user ID and the user they are chatting with
$loggedInUserId = $_SESSION['id'];
$chatWithId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($chatWithId === 0) {
    die("No user selected for chat.");
}

// Fetch the username of the person being chatted with
$stmt = $conn->prepare("SELECT username FROM userdata WHERE id = ?");
$stmt->bind_param("i", $chatWithId);
$stmt->execute();
$stmt->bind_result($chatWithUsername);
if (!$stmt->fetch()) {
    die("User not found.");
}
$stmt->close();

// Handle form submission to send a message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $loggedInUserId, $chatWithId, $message);

        if (!$stmt->execute()) {
            echo "Error sending message: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Message cannot be empty.</p>";
    }
}

// Fetch messages between the two users
$stmt = $conn->prepare("
    SELECT sender_id, message, timestamp 
    FROM messages 
    WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
    ORDER BY timestamp ASC
");
$stmt->bind_param("iiii", $loggedInUserId, $chatWithId, $chatWithId, $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?= htmlspecialchars($chatWithUsername); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            text-align: center;
        }
        .chat-box {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            background: #f9f9f9;
        }
        .message {
            margin: 10px 0;
            padding: 8px;
            border-radius: 5px;
            display: inline-block;
        }
        .sent {
            background-color: #d1e7ff;
            text-align: right;
        }
        .received {
            background-color: #e2ffe2;
        }
        form {
            margin-top: 20px;
        }
        textarea {
            width: 80%;
            height: 50px;
            margin: 10px 0;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="header" style=" margin:-20px;">
        <h1><img src="Pictures/Projectly.png" alt="projectly icon" style="width:35px; margin-bottom:-10px;">Projectly</h1>

    </div>
    
    <h1>Chat with <?= htmlspecialchars($chatWithUsername); ?></h1>

    <!-- Chat messages -->
    <div class="chat-box">
        <?php if (count($messages) > 0): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message <?= $msg['sender_id'] == $loggedInUserId ? 'sent' : 'received'; ?>">
                    <strong><?= $msg['sender_id'] == $loggedInUserId ? 'You' : htmlspecialchars($chatWithUsername); ?>:</strong>
                    <?= htmlspecialchars($msg['message']); ?>
                    <br>
                    <small><em><?= $msg['timestamp']; ?></em></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages yet. Start the conversation!</p>
        <?php endif; ?>
    </div>

    <!-- Message form -->
    <form method="POST" action="">
        <textarea name="message" placeholder="Type your message here..." required></textarea>
        <br>
        <button type="submit">Send</button>
    </form>
    <div class="footer-nav" style=" margin-left: -20px;">
        <a href="index.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon" style="">Home</a>

        <?php if (isset($_SESSION['username'])): ?>
            <a href="profile.php"><img src="pictures/profile-icon.png" alt="Profile Icon" class="profile-icon">Profile(<?php echo htmlspecialchars($_SESSION['username']); ?>)</a> 
        <?php else: ?>
            <a href="login.php"><img src="pictures/profile-icon.png" alt="Profile Icon" class="profile-icon">Profile</a>       
        <?php endif; ?>
    </div>
</body>
</html>
