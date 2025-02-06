<?php
session_start();
//echo '<pre>';
//print_r($_SESSION); 
//echo '</pre>';
include 'C:/MAMP/htdocs/database/db_connect.php'; // Make sure this path is correct
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check the database connection
// Check the database connection
if ($conn->connect_error) {
    die("Connection to profiledata database failed: " . $conn->connect_error);
}
$loggedInUserId = $_SESSION['id'];
$stmt = $conn->prepare("
    SELECT DISTINCT 
        profiledata.id, profiledata.name, profiledata.surname, profiledata.emojis 
    FROM profiledata
    INNER JOIN messages 
        ON (messages.sender_id = profiledata.id AND messages.receiver_id = ?) 
        OR (messages.receiver_id = profiledata.id AND messages.sender_id = ?)
    WHERE profiledata.id != ?
");
$stmt->bind_param("iii", $loggedInUserId, $loggedInUserId, $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data from the `profiledata` table


if (!$result) {
    die("Error retrieving data: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a partner</title>

    
</head>
<body >
<div class="header" >
    <h1><img src="Pictures/Projectly.png" alt="projectly icon" style="width:35px; margin-bottom:-10px;">Projectly</h1>
</div>
<div class="categories" style="display: flex; gap: 20px; justify-content: center; align-items: center;">
<div class="gradient-border-table"> 

<table class="table table-striped" style="width:1000px; height:600px; text-align: center;">
<tr>
    <th colspan="3" style="height:30%; font-size:40px;">Your chats</th>
</tr>
<?php
// Display the data in rows
$counter = 0;
echo '<tr>'; // Start the first row

while ($row = $result->fetch_assoc()) {
    echo '<td>';
    echo '<a href="chat.php?user_id=' . $row['id'] . '" style="width: 100%;">';
    echo '<button type="submit" style="width: 100%;">';

    echo '<div class="emoji-container" style="font-size:40px;">';
    echo htmlspecialchars($row['emojis']); // Display emojis
    echo '</div>';
    echo '<div>';
    echo '<strong>Chat with</strong>';
    echo ' ' . htmlspecialchars($row['name']) . '<br>';
    echo ' ' . htmlspecialchars($row['surname']) . '<br>';
    echo '<div class="clearfix"></div>';
    echo '</div>';
    echo '</td>';
    $counter++;

    // After every three cells, close the row and start a new one
    if ($counter % 1 == 0) { // Adjust to 3 for three "boxes" per row
        echo '</tr><tr>';
    }
}

if ($counter > 0 && $counter % 1 != 0) {
    echo '</tr>'; // Close the last row if it's incomplete
}

$stmt->close();
?>

</table>
</div>



</div>



<div class="footer-nav" >
    <a href="index.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon">Home</a>

    <?php if (isset($_SESSION['username'])): ?>
        <a href="profile.php"><img src="pictures/profile-icon.png" alt="Profile Icon" class="profile-icon">Profile(<?php echo htmlspecialchars($_SESSION['username']); ?>)</a> 
    <?php else: ?>
        <a href="login.php"><img src="pictures/profile-icon.png" alt="Profile Icon" class="profile-icon">Profile</a>       
    <?php endif; ?>
</div>
</body>
</html>