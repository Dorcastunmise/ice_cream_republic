<?php
    include "../components/connect.php";

    if(isset($_POST['submit'])) {

        $email = $_POST['email'];
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        $pass = $_POST['pass'];
        $pass = htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');

        //prepare the sql statement to check matching credentials
        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ? AND password = ?");
        $select_seller->execute(([$email, $pass]));

        $row = $select_seller->fetch(PDO::FETCH_ASSOC);
        if($select_seller->rowCount() > 0) {
            setcookie('seller_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
            header('Location: dashboard.php');
            exit();
        }else {
            $warning_msg[] = 'Incorrected email or password inserted!';
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
    
</head>
<body>
   
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h2 >Login</h2>
            <div class="input-field">
                <label>Email Address <span>*</span></label>
                <input  class="box"
                        type="text" name="email" 
                        placeholder="Enter your email" 
                        maxlength="50"                                
                        required>
            </div>
            <div class="input-field">
                <label>Password <span>*</span></label>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js" integrity="sha512-7VTiy9AhpazBeKQAlhaLRUk+kAMAb8oczljuyJHPsVPWox/QIXDFOnT9DUk1UC8EbnHKRdQowT7sOBe7LAjajQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php include "../components/alert.php";?>
</body>
</html>