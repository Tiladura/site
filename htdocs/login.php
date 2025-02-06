<?php
include 'C:/MAMP/htdocs/database/db_connect.php';

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // Changed from email to username
    $password = $_POST['password'];

    // Check if username exists and password matches
    $stmt = $conn->prepare("SELECT id, password FROM userdata WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_password);
        $stmt->fetch();

        if ($password === $db_password) {
            session_start();
            $_SESSION['id'] = $user_id; // Store user ID in session
            $_SESSION['username'] = $username; // Change email to username
            header("Location: index.php");
            exit();
        } else {
            $message = "Incorrect password";
            $toastClass = "bg-danger";
        }
    } else {
        $message = "Username not found"; // Change the message accordingly
        $toastClass = "bg-warning";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css" />
<link rel="icon" type="image/png" href="/favicon-48x48.png" sizes="48x48" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projectly login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<head>
    <div class="header">
        <h1><img src="Pictures/Projectly.png" alt="projectly icon" style="width:35px; margin-bottom:5px;">Projectly</h1>

    </div>
    
<body class="bg-light">
    <div class="container p-5 d-flex flex-column align-items-center">
        <?php if ($message): ?>
            <div class="alert text-white <?php echo $toastClass; ?> w-100 text-center" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" class="p-4 border rounded shadow-sm" style="width: 380px;">
            <h5 class="text-center mb-4">Login into your account</h5>
            <div class="mb-3">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="text-center mt-3">
                <a href="./register.php">Create account</a> 
            </div>
        </form>
    <div class="footer-nav">
        <a href="index.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon" style="margin-bottom:10px;">Home</a>
    </div>
    </div>
</body>
</html>
