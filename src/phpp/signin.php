<?php 
require './config/database.php';
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
unset($_SESSION['signin-data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Sign in Page</title>
</head>
<body>

<section class="form-section">
    <div class="container form-section-container">
        <h2>Sign In</h2>
        
        <?php if(isset($_SESSION['signup-success'])) : ?>
        <div class="alert-message success"><p><?= $_SESSION['signup-success']; unset($_SESSION['signup-success']); ?></p></div>
        <?php elseif(isset($_SESSION['signin-error'])) : ?>
        <div class="alert-message error"><p><?= $_SESSION['signin-error']; unset($_SESSION['signin-error']); ?> </p></div>
        <?php endif  ?>  
        <form action="signin-logic.php" method="post">
            <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email">
            <input type="password" name="password" value=""  placeholder="Enter Password">
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
        </form>
    </div>
</section>

</body>

</html>