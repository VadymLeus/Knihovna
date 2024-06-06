<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" type="text/css" href="/public/css/historyStyle.css">
</head>
<body>
<div class="header">
    <a href="/public" class="button">Back to Main Page</a>
    <?php
    session_start();
    if (!isset($_SESSION['nickname']) || ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'admin')) {
        header("Location: ../index.php");
        exit;
    }

    require_once "../core/database.php";
    require_once "../controllers/HistoryController.php";
    
    $historyController = new HistoryController($db);
    
    if ($_SESSION['role'] === 'user') {
        $userId = $_SESSION['user_id'];
        if (isset($_POST['search_book'])) {
            $searchBook = $_POST['search_book'];
            $orders = $historyController->getUserOrdersWithSearch($userId, $searchBook);
        } else {
            $orders = $historyController->getUserOrders($userId);
        }
    } elseif ($_SESSION['role'] === 'admin') {
        $allOrders = $historyController->getAllOrdersWithUserEmails();
    }
    ?>

    <?php if ($_SESSION['role'] === 'user'): ?>
        <form method="POST" class="search-form">
            <input type="text" name="search_book" placeholder="Search by book name">
            <button type="submit">Search</button>
        </form>
    <?php endif; ?>
</div>

<?php if ($_SESSION['role'] === 'user' && isset($orders)): ?>
    <h3>Your Orders</h3>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Book Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['book_title']; ?></td>
                    <td><?php echo $order['price']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if ($_SESSION['role'] === 'admin' && isset($allOrders)): ?>
    <h3>All Orders</h3>
    <?php if (isset($_POST['search_email'])): ?>
        <?php
        $email = $_POST['search_email'];
        $userOrders = $historyController->getUserOrdersByEmail($email);
        ?>
        <h4>Orders for <?php echo $email; ?></h4>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Book Title</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userOrders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['book_title']; ?></td>
                        <td><?php echo $order['price']; ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <form method="POST" class="search-form">
            <input type="text" name="search_email" placeholder="Search by user email">
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Email</th>
                    <th>Book Title</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allOrders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['user_email']; ?></td>
                        <td><?php echo $order['book_title']; ?></td>
                        <td><?php echo $order['price']; ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td><?php echo $order['order_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>
