<?php
session_start();
echo '<pre>';
print_r($_SESSION); 
echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/png" href="/favicon-48x48.png" sizes="48x48" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />

    <title>Projectly</title>
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
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Projectly</h1>
        <div>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php" style = "color: white; text-decoration: none; margin-right: 20px;" >Logout</a> 
        <?php else: ?>
            <a href="login.php" class = "fuck">
                Login
            </a>
            <a href="#" class = "fuck">
                /
            </a>
            <a href="register.php" class = "fuck">
                Register
            </a>      
        <?php endif; ?>

        </div>
    </div>
    

    <!--  Search Bar 
    <div class="container">
        <div class="search-bar">
            <input type="text" placeholder="Search..." name="search">
            <button type="submit">Search</button>
        </div>
    -->
        <!-- Categories Section -->
        <div class="categories" style="display: flex; gap: 20px; justify-content: center; align-items: center;">
    <a href="#" class="category-button" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 30vh;">
        <div>
            <h3>Find a partner</h3>
            <p>Find a partner for your future projects.</p>
        </div>
    </a>
    <a href="#" class="category-button" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 30vh;">
        <div>
            <h3>Browse project ideas</h3>
            <p>Browse project ideas for inspiration</p>
        </div>
    </a>
</div>



        <!-- Recommendations Section -->
        <div class="recommendations">
            <h2 style="text-align:center;">Partner recommendations</h2>
            <div style="width: 80%; margin: auto;">
            <!-- Recommendation Block 1 -->
            <div class="recommendation-block">
                <img src="https://via.placeholder.com/100" alt="Recommendation 1">
                <p>Recommended service or product 1 with a short description.</p>
            </div>

            <!-- Recommendation Block 2 -->
            <div class="recommendation-block">
                <img src="https://via.placeholder.com/100" alt="Recommendation 2">
                <p>Recommended service or product 2 with a short description.</p>
            </div>

            <!-- Recommendation Block 3 -->
            <div class="recommendation-block">
                <img src="https://via.placeholder.com/100" alt="Recommendation 3">
                <p>Recommended service or product 3 with a short description.</p>
            </div>

            <!-- Recommendation Block 4 -->
            <div class="recommendation-block">
                <img src="https://via.placeholder.com/100" alt="Recommendation 4">
                <p>Recommended service or product 4 with a short description.</p>
            </div>
        </div>
        </div>
    </div>

    <!-- Footer Navigation -->
    <div class="footer-nav">
        <a href="index.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon">Home</a>
        <a href="#"><img src="pictures/penis.png" alt="Create Icon" class="create-icon">Create project offer</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="profile.php"><img src="pictures/profile-icon.png" alt="Profile Icon" class="profile-icon">Profile(<?php echo htmlspecialchars($_SESSION['username']); ?>)</a> 
        <?php else: ?>
            <a href="login.php"><img src="pictures/profile-icon.png" alt="Profile Icon" class="profile-icon">Profile</a>       
        <?php endif; ?>
    </div>

</body>
</html>

<!--

CREATE DATABASE users;

-- Switch to the created database
USE users;

-- Create the userdata table with id, username, and password
CREATE TABLE userdata (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- id is the primary key with auto increment
    username VARCHAR(50) NOT NULL,      -- username, should be unique for each user
    password VARCHAR(255) NOT NULL      -- password for the user
);

-- Create the profiledata table with name, surname, description, and gender
CREATE TABLE profiledata (
    id INT,                            -- id is a foreign key that references userdata
    name VARCHAR(50) NOT NULL,          -- name of the user
    surname VARCHAR(50) NOT NULL,       -- surname of the user
    description TEXT,                   -- description about the user
    gender VARCHAR(10),                 -- gender of the user
    PRIMARY KEY (id),                   -- primary key for the profiledata table
    FOREIGN KEY (id) REFERENCES userdata(id)  -- Foreign key relationship with userdata table
);
!-->

