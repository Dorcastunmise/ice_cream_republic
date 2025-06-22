<?php

    include '../components/connect.php';
    $seller_id = ''; // Initialize $seller_id
    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        header('location: login.php');
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice Cream Delights - Seller's Dashboard</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

    <div class="main-container">

        <?php include '../components/admin_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <img src="../image/separator-img.png" alt="">
            </div>

            <div class="box-container">
                <div class="box">
                    <h3>Welcome!</h3>
                    <p><?= $fetch_profile['name']; ?></p>
                    <a href="update.php" class="btn">Update Profile</a>
                </div>
                <div class="box">
                    <?php
                    $select_message = $conn->prepare("SELECT * FROM message");
                    $select_message->execute();
                    $number_of_msg = $select_message->rowCount();
                    ?>
                    <h3><?= $number_of_msg; ?></h3>
                    <p>Unread Messages</p>
                    <a href="admin_messages.php" class="btn">View Message</a>
                </div>

                <div class="box">
                    <?php
                    $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
                    $select_products->execute([$seller_id]);
                    $number_of_products = $select_products->rowCount();
                    ?>
                    <h3><?= $number_of_products; ?></h3>
                    <p>Products Added</p>
                    <a href="add_products.php" class="btn">Add product</a>
                </div>

                <div class="box">
                    <?php
                    $select_active_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ? AND status = ?");
                    $select_active_products->execute([$seller_id, 'active']);
                    $number_of_active_products = $select_active_products->rowCount();
                    ?>
                    <h3><?= $number_of_active_products; ?></h3>
                    <p>Total Active Products</p>
                    <a href="view_products.php" class="btn">Active product</a>
                </div>

                <div class="box">
                    <?php
                    $select_deactive_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ? AND status = ?");
                    $select_deactive_products->execute([$seller_id, 'deactive']);
                    $number_of_deactive_products = $select_deactive_products->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_products; ?></h3>
                    <p>Total Deactivated Products</p>
                    <a href="view_products.php" class="btn">Deactivated Products</a>
                </div>

                <div class="box">
                    <?php
                    $select_users = $conn->prepare("SELECT * FROM users");
                    $select_users->execute();
                    $number_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $number_of_users; ?></h3>
                    <p>Users Accounts</p>
                    <a href="user_accounts.php" class="btn">View Users</a>
                </div>

                <div class="box">
                    <?php
                    $select_sellers = $conn->prepare("SELECT * FROM sellers");
                    $select_sellers->execute();
                    $number_of_sellers = $select_sellers->rowCount();
                    ?>
                    <h3><?= $number_of_sellers; ?></h3>
                    <p>Sellers Accounts</p>
                    <a href="view_sellers.php" class="btn">View Sellers</a>
                </div>

                <div class="box">
                    <?php
                    $select_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ?");
                    $select_orders->execute([$seller_id]);
                    $number_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?= $number_of_orders; ?></h3>
                    <p>Total Orders Placed</p>
                    <a href="admin_order.php" class="btn">Total Orders</a>
                </div>

                <div class="box">
                    <?php
                    $select_confirm_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ? AND status = ?");
                    $select_confirm_orders->execute([$seller_id, 'in progress']);
                    $number_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $number_of_confirm_orders; ?></h3>
                    <p>Total Confirmed Orders</p>
                    <a href="admin_order.php" class="btn">Confirmed Orders</a>
                </div>

                <div class="box">
                    <?php
                    $select_cancelled_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ? AND status = ?");
                    $select_cancelled_orders->execute([$seller_id, 'cancelled']);
                    $number_of_cancelled_orders = $select_cancelled_orders->rowCount();
                    ?>
                    <h3><?= $number_of_cancelled_orders; ?></h3>
                    <p>Total Cancelled Orders</p>
                    <a href="admin_order.php" class="btn">Cancelled Orders</a>
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