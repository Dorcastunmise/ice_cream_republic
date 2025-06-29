<?php
    include '../components/connect.php';
    $seller_id = ''; // Initialize $seller_id
    if (isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        header('location: login.php');
        exit();
    }

    $get_id = $_GET['post_id'];
    //delete products
    if (isset($_POST['delete'])) {
    $p_id = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');
    $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ? AND seller_id = ?");
    $delete_image->execute([$p_id, $seller_id]);
    
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_delete_image['image'] != '') {
        unlink('../uploaded_files/' . $fetch_delete_image['image']);
    }

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ? AND seller_id = ?");
    $delete_product->execute([$p_id, $seller_id]);
    header('location: view_products.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Products</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="read_post">
            <div class="heading">
                <h1>Product Detail</h1>
                <img src="../image/separator-img.png" alt="">
            </div>

            <div class="box-container">
                <?php
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? AND seller_id = ?");
                $select_product->execute([$get_id, $seller_id]);
                if ($select_product->rowCount() > 0) {
                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                        <div class="status" style="color: <?php if ($fetch_product['status'] == 'active') {
                                                                    echo 'limegreen';
                                                                } else {
                                                                    echo 'coral';
                                                                } ?>;">
                                <?= $fetch_product['status']; ?>
                        </div>

                        <?php if ($fetch_product['image'] != '') { ?>
                                <img src="../uploaded_files/<?= $fetch_product['image']; ?>" alt="" class="image">
                        <?php } ?>
                        <div class="price">$<?= $fetch_product['price']; ?></div>
                        <div class="title"><?= $fetch_product['name']; ?></div>
                        <div class="content"><?= $fetch_product['product_detail']; ?></div>

                        <div class="flex-btn">
                            <a href="edit_products.php?id=<?= $fetch_product['id']; ?>" class="btn">Edit</a>
                            <button type="submit" name="delete" class="btn"
                                onclick="return confirm('Are you sure you want to delete this product?');">
                                Delete
                            </button>
                        </div>
                    </form>                    
                <?php
                    }                       
                } else {
                    ?>
                    <div class="empty">
                        <p>No products added yet!</p>
                        <br>
                        <a href="add_products.php" class="btn" 
                        style="margin-top: 1.5rem;">
                        Add Products
                        </a>
                    </div>
                <?php
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