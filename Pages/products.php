<?php
// Include necessary files and classes
include_once '../Includes/database.php';
include_once '../Includes/classes.php';

// Function to get all products or products by category
function getProducts($categoryId = null)
{
    $productDAO = new ProductDAO();

    try {
        // Call the method based on whether a category is selected
        if ($categoryId !== null) {
            $products = $productDAO->getProductsByCategory($categoryId);
        } else {
            $products = $productDAO->getAllProducts();
        }

        // Display products
        foreach ($products as $product) {
            // Display each product as a card with Tailwind CSS styles
            echo '<div class="max-w-sm rounded overflow-hidden shadow-lg bg-white m-4">';
            echo '<img class="w-full h-64 object-cover" src="' . $product->getImage() . '" alt="' . $product->getLabel() . '">';
            echo '<div class="px-6 py-4">';
            echo '<div class="font-bold text-xl mb-2">' . $product->getLabel() . '</div>';
            echo '<p class="text-gray-700 text-base">Description: ' . $product->getDescription() . '</p>';
            echo '<p class="text-gray-700 text-base">Price: $' . $product->getFinalPrice() . '</p>';
            // Add more details as needed
            echo '</div>';
            echo '</div>';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Function to get all categories
function getAllCategories()
{
    $categoryDAO = new CategoryDAO();

    try {
        $categories = $categoryDAO->getAllCategories();

        // Display categories as options in a select dropdown with Tailwind CSS styles
        echo '<select class="p-2 border" name="categoryFilter" id="categoryFilter" onchange="filterByCategory()">';
        echo '<option value="">All Categories</option>';
        foreach ($categories as $category) {
            echo '<option value="' . $category->getCategoryId() . '">' . $category->getCategoryName() . '</option>';
        }
        echo '</select>';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Add your CSS styles or link to external stylesheets here -->
    <!-- Add Tailwind CSS CDN or link to your local stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="p-4">

    <h1 class="text-4xl font-bold mb-8">Product List</h1>

    <!-- Display category filter with Tailwind CSS styles -->
    <div class="mb-4">
        <label for="categoryFilter" class="text-lg font-semibold">Filter by Category:</label>
        <?php getAllCategories(); ?>
    </div>

    <div class="flex flex-wrap">
        <?php
        // Call the function to display products
        getProducts();
        ?>
    </div>

    <!-- Add your HTML structure and additional styling as needed -->

    <script>
        // JavaScript function to handle category filter change
        function filterByCategory() {
            var categoryId = document.getElementById('categoryFilter').value;
            // Reload the page with the selected category filter
            window.location.href = 'products.php?category=' + categoryId;
        }
    </script>

</body>

</html>