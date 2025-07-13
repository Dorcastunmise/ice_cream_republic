<?php
session_start();
ob_start();
include "components/connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['send_message'])) {
    if($user_id != '') {
        $id = unique_id();
        $name = trim(htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'));
        $email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));
        $subject = trim(htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8'));
        $message = trim(htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8'));

        $verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");
        $verify_message->execute([$user_id, $name, $email, $subject, $message]);

        if($verify_message->rowCount() > 0) {
            $warning_msg[] = "Message already sent!";
        } else {
            $insert_message = $conn->prepare("INSERT INTO `message` (id, user_id, name, email, subject, message)
                                    VALUES (?, ?, ?, ?, ?, ?)");
            $insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);      
            $success_msg[] = "Your thoughts have been shared. Thank you! We appreciate your feedback.";     
        }
    } else {
        $warning_msg[] = "You are not logged in!";
    }
    
}
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Section</title>
    <link rel="stylesheet" href="css/user_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

        <?php include 'components/user_header.php'; ?>

        <div class="banner">
            <div class="detail">
                <h1>Get in Touch with Crème & Co.</h1>
                <p>
                    Whether you're looking for more scoop info, want to leave a sweet review, or just have something on your mind, we're all ears! <br>
                    At Crème & Co., every message matters. <br>
                    Reach out and we'll get back to you as quickly as possible. <br>
                    We can't wait to connect with you!
                </p>

                <span>
                    <a href="home.php">Home</a>
                    <i class="bx bx-right-arrow-alt"></i>Contact
                </span>
            </div>
        </div>
        
        <div class="services">
            <div class="heading">
                <h1>Our Services</h1>
                <p>
                    At Crème & Co., we go beyond scoops and cones. <br>
                    From personalized ice cream cakes to event catering and doorstep deliveries, our services are crafted to sweeten every moment. <br>
                    Whatever your craving or occasion, we're here to serve smiles with every swirl. <br>
                    Take a peek at what we offer, your next treat might be just a click away!
                </p>
                <img src="image/separator-img.png">            
            </div>

            <div class="box-container">
                <div class="box">
                    <img src="image/0.png" alt="">
                    <div>
                        <h1>Free Fast Shipping</h1>
                        <p>
                            Enjoy your favorite scoops without stepping out! <br>
                            At Crème & Co., we offer free delivery to bring happiness right to your doorstep. <br>
                            Whether it's a solo indulgence or a family treat, we make sure it gets to you fresh, fast, and frozen just right. <br>
                            No fees, no fuss, just sweet convenience.
                        </p>
                    </div>
                </div>

                <div class="box">
                    <img src="image/1.png" alt="">
                    <div>
                        <h1>Money Back & Guarantee</h1>
                        <p>
                            We believe in our scoops, and we believe in your satisfaction. <br>
                            If something isn't right with your order, we've got your back. <br>
                            Our money-back guarantee ensures peace of mind with every purchase. <br>
                            Because at Crème & Co., your happiness is always on the menu!
                        </p>
                    </div>
                </div>

                <div class="box">
                    <img src="image/2.png" alt="">
                    <div>
                        <h1>Online Support 24/7</h1>
                        <p>
                            Questions? Cravings? Concerns? We're here around the clock just for you. <br>
                            Whether you need help with an order or just want to chat about flavors, our friendly support team is always ready. <br>
                            Reach out anytime, because at Crème & Co., sweet service never sleeps.
                        </p>

                    </div>
                </div>

                

                <div class="box">
                    <img src="image/0.png" alt="">
                    <div>
                        <h1>Free Delivery</h1>
                        <p>
                            Enjoy your favorite scoops without stepping out! <br>
                            At Crème & Co., we offer free delivery to bring happiness right to your doorstep. <br>
                            Whether it's a solo indulgence or a family treat, we make sure it gets to you fresh, fast, and frozen just right. <br>
                            No fees, no fuss, just sweet convenience.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-container">
            <div class="heading">
                <h1>Contact Us</h1>
                <p>
                    Have questions, feedback, or just want to say hi? <br>
                    We're here to help make your experience as sweet as our scoops. <br>
                    Reach out anytime, whether it's about an order, our flavors, or just a sprinkle of curiosity. <br>
                    At Crème & Co., your voice always matters.
                </p>
                <img src="image/separator-img.png">
            </div>
            <form action="" class="register" method="post">
                <div class="input-field">
                    <label> Name <sup>*</sup></label>
                    <input type="text" name="name" class="box" placeholder="Enter your name" required>
                </div>

                <div class="input-field">
                    <label> Email <sup>*</sup></label>
                    <input type="email" name="email" class="box" placeholder="Enter your email" required>
                </div>

                <div class="input-field">
                    <label> Subject <sup>*</sup></label>
                    <input type="text" name="subject" class="box" placeholder="Reason..." required>
                </div>

                <div class="input-field">
                    <label> Comment <sup>*</sup></label>
                    <textarea name="message" cols="30" rows="10" class="box" placeholder="Your comment" required>
                    </textarea>
                </div>

                <button type="submit" name="send_message" class="btn">Send</button>
            </form>
        </div>

        <div class="address">
            <div class="heading">
                <h1>Our Contact Details</h1>
                <p>
                    Have questions, feedback, or just want to chat about your favorite flavor? <br>
                    We'd love to hear from you! Our team is just a message away, ready to help and always happy to scoop out the support you need. 🍦
                </p>
                <img src="image/separator-img.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <i class="bx bxs-map-alt"></i>
                    <div>
                        <h4>Address</h4>
                        <p>Crème & Co. HQ, 4th Floor, Ice Plaza, 18 Admiralty Way, Lekki Phase 1, Lagos, Nigeria</p>
                    </div>
                </div>
                
                <div class="box">
                    <i class="bx bxs-phone-incoming"></i>
                    <div>
                        <h4>Phone/Mobile</h4>
                        <p>+234 803 123 4567</p>
                        <p>+234 701 987 6543</p>
                        <p>+234 816 222 8899</p>
                        <p>+234 909 456 3210</p>
                    </div>
                </div>

                 <div class="box">
                    <i class="bx bxs-envelope"></i>
                    <div>
                        <h4>Email</h4>
                        <p>oluwatunmisealimi67@gmail.com</p>
                        <p>support@cremeandco.ng</p>
                        <p>orders@cremeandco.ng</p>
                        <p>hello@cremeandco.ng</p>
                    </div>
                </div>

            </div>
        </div>

      <?php 
        include "components/footer.php";
        include "components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="js/user_script.js"></script>

</body>
</html>