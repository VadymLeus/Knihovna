<?php
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: /public/");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="/public/css/mainStyle.css">
</head>
<body>
<div class="header">
    <div class="header-left">
        <form action="/public/index.php?url=main/index" method="GET">
            <input type="text" name="search" placeholder="Search by title or author" value="<?php echo htmlspecialchars($data['searchTerm']); ?>">
            <select name="filter">
                <option value="">All</option>
                <option value="Tragedy" <?php echo ($data['filter'] == 'Tragedy') ? 'selected' : ''; ?>>Tragedy</option>
                <option value="Roman" <?php echo ($data['filter'] == 'Roman') ? 'selected' : ''; ?>>Roman</option>
                <option value="Philosophy" <?php echo ($data['filter'] == 'Philosophy') ? 'selected' : ''; ?>>Philosophy</option>
                <option value="Novel" <?php echo ($data['filter'] == 'Novel') ? 'selected' : ''; ?>>Novel</option>
                <option value="Mysticism" <?php echo ($data['filter'] == 'Mysticism') ? 'selected' : ''; ?>>Mysticism</option>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="header-right">
        <?php if (isset($_SESSION['nickname'])): ?>
            <?php
            $welcomeMessage = ($_SESSION['role'] === 'admin') ? 'Welcome admin, ' : 'Welcome, ';
            ?>
            <form action="/views/profile.php" method="GET" style="display:inline;">
               <button class="welcome-button"><?php echo $welcomeMessage . $_SESSION['nickname']; ?></button>
            </form>
            <?php if ($_SESSION['role'] !== 'admin'): ?>
                <a href="/views/buy_book" class="button">Cart (<?php echo $data['cartBookCount']; ?>)</a>
            <?php endif; ?>
            <a href="/views/history" class="button">Purchase History</a>
            <a href="/public/?action=logout" class="button">Logout</a>
        <?php else: ?>
            <a href="/views/authentication" class="button">Login</a>
            <a href="/views/register" class="button">Register</a>
        <?php endif; ?>
    </div>
</div>
<div class="content">
    <?php foreach ($data['books'] as $book): ?>
        <div class="book">
            <img src="../<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>" class="book-cover" width="332" height="475"<?php if ($book['quantity'] <= 0) { echo " style='filter: grayscale(100%);'"; } ?>>
            <div class="book-details">
                <h2><?php echo $book['title']; ?></h2>
                <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
                <p><strong>Genre:</strong> <?php echo $book['genre']; ?></p>
                <?php if ($book['discount'] != 0): ?>
                    <?php
                    $discountPrice = $book['price'] * (100 - $book['discount']) / 100;
                    ?>
                    <p><strong>Price:</strong> &dollar;<del><?php echo number_format($book['price'], 2); ?></del> &rarr; <?php echo number_format($discountPrice, 2); ?> (<?php echo number_format($book['discount'], 2); ?>% off)</p>
                <?php else: ?>
                    <p><strong>Price:</strong> &dollar;<?php echo number_format($book['price'], 2); ?></p>
                <?php endif; ?>
                <div class="book-details" style="text-align: center;">
                    <?php if ($book['quantity'] <= 0): ?>
                        <p style="color: red;">This book is currently out of stock</p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'user' || $_SESSION['role'] === 'admin')): ?>
                        <form action="/public/index.php?url=main/index" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <?php if ($_SESSION['role'] === 'user' && $book['quantity'] > 0): ?>
                                <?php if ($data['isBookInCart']($book['id'])): ?>
                                    <button type='submit' name='remove_from_cart' style='padding: 8px 20px; background-color: #dc3545; color: white; border: none; cursor: pointer; margin-top: 10px; border-radius: 5px; width: 150px;'>Remove from Cart</button>
                                <?php else: ?>
                                    <button type='submit' name='buy' style='padding: 8px 20px; background-color: #007bff; color: white; border: none; cursor: pointer; margin-top: 10px; border-radius: 5px; width: 150px;'>Buy</button>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <a href="/views/edit_book?id=<?php echo $book['id']; ?>" class="change-book-info">Change Book Info</a>

                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (isset($data['noResultsMessage'])): ?>
        <p><?php echo $data['noResultsMessage']; ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="admin-button">
            <a href="/views/add_new_book"><img src="/public/images/add-new-book.png" alt="Add New Book"></a>
        </div>
    <?php endif; ?>
</div>
<div class="footer">
    <p><b>You can contact us:</b></p>
    <p>We in: <a href="https://www.instagram.com" target="_blank">Instagram</a></p>
    <p>We in: <a href="https://www.telegram.org" target="_blank">Telegram</a></p>
    <p>+38 (097) 123 4567</p>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
        <a href="/public/index.php?url=support">Contact Support</a>
    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="/public/index.php?url=support/requests">View Support Requests</a>
    <?php endif; ?>
</div>
</body>
</html>
