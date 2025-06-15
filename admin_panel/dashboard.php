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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

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
                    <a href="update.php" class="btn">Update Profile"></a>
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
                    <p>TotalActive Products</p>
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
                    <p>Total Orders</p>
                    <a href="admin_order.php" class="btn">Total Orders</a>
                </div>

            </div>
        </section>

    </div>
    
</body>
</html>