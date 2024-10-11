<?php
session_start();
include('../includes/connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch dashboard metrics
$metrics = [];
// Total Users
$totalUsersQuery = "SELECT COUNT(*) as total FROM users";
$result = $conn->query($totalUsersQuery);
if ($result) {
    $metrics['total_users'] = $result->fetch_assoc()['total'];
}

// Total Products
$totalProductsQuery = "SELECT COUNT(*) as total FROM products";
$result = $conn->query($totalProductsQuery);
if ($result) {
    $metrics['total_products'] = $result->fetch_assoc()['total'];
}

// Total Sales (Assuming you have a sales table)
$totalSalesQuery = "SELECT COUNT(*) as total FROM sales";
$result = $conn->query($totalSalesQuery);
if ($result) {
    $metrics['total_sales'] = $result->fetch_assoc()['total'];
}

// Sample data for the charts
$labels = ['Users', 'Products', 'Sales'];
$values = [$metrics['total_users'], $metrics['total_products'], $metrics['total_sales']];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .cover-image {
            background-image: url('../img/coverImg.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 200px; /* Adjust height as needed */
        }
        /* Resize the charts */
        canvas {
            max-width: 400px; /* Limit the max width */
            max-height: 300px; /* Limit the max height */
            margin: auto; /* Center the canvas */
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex">
    <!-- Sidebar -->
    <?php include "../includes/sidebar.php"; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <!-- Cover Image -->
        <div class="cover-image rounded-lg mb-6"></div>

        <h1 class="text-3xl font-bold mb-6 text-center">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="card bg-blue-600 text-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total Users</h2>
                <p class="text-2xl font-bold"><?php echo $metrics['total_users']; ?></p>
            </div>
            <div class="card bg-green-600 text-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total Products</h2>
                <p class="text-2xl font-bold"><?php echo $metrics['total_products']; ?></p>
            </div>
            <div class="card bg-yellow-600 text-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total Sales</h2>
                <p class="text-2xl font-bold"><?php echo $metrics['total_sales']; ?></p>
            </div>
            <!-- Add more cards for additional metrics as needed -->
        </div>

        <!-- Graphs Section -->
        <h2 class="text-2xl font-semibold my-4 text-center">Metrics Overview</h2>
        <div class="flex flex-col md:flex-row justify-center items-center mb-6">
            <!-- Bar Graph -->
            <div class="w-full md:w-1/2 p-2">
                <h3 class="text-lg font-semibold text-center">Bar Chart</h3>
                <canvas id="barChart"></canvas>
            </div>
            <!-- Pie Chart -->
            <div class="w-full md:w-1/2 p-2">
                <h3 class="text-lg font-semibold text-center">Pie Chart</h3>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

<script>
    // Bar Chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Count',
                data: <?php echo json_encode($values); ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Chart
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Count',
                data: <?php echo json_encode($values); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

</body>
</html>