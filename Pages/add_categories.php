<?php
// Include the necessary files and start the session
require_once '../Includes/database.php';
require_once '../Includes/classes.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $category_name = $_POST['category_name'];

    // Validate and sanitize the input (you may need more robust validation)
    $category_name = filter_var($category_name, FILTER_SANITIZE_STRING);

    // Create a Category object
    $category = new Category($category_name);

    // Add the category to the database
    $categoryDAO = new CategoryDAO();
    $result = $categoryDAO->addCategory($category);

    if ($result) {
        // Category added successfully, you can redirect or show a success message
        header('Location: categories.php');
        exit();
    } else {
        // Error adding category, you can redirect or show an error message
        $error_message = 'Error adding category';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <!-- Include the Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-semibold mb-4">
            Add Category</h2>
        <?php
        if (isset($error_message)) {
            echo '<p class="text-red-500 mb-4">' . $error_message . '</p>';
        }
        ?>
        <form method="post" action="" class="space-y-4">
            <div>
                <label for="category_name" class="block text-sm font-medium text-gray-600">Category Name:</label>
                <input type="text" name="category_name" required class="mt-1 p-2 w-full border rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Add
                Category</button>
        </form>

        <p class="mt-4 text-sm text-gray-600"><a href="categories.php" class="text-blue-500">Back to Categories</a></p>
    </div>
</body>

</html>