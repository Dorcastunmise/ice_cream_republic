<?php
session_start();
ob_start();
    include "../components/connect.php";

    if(isset($_POST['submit'])) {
        $id = unique_id();
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $pass = $_POST['pass'];                 
        $cpass = $_POST['cpass'];
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/';

        $image = htmlspecialchars($_FILES['image']['name'], ENT_QUOTES, 'UTF-8');
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id() . '.' . $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/' . $rename;

        // Check if seller already exists
        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
        $select_seller->execute([$email]);

        if($select_seller->rowCount() > 0) {
            $warning_msg[] = 'Email already exists';
        } 
        // Password strength check
        elseif (!preg_match($pattern, $pass)) {
            $error_msg[] = 'Registration Failed!<br>Password requirements:<br>'
                        . '- At least 8 characters<br>'
                        . '- At least one uppercase letter<br>'
                        . '- At least one lowercase letter<br>'
                        . '- At least one number<br>'
                        . '- At least one special character';
        } 
        // Password match check
        elseif($pass !== $cpass) {
            $warning_msg[] = 'Passwords do not match!';
        } 
        // All validations passed — insert into DB
        else {
            // Hash the password before saving
            $hashed_password = password_hash($cpass, PASSWORD_DEFAULT);

            $insert_seller = $conn->prepare("INSERT INTO sellers (id, name, email, password, image) VALUES (?, ?, ?, ?, ?)");
            $insert_seller->execute([$id, $name, $email, $hashed_password, $rename]);

            if($insert_seller) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'Account Registered Successfully!';
            } else {
                $error_msg[] = "Registration Failed!";
            }
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice-cream Delights : Registration Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
   
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h2>Register Now!</h2>

            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>Full Name <span>*</span></p>
                        <input  class="box"
                                type="text" name="name" 
                                placeholder="Enter your name" 
                                maxlength="50"                                
                                required>
                    </div>
                    <div class="input-field">
                        <p>Email Address <span>*</span></p>
                        <input  class="box"
                                type="text" name="email" 
                                placeholder="Enter your email" 
                                maxlength="50"                                
                                required>
                    </div>

                    <div class="input-field">
                        <p>Password <span>*</span></p>
                        <input  class="box"
                                type="password" name="pass" 
                                placeholder="Enter your password" 
                                maxlength="50"                                
                                required>
                    </div>
                    <div class="input-field">
                        <p>Confirm Password<span>*</span></p>
                        <input  class="box"
                                type="password" name="cpass" 
                                placeholder="confirm your password" 
                                maxlength="50"                                
                                required>
                    </div>
                </div>
            </div>

        <div class="input-field">
            <p>Profile Picture <span>*</span></p>
            <input class="box" type="file" name="image" accept="image/*" required>
        </div>

        <p class="link">Already have an account? <a href="login.php">Login into account</a></p>
        <input type="submit" name="submit" value="register" class="btn">

        </form>
    </div>
    <?php include "../components/alert.php";?>
</body>
</html>