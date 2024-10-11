<?php
// Database connection
include '../includes/connect.php';

// Fetch all users from the database
$usersQuery = "SELECT id, username, email, role, last_login FROM users";
$usersResult = mysqli_query($conn, $usersQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex">
    <!-- Sidebar -->
    <?php include('../includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="p-6 w-full">
        <h1 class="text-4xl font-bold text-blue-600 mb-6">User Management</h1>
        
        <!-- User Table -->
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Username</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Role</th>
                    <th class="py-3 px-4 text-left">Last Login</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($usersResult)) { ?>
                    <tr>
                        <td class="py-3 px-4"><?php echo $user['id']; ?></td>
                        <td class="py-3 px-4"><?php echo $user['username']; ?></td>
                        <td class="py-3 px-4"><?php echo $user['email']; ?></td>
                        <td class="py-3 px-4"><?php echo $user['role']; ?></td>
                        <td class="py-3 px-4"><?php echo $user['last_login']; ?></td>
                        <td class="py-3 px-4">
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-400">
                                Edit
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
