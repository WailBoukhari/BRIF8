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
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>