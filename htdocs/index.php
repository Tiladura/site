<?php
session_start();
//echo '<pre>';
//print_r($_SESSION); 
//echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="styles.css" />
<link rel="icon" type="image/png" href="/favicon-48x48.png" sizes="48x48" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />

    <title>Projectly</title>

</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1><img src="Pictures/Projectly.png" alt="projectly icon" style="width:35px; margin-bottom:5px;" align="center">Projectly</h1>
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
    <a   style="width: 70%; display: flex; flex-direction: column; justify-content: center; align-items: center; height: 30vh; ">
        <div>
            <h1 style="text-align:center;">    Our site gives</h1>
            <ul>
                <li> Opportunities to find new friends</li>
                <li> Interesting projects suitable for you</li>
                <li> Coopearative skills</li>
            </ul>
        </div>
        <a href="partners.php" class="category-button" >
    <div>
            <h3>Find a partner</h3>
            <p>Find a partner for your future projects.</p>
        </div>
    </a>

</div>

            <div align="center">
                <h1>Example of project</h1>
                <video width="1000" height="600" controls>
                    <source src="videoplayback.mp4" type="video/mp4">
                </video>
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
    <div class="footer-nav" >
    <?php if (isset($_SESSION['username'])): ?>
        <a href="notifications.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon">Chats</a>     
        <?php else: ?>
            <a href="login.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon">Chats</a>       
        <?php endif; ?>


        <?php if (isset($_SESSION['username'])): ?>
            <a href="profile.php"><img src="pictures/profile-icon.png" alt="Profile Icon" class="profile-icon">Profile(<?php echo htmlspecialchars($_SESSION['username']); ?>)</a> 
        <?php else: ?>
            <a href="login.php"><img src="pictures/profile-icon.png" alt="Profile Icon" class="profile-icon">Profile</a>       
        <?php endif; ?>
    </div>

</body>
</html>
