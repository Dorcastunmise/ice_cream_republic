<?php

    include "../components/connect.php";

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $seller_id = ''; // Initialize $seller_id
    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        header('location: login.php');
        exit();
    }

    if(isset($_POST['submit'])) {

        // Prepare the SQL statement to fetch the current profile
        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE id = ? LIMIT 1");
        $select_seller->execute([$seller_id]);
        $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC);

        $prev_password = $fetch_seller['password'];
        $prev_image = $fetch_seller['image'];

        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        
        //Name update
        if(!empty($name)) {
            $update_name = $conn->prepare("UPDATE sellers SET name = ? WHERE id = ?");
            $update_name->execute([$name, $seller_id]);
            $success_msg[] = 'Name updated successfully!';
        }
        
        //Email update
        if(!empty($email)) {
            $select_email = $conn->prepare("SELECT * FROM sellers WHERE email = ? AND id = ?");
            $select_email->execute([$email, $seller_id]);
            if($select_email->rowCount() > 0) {
                $warning_msg[] = 'Email already exists!';
            } else {
                $update_email = $conn->prepare("UPDATE sellers SET email = ? WHERE id = ?");
                $update_email->execute([$email, $seller_id]);
                $success_msg[] = 'Email updated successfully!';
            }
        }

        //Image update
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image']['name'];
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $rename = unique_id() . '.' . $ext;
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name']; 
            $image_folder = '../uploaded_files/' . $rename; 
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            if(!empty($image)) {
                if(!in_array($ext, $allowed_extensions)) {
                    $warning_msg[] = 'Invalid image format! Please upload a JPG, JPEG, PNG, or GIF image.';
                } elseif($image_size > 2000000) {       
                    $warning_msg[] = 'Image size is too large! Please upload an image smaller than 2MB.';
                } else {
                    // Update the image in the database
                    $update_image = $conn->prepare("UPDATE sellers SET image = ? WHERE id = ?");
                    $update_image->execute([$rename, $seller_id]);
                    move_uploaded_file($image_tmp_name, $image_folder);
                    
                    // Delete the previous image if it exists
                    if(file_exists('../uploaded_files/' . $prev_image)) {
                        unlink('../uploaded_files/' . $prev_image);
                    }

                    $success_msg[] = 'Image updated successfully!';
                }
            }
        }

        //Password update
        $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];                 
        $cpass = $_POST['cpass'];

        if($old_pass != $empty_pass) {
            echo $prev_password . '<==>' . $old_pass;
            $old_and_db = password_verify($old_pass, $prev_password);

            if(!$old_and_db) {
                $warning_msg[] = 'Old password is incorrect!';
            } elseif($new_pass != $cpass) {
                $warning_msg[] = 'New password and confirm password do not match!';
            } else {
                if($new_pass != $empty_pass) {
                    $update_password = $conn->prepare("UPDATE sellers SET password = ? WHERE id = ?");
                    $update_password->execute([password_hash($cpass, PASSWORD_DEFAULT), $seller_id]);
                    $success_msg[] = 'Password updated successfully!';
                } else {
                    $warning_msg[] = 'New password cannot be empty!';
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
    <title>Update Profile</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="form-container">
            <div class="heading">
                <h1>Update Profile Details</h1>
                <img src="../image/separator-img.png" alt="">
            </div>

            <form action="" method="post" enctype="multipart/form-data" class="register">
                <div class="img-box">
                    <img src="../uploaded_files/<?=$fetch_profile['image'];?>" alt="">
                </div>
                <div class="flex">
                    <div class="col">
                        <div class="input-field">
                            <p>Name <span>*</span></p>
                            <input class="box" type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>">
                        </div>
                        <div class="input-field">
                            <p>email <span>*</span></p>
                            <input class="box" type="text" name="email" placeholder="<?= $fetch_profile['email']; ?>">
                        </div>
                        <div class="input-field">
                            <p>Select Picture <span>*</span></p>
                            <input class="box" type="file" name="image" accept="image/*">
                        </div>
                    </div>

                    <div class="col">
                        <div class="input-field">
                            <p>Old Password <span>*</span></p>
                            <input class="box" type="password" name="old_pass" placeholder="Enter old password">
                        </div>
                        <div class="input-field">
                            <p>New Password <span>*</span></p>
                            <input class="box" type="password" name="new_pass" placeholder="Enter new password">
                        </div>
                        <div class="input-field">
                            <p>Confirm New Password <span>*</span></p>
                            <input class="box" type="password" name="cpass" placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <input type="submit" name="submit" id="submit" class="btn" value="Update Profile">

            </form>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <?php 
        include "../components/alert.php";
    ?>
    <script src="../js/admin_script.js"></script>
   
</body>
</html>