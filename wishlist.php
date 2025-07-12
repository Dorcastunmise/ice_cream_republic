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

    include 'components/add_wishlist.php';


    //Delete wishlist Item
    if(isset($_POST['delete_item'])) {
        $wishlist_id = htmlspecialchars($_POST['wishlist_id'], ENT_QUOTES, 'UTF-8');

        $verify_delete_item = $conn->prepare("SELECT * FROM `wishlist` WHERE id = ?");
        $verify_delete_item->execute([$wishlist_id]);
         if($verify_delete_item->execute([$wishlist_id])) {
            print_r($wishlist_id);
            echo "<br>";
            print_r($verify_delete_item);
         }
        if($verify_delete_item->rowCount() > 0) {
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
            $delete_wishlist->execute([$wishlist_id]);
            $success_msg[] = 'Item deleted successfully!'; 
           
        } else {
            $warning_msg[] = 'Item has been removed already';
        }
    }

    //Empty wishlist
    if(isset($_POST['empty_wishlist'])) {
        $verify_empty_item = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
        $verify_empty_item->execute([$user_id]);

        if($verify_empty_item->rowCount() > 0) {    
            $empty_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
            $empty_wishlist->execute([$user_id]);
            $success_msg[] = 'Wishlist emptied successfully!'; 
        } else {
            $warning_msg[] = 'Wishlist is completely empty already';
        }
    }

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crème & Co. : User's Wishlist</title>
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
            <h1>Your Wishlist, Your Whim Dearie...<i class="bx bx-book-heart"></i></h1>
            <p>
                At Crème & Co., your wishlist is where dreams chill while you decide. <br>
                It is a cozy corner for all the flavors that caught your eye and captured your taste. <br>
                Whether you're saving a scoop for later or curating your next indulgence, your list is always ready. <br>
                Come back anytime to pick what your heart desires most. <br>
                After all, some cravings are worth the wait. <br>
            </p>

            <span>
                <a href="home.php">Home</a>
                <i class="bx bx-right-arrow-alt"></i>wishlist
            </span>
        </div>
    </div>

    <div class="products">
        <div class="heading">
            <h1>My Wishlist</h1>
            <img src="image/separator-img.png">
        </div>
        <div class="box-container">
            <?php
                $grand_total = 0;

                $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $select_wishlist->execute([$user_id]);

                if ($select_wishlist->rowCount() > 0) {
                    while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                        $select_wishlist_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_wishlist_product->execute([$fetch_wishlist['product_id']]);

                        if ($select_wishlist_product->rowCount() > 0) {
                            $fetch_product = $select_wishlist_product->fetch(PDO::FETCH_ASSOC);
            ?>


            <form action="" method="post"
                    class="box <?php 
                            if($fetch_product['stock'] == 0) {echo 'disabled';}
                        ?>" 
            >
                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
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
                    <div class="button">
                        <div>
                            <h3><?= $fetch_product['name']; ?></h3>
                        </div>                

                        <div>
                            <button type="submit" name="add_to_cart">
                                <i class="bx bx-cart"></i>
                            </button>
                            <a href="view_page.php?pid=<?= $fetch_product['id']; ?>" class="bx bsx-show"></a>
                            <button type="submit" name="delete_item"
                                    onclick="return confirm('Are you sure you want to delete this wishlist?');"
                            >
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="product_id" value="<? $fetch_product['id']; ?>">
                    <div class="flex">
                        <p class="price">Price: <?= $fetch_product['price'];?></p>
                    </div>

                    <div class="flex">
                        <input type="hidden" name="qty" value="1" class="qty"
                                min="1" max="99" maxlength="2" required
                        >
                        <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Buy Now!</a>
                    </div>

                    
                </div>

            </form>
            <?php
                            $grand_total += $fetch_wishlist['price'];
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
                            class="btn" name="empty_wishlist" 
                            type="submit" 
                            onclick="return confirm('Are you sure you want to empty your wishlist?');"
                        >
                        <i class="bx bx-trash-alt"></i>Empty wishlist
                        </button>
                    </form>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
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