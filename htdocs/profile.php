<?php
session_start();
include 'C:/MAMP/htdocs/database/db_connect.php'; // Make sure this path is correct
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check the database connection
if ($conn->connect_error) {
    die("Connection to profiledata database failed: " . $conn->connect_error);
}

// Initialize message variables
$message = "";
$toastClass = "";

// Insert profile if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $gender = $_POST['gender'];
    $description = trim($_POST['description']);
    $userId = $_SESSION['id']; // Assuming `id` is stored in the session

    // Insert or update the record
    $stmt = $conn->prepare("
        INSERT INTO profiledata (id, name, surname, gender, description)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            surname = VALUES(surname),
            gender = VALUES(gender),
            description = VALUES(description)
    ");
    
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    $stmt->bind_param("issss", $userId, $name, $surname, $gender, $description);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $message = "Profile updated successfully!";
            $toastClass = "alert-success";
            // Update session data
            $_SESSION['name'] = $name;
            $_SESSION['surname'] = $surname;
            $_SESSION['gender'] = $gender;
            $_SESSION['description'] = trim($description_from_db);
        } else {
            $message = "No changes made to the profile.";
            $toastClass = "alert-warning";
        }
    } else {
        $message = "Failed to update profile. Error: " . $stmt->error;
        $toastClass = "alert-danger";
    }
    $stmt->close();
}

// Fetch user profile data if session ID exists
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT name, surname, gender, description FROM profiledata WHERE id = ?");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($name, $surname, $gender, $description);
    $stmt->fetch();
    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .history {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .fuck {
            text-decoration: none;
            color: white;
        }

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
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            padding-bottom: 50px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            padding-bottom: 100px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
        }

        .header h1 {
            font-size: 24px;
            margin-left: 100px;
        }

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
    <link rel="icon" type="image/png" href="/favicon-48x48.png" sizes="48x48" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="header">
    <h1>Projectly</h1>
</div>
<div class="container p-5 d-flex flex-column align-items-center">
    <?php if ($message): ?>
        <div class="alert text-white <?php echo $toastClass; ?> w-100 text-center" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <table class="table table-striped" style="width:1000px; height:600px; text-align: center;">
            <h1>
                <th colspan="2" style="font-size: 50px; text-align: center;">
                    <?= htmlspecialchars($_SESSION['username']); ?>'s Details:
                </th>
            </h1>
            <tr>
                <th class="profile-pic-cell">
                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                </th>
                <td>
                    <button style="position: relative; top: 50%; transform: translateY(-50%) translateX(-113%);">
                        Upload profile picture
                    </button>
                </td>
            </tr>
            <tr>
                <th>First Name</th>
                <td>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="<?= isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                </td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>
                    <input type="text" name="surname" id="surname" class="form-control" 
                           value="<?= isset($surname) ? htmlspecialchars($surname) : ''; ?>" required>
                </td>
            </tr>
            <tr>
                
                <th>General Description</th>
                <td>
                    <textarea name="description" id="description" class="form-control" required>
                        <?= isset($description)?htmlspecialchars($description):'';?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>
                    <select name="gender" class="form-select form-select mb-3" aria-label=".form-select-lg example" required>
                        <option value="">--Select Gender--</option>
                        <option value="Male" <?= isset($gender) && $gender === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?= isset($gender) && $gender === 'Female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                </td>
            </tr>
        </table>

        <div class="p-2">
            <button type="submit" name="update_profile" class="btn btn-primary float-end">Save</button>
            <a href="index.php">
                <label class="btn btn-secondary">Back</label>
            </a>
        </div>
    </form>

    <div class="footer-nav">
        <a href="index.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon" style="margin-bottom:10px;">Home</a>
    </div>
</div>
</body>
</html>
