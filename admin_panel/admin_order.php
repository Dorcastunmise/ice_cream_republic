<?php

    include '../components/connect.php';
    $seller_id = ''; // Initialize $seller_id

    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
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
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

    <div class="main-container">
            <?php include '../components/admin_header.php'; ?>

            <section class="order-container">
                <div class="heading">
                    <img src="../image/separator-img.png">
                        Total Orders
                    <img src="../image/separator-img.png">
                </div>

                <div class="box-container">
                    <?php
                        $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
                        $select_order->execute([$seller_id]);
                        if($select_order->rowCount() > 0) {
                            while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                        <div class="box">
                            <div class="status" 
                                style="color: <?php if ($fetch_order['status'] == 'in progress') {
                                echo 'limegreen';
                            } else {
                                echo 'red';
                            } ?>;"                            
                            >
                                <?= $fetch_order['status']; ?>
                            </div>

                            <div class="details">
                                <p>Username: <span><?= $fetch_order['name'];?></span></p>
                                <p>ID: <span><?= $fetch_order['user_id'];?></span></p>
                                <p>Effective Date: <span><?= $fetch_order['date'];?></span></p>
                                <p>Contact: <span><?= $fetch_order['number'];?></span></p>
                                <p>Email: <span><?= $fetch_order['email'];?></span></p>
                                <p>Total Price: <span><?= $fetch_order['price'];?></span></p>
                                <p>Payment method: <span><?= $fetch_order['method'];?></span></p>
                                <p>Delivery Address: <span><?= $fetch_order['address'];?></span></p>
                            </div>
                        
                            <form action="" method="post">
                                <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                                <select name="update_payment" class="box" style="width:90%;">
                                    <option disabled selected><?= $fetch_order['payment_status']; ?></option>
                                    <option value="pending">Pending</option>
                                    <option value="order delivered">Delivered</option>
                                </select>
                                <div class="flex-btn">
                                    <input type="submit" name="update_order" class="btn" value="Update Payment">
                                    <input type="submit" name="delete_order" class="btn" value="Delete Order"
                                    onclick="return confirm('Are you sure you want to delete this order?');">
                                </div>
                            </form>
                        </div>

                    <?php
                            }
                        } else {
                            echo '<div class="empty">
                            <p>No orders placed yet!</p>
                            </div>
                            ';
                        }
                    ?>
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