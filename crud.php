<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'create') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity']; // Add this line to get quantity from form

        // File Upload
        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large. Please choose a smaller file.";
        } else {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO products (name, description, price, quantity, image) VALUES ('$name', '$description', '$price', '$quantity', '$target_file')";
                if ($conn->query($sql) === TRUE) {
                    // Product added successfully, redirect to product_list.php
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Invalid action";
    }
}
?>
