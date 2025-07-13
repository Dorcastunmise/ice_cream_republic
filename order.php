<?php

    include 'components/connect.php';
    $user_id = ''; // Initialize $user_id

    if(isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    } else {
        header('location: login.php');
        exit();
    }

    //update order from database
    if(isset($_POST['update_order'])) {
        $order_id = htmlspecialchars($_POST['order_id'], ENT_QUOTES, 'UTF-8');
        $update_payment = htmlspecialchars($_POST['update_payment'], ENT_QUOTES, 'UTF-8');
        $update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
        $update_pay->execute([$update_payment, $order_id]);
        $success_msg[] = "Payment's status updated successfully!";
    }

    //delete order
    if(isset($_POST['delete_order'])) {
        $delete_id = htmlspecialchars($_POST['order_id'], ENT_QUOTES, 'UTF-8');
        
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$delete_id]);
        if($delete_order->rowCount() > 0) {
            $success_msg[] = "Order deleted successfully!";
        } else {
            $warning_msg[] = "Order not found or already deleted.";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Section</title>
    <link rel="stylesheet" href="css/user_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

        <?php include 'components/user_header.php'; ?>

        <div class="banner">
            <div class="detail">
                <h1>Your Dessert Journey So Far</h1>
                <p>
                    A quick look at the scoops and smiles you've picked so far. <br>
                    Whether it's a single treat or a full dessert haul, your order details are all here. <br>
                    Review, relive, or reorder, your cravings are just a click away. <br>
                </p>
                <span>
                    <a href="home.php">Home</a>
                    <i class="bx bx-right-arrow-alt"></i>Orders
                </span>
            </div>
        </div>
        
        <div class="orders">
            <div class="heading">
                <img src="image/separator-img.png">
                    Total Orders
                <img src="image/separator-img.png">
            </div>

            <div class="box-container">
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
                    $select_orders->execute([$user_id]);

                    if($select_orders->rowCount() > 0) {
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                            $product_id = $fetch_orders['product_id'];
                            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_product->execute([$product_id]);

                            if($select_product->rowCount() > 0) {
                               while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                ?>
                
                <div class="box" 
                    <?php if ($fetch_orders['status'] === 'cancelled') 
                        { echo 'style="border: 2px solid red"'; }
                    ?>
                >
                    <a href="view_order.php?get_id=<?=$fetch_orders['id']; ?>">
                        <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                        <p class="date">
                            <i class="bx bxs-calendar-alt"></i><?= $fetch_orders['date']; ?>
                        </p>
                        
                        <div class="content">
                            <img src="image/shape-19.png" class="shap">
                            <div class="row">
                                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                <p class="price">Price: $<?= $fetch_product['price']; ?></p>
                                <p class="status" 
                                    style="color:
                                    <?php 
                                        if ($fetch_orders['status'] == 'delivered') {
                                            echo "limegreen";
                                        } elseif($fetch_orders['status'] == 'cancelled') {
                                            echo "orange";
                                        } else {
                                            echo "rgb(97, 61, 67)";
                                        }
                                    ?>"
                                >
                                    <?= $fetch_orders['status'];?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                    

                <?php
                                    }
                               }
                        }
                    }  else {
                        echo '<p class="empty">No orders placed yet!</p>';
                    }
                ?>
            </div>
        </div>

      <?php 
        include "components/footer.php";
        include "components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="js/user_script.js"></script>

</body>
</html>