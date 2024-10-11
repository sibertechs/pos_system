<?php
 // Include database connection
include('../includes/connect.php');

// Handle the deletion of a product
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('i', $delete_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Failed to delete the product.');</script>";
    }
    $stmt->close();
}

// Fetch products from the database
$query = "SELECT * FROM products";
$result = $conn->query($query);   
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Alpine.js for modal functionality -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar with logo -->
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="../img/logo.png" alt="Logo" class="w-10 h-10 mr-3">
                <h1 class="text-white text-2xl">Product Management</h1>
            </div>
            <a href="add_product.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add New Product</a>
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4 md:px-0">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
            <h2 class="text-2xl md:text-3xl font-semibold">All Products</h2>
        </div>

        <!-- Responsive Product Table -->
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase">ID</th>
                        <th class="py-3 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase">Product Name</th>
                        <th class="py-3 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase">Price</th>
                        <th class="py-3 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase">Quantity</th>
                        <th class="py-3 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase">Total Amount</th>
                        <th class="py-3 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm"><?php echo $row['id']; ?></td>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm"><?php echo $row['product_name']; ?></td>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm"><?php echo $row['price']; ?> GHS</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm"><?php echo $row['quantity']; ?></td>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm"><?php echo $row['total_amount']; ?> GHS</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm">
                            <button 
                                @click="$dispatch('open-modal', {
                                    id: <?php echo $row['id']; ?>,
                                    name: '<?php echo addslashes($row['product_name']); ?>',
                                    price: <?php echo $row['price']; ?>,
                                    quantity: <?php echo $row['quantity']; ?>
                                })"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                                Edit
                            </button>
                            <a href="products.php?delete_id=<?php echo $row['id']; ?>" 
                               class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm" 
                               onclick="return confirm('Are you sure you want to delete this product?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="6" class="py-2 px-4 text-center text-gray-500 text-sm">No products found</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Editing Product -->
    <div x-data="{ 
        showModal: false, 
        productId: null, 
        productName: '', 
        productPrice: 0, 
        productQuantity: 0
    }"
    @open-modal.window="
        showModal = true;
        productId = $event.detail.id;
        productName = $event.detail.name;
        productPrice = $event.detail.price;
        productQuantity = $event.detail.quantity;
    ">
        <div x-show="showModal" 
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" 
             @click.away="showModal = false">
            <div class="bg-white p-6 rounded-lg w-96">
                <h2 class="text-xl font-semibold mb-4">Edit Product</h2>
                <form action="update_product.php" method="POST">
                    <input type="hidden" name="product_id" x-model="productId">
                    <div class="mb-4">
                        <label for="product_name" class="block text-gray-700">Product Name</label>
                        <input type="text" id="product_name" name="product_name" x-model="productName" class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="product_price" class="block text-gray-700">Price</label>
                        <input type="number" id="product_price" name="product_price" x-model="productPrice" class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="product_quantity" class="block text-gray-700">Quantity</label>
                        <input type="number" id="product_quantity" name="product_quantity" x-model="productQuantity" class="w-full px-3 py-2 border border-gray-300 rounded">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="showModal = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>