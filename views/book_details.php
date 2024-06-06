<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link rel="stylesheet" href="/public/css/bookDetailsStyle.css">
</head>
<body>
<div class="book-details">
    <img src="../<?php echo $data['book']['image']; ?>" alt="<?php echo $data['book']['title']; ?>" class="book-cover" width="332" height="475">
    <div class="details">
        <h1><?php echo $data['book']['title']; ?></h1>
        <p><strong>Author:</strong> <?php echo $data['book']['author']; ?></p>
        <p><strong>Genre:</strong> <?php echo $data['book']['genre']; ?></p>
        <p><strong>Price:</strong> &dollar;<?php echo number_format($data['book']['price'], 2); ?></p>
        <p><strong>Quantity:</strong> <?php echo $data['book']['quantity']; ?></p>
        <a href="/public/index.php?url=main/index">Back to Main</a>
    </div>
</div>
</body>
</html>
