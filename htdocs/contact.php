<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .center-text {
            text-align: center;
        }
    </style>        
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Contact Us</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>

    <section>
        <h2 class="center-text">Get in Touch</h2>

        <form action="contact.php" method="POST" class="center-text">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="message">Message:</label><br>
            <textarea id="message" name="message" required></textarea><br><br>

            <input type="submit" value="Send Message">
        </form>
    </section>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and process form data
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        echo "<section>";
        echo "<h2>Thank you for your message, $name!</h2>";
        echo "<p>We will get back to you at $email soon.</p>";
        echo "<p>Your message: $message</p>";
        echo "</section>";
    }
    ?>

    <footer>
        <p>&copy; 2024 My PHP Website</p>
    </footer>
</body>
</html>
