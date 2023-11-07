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

    $sql = "DELETE FROM products WHERE id=$product_id";

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
    <title>Delete Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Delete Product</h2>
    <p>Are you sure you want to delete the following product?</p>
    <p>Name: <?php echo $name; ?></p>
    <p>Description: <?php echo $description; ?></p>
    <p>Price: <?php echo $price; ?></p>

    <form action="delete_product.php" method="post">
        <input type="hidden" name="id" value="<?php echo $product_id; ?>">
        <button type="submit">Confirm Delete</button>
    </form>
</body>
</html>
