<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Diary Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>My Diary Platform</h1>
    <nav>
        <a href="index.php" class="button">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="button">Logout</a>
            <a href="write_diary.php" class="button">Write Diary</a>
        <?php else: ?>
            <a href="login.php" class="button">Login</a>
            <a href="register.php" class="button">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>
