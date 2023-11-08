<?php
include('db.php');

$message = ""; // Initialize the message variable

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id=$product_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $available_quantity = $row['quantity'];
    } else {
        echo "Product not found";
        exit();
    }
} else {
    echo "Invalid product ID";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity = $_POST['quantity'];
    $client_name = $_POST['name'];
    $phone_number = $_POST['phone_number'];

    if ($quantity > $available_quantity) {
        $message = "Error: Quantity ordered exceeds available quantity.";
    } else {
        $total_price = $price * $quantity;
        $sql = "INSERT INTO orders (product_id, quantity, total_price, name, phone_number) VALUES ($product_id, $quantity, $total_price, '$client_name', '$phone_number')";
        if ($conn->query($sql) === TRUE) {
            header('Location: product_list.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var phone_number = document.getElementById("phone_number").value;

            if (name.length < 3) {
                alert("Name must be at least 3 characters long.");
                return false;
            }

            if (phone_number < 10) {
                alert("Phone number must be at least 10 characters long.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body class="p-6 bg-gray-100">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-4"><?php echo $name; ?></h2>
        <p class="text-gray-700 mb-2"><?php echo $description; ?></p>
        <p class="text-green-600 font-bold"><?php echo "$" . $price; ?></p>

        <form action="" method="post" class="mt-4" onsubmit="return validateForm()">
            <label for="quantity" class="block mb-2 font-bold">Quantity:</label>
            <input type="number" name="quantity" id="quantity" class="border px-4 py-2 mb-2 w-full" value="1" min="1" required>

            <label for="name" class="block mb-2 font-bold">Your Name:</label>
            <input type="text" name="name" id="name" class="border px-4 py-2 mb-2 w-full" required minlength="3">

            <label for="phone_number" class="block mb-2 font-bold">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" class="border px-4 py-2 mb-2 w-full" value="10" min="10" required>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Place Order</button>
        </form>

        <?php
        if (!empty($message)) {
            echo "<p class='text-red-500'>$message</p>";
        }
        ?>
    </div>
</body>

</html>