<?php
// Include database connection
include('../includes/connect.php');

// Fetch all products from the database
$query = "SELECT * FROM products";
$result = $conn->query($query);

// Handle new sale submission
if (isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product details for the selected product
    $productQuery = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($productQuery);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $productResult = $stmt->get_result();
    $product = $productResult->fetch_assoc();

    // Calculate total cost
    $total_amount = $product['price'] * $quantity;

    // Insert the sale into the sales table
    $insertQuery = "INSERT INTO sales (product_id, quantity, total_amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param('iid', $product_id, $quantity, $total_amount);

    if ($stmt->execute()) {
        echo "<script>alert('Sale recorded successfully!'); window.location.href='sales.php';</script>";
    } else {
        echo "<script>alert('Failed to record sale.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <?php include('../includes/sidebar.php'); ?>
        

        <!-- Main Content -->
        <div class="w-3/4 p-6">
            <h1 class="text-3xl font-bold mb-6">New Sale</h1>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-6">Create a New Sale</h2>

                <!-- New Sale Form -->
                <form action="new_sale.php" method="POST">
                    <div class="mb-4">
                        <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                        <select id="product_id" name="product_id" required class="block w-full p-2 border border-gray-300 rounded-md">
                            <option value="" disabled selected>Select a product</option>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?> - <?php echo $row['price']; ?> GHS</option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" id="quantity" name="quantity" min="1" required class="block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter quantity">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" name="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Sale</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
       include "../includes/footer.php";
   ?>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
