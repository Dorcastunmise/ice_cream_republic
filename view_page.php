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
            <h1>Sweet Scoop Details</h1>
            <p>
                Here's everything you need to know about this tasty treat. <br>
                From the flavor to the feel, it's made to melt your heart. <br>
                Take a look, fall in love, and get ready to enjoy every bite. <br>
            </p>
            <span>
                <a href="home.php">Home</a>
                <i class="bx bx-right-arrow-alt"></i>What Makes This Sweet
            </span>
        </div>
    </div>

    <section class="view_page">
        <div class="heading">
            <h1>Your Tasty Pick</h1>
            <img src="image/separator-img.png">
        </div>

        <?php
            if(isset($_GET['pid'])) {
                $product_id = htmlspecialchars($_GET['pid'], ENT_QUOTES, 'UTF-8');
                
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_products->execute([$product_id]);

                if ($select_products->rowCount() > 0) {
                    while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>

        <form action="" method="post" class="box">
            <div class="img-box">
                <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="">
            </div>

            <div class="detail">
                <?php if($fetch_product['stock'] > 9) { ?>
                    <span class="stock" style="color:green;">In stock</span>
                <?php } elseif($fetch_product['stock'] > 0) { ?>
                    <span class="stock" style="color:orange;">Hurry... Only <?= $fetch_product['stock']; ?> left!</span>
                <?php } else { ?>
                    <span class="stock" style="color:red;">Out of stock</span>
                <?php } ?>
                <p class="price">$<?= $fetch_product['price'];?></p>
                <div class="name"><?= $fetch_product['name']; ?></div>
                <p class="product_detail"><?= $fetch_product['product_detail']; ?></p>

                 <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                <div class="button">
                    <br><br>
                    <button type="submit" name="add_to_wishlist" class="btn">
                        Add to Wishlist <i class="bx bx-heart"></i>
                    </button>
                    <input type="hidden" name="qty" value="1" min="0" class="quantity">
                    <button type="submit" name="add_to_cart" class="btn">
                        Add to Cart <i class="bx bx-cart"></i>
                    </button>
                </div>
            </div>

        </form>

        <?php
                    }
                }
            }
        ?>
    </section>

    <div class="products">
        <div class="heading">
            <h1>More Flavors You'll Love</h1>
                <p>
                    Craving more? Check out these yummy picks that go great with your taste. <br>
                    From creamy classics to bold new blends, there's always something special waiting. <br>
                    Explore and find your next favorite scoop! <br>
                </p>
            <img src="image/separator-img.png">
        </div>
        <?php include 'components/shop.php';?>
    </div>
    
    <?php 
        include "components/footer.php";
        include "components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="js/user_script.js"></script>

</body>
</html>