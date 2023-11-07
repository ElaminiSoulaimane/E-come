<?php
session_start();

if(isset($_SESSION['username'])){
    header('Location: dashboard.php');
    exit();
} else {
    header('Location: product_list.php');
    exit();
}
?>
