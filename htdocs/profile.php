<?php
session_start();
include 'C:/MAMP/htdocs/database/db_connect.php'; // Make sure this path is correct
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
// Check the database connection

// Fetch the profile ID from the URL

if ($conn->connect_error) {
    die("Connection to profiledata database failed: " . $conn->connect_error);
}

$userId = isset($_GET['id']) ? intval($_GET['id']) : (isset($_SESSION['id']) ? $_SESSION['id'] : 0);
$isCurrentUser = ($userId == $_SESSION['id']);

$emojiList = [
    '😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😜', '😝',
    '😎', '🤓', '🤩', '🥳', '😋', '😛', '😶', '🤐', '😷', '🤧',
    '😇', '🤠', '🥺', '😔', '😕', '🙃', '🤑', '😲', '😳', '😵',
    '😯', '😦', '😧', '😮', '😫', '😩', '😢', '😭', '😤', '😠',
    '😡', '🤬', '😶‍🌫️', '😱', '😨', '😰', '😥', '😓', '🤯', '🥵',
    '🥶', '😬', '😏', '😑', '😒', '🙄', '😬', '🤥', '🤫', '🤭',
    '😚', '😙', '😗', '😘', '😻', '😍', '🥰', '❤️', '💛', '💚',
    '💙', '💜', '🖤', '🤍', '🤎', '💔', '💕', '💞', '💘', '💝',
    '💌', '💋', '👋', '🤚', '✋', '🖐', '✌️', '🤞', '🤟', '🤘',
    '🤙', '👎', '👍', '👏', '🙌', '🤲', '🤝', '🙏', '💪', '🦵',
    '🦶', '🦴', '🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼',
    '🐨', '🐯', '🦁', '🐮', '🐷', '🐸', '🦋', '🐦', '🐧', '🐣',
    '🐥', '🦉', '🦄', '🐗', '🐴', '🐝', '🐞', '🦗', '🦠', '🐞',
    '🐍', '🦓', '🐘', '🦛', '🦒', '🐪', '🐫', '🦚', '🦢', '🦜',
    '🐾', '🐇', '🦔', '🦷', '🐌', '🐞', '🐋', '🐙', '🐚', '🐊',
    '🐢', '🐍', '🐋', '🦈', '🐬', '🐳', '🦕', '🐟', '🐠', '🦑',
    '🦞', '🦀', '🐚', '🦠', '🐡', '🦗', '🐜', '🦦', '🦧', '🐅',
    '🐘', '🦛', '🦄', '🐓', '🐔', '🐥', '🐣', '🐦', '🦋', '🐜',
    '🐝', '🐞', '🐸', '🐀', '🦇', '🦝', '🦦', '🦧', '🦢', '🦦',
    '🐓', '🐇', '🐰', '🐾', '🐊', '🐆', '🦋', '🐜', '🐦', '🦣',
    '🍏', '🍎', '🍐', '🍊', '🍋', '🍌', '🍉', '🍇', '🍓', '🍈',
    '🍒', '🍑', '🍍', '🥥', '🥝', '🍅', '🍆', '🥒', '🌶', '🥬',
    '🥔', '🥕', '🌽', '🥒', '🍠', '🥝', '🍯', '🍪', '🍫', '🍬',
    '🍭', '🍩', '🍿', '🍷', '🍸', '🍺', '🍻', '🥂', '🍹', '🍾',
    '🥃', '🥧', '🍽', '🍴', '🥄', '🥢', '🥡', '🥗', '🍳', '🥘',
    '🍲', '🥣', '🥯', '🥪', '🌮', '🌯', '🍜', '🍝', '🍛', '🍲',
    '🥟', '🍙', '🍚', '🍘', '🍱', '🍣', '🍤', '🥩', '🥓', '🍗',
    '🍖', '🍟', '🍕', '🌭', '🍔', '🥪', '🍞', '🥐', '🥖', '🍜',
    '🍦', '🍧', '🍨', '🍩', '🍪', '🍮', '🎂', '🍰', '🍫', '🍬',
    '🍯', '🍪', '🍴', '🥄', '🍽', '🧁', '🥧', '🍣', '🍤', '🍚',
    '🍜', '🍙', '🍚', '🥗', '🥡', '🥢', '🥘', '🍖', '🍗', '🥩',
    '🥓', '🍕', '🍔', '🍟', '🍤', '🌮', '🌯', '🍜', '🍣', '🍗',
    '🍩', '🥞', '🦩', '🎮', '🕹', '🎯', '🧩', '🎲', '♟', '♠️',
    '♣️', '♦️', '♥️', '🎴', '🃏', '🀄', '🃏', '🎳', '⛷', '🏂',
    '🏃', '🚴', '🏋️', '🤸‍♂️', '🏌️', '🤾', '🏄', '🏇', '⛹️',
    '🏆', '🏅', '🥇', '🥈', '🥉', '⚽', '🏀', '🏈', '⚾', '🎾',
    '🏐', '🏉', '🏑', '🏒', '🥍', '⛳', '⛷', '🏂', '⛸', '🎯',
    '🏹', '🎣', '🎽', '🏏', '🏹', '⛳', '🎳', '🚴', '🏄', '🏇',
    '🛹', '🚣', '🏊', '🤾', '⛷', '🏂', '🛶', '⛹️', '🎲', '🎰',
    '🎯', '🎮', '🎹', '🎷', '🎺', '🎸', '🎻', '🥁', '🎤', '🎼',
    '🎧', '🎵', '🎶', '🎙', '🎚', '🎛', '🎤', '📻', '🎷', '🎼',
    '🎺', '🎸', '🎹', '🎶', '🎵', '🎼', '🎶', '🎼'
];

// Function to get two random emojis
function getRandomEmojis($emojiList) {
    $emoji1 = $emojiList[array_rand($emojiList)];
    $emoji2 = $emojiList[array_rand($emojiList)];
    return $emoji1 . ',' . $emoji2; // Save as a comma-separated string
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
    $userId = $_SESSION['id'];
    $sat = $_POST['sat'];
    $act = $_POST['act'];
    $ielts = $_POST['ielts'];

    // Insert or update the record
    $stmt = $conn->prepare("
        INSERT INTO profiledata (id, name, surname, gender, description, sat, ielts, act, emojis)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            surname = VALUES(surname),
            gender = VALUES(gender),
            description = VALUES(description),
            sat = VALUES(sat),
            ielts = VALUES(ielts),
            act = VALUES(act)

    ");  
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    $stmt->bind_param("issssssss", $userId, $name, $surname, $gender, $description, $sat, $ielts, $act, $emojis);

    
    if ($stmt->execute()) {     //fucking upload new info
        if ($stmt->affected_rows > 0) {
            $message = "Profile updated successfully!";
            $toastClass = "alert-success";
            // Update session data
            $_SESSION['name'] = $name;
            $_SESSION['surname'] = $surname;
            $_SESSION['gender'] = $gender;
            $_SESSION['description'] = trim($description);
            $_SESSION['sat'] = $sat;
            $_SESSION['ielts'] = $ielts;
            $_SESSION['act'] = $act;
            $_SESSION['emojis'] = $emojis;

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
$userId = isset($_GET['id']) ? intval($_GET['id']) : (isset($_SESSION['id']) ? $_SESSION['id'] : 0);

if ($userId > 0) {
    $stmt = $conn->prepare("SELECT name, surname, gender, description, sat, ielts, act, emojis FROM profiledata WHERE id = ?");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($name, $surname, $gender, $description, $sat, $ielts, $act, $emojis);
    if ($stmt->fetch()) {
        // Profile data loaded successfully
    } else {
        // Handle case where the user ID is invalid or not found
        $name = $surname = $gender = $description = $sat = $ielts = $act = $emojis = "N/A";
        $message = "User not found.";
        $toastClass = "alert-danger";
    }
    $stmt->close();


    if (empty($emojis)) {
        $emojis = getRandomEmojis($emojiList);

        // Update the database with the assigned emojis
        $stmt = $conn->prepare("UPDATE profiledata SET emojis = ? WHERE id = ?");
        if (!$stmt) {
            die("Preparation failed: " . $conn->error);
        }
        $stmt->bind_param("si", $emojis, $userId);
        if ($stmt->execute()) {
            $_SESSION['emojis'] = $emojis; // Update session data
        }
        $stmt->close();
    }

}?>



<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css" />
    <link rel="icon" type="image/png" href="/favicon-48x48.png" sizes="48x48" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="header">
    <h1><img src="Pictures/Projectly.png" alt="projectly icon" style="width:35px; margin-bottom:5px;">Projectly</h1>
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
                <?= htmlspecialchars($name); ?>'s Details:
                </th>
            </h1>
            <tr>
<th colspan="2"style="text-align: center;"><h1>Emoji:<?= isset($emojis) ? implode(' ', explode(',', $emojis)) : ''; ?></h1></th>
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
                    <input type="text" name="surname" id="surname" class="form-control" value="<?= isset($surname) ? htmlspecialchars($surname) : ''; ?>" required>
                </td>
            </tr>
            <tr>
                
                <th>General Description</th>
                <td>
                    <textarea name="description" id="description" class="form-control" required><?= isset($description)?htmlspecialchars(trim($description)):'';?></textarea>
                </td>
            </tr>
            <tr>
                <th>Test scores</th>
                <td align="center">
                SAT:<input type="text" style="width:12%" name="sat" maxlength="4" id="sat" pattern="\d{1,4}" class="form-control" value="<?= isset($sat) ? htmlspecialchars($sat) : ''; ?>" required />


                IELTS:<input type="text" style="width:12%" name="ielts" id="ielts" maxlength="3" pattern="\d{1,2}(\.\d)?" class="form-control" value="<?= isset($ielts) ? htmlspecialchars($ielts) : ''; ?>" required />

                ACT:<input type="text"  style="width:12%" name="act" maxlength="4"  id="act" pattern="\d{1,2}" class="form-control" value="<?= isset($act) ? htmlspecialchars($act) : ''; ?>"required/>
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
                <label class="btn btn-secondary "  >Back</label>
            </a>
            <?php if (!$isCurrentUser): ?>

            <a href="chat.php?user_id=<?= $userId; ?>" class="btn btn-primary" style="margin-left:380px;">+Chat</a>
            <?php endif; ?>
        



        </div>
    </form>
    </div>
    <div class="footer-nav" >
        <a href="index.php"><img src="pictures/home-icon.png" alt="Home Icon" class="home-icon" style="margin-bottom:10px;">Home</a>
    </div>
</div>
</body>
</html>
