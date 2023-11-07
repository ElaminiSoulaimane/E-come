<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

$ts = "SELECT 
            orders.id, 
            products.name as product_name, 
            orders.quantity, 
            orders.total_price, 
            orders.name, 
            orders.phone_number, 
            orders.status 
        FROM orders 
        INNER JOIN products ON orders.product_id = products.id 
        WHERE orders.status = 'livré'";


$sql = "SELECT orders.id, products.name as product_name, orders.quantity, orders.total_price, orders.name, orders.phone_number, orders.status 
        FROM orders 
        INNER JOIN products ON orders.product_id = products.id";



$totalLivréPrice = 0; // Initialize a variable to store the total price
$result = $conn->query($ts);
while ($row = $result->fetch_assoc()) {
    $totalLivréPrice += $row['total_price']; // Add the total price of each 'livré' order
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Welcome, Order Pages</h2>
    <a href="dashboard.php">Product List</a>
    <a href="logout.php">Logout</a>

    <h2>Order List</h2>
    <h2>Total Price of 'livré' Orders: <?php echo $totalLivréPrice; ?> MAD</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Client Name</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Actions</th> <!-- Add a new column for actions -->
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['total_price']} MAD </td>
                <td>{$row['name']}</td>
                <td>{$row['phone_number']}</td>
                <td>
                    <form action='update_status.php' method='post'> 
                        <input type='hidden' name='order_id' value='{$row['id']}'>
                        <select name='status'>
                            <option value='en cours' " . ($row['status'] == 'en cours' ? 'selected' : '') . ">En Cours</option>
                            <option value='livré' " . ($row['status'] == 'livré' ? 'selected' : '') . ">Livré</option>
                            <option value='return' " . ($row['status'] == 'return' ? 'selected' : '') . ">Return</option>
                        </select>
                        <button type='submit'>Update</button>
                    </form>
                </td>
                <td> <!-- Add a new cell for delete button -->
    <form action='delete_order.php' method='post'> 
        <input type='hidden' name='order_id' value='{$row['id']}'>
        <button type='submit'>Delete</button>
    </form>
</td>
            </tr>";
        }
        ?>

    </table>
</body>

</html>