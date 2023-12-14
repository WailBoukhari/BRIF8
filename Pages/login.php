<?php
require_once '../Includes/database.php';
require_once '../Includes/classes.php'; // Assuming you saved the classes in a file named 'classes.php'

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have form fields named 'email' and 'password'
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        // Create an instance of the User class and pass the existing PDO connection
        $user = new User($conn, null, null, $email, $password, null, null, null, null, null, null, null);

        // Validate the user credentials
        $loggedInUser = $user->login(
            $username,
            $password,
            $role = '',
            $verified = false
        );

        if ($loggedInUser) {
            echo "Login successful!";
            // Perform any additional actions upon successful login
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>

<body>
    <h2>User Login</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>

</html>