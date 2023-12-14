<?php
require_once '../Includes/database.php';
require_once '../Includes/classes.php'; // Assuming you saved the classes in a file named 'classes.php'

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have form fields named 'fullName', 'phoneNumber', 'address', 'city', 'email', 'password', etc.
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $fullName = isset($_POST['fullName']) ? $_POST['fullName'] : '';
    $phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = 'user'; // Assuming a default role for a regular user
    $verified = 0; // Assuming a new user is not verified initially
    $disabled = 0; // Assuming a new user is not disabled initially

    try {
        // Create an instance of the User class and pass the existing PDO connection
        $user = new User($conn, $user_id, $username, $email, $password, $role, $verified, $fullName, $phoneNumber, $address, $disabled, $city);

        // Add the user
        $userAdded = $user->addUser($username, $email, $password, $role, $verified, $fullName, $phoneNumber, $address, $disabled, $city);

        if ($userAdded) {
            echo "User registered successfully!";
        } else {
            echo "Error registering user.";
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
    <title>Document</title>
</head>

<body>
    <h2>User Registration</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="fullName">Full Name:</label>
        <input type="text" name="fullName" required><br>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" name="phoneNumber"><br>

        <label for="address">Address:</label>
        <input type="text" name="address"><br>

        <label for="city">City:</label>
        <input type="text" name="city"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Register">
    </form>
</body>

</html>