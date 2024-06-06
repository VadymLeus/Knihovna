<?php
session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit;
}

require_once "../controllers/AddBookController.php";
$addBookController = new AddBookController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $quantity = $_POST['quantity'];
    $genre = $_POST['genre'];
    $imagePath = '';

    if ($_FILES['image']['size'] > 0) {
        $targetDirectory = "../public/images/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDirectory . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = "public/images/" . $imageName;
        } else {
            echo "Error uploading image.";
        }
    }

    if ($addBookController->addNewBook($title, $author, $price, $discount, $quantity, $genre, $imagePath)) {
        header("Location: ../public/index.php");
    } else {
        echo "Error adding book.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <link rel="stylesheet" href="../public/css/AddEditstyle.css">
</head>
<body>
    <h1>Add New Book</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author"><br>
        <label for="price">Price:</label><br>
        <input type="number" step="0.01" id="price" name="price"><br>
        <label for="discount">Discount:</label><br>
        <input type="number" step="0.01" id="discount" name="discount"><br>
        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity"><br>
        <label for="genre">Genre:</label><br>
        <input type="text" id="genre" name="genre"><br>
        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image"><br>
        <button type="submit">Add Book</button> <a href="/public" class="button">Back to Main Page</a>
    </form>
</body>
</html>
