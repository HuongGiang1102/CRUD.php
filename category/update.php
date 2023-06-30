<?php
require_once 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $categoryId = $_POST['id'];
        $category = getCategory($categoryId);

        if (!$category) {
            die('Category not found');
        }

        $name = $_POST['name'];

        if (empty($name)) {
            $error = 'Please enter a category name.';
            header('Location: edit.php?id=' . $categoryId . '&error=' . urlencode($error));
            exit();
        }

        updateCategory($categoryId, $name);

        header('Location: index.php');
        exit();
    } else {
        die('Category ID not provided');
    }
}

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $category = getCategory($categoryId);

    if (!$category) {
        die('Category not found');
    }
} else {
    die('Category ID not provided');
}
?>