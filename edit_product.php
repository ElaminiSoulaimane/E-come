<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id=$product_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
    } else {
        echo "Product not found";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id=$product_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Product</h2>
    <form action="edit_product.php" method="post">
        <input type="hidden" name="id" value="<?php echo $product_id; ?>">
        <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" required><br>
        <textarea name="description" placeholder="Description" required><?php echo $description; ?></textarea><br>
        <input type="number" name="price" placeholder="Price" step="0.01" value="<?php echo $price; ?>" required><br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
