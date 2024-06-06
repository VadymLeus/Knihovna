<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/authstyle.css">
    <script src="../public/js/authValidation.js"></script>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if(isset($data['errorMessage'])) echo "<p class='error-message'>{$data['errorMessage']}</p>"; ?>
    <a href="/public" class="button">Back to Main Page</a>
    <form action="/public/index.php?url=auth/authenticate" method="POST" onsubmit="return validateLoginForm()">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Login">
        <a href="/views/register.php" class="go-to-register">Go to Register</a>
    </form>
</div>
</body>
</html>
