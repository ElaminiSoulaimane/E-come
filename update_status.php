<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    // Update the status in the orders table
    $sql = "UPDATE orders SET status='$new_status' WHERE id=$order_id";
    $conn->query($sql);

    // If the status is 'livré', update the quantity in the products table
    if ($new_status == 'livré') {
        $sql = "SELECT product_id, quantity FROM orders WHERE id=$order_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];

            // Update the quantity in the products table
            $sql = "UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id";
            $conn->query($sql);
        }
    }

    // Redirect back to admin_dashboard.php
    header('Location: admin_dashboard.php');
    exit();
} else {
    echo "Invalid request.";
}
?>
