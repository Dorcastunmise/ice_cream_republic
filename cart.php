<?php
    session_start();    
    ob_start();
    include "components/connect.php";

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(1);

    if(isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    } else {
        $user_id = '';
    }

    //Update Cart
    if(isset($_POST['update_cart'])) {
        $cart_id = htmlspecialchars($_POST['cart_id'], ENT_QUOTES, 'UTF-8');
        $qty = htmlspecialchars($_POST['qty'], ENT_QUOTES, 'UTF-8');

        $update_cart = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id = ?");
        $update_cart->execute([$qty, $cart_id]);
        $success_msg[] = 'Cart updated successfully!';    
    }

    //Delete Cart Item
    if(isset($_POST['delete_item'])) {
        $cart_id = htmlspecialchars($_POST['cart_id'], ENT_QUOTES, 'UTF-8');

        $verify_delete_item = $conn->prepare("SELECT * FROM `cart` WHERE id = ?");
        $verify_delete_item->execute([$cart_id]);

        if($verify_delete_item->rowCount() > 0) {
            $delete_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
            $delete_item->execute([$cart_id]);
            $success_msg[] = 'Item deleted successfully!'; 
           
        } else {
            $warning_msg[] = 'Item deleted already';
        }
    }
    
    //Empty Cart
    if(isset($_POST['empty_cart'])) {
        $verify_empty_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $verify_empty_item->execute([$user_id]);

        if($verify_empty_item->rowCount() > 0) {    
            $empty_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $empty_cart->execute([$user_id]);
            $success_msg[] = 'Cart emptied successfully!'; 
        } else {
            $warning_msg[] = 'Cart is completely empty already';
        }
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crème & Co. : User's Cart</title>
    <link rel="stylesheet" href="css/user_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
   
    <?php
        include 'components/user_header.php';
    ?>
    <div class="banner">
        <div class="detail">
            <h1>Your Cart, Your Taste Dearie...<i class="bx bx-heart-square"></i></h1>
            <p>
                At Crème & Co., your shopping cart is more than just a list of items. It is a reflection of your cravings and your moments of joy. <br>
                Each flavor you select brings you closer to a sweet experience made with care and creativity. <br>
                Whether you are preparing for a quiet evening or planning to share with others, your cart holds something delightful. <br>
                Take your time, explore more, and trust that your chosen treats will be ready when you are. <br>
                The perfect scoop is never far away. <br>
            </p>
            <span>
                <a href="home.php">Home</a>
                <i class="bx bx-right-arrow-alt"></i>Cart
            </span>
        </div>
    </div>

    <div class="products">
        <div class="heading">
            <h1>My Cart</h1>
            <img src="image/separator-img.png">
        </div>
        <div class="box-container">
            <?php
                $grand_total = 0;

                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $select_cart->execute([$user_id]);

                if ($select_cart->rowCount() > 0) {
                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        $select_cart_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_cart_product->execute([$fetch_cart['product_id']]);

                        if ($select_cart_product->rowCount() > 0) {
                            $fetch_product = $select_cart_product->fetch(PDO::FETCH_ASSOC);
            ?>


            <form action="" method="post"
                    class="box <?php 
                            if($fetch_product['stock'] == 0) {echo 'disabled';}
                        ?>" 
            >
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="">

                <?php if($fetch_product['stock'] > 1) { ?>
                    <span class="stock" style="color:green;">In stock</span>
                <?php } elseif($fetch_product['stock'] > 0) { ?>
                    <span class="stock" style="color:orange;">Hurry... Only <?= $fetch_product['stock']; ?> left!</span>
                <?php } else { ?>
                    <span class="stock" style="color:red;">Out of stock</span>
                <?php } ?>

                <div class="content">
                    <img src="image/shape-19.png" class="shap" alt="">
                    <h3 class="name"><?= $fetch_product['name']; ?></h3>

                    <div class="flex-btn">
                        <p class="price">Price: <?= $fetch_product['price']; ?></p>
                        <input type="number" min="1" max="99" 
                                value="<?= $fetch_product['price']; ?>" 
                                name="qty" class="qty" maxlength="2" required
                        >
                        <button type="submit" name="update_cart" class="fa fa-edit box"></button>
                    </div>
                    
                    <div class="flex-btn">
                        <a class="sub-total">Sub Total: 
                            <span>
                                <?= $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);?>
                            </span>
                        </a>
                        <button 
                            type="submit" name="delete_item" 
                            class="btn" onclick="return confirm('Are you sure you want to delete this item?');"
                        >
                        <i class="bxs-trash"></i>Delete
                        </button>
                    </div>
                </div>

            </form>
            <?php
                        $grand_total += $sub_total;
                    } else {
                        echo '
                        <div class="empty">
                            <p>No products added yet!</p>
                        </div>
                    ';
                    }
                }
            } else {
                    echo '
                        <div class="empty">
                            <p>No products added yet!</p>
                        </div>
                    ';
            }
                    
            ?>
        </div>

        <?php if($grand_total > 0) { ?>
            <div class="cart-total">
                <p>Total amount payable: <span>$<?= $grand_total;?></span></p>
                <div class="button">
                    <form action="" method="post">
                        <button 
                            class="btn" name="empty_cart" 
                            type="submit" 
                            onclick="return confirm('Are you sure you want to empty your cart?');"
                        >
                        <i class="bx bx-trash-alt"></i>Empty Cart
                        </button>
                    </form>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
        <?php } ?>
    </div>

    
    <?php 
        include "components/footer.php";
        include "components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="js/user_script.js"></script>

</body>
</html>