<?php

    include 'components/connect.php';
    $user_id = ''; 

    if(isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    } else {
        header('location: login.php');
        exit();
    }

    if(isset($_GET['get_id'])) {
        $get_id = $_GET['get_id'];
    } else {
        $get_id = '';
        header('location: order.php');
    }

    if(isset($_POST['cancel'])) {
        $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
        $update_order->execute(['cancelled', $get_id]);
        $success_msg[] = "Order cancelled successfully!";
        header('location: order.php');
        exit();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Section</title>
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
                <h1>Scoop Summary: Your Order Details 🍦</h1>
                <p>
                    Every order is a step closer to creamy happiness! 💖<br>
                    Below are the details of your selected treats—crafted to delight, packed with care, and ready to bring smiles.<br>
                    Review your scoop summary and get ready to indulge. If you see anything that needs a change, just give us a swirl!
                </p>

                <span>
                    <a href="home.php">Home</a>
                    <i class="bx bx-right-arrow-alt"></i>Order Details
                </span>
            </div>
        </div>
        
        <div class="order-detail">
            <div class="heading">
                <h1>Your Sweet Order Details</h1>
                <p>
                    Here's a full breakdown of your order—sweet, simple, and just the way you like it.<br>
                    Double-check your selections and let the anticipation for dessert begin! 🍨
                </p>
                <img src="image/separator-img.png">
            </div>

            <div class="box-container">
                <?php
                    $grand_total = 0;
                    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
                    $select_order->execute([$get_id]);

                    if($select_order->rowCount() > 0) {
                        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                        $select_product->execute([$fetch_order['product_id']]);

                        if($select_product->rowCount() > 0) {
                            while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                            $sub_total = $fetch_order['price'] * $fetch_order['qty'];
                            $grand_total += $sub_total;
                ?>
                
                <div class="box">
                    <div class="col">
                        <p class="title">
                            <i class="bx bxs-calendar-alt"></i><?= $fetch_order['date']; ?>
                        </p>
                        <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image"
                            alt="<?= $fetch_product['name']; ?>"
                        >
                        <p class="price"><?= $fetch_product['price']; ?></p>
                        <p class="name"><?= $fetch_product['name']; ?></p>
                        <p class="grand-total">
                            Total amount payable: <span>$<?= $sub_total;?></span> 
                        </p>
                    </div>
                    <div class="col">
                        <p class="title">Billing Address</p>
                        <p class="user">
                            <i class="bi bi-person-bounding-box"></i><?= $fetch_order['name']; ?>
                        </p>

                        <p class="user">
                            <i class="bi bi-phone"></i><?= $fetch_order['number']; ?>
                        </p>

                        <p class="user">
                            <i class="bi bi-envelope"></i><?= $fetch_order['email']; ?>
                        </p>

                        <p class="user">
                            <i class="bi bi-pin-map-fill"></i><?= $fetch_order['address']; ?>
                        </p>

                        <p class="status" style="
                                    color:
                                    <?php 
                                        if ($fetch_order['status'] == 'delivered') {
                                            echo "limegreen";         // success
                                        } elseif ($fetch_order['status'] == 'cancelled') {
                                            echo "darkorange";        // warning
                                        } else {
                                            echo "#4244c2ff";           // info / processing (soft blue-violet tone)
                                        }
                                    ?>"
                        >
                            <?php echo $fetch_order['status']; ?>
                        </p>

                        <?php if($fetch_order['status'] == 'cancelled') { ?>
                            <p>Cancelled Order</p>
                            <a href="checkout.php?get_id=<?= $fetch_order['id']; ?>" class="btn"
                                style="line-height: 3;"
                            >
                                Order Again
                            </a>
                        <?php } else { ?>
                            <form action="" method="post">
                                <button name="cancel"
                                        class="btn" type="submit" 
                                        onclick="return confirm('Are you sure you want to cancel this order?');"
                                >
                                    Cancel Order
                                </button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
                    

                <?php
                                }
                            }
                        }
                    } else {
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