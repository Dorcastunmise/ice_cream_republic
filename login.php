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

    if(isset($_POST['submit'])) {

        $email = $_POST['email'];
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        $pass = $_POST['pass'];
        
        //prepare the sql statement to check matching credentials
        $select_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $select_user->execute(([$email, $pass]));
        if ($select_user->rowCount() > 0) {
            $row = $select_user->fetch(PDO::FETCH_ASSOC);

            // Step 2: Verify password
            if (password_verify($pass, $row['password'])) {
                setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30), '/');
                header('Location: home.php');
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
            <h1>Register</h1>
            <p>Login to your account today and unlock exclusive offers, special treats, and member-only perks.<br>
                It's quick, easy, and totally worth it!<br>
                Feel free to sign up if you don't have an account.<br>
            </p>
            <span>
                <a href="home.php">Home</a>
                <i class="bx bx-right-arrow-alt"></i>Login
            </span>
        </div>
    </div>

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
        include "components/footer.php";
        include "components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="js/user_script.js"></script>

</body>
</html>