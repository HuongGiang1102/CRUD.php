<?php
    require_once 'pdo.php';

    if (isset($_GET['id'])) {
        $categoryId = $_GET['id'];
    } else {
        die('Category ID not provided');
    }
    $categories = getCategory($categoryId);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Edit</h1>
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= $categories['id'] ?? '' ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $categories['name'] ?? '' ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>