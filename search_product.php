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

    include "components/add_wishlist.php";
    include "components/add_cart.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crème & Co. : Product Search</title>
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
            <h1>Find your Flavour</h1>
            <p>
                Can't decide? Start typing to explore scoops that match your cravings.
            </p>
            <span>
                <a href="home.php">Home</a>
                <i class="bx bx-right-arrow-alt"></i>Search Product
            </span>
        </div>
    </div>

    <div class="products">
        <div class="heading">
            <h1>Search</h1>
            <img src="image/separator-img.png">
        </div>
        <div class="box-container">
            <?php
                if(isset($_POST['search_product']) || isset($_POST['search_product_btn'])) { 
                    $search_product = htmlspecialchars($_POST['search_product'], ENT_QUOTES, 'UTF-8');
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ? AND status = ?");
                    $select_products->execute(['%'.$search_product.'%','active']);

                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <form action="" method="post"
                    class="box <?php 
                            if($fetch_products['stock'] == 0) {echo 'disabled';}
                        ?>" 
            >
                <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image" alt="">
                <?php if($fetch_products['stock'] > 1) { ?>
                    <span class="stock" style="color:green;">In stock</span>
                <?php } elseif($fetch_products['stock'] > 0) { ?>
                    <span class="stock" style="color:orange;">Hurry... Only <?= $fetch_products['stock']; ?> left!</span>
                <?php } else { ?>
                    <span class="stock" style="color:red;">Out of stock</span>
                <?php } ?>

                <div class="content">
                    <img src="image/shape-19.png" class="shap" alt="">
                    <div class="button">
                        <div>
                            <h3 class="name"><?= $fetch_products['name']; ?></h3>
                        </div>
                        <div>
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            <button type="submit" name="add_to_wishlist"><i class="bx bx-heart-square"></i></button>
                            <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
                        </div> 
                    </div>
                    <p class="price">Price: <?= $fetch_products['price']; ?></p>
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                    <div class="flex-btn">
                        <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Buy Now</a>
                        <input type="number" min="1" max="99" value="1" name="qty" class="qty" maxlength="2" required>
                    </div>
                </div>

            </form>
            <?php
                        }
                    } else {
                        echo '
                            <div class="empty">
                                <p>No products found!</p>
                            </div>
                        ';
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>Please search for something else.</p>
                        </div>
                    ';
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