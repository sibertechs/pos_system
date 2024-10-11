<?php
// Database connection
include '../includes/connect.php';

// Fetch all customers
$query = "SELECT * FROM customers";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex">
    <!-- Sidebar -->
    <?php include('../includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="p-6 w-full">
        <h1 class="text-4xl font-bold text-blue-600 mb-6">Customer Management</h1>

        <!-- Add Customer Button -->
        <a href="add_customer.php" class="mb-4 inline-block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">
            Add New Customer
        </a>

        <!-- Customers Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-lg rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Customer Name</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Phone</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($customer = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="py-2 px-4"><?php echo $customer['id']; ?></td>
                        <td class="py-2 px-4"><?php echo $customer['customer_name']; ?></td>
                        <td class="py-2 px-4"><?php echo $customer['email']; ?></td>
                        <td class="py-2 px-4"><?php echo $customer['phone']; ?></td>
                        <td class="py-2 px-4">
                            <a href="edit_customer.php?id=<?php echo $customer['id']; ?>" class="text-blue-600 hover:underline">Edit</a>
                            <a href="delete_customer.php?id=<?php echo $customer['id']; ?>" class="text-red-600 hover:underline ml-4" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
    include "../includes/footer.php";
?>
</body>
</html>
