<?php
include '../components/connect.php';
$seller_id = ''; // Initialize $seller_id
if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    header('location: login.php');
    exit();
}

// Delete product from the database
if (isset($_POST['delete'])) {
    $product_id = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ? AND seller_id = ?");
    $delete_product->execute([$product_id, $seller_id]);
    if ($delete_product) {
        $warning_msg[] = 'Product deleted successfully!';
    } else {
        $warning_msg[] = 'Failed to delete product!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Products</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="show-post">
            <div class="heading">
                <h1 style="margin-top: 80px;">Products Created by YOU <i class="fas fa-heart"></i></h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
                $select_products->execute([$seller_id]);
                if ($select_products->rowCount() > 0) {
                    while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
                            <?php if ($fetch_product['image'] != '') { ?>
                                <img src="../uploaded_files/<?= $fetch_product['image']; ?>" alt="" class="image">
                            <?php } ?>
                            <div class="status" style="color: <?php if ($fetch_product['status'] == 'active') {
                                                                    echo 'limegreen';
                                                                } else {
                                                                    echo 'coral';
                                                                } ?>;">
                                <?= $fetch_product['status']; ?>
                            </div>
                            <div class="price">$<?= $fetch_product['price']; ?></div>
                            <div class="content">
                                <img src="../image/shape-19.png" alt="" class="shape">
                                <div class="title"><?= $fetch_product['name']; ?></div>
                                <div class="flex-btn">
                                    <a href="edit_products.php?id=<?= $fetch_product['id']; ?>" class="btn">Edit</a>
                                    <button type="submit" name="delete" class="btn"
                                        onclick="return confirm('Are you sure you want to delete this product?');">
                                        Delete
                                    </button>
                                    <a href="read_product.php?post_id=<?= $fetch_product['id']; ?>" class="btn">
                                        Read
                                    </a>
                                </div>
                            </div>

                        </form>
                    <?php

                    }

                } else {
                    echo '<div class="empty">
                            <p>No products added yet!</p>
                            <br>
                            <a href="add_products.php" class="btn" 
                            style="margin-top: 1.5rem;">
                            Add Products
                            </a>
                        </div>';
                }

                ?>
            </div>
        </section>
    </div>
    </div>
    
    <?php
    include "../components/alert.php";
    ob_end_flush();
    ?>
    <script src="../js/admin_script.js"></script>
</body>

</html>