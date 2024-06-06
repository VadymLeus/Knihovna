<?php
session_start();

require_once "../core/database.php";
require_once "../controllers/BuyBookController.php";

if (!isset($_SESSION['nickname']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$buyBookController = new BuyBookController($db);
$cartItems = $buyBookController->getCartItems($_SESSION['user_id']);

$totalPrice = 0;
foreach ($cartItems as $item) {
    $discountPrice = $item['price'] * (100 - $item['discount']) / 100;
    $totalPrice += $discountPrice * $item['quantity'];
}

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['remove_item_id'])) {
        $removeItemId = $_POST['remove_item_id'];
        $buyBookController->removeCartItem($_SESSION['user_id'], $removeItemId);
        header("Location: ../views/buy_book.php");
        exit;
    }
    
    if (isset($_POST['update_item_id'])) {
        $updateItemId = $_POST['update_item_id'];
        $newQuantity = $_POST['quantity'][$updateItemId];
        if (!$buyBookController->updateCartItemQuantity($_SESSION['user_id'], $updateItemId, $newQuantity)) {
            $errorMessage = 'The quantity exceeds the available stock.';
        } else {
            header("Location: ../views/buy_book.php");
            exit;
        }
    }
    
    if (isset($_POST['confirm_order'])) {
        $result = $buyBookController->confirmOrder($_SESSION['user_id']);
        if ($result) {
            header("Location: ../views/success/order_success.php");
            exit;
        } else {
            header("Location: ../index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="../public/css/Cart.css">
</head>
<body>
<div class="container">
    <h1>Cart - Total Price: <?php echo number_format($totalPrice, 2); ?>&dollar;</h1>
    <?php if (!empty($cartItems)): ?>
        <form action="" method="POST">
            <button name="confirm_order" class="confirm-button">Confirm Order</button>
        </form>
    <?php endif; ?>
    <a href="/public" class="button">Back to Main Page</a>

    <div class="cart-items">
        <?php foreach ($cartItems as $item): ?>
            <div class="cart-item">
                <img src="../<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                <div class="item-details">
                    <h2><?php echo $item['title']; ?></h2>
                    <p><strong>Author:</strong> <?php echo $item['author']; ?></p>
                    <?php
                    $discountPrice = $item['price'] * (100 - $item['discount']) / 100;
                    $priceInfo = ($item['discount'] != 0) ? "&dollar;<del>" . number_format($item['price'], 2) . "</del> &rarr; " . number_format($discountPrice, 2) . " (" . number_format($item['discount'], 2) . "% off)" : "&dollar;" . number_format($item['price'], 2);
                    echo "<p><strong>Price:</strong> " . $priceInfo . "</p>";
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="update_item_id" value="<?php echo $item['id']; ?>">
                        <label for="quantity_<?php echo $item['id']; ?>">Quantity:</label>
                        <input type="number" id="quantity_<?php echo $item['id']; ?>" name="quantity[<?php echo $item['id']; ?>]" min="1" value="<?php echo $item['quantity']; ?>">
                        <button type="submit" class="update-button">Update</button>
                        <button class="remove-button" name="remove_item_id" value="<?php echo $item['id']; ?>">Remove</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <img src="../public/images/EmptyCart.png" alt="Empty Cart">
        </div>
    <?php endif; ?>
</div>
</body>
</html>
