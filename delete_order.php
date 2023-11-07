<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        
        // Assuming you have a table named 'orders'
        $sql = "DELETE FROM orders WHERE id=$order_id";

        if ($conn->query($sql) === TRUE) {
            // Redirect to admin_dashboard.php after successful deletion
            header('Location: admin_dashboard.php');
            exit();
        } else {
            echo "Error deleting order: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid order ID";
    }
}
?>
