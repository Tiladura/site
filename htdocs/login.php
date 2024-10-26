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
    <style>
        .history {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .fuck{
            text-decoration: none;
            color: white;
        }

        /* Scale and align the icon */
        .history-icon {
            max-width: 20px;
            max-height: 20px;
            margin-right: 5px;
            width: auto;
            height: auto;
            position: relative;
            top: 3px;
            text-decoration: none;
        }

        .profile, .create, .home {
            display: flex;
            align-items: center;
        }
        
        .profile-icon, .create-icon, .home-icon {
            max-width: 20px;
            max-height: 20px;
            margin-right: 5px;
            width: auto;
            height: auto;
            position: relative;
            top: 3px;
            margin-top: -10px;
        }

        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            padding-bottom: 50px;
        }

        /* Container */
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            bottom-padding: 100px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            
        }

        .header h1 {
            font-size: 24px;
            text-decoration: none;
            margin-left: 100px;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            align-items: center;
            margin-top: 20px;
            justify-content: flex-end; /* Aligns the search bar to the right */
            margin-left: -100px; /* Adjust this value to move the search bar left */
        }
        .search-bar input {
            width: 80%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-left: 20px;
            margin-top: -20px;
        }

        .search-bar button {
            padding: 10px 20px;
            margin-left: 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            margin-top: -20px;
            margin-left: 20px;

        }

        /* Category Sections */
        .categories {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }
        .categories2{
            display: flex;
            justify-content: space-around;
            margin-top: 6px;
        }

        .category-button {
            width: 44%;
            padding: 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none; /* Remove underline from links */
        }

        .category-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .category-button h3, .category-button p {
            margin: 0; /* Remove default margins */
        }

        /* Recommendations Section */
        .recommendations {
            margin-top: 30px;
        }

        .recommendations h2 {
            margin-bottom: 10px;
        }

        .recommendation-block {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .recommendation-block img {
            width: 100px;
            height: 100px;
            margin-right: 15px;
            border-radius: 5px;
        }

        .recommendation-block p {
            margin: 0;
            font-size: 16px;
        }

        /* Footer Navigation */
        .footer-nav {
            display: flex;
            justify-content: space-around;
            padding: 15px;
            background-color: #007bff;
            position: fixed;
            bottom: 0;
            width: 100%;
            color: white;
        }

        .footer-nav a {
            color: white;
            text-decoration: none;
        }
    </style>
    <div class="header">
        <h1>Projectly</h1>

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
        <a href="index.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon" >Home</a>
    </div>
    </div>
</body>
</html>
