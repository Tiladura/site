<?php
session_start();
include 'C:/MAMP/htdocs/database/db_connect.php'; // Ensure this points to your database connection file
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    $userId = $_SESSION['id'];

    $stmt = $conn->prepare("UPDATE profiledata SET name = ?, surname = ?, gender = ?, description = ? WHERE id = ?");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    $stmt->bind_param("ssssi", $name, $surname, $gender, $description, $userId);

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
        $toastClass = "alert-success";
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['gender'] = $gender;
        $_SESSION['description'] = $description;
    } else {
        $message = "Failed to update profile. Error: " . $stmt->error;
        $toastClass = "alert-danger";
    }

    $stmt->close();
} else {
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
        $stmt = $conn->prepare("SELECT * FROM profiledata WHERE id = ?");
        if (!$stmt) {
            die("Preparation failed: " . $conn->error);
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $username, $surname, $description, $gender);
            $stmt->fetch();
            $_SESSION['username'] = $username;
            $_SESSION['surname'] = $surname;
            $_SESSION['description'] = $description;
            $_SESSION['gender'] = $gender;
        }
        $stmt->close();
    }
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
            width: 30%;
            padding: 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none; /* Remove underline from links */
            height: 100px;
            
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

    <form method="post">
        <table class="table table-striped" style="width:1000px; height:600px;">
            <h1><th colspan="2" style="font-size: 50px; text-align: center;"><?php echo htmlspecialchars($_SESSION['username']); ?>'s Details:</th></h1>
            <tr>
                <th class="profile-pic-cell">
                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                </th>
            </tr>
            <tr>
                <th>First Name</th>
                <td>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="<?= isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : ''; ?>" required>
                </td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>
                    <input type="text" name="surname" id="surname" class="form-control" 
                           value="<?= isset($_SESSION['surname']) ? htmlspecialchars($_SESSION['surname']) : ''; ?>" required>
                </td>
            </tr>
            <tr>
                <th>General Description</th>
                <td>
                    <textarea name="description" id="description" class="form-control" required><?= isset($_SESSION['description']) ? htmlspecialchars($_SESSION['description']) : ''; ?></textarea>
                </td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>
                    <select name="gender" class="form-select form-select mb-3" aria-label=".form-select-lg example" required>
                        <option value="">--Select Gender--</option>
                        <option value="Male" <?= (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?= (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
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
        <a href="index.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon">Home</a>
    </div>
</div>
</body>
</html>
