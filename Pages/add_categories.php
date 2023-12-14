<?php
include_once 'includes/database.php';
include_once 'includes/classes.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get category data from the form
    $categoryName = $_POST["categoryName"];

    // Validate the data (you might want to add more validation)
    if (empty($categoryName)) {
        $error = "Category name is required.";
    } else {
        // Create a Category instance and add the category to the database
        $category = new Category($conn);
        $category->addCategory($categoryName);
        $success = "Category added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Categories</title>
</head>

<body>

    <h2>Add Category</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>Error: $error</p>";
    }

    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="categoryName">Category Name:</label>
        <input type="text" name="categoryName" required>
        <br>
        <input type="submit" value="Add Category">
    </form>

</body>

</html>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Categories</title>
</head>

<body>

    <h2>Add Category</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>Error: $error</p>";
    }

    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="categoryName">Category Name:</label>
        <input type="text" name="categoryName" required>
        <br>
        <input type="submit" value="Add Category">
    </form>

</body>

</html>