<?php
require_once 'pdo.php';

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    deleteCategory($categoryId);
    header('Location: index.php');
    exit();
} else {
    die('Category ID not provided');
}
?>
