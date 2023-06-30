<?php
require_once 'pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    if (empty($name)) {
        $error = 'Please enter a category name.';
        header('Location: create.php?error=' . urlencode($error));
        exit();
    }

    createCategory($name);
    header('Location: index.php');
    exit();
}
?>
