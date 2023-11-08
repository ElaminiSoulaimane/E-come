<?php
include('db.php');

$sql = "SELECT orders.id, products.name as product_name, orders.quantity, orders.total_price, orders.name, orders.phone_number, orders.status 
        FROM orders 
        INNER JOIN products ON orders.product_id = products.id";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "
            <td>{$row['id']}</td>
            <td>{$row['product_name']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['total_price']}</td>
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
            <td>
                <form action='delete_order.php' method='post'> 
                    <input type='hidden' name='order_id' value='{$row['id']}'>
                    <button type='submit'>Delete</button>
                </form>
            </td>
       ";
}

$conn->close();
