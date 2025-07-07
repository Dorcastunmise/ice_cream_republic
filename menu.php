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
    <title>Crème & Co. : User's Login Page</title>
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
            <h1>Crème & Co. Shop</h1>
            <p>
                Discover pure delight at Crème & Co., where every scoop is crafted to bring a smile. <br>
                From creamy classics to adventurous new flavors, our ice cream varieties are made with care and creativity. <br>
                Whether you're craving a sweet solo treat or sharing a dessert moment with loved ones, there's something special here for everyone. <br>
                Customers from all over stop by to cool off, celebrate, and enjoy a taste that lingers long after the last bite. <br>
                Come in and find your new favorite flavor. There's always something fresh and delicious waiting for you. <br>
            </p>
            <span>
                <a href="home.php">Home</a>
                <i class="bx bx-right-arrow-alt"></i>Supermarket
            </span>
        </div>
    </div>

    <div class="products">
        <div class="heading">
            <h1>Latest Flavour Released</h1>
            <img src="image/separator-img.png"</h1>
        </div>
        <div class="box-container">
            <?php
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                $select_products->execute(['active']);
                if ($select_products->rowCount() > 0) {
                    while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <form action="" method="post"
                    class="box <?php 
                            if($fetch_product['stock'] == 0) {echo 'disabled';}
                        ?>" 
            >
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
                            <h3 class="name"><?= $fetch_product['name']; ?></h3>
                        </div>
                        <div>
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            <button type="submit" name="add_to_wishlist"><i class="bx bx-wishlist"></i></button>
                            <a href="view_page.php?pid=<?= $fetch_product['id']; ?>" class="bx bxs-show"></a>
                        </div> 
                    </div>
                    <p class="price">Price: <?= $fetch_product['price']; ?></p>
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                    <div class="flex-btn">
                        <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Buy Now</a>
                        <input type="number" min="1" max="99" value="1" name="qty" class="qty" maxlength="2" required>
                    </div>
                </div>

            </form>
            <?php
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
    </div>

    
    <?php 
        include "components/footer.php";
        include "components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="js/user_script.js"></script>

</body>
</html>