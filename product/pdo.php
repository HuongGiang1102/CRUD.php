<?php
$DB_TYPE = 'mysql';
$DB_HOST = 'localhost';
$DB_NAME = 'crud';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $conn = new PDO("{$DB_TYPE}:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Connect error: ' . $e->getMessage());
}

function prepareSQL($sql)
{
    global $conn;
    return $conn->prepare($sql);
}

function getAllCategories()
{
    global $conn;
    $stmt = $conn->query('SELECT * FROM categories');
    return $stmt->fetchAll();
}

function getCategory($categoryId)
{
    global $conn;

    $query = "SELECT * FROM categories WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $categoryId);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createCategory($name)
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO categories (name) VALUES (?)');
    $stmt->execute([$name]);
}

function updateCategory($categoryId, $name)
{
    global $conn;

    $query = "UPDATE categories SET name = :name WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $categoryId);
    $stmt->execute();
}

function deleteCategory($id)
{
    global $conn;
    $stmt = $conn->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$id]);
}

function getAllProducts()
{
    global $conn;
    $stmt = $conn->query('SELECT * FROM products');
    return $stmt->fetchAll();
}

function getProduct($productId)
{
    global $conn;

    $query = "SELECT * FROM products WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $productId);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createProduct($name, $price, $categoryId)
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO products (name, price, category_id) VALUES (?, ?, ?)');
    $stmt->execute([$name, $price, $categoryId]);
}

function updateProduct($productId, $name, $price, $categoryId)
{
    global $conn;

    $query = "UPDATE products SET name = :name, price = :price, category_id = :category_id WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $categoryId);
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
}

function deleteProduct($id)
{
    global $conn;
    $stmt->execute([$id]);}
?>
<?php
require_once 'pdo.php';

$categories = getAllCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $categoryId = $_POST['category_id'];

    if (empty($name) || empty($price) || empty($categoryId)) {
        $error = 'Please fill in all fields.';
        header('Location: create.php?error=' . urlencode($error));
        exit();
    }

    createProduct($name, $price, $categoryId);
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
    <title>Create Product</title>
</head>
<body>
    <div class="container">
        <h1>Create Product</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php endif; ?>
        <form action="create.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category_id" required>
                    <option selected disabled>Select category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
