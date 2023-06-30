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
?>
