<?php
session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit;
}

require_once "../controllers/EditBookController.php";
$editBookController = new EditBookController();

$bookId = $_GET['id'] ?? null;
if (!$bookId) {
    header("Location: ../public/index.php");
    exit;
}

$book = $editBookController->getBookById($bookId);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        if ($editBookController->deleteBook($bookId)) {
            header("Location: ../public/index.php");
        } else {
            echo "Error deleting book.";
        }
    } else {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $price = $_POST['price'];
        $discount = $_POST['discount'];
        $quantity = $_POST['quantity'];
        $genre = $_POST['genre'];
        $imagePath = $book['image'];

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

        if ($editBookController->updateBook($bookId, $title, $author, $price, $discount, $quantity, $genre, $imagePath)) {
            header("Location: ../public/index.php");
        } else {
            echo "Error updating book.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="../public/css/AddEditstyle.css">
</head>
<body>
    <h1>Edit Book</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>"><br>
        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>"><br>
        <label for="price">Price:</label><br>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($book['price']); ?>"><br>
        <label for="discount">Discount:</label><br>
        <input type="number" step="0.01" id="discount" name="discount" value="<?php echo htmlspecialchars($book['discount']); ?>"><br>
        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($book['quantity']); ?>"><br>
        <label for="genre">Genre:</label><br>
        <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>"><br>
        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image"><br>
        
        <button type="submit" name="update">Update Book</button>
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this book?');">Delete Book</button>
        <a href="/public" class="button">Back to Main Page</a>
    </form>
</body>
</html>
