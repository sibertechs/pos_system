<?php
    // Include database connection
    include('../includes/connect.php');

    // Initialize variables
    $productName = $price = $quantity = $category = "";
    $message = "";
    $alertType = "";  // This will determine the type of alert (success or error)

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productName = $_POST['product_name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $category = $_POST['category'];

        // Validate input
        if (!empty($productName) && !empty($price) && !empty($quantity) && !empty($category)) {
            // Check if the product already exists
            $check_sql = "SELECT * FROM products WHERE product_name='$productName'";
            $result = mysqli_query($conn, $check_sql);

            if (mysqli_num_rows($result) > 0) {
                // Product already exists
                $message = "Product already exists!";
                $alertType = "error";
            } else {
                // Calculate total amount (price * quantity)
                $totalAmount = $price * $quantity;

                // Insert new product into the database with total_amount
                $sql = "INSERT INTO products (product_name, price, quantity, category, total_amount) 
                        VALUES ('$productName', '$price', '$quantity', '$category', '$totalAmount')";

                if (mysqli_query($conn, $sql)) {
                    // Product added successfully
                    $message = "Product added successfully!";
                    $alertType = "success";

                    // Redirect to avoid form resubmission
                    header("Location: add_product.php?success=1");
                    exit();
                } else {
                    $message = "Error adding product: " . mysqli_error($conn);
                    $alertType = "error";
                }
            }
        } else {
            $message = "Please fill in all fields.";
            $alertType = "error";
        }
    }

    // Check if redirected with success
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        $message = "Product added successfully!";
        $alertType = "success";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System | Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        // JavaScript function to show alert messages based on server response
        function showAlert(message, type) {
            if (message && type) {
                if (type === 'success') {
                    alert("Success: " + message);
                } else if (type === 'error') {
                    alert("Error: " + message);
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen" onload="showAlert('<?php echo $message; ?>', '<?php echo $alertType; ?>')">
    <div class="flex flex-1">
        <!-- Sidebar -->
        <?php include('../includes/sidebar.php'); ?>
        
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h1 class="text-3xl font-bold mb-6">Add New Product</h1>

            <!-- Add Product Form -->
            <form method="POST" action="add_product.php" class="bg-white p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <label for="product_name" class="block text-sm font-bold mb-2">Product Name:</label>
                    <input type="text" id="product_name" name="product_name" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-bold mb-2">Price (GHS):</label>
                    <input type="number" id="price" name="price" step="0.01" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-bold mb-2">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-bold mb-2">Category:</label>
                    <input type="text" id="category" name="category" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">Add Product</button>
                </div>
            </form>
        </div>
    </div>

   <?php
       include "../includes/footer.php";
   ?>
</body>
</html>