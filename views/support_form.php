<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Form</title>
    <link rel="stylesheet" href="../public/css/support_form.css">
</head>
<body>
<div class="container">
    <h2>Contact Support</h2>
    <a href="/public/" class="button">Go back to homepage</a>
    <form action="/public/index.php?url=support/submitForm" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        <button type="submit" class="button">Submit</button>
    </form>
</div>
</body>
</html>
