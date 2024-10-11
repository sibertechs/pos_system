<?php
// Database connection
include '../includes/connect.php';

// Fetch user details based on ID
$userId = $_GET['id'];
$userQuery = "SELECT * FROM users WHERE id = $userId";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// Handle role update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newRole = $_POST['role'];
    $updateQuery = "UPDATE users SET role = '$newRole' WHERE id = $userId";
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "User role updated successfully!";
        header("Location: users.php");
    } else {
        echo "Error updating user role: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Role - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex">
    <!-- Sidebar -->
    <?php include('../includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="p-6 w-full">
        <h1 class="text-4xl font-bold text-blue-600 mb-6">Edit User Role</h1>

        <form method="POST" class="bg-white p-6 shadow-lg rounded-lg">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" value="<?php echo $user['username']; ?>" disabled class="bg-gray-200 p-3 rounded w-full">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" value="<?php echo $user['email']; ?>" disabled class="bg-gray-200 p-3 rounded w-full">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                <select name="role" class="bg-gray-200 p-3 rounded w-full">
                    <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="cashier" <?php if ($user['role'] == 'cashier') echo 'selected'; ?>>Cashier</option>
                    <option value="manager" <?php if ($user['role'] == 'manager') echo 'selected'; ?>>Manager</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-500">Update Role</button>
        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
