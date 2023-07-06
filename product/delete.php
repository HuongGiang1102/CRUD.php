<?php
require_once 'pdo.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    deleteProduct($productId);
    header('Location: index.php');
    exit();
} else {
    die('Product ID not provided');
}
?>
