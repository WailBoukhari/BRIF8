<?php
// Include necessary files and start the session
require_once '../Includes/database.php';
require_once '../Includes/classes.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex justify-between p-4 bg-white shadow">
        <h2 class="text-2xl font-semibold">Dashboard</h2>
        <a href="logout.php" class="text-blue-500">Logout</a>
    </div>


    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>