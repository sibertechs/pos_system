<?php
// Database connection
include '../includes/connect.php';

// Fetch customers
$customerQuery = "SELECT id, customer_name, email, phone, total_purchases, last_purchase FROM customers";
$customerResult = mysqli_query($conn, $customerQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex">
    <!-- Sidebar -->
    <?php include('../includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="p-6 w-full">
        <h1 class="text-4xl font-bold text-blue-600 mb-6">Customers</h1>

        <!-- Add Customer Button -->
        <a href="add_customer.php" class="mb-4 inline-block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">
            Add Customer
        </a>

        <!-- Customers Table -->
        <div class="bg-white shadow-lg overflow-x-auto rounded-lg p-6">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Total Purchases (GH₵)</th>
                        <th class="px-4 py-2">Last Purchase</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($customerRow = mysqli_fetch_assoc($customerResult)): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $customerRow['id']; ?></td>
                            <td class="border px-4 py-2"><?php echo $customerRow['customer_name']; ?></td>
                            <td class="border px-4 py-2"><?php echo $customerRow['email']; ?></td>
                            <td class="border px-4 py-2"><?php echo $customerRow['phone']; ?></td>
                            <td class="border px-4 py-2"><?php echo number_format($customerRow['total_purchases'], 2); ?></td>
                            <td class="border px-4 py-2"><?php echo $customerRow['last_purchase'] ?: 'N/A'; ?></td>
                            <td class="border px-4 py-2">
                                <a href="edit_customer.php?id=<?php echo $customerRow['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                                |
                                <a href="delete_customer.php?id=<?php echo $customerRow['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
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
