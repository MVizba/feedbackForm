<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="container" >
    <form action="feedbackForm.php" method="POST">
        <h2>Your opinion matters !</h2>
        <label>Name:</label>
        <input type="text" name="name" placeholder="Name"
               value="<?php echo isset($_COOKIE['name']) ? htmlspecialchars($_COOKIE['name']) : ''; ?>"required>
        <label>Email:</label>
        <input type="email" name="email" placeholder="Email"
               value="<?php echo isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : ''; ?>" required>
        <label>Your feedback:</label>
        <textarea name="message" placeholder="Message" required><?php echo isset($_COOKIE['message']) ? htmlspecialchars($_COOKIE['message']) : ''; ?></textarea>
        <div class="checkbox">
            <input type="checkbox" id="privacy" name="privacy" required>
            <label for="privacy">I agree to the <a href="https://letmegooglethat.com/?q=private+policy" target="_blank">Privacy Policy</a></label>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>