<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Requests</title>
    <link rel="stylesheet" href="../public/css/support_requests.css">
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this request?");
        }
    </script>
</head>
<body>
<div class="container">
    <h2>All Support Requests</h2>
    <a href="/public/" class="button">Go back to homepage</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Email</th>
                <th>Title</th>
                <th>Content</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['requests'] as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request['list_id']); ?></td>
                    <td><?php echo htmlspecialchars($request['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($request['email']); ?></td>
                    <td><?php echo htmlspecialchars($request['title']); ?></td>
                    <td><?php echo htmlspecialchars($request['content']); ?></td>
                    <td><?php echo htmlspecialchars($request['date']); ?></td>
                    <td>
                        <form action="/public/index.php?url=support/deleteRequest/<?php echo $request['list_id']; ?>" method="POST" onsubmit="return confirmDelete();">
                            <button type="submit" class="button">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
