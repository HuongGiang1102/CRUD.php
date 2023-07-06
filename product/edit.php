<?php
require_once 'pdo.php';

$categories = getAllCategories();

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = getProduct($productId);
    if (!$product) {
        die('Product not found');
    }
} else {
    die('Product ID not provided');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $productId = $_POST['product_id'];

    if (empty($name) || empty($price) || empty($productId)) {
        $error = 'Please fill in all fields.';
        header('Location: edit.php?id=' . $productId . '&error=' . urlencode($error));
        exit();
    }

    updateProduct($productId, $name, $price, $categoryId);
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Product</title>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php endif; ?>
        <form action="edit.php?id=<?= $productId ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $product['price'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="product" class="form-label">Product</label>
                <select class="form-select" id="product" name="product_id" required>
                    <option selected disabled>Select product</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= ($category['id'] === $product['category_id']) ? 'selected' : '' ?>>
                             <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
