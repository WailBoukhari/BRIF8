<?php
// Include the database and BaseDAO classes
require_once '../Includes/database.php';
require_once '../Includes/classes.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Assuming you have a UserDAO class with a method to disable a user
    $categoryDAO = new CategoryDAO();
    $categoryDAO->enableCategory($categoryId);

    // Redirect back to the user management page after disabling the user
    header("Location: dashboard.php?page=category-management");
    exit();
} else {
    // Handle invalid requests
    header("Location: error.php");
    exit();
}
