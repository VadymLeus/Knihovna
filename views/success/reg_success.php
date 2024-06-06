<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="../public/css/regstyle.css">
</head>
<body>
<div class="container">
    <h2>Registration Successful</h2>
    <?php
    if (isset($_GET['nickname'])) {
        $nickname = $_GET['nickname'];
        echo "<p>Welcome, $nickname!</p>";
    }
    ?>
    <p>Your registration was successful. You can now login.</p>
    <a href="/public" class="button">Back to Main Page</a>
</div>
</body>
</html>
