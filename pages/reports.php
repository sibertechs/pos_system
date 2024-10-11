<?php
// Database connection
include '../includes/connect.php'; // Ensure this file contains the connection to your DB

// Fetch sales report
$salesQuery = "SELECT COALESCE(SUM(total_amount), 0) AS total_sales, COUNT(id) AS completed_orders FROM sales WHERE status = 'completed'";
$salesResult = mysqli_query($conn, $salesQuery);
$salesRow = mysqli_fetch_assoc($salesResult);

// Format total sales
$totalSales = $salesRow['total_sales'] ?? 0;
$formattedTotalSales = number_format($totalSales, 2);
$completedOrders = $salesRow['completed_orders'] ?? 0;

// Fetch product report (Best selling product)
$productQuery = "SELECT COALESCE(SUM(sold_quantity), 0) AS total_sold, product_name FROM products GROUP BY product_name ORDER BY total_sold DESC LIMIT 1";
$productResult = mysqli_query($conn, $productQuery);
$productRow = mysqli_fetch_assoc($productResult);

// Handle possible null values
$totalSold = $productRow['total_sold'] ?? 0;
$bestSellingProduct = $productRow['product_name'] ?? 'No products sold';

// Fetch inventory report
$inventoryQuery = "SELECT COALESCE(SUM(stock_quantity), 0) AS total_in_stock, COUNT(*) AS low_stock_products FROM products WHERE stock_quantity <= low_stock_threshold";
$inventoryResult = mysqli_query($conn, $inventoryQuery);
$inventoryRow = mysqli_fetch_assoc($inventoryResult);

// Handle possible null values
$totalInStock = $inventoryRow['total_in_stock'] ?? 0;
$lowStockProducts = $inventoryRow['low_stock_products'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex">
    <!-- Sidebar -->
    <?php include('../includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="p-6 w-full">
        <h1 class="text-4xl font-bold text-blue-600 mb-6">Reports</h1>
        
        <!-- Reports Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            
            <!-- Sales Report Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Sales Report</h2>
                <p>Total Sales: <span class="text-green-500 font-bold">GH₵ <?php echo $formattedTotalSales; ?></span></p>
                <p>Completed Orders: <span class="text-green-500 font-bold"><?php echo $completedOrders; ?></span></p>
                <button class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">
                    View Full Report
                </button>
            </div>

            <!-- Product Report Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Product Report</h2>
                <p>Total Products Sold: <span class="text-green-500 font-bold"><?php echo $totalSold; ?></span></p>
                <p>Best Selling Product: <span class="text-green-500 font-bold"><?php echo $bestSellingProduct; ?></span></p>
                <button class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">
                    View Full Report
                </button>
            </div>

            <!-- Inventory Report Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Inventory Report</h2>
                <p>Products in Stock: <span class="text-green-500 font-bold"><?php echo $totalInStock; ?></span></p>
                <p>Low Stock Products: <span class="text-red-500 font-bold"><?php echo $lowStockProducts; ?></span></p>
                <button class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">
                    View Full Report
                </button>
            </div>

        </div>
    </div>
</div>

<?php
    include "../includes/footer.php";
?>
</body>
</html>
