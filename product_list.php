<?php
include('db.php');

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Product List</h2>
        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<div class='border p-4 rounded'>
                        <h3 class='font-bold text-xl mb-2'><a href='product_detail.php?id={$row['id']}'>{$row['name']}</a></h3>
                        <img src='{$row['image']}' alt='{$row['name']}' class='mb-2 rounded'>
                        <p class='text-gray-700 mb-2'>{$row['description']}</p>
                        <p class='text-green-600 font-bold'>\${$row['price']}</p>
                        <p class='text-blue-600 font-bold'>Available Quantity: {$row['quantity']}</p>
                    </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>

