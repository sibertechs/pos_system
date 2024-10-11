<?php
// Database connection
include '../includes/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $insertQuery = "INSERT INTO customers (customer_name, email, phone) VALUES ('$customer_name', '$email', '$phone')";
    mysqli_query($conn, $insertQuery);

    header('Location: customers.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex">
    <!-- Sidebar -->
    <?php include('../includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="p-6 w-full">
        <h1 class="text-4xl font-bold text-blue-600 mb-6">Add Customer</h1>

        <!-- Add Customer Form -->
        <form action="add_customer.php" method="POST" class="bg-white shadow-lg rounded-lg p-6">
            <div class="mb-4">
                <label for="customer_name" class="block text-gray-700">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" class="w-full mt-2 p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full mt-2 p-2 border rounded-lg">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone</label>
                <input type="text" name="phone" id="phone" class="w-full mt-2 p-2 border rounded-lg" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">Add Customer</button>
        </form>
    </div>
</div>

<?php
    include "../includes/footer.php";
?>
</body>
</html>
