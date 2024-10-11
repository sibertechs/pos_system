<?php
session_start();
include('../includes/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username or email already exists
    $checkQuery = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errorMessage = "Username or email already exists.";
    } else {
        // Prepare the SQL query to insert a new user without hashing the password
        $insertQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('sss', $username, $email, $password);
        
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id; // Set session variable
            header("Location: login.php"); // Redirect to the login page
            exit();
        } else {
            $errorMessage = "Error creating account. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex justify-center items-center h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-96">
        <h1 class="text-2xl font-bold text-center mb-6">Signup</h1>
        
        <?php if (!empty($errorMessage)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                <?= htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="w-full mt-1 p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full mt-1 p-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full mt-1 p-2 border rounded-lg" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">
                Signup
            </button>
        </form>

        <p class="mt-4 text-center">
            Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login here</a>
        </p>
    </div>
</div>

</body>
</html>