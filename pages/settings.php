<?php
// Start session and include database connection
session_start();
include('../includes/connect.php');

// Check if user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$userId = $_SESSION['user_id'];

// Handle form submission for updating settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Get the password as plain text

    // Prepare the SQL update query
    if (!empty($password)) {
        // If a password is provided, update it in the database
        $query = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $username, $email, $password, $userId);
    } else {
        // If no password is provided, update only username and email
        $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $username, $email, $userId);
    }

    // Execute the statement and check for success
    if ($stmt->execute()) {
        $successMessage = "Settings updated successfully!";
    } else {
        $errorMessage = "Error updating settings.";
    }
}

// Fetch current user data to pre-fill the form
$query = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 0) {
    header("Location: login.php"); // Redirect if user not found
    exit();
}

$user = $result->fetch_assoc();

$usernameValue = $user['username'] ?? ''; // Fallback to empty string if not set
$emailValue = $user['email'] ?? ''; // Fallback to empty string if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex">
    <!-- Sidebar -->
    <?php include('../includes/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="p-6 w-full">
        <h1 class="text-4xl font-bold text-blue-600 mb-6">Settings</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($successMessage)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                <?= htmlspecialchars($successMessage); ?>
            </div>
        <?php elseif (!empty($errorMessage)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                <?= htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Settings Form -->
        <form action="settings.php" method="POST" class="bg-white shadow-lg rounded-lg p-6">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="w-full mt-1 p-2 border rounded-lg" value="<?= htmlspecialchars($usernameValue); ?>" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full mt-1 p-2 border rounded-lg" value="<?= htmlspecialchars($emailValue); ?>" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">New Password (optional)</label>
                <input type="password" name="password" id="password" class="w-full mt-1 p-2 border rounded-lg">
            </div>

            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">
                Save Changes
            </button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

</body>
</html>