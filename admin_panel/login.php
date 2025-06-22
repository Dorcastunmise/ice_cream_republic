<?php
session_start();    
ob_start();
include "../components/connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);


    if(isset($_POST['submit'])) {

        $email = $_POST['email'];
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        $pass = $_POST['pass'];
        
        //prepare the sql statement to check matching credentials
        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
        $select_seller->execute(([$email]));
        if ($select_seller->rowCount() > 0) {
            $row = $select_seller->fetch(PDO::FETCH_ASSOC);

            // Step 2: Verify password
            if (password_verify($pass, $row['password'])) {
                setcookie('seller_id', $row['id'], time() + (60 * 60 * 24 * 30), '/');
                header('Location: dashboard.php');
                exit();
            } else {
                $warning_msg[] = 'Incorrect password!';
            }
        } else {
            $warning_msg[] = 'Incorrect email or password!';
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ice-cream Delights : Seller's Login Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
   
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h2 >Login</h2>
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

        <p class="link">Have no account? <a href="register.php">Register</a></p>
        <input type="submit" name="submit" value="login" class="btn">

        </form>
    </div>
    <?php 
        include "../components/alert.php";
        ob_end_flush(); 
    ?>
</body>
</html>