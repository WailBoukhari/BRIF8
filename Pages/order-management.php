<!-- Content Area -->
<div class="container mx-auto mt-5 p-6 bg-white shadow-md rounded-md">

    <h2 class="text-2xl font-semibold mb-4">User Management</h2>

    <!-- Add User Form -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Add New User</h3>
        <form action="" method="post" class="flex space-x-4">
            <input type="text" name="username" placeholder="Username" class="p-2 border rounded">
            <input type="password" name="password" placeholder="Password" class="p-2 border rounded">
            <input type="email" name="email" placeholder="Email" class="p-2 border rounded">
            <select name="role" class="p-2 border rounded">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">Add
                User</button>
        </form>
    </div>

    <!-- User Table -->
    <div>
        <h3 class="text-lg font-semibold mb-2">User List</h3>
        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border p-2">Username</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve users from the database and display them in the table
                $userDAO = new UserDAO();
                $users = $userDAO->getAllUsers();

                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td class='border p-2'>{$user['username']}</td>";
                    echo "<td class='border p-2'>{$user['email']}</td>";
                    echo "<td class='border p-2'>{$user['role']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>