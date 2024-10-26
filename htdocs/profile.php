<?php
session_start();
include 'C:/MAMP/htdocs/database/db_connect.php'; // Ensure this points to your database connection file
error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = "";
$toastClass = "";

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 

    // Check if username exists and password matches
    $stmt = $conn->prepare("SELECT name, surname, gender, description FROM profiledata WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $_SESSION['id'] = $user_id; // Store user ID in session
    $_SESSION['username'] = $username; // Change email to username
    $_SESSION['name'] = $name; // Store user's name in session
    $_SESSION['surname'] = $surname; // Store user's surname in session


}

// Fetch user details for the profile edit (if user is logged in)
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare("SELECT name, surname, gender, description FROM profiledata WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($row['name'], $row['surname'], $row['gender'], $row['description']);
    $stmt->fetch();
    $stmt->close();
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
        .profile-pic-cell {
            text-align: center; /* Center horizontally */
            vertical-align: middle; /* Center vertically */
            height: 150px; /* Adjust the height if necessary */
        }
        .form-label {
            font-size: 18px; /* Adjust size for labels */
        }

        .form-control {
            font-size: 18px; /* Adjust size for input fields */
        }

        .table th {
            font-size: 18px; /* Adjust size for table headers */
        }

        .table td {
            font-size: 18px; /* Adjust size for table data cells */
        }
        .form-control {
            height: 50px; /* Adjust this value to change the height of other input fields */
        }
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

        <form method="post">
            <table class="table table-striped" style="width:1000px; height:600px;">
                <h1><th colspan="2" style="font-size: 50px; text-align: center;">User Details:</th></h1> 
                <tr>
                    <th class="profile-pic-cell">
                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                    </th>
                </tr>
                <tr>
                    <th><i class="bi bi-person-circle"></i> First name</th>
                    <td>
                        <input value="<?= isset($row['name']) ? $row['name'] : '' ?>" type="text" class="form-control" name="name" placeholder="Name">
                        <div><small class="js-error js-error-firstname text-danger"></small></div>
                    </td>
                </tr>
                <tr>
                    <th><i class="bi bi-person-square"></i> Last name</th>
                    <td>
                        <input value="<?= isset($row['surname']) ? $row['surname'] : '' ?>" type="text" class="form-control" name="surname" placeholder="Surname">
                        <div><small class="js-error js-error-lastname text-danger"></small></div>
                    </td>
                </tr>
                <tr>
                    <th><i class="bi bi-person-square"></i> General description</th>
                    <td>
                        <textarea name="description" class="form-control" placeholder="Description" style="height: 300px;"><?= isset($row['description']) ? $row['description'] : '' ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><i class="bi bi-gender-ambiguous"></i> Gender</th>
                    <td>
                        <select name="gender" class="form-select form-select mb-3" aria-label=".form-select-lg example">
                            <option value="">--Select Gender--</option>
                            <option selected value="<?= isset($row['gender']) ? $row['gender'] : '' ?>"><?= isset($row['gender']) ? $row['gender'] : '' ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <div><small class="js-error js-error-gender text-danger"></small></div>
                    </td>
                </tr>
            </table>

            <div class="progress my-3 d-none">
                <div class="progress-bar" role="progressbar" style="width: 50%;">Working... 25%</div>
            </div>

            <div class="p-2">
                <button class="btn btn-primary float-end">Save</button>
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
