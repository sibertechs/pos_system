<?php
// Database connection
include '../includes/connect.php';

// Get customer ID from the URL
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Delete customer
    $deleteQuery = "DELETE FROM customers WHERE id = $customer_id";
    mysqli_query($conn, $deleteQuery);

    // Redirect back to the customers list
    header('Location: customers.php');
}
?>
