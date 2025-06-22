<?php
include '../components/connect.php';
    $seller_id = ''; // Initialize $seller_id
    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        header('location: login.php');
        exit();
    }

    // Fetch seller's products
    $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
    $select_products->execute([$seller_id]);
    $total_products = $select_products->rowCount();

    // Fetch seller's orders
    $select_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ?");
    $select_orders->execute([$seller_id]);
    $total_orders = $select_orders->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller's Profile</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="seller-profile">
            <div class="heading">
                <h1>Profile Details</h1>
                <img src="../image/separator-img.png" alt="">
            </div>

            <div class="details">
                <div class="seller">
                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                    <h3 class="name"><?= $fetch_profile['name']; ?></h3>
                    <span>Seller</span>
                    <a href="update.php" class="btn">Update Profile</a>
                </div>
                <div class="flex">
                    <div class="box">
                        <span><?= $total_products; ?></span>
                        <p>Total Products</p>
                        <a href="view_products.php" class="btn">View Products</a>
                    </div>
                    <div class="box">
                        <span><?= $total_orders; ?></span>
                        <p>Total Orders Placed</p>
                        <a href="admin_order.php" class="btn">View Orders</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php 
        include "../components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="../js/admin_script.js"></script>
</body>
</html>