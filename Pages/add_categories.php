<?php
// Include necessary files and classes
require_once 'path/to/config.php'; // Include your database configuration file
require_once 'path/to/CategoryDAO.php'; // Include your CategoryDAO file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data
    $categoryName = $_POST['category_name'];
    // Other form fields...

    // Validate and sanitize the input (Add your validation logic here)

    // Create a new Category object
    $newCategory = new Category(null, $categoryName, 'path/to/default_image.jpg'); // Adjust the default image path

    // Create an instance of CategoryDAO
    $categoryDAO = new CategoryDAO();

    // Add the category to the database
    $success = $categoryDAO->addCategory($newCategory);

    if ($success) {
        // Category added successfully
        header('Location: category-management.php'); // Redirect to the category management page
        exit();
    } else {
        // Handle the error (e.g., display an error message)
        $errorMessage = 'Failed to add the category.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title>Add Category</title>
</head>

<body class="bg-gray-100">

    <!-- Content Area -->
    <div class="container mx-auto mt-5 p-6 bg-white shadow-md rounded-md">

        <h2 class="text-2xl font-semibold mb-4">Add Category</h2>

        <!-- Display error message if any -->
        <?php if (isset($errorMessage)) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?= $errorMessage ?></span>
        </div>
        <?php endif; ?>

        <!-- Category Form -->
        <form action="" method="post">
            <div class="mb-4">
                <label for="category_name" class="block text-gray-700 text-sm font-bold mb-2">Category Name:</label>
                <input type="text" name="category_name" id="category_name"
                    class="w-full border p-2 rounded-md focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <!-- Add other form fields as needed -->

            <div class="mt-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                    Add Category
                </button>
            </div>
        </form>

    </div>

</body>

</html>