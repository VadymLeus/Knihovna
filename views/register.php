<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="/public/css/regstyle.css">
    <script src="/public/js/regValidation.js"></script>
</head>
<body>
<div class="container">
    <h2>Registration Form</h2>
    <a href="/public" class="button">Back to Main Page</a>
    <?php if (isset($data['errorMessage'])): ?>
        <p class="error-message"><?php echo $data['errorMessage']; ?></p>
    <?php endif; ?>
    <form action="/public/index.php?url=reg/register" method="POST" onsubmit="return validateRegistrationForm()">
        <label for="nickname">Nickname:</label>
        <input type="text" id="nickname" name="nickname" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <input type="submit" value="Register">
    </form>
</div>
</body>
</html>
