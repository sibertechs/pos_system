<?php
// Include database connection
include('../includes/connect.php');

// Initialize totalSales to 0 to avoid warnings when no sales are found
$totalSales = 0;
$salesResult = false; // Initialize to avoid undefined variable error

// Fetch sales with or without date filtering
if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    // If date range is provided
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    $query = "
        SELECT s.id AS sale_id, p.product_name, s.quantity, s.total_amount, s.sale_date 
        FROM sales s
        JOIN products p ON s.product_id = p.id
        WHERE s.sale_date BETWEEN ? AND ?
        ORDER BY s.sale_date DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $start_date, $end_date);
    $stmt->execute();
    $salesResult = $stmt->get_result();
} else {
    // If no date range is provided, fetch all sales
    $query = "
        SELECT s.id AS sale_id, p.product_name, s.quantity, s.total_amount, s.sale_date 
        FROM sales s
        JOIN products p ON s.product_id = p.id
        ORDER BY s.sale_date DESC
    ";
    $salesResult = $conn->query($query);
}

// Calculate total sales
if ($salesResult && $salesResult->num_rows > 0) {
    while ($row = $salesResult->fetch_assoc()) {
        $totalSales += $row['total_amount'];
    }
}

// Handle sale deletion
if (isset($_GET['delete_id'])) {
    $sale_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM sales WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('i', $sale_id);

    if ($stmt->execute()) {
        echo "<script>alert('Sale deleted successfully!'); window.location.href='sales.php';</script>";
    } else {
        echo "<script>alert('Failed to delete sale.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex">
      <?php 
       include "../includes/sidebar.php";
      ?>

        <!-- Main Content -->
        <div class="w-3/4 p-6">
            <h1 class="text-3xl font-bold mb-6">Sales</h1>

            <!-- Date Filtering Form -->
            <form method="GET" class="mb-6 bg-white shadow-md rounded-lg p-4">
                <h2 class="text-xl font-semibold mb-4">Filter Sales by Date</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="w-full p-2 border rounded" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                    </div>
                    <div>
                        <label for="end_date" class="block text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="w-full p-2 border rounded" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Filter Sales</button>
                </div>
            </form>

            <!-- Sales History Table -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-6">Sales History</h2>

                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Product Name</th>
                            <th class="px-4 py-2 text-left">Quantity</th>
                            <th class="px-4 py-2 text-left">Total Amount</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($salesResult && $salesResult->num_rows > 0) {
                            while ($row = $salesResult->fetch_assoc()) { ?>
                        <tr class="border-t border-gray-300">
                            <td class="px-4 py-2"><?php echo $row['product_name']; ?></td>
                            <td class="px-4 py-2"><?php echo $row['quantity']; ?></td>
                            <td class="px-4 py-2"><?php echo number_format($row['total_amount'], 2); ?> GHS</td>
                            <td class="px-4 py-2"><?php echo $row['sale_date']; ?></td>
                            <td class="px-4 py-2">
                                <a href="sales.php?delete_id=<?php echo $row['sale_id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this sale?');">Delete</a>
                            </td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No sales records found.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Display Total Sales Amount -->
            <div class="mt-4 p-4 bg-white shadow-md rounded-lg">
                <h2 class="text-xl font-semibold">
                    Total Sales Amount: <?php echo number_format($totalSales, 2); ?> GHS
                </h2>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <?php
    include "../includes/footer.php";
    ?>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>