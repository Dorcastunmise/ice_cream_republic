<?php

    include '../components/connect.php';
    $seller_id = ''; // Initialize $seller_id

    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        header('location: login.php');
        exit();
    }

    // Retrieve product id from form
    if(isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
    } elseif(isset($_GET['id'])) {
        $product_id = $_GET['id'];
    } else {
        $product_id = '';
    }


    //Edit product
    if(isset($_POST['update'])) {
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
        $detail = htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8');
        $stock = htmlspecialchars($_POST['stock'], ENT_QUOTES, 'UTF-8');
        $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');

        $update_product = $conn->prepare("UPDATE products SET name = ?, price = ?, product_detail = ?, stock = ?, status = ? 
                                        WHERE id = ?");
        $update_product->execute([$name, $price, $detail, $stock, $status, $product_id]);
        $success_msg[] = 'Product updated successfully!';

        //handle image update
        $old_image = $_POST['old_image'];
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_folder = '../uploaded_files/' . $image;
        $image_tmp_name = $_FILES['image']['tmp_name'];

        $seller_image = $conn->prepare("SELECT * FROM products WHERE image = ? AND seller_id = ?");
        $seller_image->execute([$image, $seller_id]);

        if(isset($image) && !empty($image)) { 
            if($image_size > 2000000) {
                $warning_msg[] = 'Image too large to upload (over 2MB)!';
            } else if(!in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                $warning_msg[] = 'Invalid image format!';
            } else if($seller_image->rowCount() > 0) {
                $warning_msg[] = 'Please rename the image to avoid conflicts';
                move_uploaded_file($image_tmp_name, $image_folder);
            } else {
                $update_image = $conn->prepare("UPDATE products SET image = ? WHERE id = ?");
                $update_image->execute([$image, $product_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                //remove old image if different and not empty
                if($old_image != $image && !empty($old_image)) {
                    unlink('../uploaded_files/' . $old_image);
                }
                $success_msg[] = 'Image updated successfully!';

            }
             
        } 

    }

    /*Delete Image */
    //delete products
    if(isset($_POST['delete_image'])) {
        $product_id = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');
        
        //Fetch both product details and its image
        $delete_image = $conn->prepare("SELECT image FROM products WHERE id = ? AND seller_id = ?");
        $delete_image->execute([$product_id, $seller_id]);
        $fetch_image = $delete_image->fetch(PDO::FETCH_ASSOC);

        if($fetch_image && !empty($fetch_image['image'])) {
            unlink('../uploaded_files/' . $fetch_image['image']);
            
            $update_image = $conn->prepare("UPDATE products SET image = '' WHERE id = ?");
            $update_image->execute([$product_id]);
            $success_msg[] = 'Image deleted successfully!';
        }

    }

    //Delete product
    if(isset($_POST['delete_product'])) {
        $product_id = htmlspecialchars($_POST['product_id'], ENT_QUOTES, 'UTF-8');

        $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $delete_image->execute([$product_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
        if($fetch_delete_image['image'] != '') {
            unlink('../uploaded_files/' . $fetch_delete_image['image']);
        }

        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $delete_product->execute([$product_id]);
        $success_msg[] = 'Product deleted successfully!';   

        header('location: view_products.php');
        exit();

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Products</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
            <section class="post-editor">
                <div class="heading">
                    <h1>Edit Products</h1>
                    <img src="../image/separator-img.png" alt="">
                </div>

                <div class="box-container">
                    <?php
                        $product_id = $_GET['id'];
                        $select_product = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
                        $select_product->execute([$product_id, $seller_id]);
                        if($select_product->rowCount() > 0) {
                            while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                        
                    ?>
                    <div class="form-container">
                        <form action="" method="POST" enctype="multipart/form-data" class="register">
                            <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                            <div class="input-field">
                                <p>Product Status <span>*</span></p>
                                <select name="status" class="box">
                                    <option value="<?= $fetch_product['status']; ?>" selected>
                                        <?= $fetch_product['status']; ?>
                                    </option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <p>Product Name <span>*</span></p>
                                <input type="text" class="box" name="name" value="<?= $fetch_product['name']; ?>" required>
                            </div>

                            <div class="input-field">
                                <p>Product Price <span>*</span></p>
                                <input type="number" class="box" name="price" value="<?= $fetch_product['price']; ?>" required>
                            </div>

                            <div class="input-field">
                                <p>Product Detail <span>*</span></p>
                                <textarea class="box" name="detail" required><?= $fetch_product['product_detail']; ?></textarea>
                            </div>

                            <div class="input-field">
                                <p>Product Stock <span>*</span></p>
                                <input class="box" type="number"
                                        value="<?= $fetch_product['stock']; ?>"
                                        min="0" max="9999999999" maxlength="10" 
                                        name="stock" required>
                            </div>

                            <div class="input-field">
                                <p>Product Image <span>*</span></p>
                                <input class="box" type="file" name="image" accept="image/*">
                                <?php if($fetch_product['image'] != ''): ?>
                                    <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                                    <div class="flex-btn">
                                        <input type="submit" name="delete_image" class="btn" value="delete image">
                                        <a href="view_products.php" class="btn" style="width: 40%;
                                        text-align: center; height: 3rem; margin-top: .7rem"
                                        >
                                        Go Back
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="flex-btn">
                                <input type="submit" name="update" class="btn" value="update product">
                                <input type="submit" name="delete_product" class="btn" value="delete product">
                            </div>                    
                        </form>
                        <?php 
                            }
                        } else { ?>
                        <div class="empty">
                            <p>No product added yet!</p>
                        </div>

                        <?php } ?>
                    </div>
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