<?php

    include '../components/connect.php';
    $seller_id = ''; // Initialize $seller_id
    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        header('location: login.php');
        exit();
    }

    //add product to the database
    if(isset($_POST['publish'])) {
        $id = unique_id();
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
        $detail = htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8');
        $stock = htmlspecialchars($_POST['stock'], ENT_QUOTES, 'UTF-8');
        $status = 'published';

        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_folder = '../uploaded_files/' . $image;
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $seller_image = $conn->prepare("SELECT * FROM products WHERE image = ? AND seller_id = ?");
        $seller_image->execute([$image, $seller_id]);

        if(isset($image)) {
            if ($seller_image->rowCount() > 0) {
                $warning_msg[] = 'Image already exists!';
            } else {
                if($image_size > 2000000) {
                    $warning_msg[] = 'Image size is too large!';
                } else if(!in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $warning_msg[] = 'Invalid image format!';
                } else {
                    move_uploaded_file($image_tmp_name, $image_folder);
                }
            }
        } else {
            $image = '';
        }

        if(empty($name) || empty($price) || empty($detail) || empty($stock) || empty($image)) {
                $warning_msg[] = 'Please fill all the fields!';
        } else {
            if( ($seller_image->rowCount() > 0) && $image != '') {
                $warning_msg = 'Please rename the image!';
            } else {
                $insert_product = $conn->prepare("INSERT INTO products (id, name, price, product_detail, stock, image, status, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_product->execute([$id, $name, $price, $detail, $stock, $image, $status, $seller_id]);

                if($insert_product) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $warning_msg[] = 'Product added successfully!';
                } else {
                    $warning_msg[] = 'Failed to add product!';
                }
            }
        }
    }

    //add product to the database as draft
    if(isset($_POST['draft'])) {
        $id = unique_id();
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
        $detail = htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8');
        $stock = htmlspecialchars($_POST['stock'], ENT_QUOTES, 'UTF-8');
        $status = 'draft';

        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_folder = '../uploaded_files/' . $image;
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $seller_image = $conn->prepare("SELECT * FROM products WHERE image = ? AND seller_id = ?");
        $seller_image->execute([$image, $seller_id]);

        if(isset($image)) {
            if ($seller_image->rowCount() > 0) {
                $warning_msg[] = 'Image already exists!';
            } else {
                if($image_size > 2000000) {
                    $warning_msg[] = 'Image size is too large!';
                } else if(!in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $warning_msg[] = 'Invalid image format!';
                } else {
                    move_uploaded_file($image_tmp_name, $image_folder);
                }
            }
        } else {
            $image = '';
        }

        if(empty($name) || empty($price) || empty($detail) || empty($stock) || empty($image)) {
                $warning_msg[] = 'Please fill all the fields!';
        } else {
            if( ($seller_image->rowCount() > 0) && $image != '') {
                $warning_msg = 'Please rename the image!';
            } else {
                $insert_product = $conn->prepare("INSERT INTO products (id, name, price, product_detail, stock, image, status, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_product->execute([$id, $name, $price, $detail, $stock, $image, $status, $seller_id]);

                if($insert_product) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $warning_msg[] = 'Product saved as a draft successfully!';
                } else {
                    $warning_msg[] = 'Failed to add product!';
                }
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
            <div class="post-editor">
                <div class="heading">
                    <h1>Add Products</h1>
                    <img src="../image/separator-img.png" alt="">
                </div>
                <div class="form-container">
                    <form action="" method="POST" enctype="multipart/form-data" class="register">
                        <div class="input-field">
                            <p>Product Name <span>*</span></p>
                            <input class="box" type="text" name="name" placeholder="Include Product Name" required>
                        </div>
                        <div class="input-field">
                            <p>Product Price <span>*</span></p>
                            <input class="box" type="text" name="price" placeholder="Include Product Price" maxlength="100" required>
                        </div>
                        <div class="input-field">
                            <p>Product Detail <span>*</span></p>
                            <textarea class="box" name="detail" placeholder="Include Product detail" maxlength="1000" required></textarea>
                        </div>
                        <div class="input-field">
                            <p>Product Stock <span>*</span></p>
                            <input class="box" type="number" name="stock" placeholder="Include Product stock" maxlength="10" 
                            min="0" max="9999999999" required>
                        </div>
                        <div class="input-field">
                            <p>Product Image <span>*</span></p>
                            <input class="box" type="file" name="image" accept="image/*"
                            required>
                        </div>
                        <div class="flex-btn">
                            <input type="submit" name="publish" class="btn" value="add product">
                            <input type="submit" name="draft" class="btn" value="save as draft">
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <?php 
        include "../components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js" integrity="sha512-7VTiy9AhpazBeKQAlhaLRUk+kAMAb8oczljuyJHPsVPWox/QIXDFOnT9DUk1UC8EbnHKRdQowT7sOBe7LAjajQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../js/admin_script.js"></script>
   
</body>
</html>