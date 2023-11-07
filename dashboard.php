<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    
   
     <a  href="admin_dashboard.php">Order Page</a> <a href="add_product.php" >Add Product</a> <a style="background-color: red;" href="logout.php">Logout</a>

    <h2>Product List</h2>
   
    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            // Calculate total price
            $total_price = $row['price'] * $row['quantity'];

            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['quantity']}</td>
                    <td><img src='{$row['image']}' alt='{$row['name']}' style='max-width: 100px; max-height: 100px;'></td>
                    <td>
                        <a href='edit_product.php?id={$row['id']}'>Edit</a>
                        <a href='delete_product.php?id={$row['id']}'>Delete</a>
                    </td>
                </tr>";
        }
        ?>
    </table>
</body>

</html>
