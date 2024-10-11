<?php
    // Get current page file name
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- FontAwesome -->
</head>
<body class="bg-gray-100 h-screen">
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="flex flex-col w-[10rem] relative min-h-full p-3 bg-gray-900 text-white shadow-lg transition duration-300 ease-in-out">
            <div class="space-y-6 flex-1">
                <!-- Sidebar Header with Logo -->
                <div class="flex flex-col items-center  justify-between">
                    <!-- Logo -->
                    <img src="../img/logo.png" alt="POS Logo" class="h-16 w-16 object-cover rounded-full mb-4 transition-transform transform-gpu hover:scale-110 duration-300 ease-in-out">
                    
                    <!-- Title -->
                    <h2 class="text-xl font-bold tracking-wider text-blue-400">POS System</h2>
                </div>

                <!-- Sidebar Menu -->
                <div class="flex-1">
                    <ul class="pt-4 space-y-2 text-sm">

                        <!-- Dashboard -->
                        <li class="rounded-lg transition-transform transform-gpu hover:scale-105 hover:shadow-2xl duration-300 ease-in-out <?php echo ($currentPage == 'dashboard.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                            <a href="dashboard.php" class="flex items-center p-3 space-x-3 rounded-lg">
                                <i class="fas fa-tachometer-alt text-xl"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </li>

                        <!-- Products with dropdown -->
                        <li class="rounded-lg transition-transform transform-gpu hover:scale-105 hover:shadow-2xl duration-300 ease-in-out">
                            <div class="flex items-center p-3 space-x-3 cursor-pointer rounded-lg hover:bg-gray-800" onclick="toggleDropdown('productsDropdown')">
                                <i class="fas fa-boxes text-xl"></i>
                                <span class="font-medium">Products</span>
                                <span class="ml-auto">▼</span>
                            </div>
                            <ul id="productsDropdown" class="pl-8 mt-2 space-y-2 text-sm hidden">
                                <li class="transition-transform transform-gpu hover:scale-105 hover:shadow-lg duration-300 ease-in-out <?php echo ($currentPage == 'products.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                                    <a href="products.php" class="block p-2 rounded-lg">All Products</a>
                                </li>
                                <li class="transition-transform transform-gpu hover:scale-105 hover:shadow-lg duration-300 ease-in-out <?php echo ($currentPage == 'add_product.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                                    <a href="add_product.php" class="block p-2 rounded-lg">Add Product</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Sales with dropdown -->
                        <li class="rounded-lg transition-transform transform-gpu hover:scale-105 hover:shadow-2xl duration-300 ease-in-out">
                            <div class="flex items-center p-3 space-x-3 cursor-pointer rounded-lg hover:bg-gray-800" onclick="toggleDropdown('salesDropdown')">
                                <i class="fas fa-cash-register text-xl"></i>
                                <span class="font-medium">Sales</span>
                                <span class="ml-auto">▼</span>
                            </div>
                            <ul id="salesDropdown" class="pl-8 mt-2 space-y-2 text-sm hidden">
                                <li class="transition-transform transform-gpu hover:scale-105 hover:shadow-lg duration-300 ease-in-out <?php echo ($currentPage == 'sales.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                                    <a href="sales.php" class="block p-2 rounded-lg">All Sales</a>
                                </li>
                                <li class="transition-transform transform-gpu hover:scale-105 hover:shadow-lg duration-300 ease-in-out <?php echo ($currentPage == 'new_sale.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                                    <a href="new_sale.php" class="block p-2 rounded-lg">New Sale</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Sales Reports -->
                        <li class="rounded-lg transition-transform transform-gpu hover:scale-105 hover:shadow-2xl duration-300 ease-in-out <?php echo ($currentPage == 'sales_report.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                            <a href="sales_report.php" class="flex items-center p-3 space-x-3 rounded-lg">
                                <i class="fas fa-file-invoice text-xl"></i>
                                <span class="font-medium">Sales Report</span>
                            </a>
                        </li>

                        <!-- Customers -->
                        <li class="rounded-lg transition-transform transform-gpu hover:scale-105 hover:shadow-2xl duration-300 ease-in-out <?php echo ($currentPage == 'customers.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                            <a href="customers.php" class="flex items-center p-3 space-x-3 rounded-lg">
                                <i class="fas fa-users text-xl"></i>
                                <span class="font-medium">Customers</span>
                            </a>
                        </li>

                        <!-- Reports -->
                        <li class="rounded-lg transition-transform transform-gpu hover:scale-105 hover:shadow-2xl duration-300 ease-in-out <?php echo ($currentPage == 'reports.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                            <a href="reports.php" class="flex items-center p-3 space-x-3 rounded-lg">
                                <i class="fas fa-chart-bar text-xl"></i>
                                <span class="font-medium">Reports</span>
                            </a>
                        </li>

                        <!-- Settings -->
                        <li class="rounded-lg transition-transform transform-gpu hover:scale-105 hover:shadow-2xl duration-300 ease-in-out <?php echo ($currentPage == 'settings.php') ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-800'; ?>">
                            <a href="settings.php" class="flex items-center p-3 space-x-3 rounded-lg">
                                <i class="fas fa-cogs text-xl"></i>
                                <span class="font-medium">Settings</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Your main content goes here -->
        </div>
    </div>

    <script>
        // Toggle dropdowns
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }
    </script>
</body>
</html>