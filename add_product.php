

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add Product</h2>
    <form action="crud.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        <input type="text" name="name" placeholder="Name" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="number" name="price" placeholder="Price" step="0.01" required><br>
        <input type="number" name="quantity" placeholder="Quantity" required><br>
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image"><br>
        <button type="submit">Add Product</button>
    </form>
</body>
</html>
