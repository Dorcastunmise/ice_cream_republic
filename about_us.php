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

    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crème & Co. : About Page</title>
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
            <h1>About Us</h1>
            <p>
                We're not just about ice cream, we're about joy in every bite! <br>
                At Crème & Co., we whip up magic with real fruits, creamy goodness, and flavors that dance on your tongue. <br>
                Whether you're 6 or 60, there's always a scoop waiting to make your day a little brighter (and sweeter!).<br>
            </p>
            <span>
                <a href="home.php">Home</a>
                <i class="bx bx-right-arrow-alt"></i>About
            </span>
        </div>
    </div>

    <div class="journey">
        <div class="box-container">
            <div class="box">
                <div class="heading">
                    <span>Crème & Co. 🍨✨</span>
                    <h1>Our Journey with a simple dream</h1>
                    <img src="image/separator-img.png" alt="Separator Image">
                </div>
                <p>
                    Our goal is simple, to create moments of joy through irresistibly crafted ice cream. <br>
                    What started as a humble dream to serve honest, creamy flavors has grown into a heartfelt mission: <br>
                    to delight every scoop-lover with rich textures, bold ingredients, and the comfort of something truly special.<br>
                </p>

                <div class="flex-btn">
                    <a href="" class="btn">Read More</a>
                    <a href="menu.php" class="btn">Explore our Goal</a>
                </div>
            </div>

            <div class="box">
                <img src="image/journey-image.jpg" class="img">
            </div>

        </div>
    </div>

    <!--Mission-->
    <div class="story">
        <div class="heading">
            <h1>Our Mission</h1>
            <img src="image/separator-img.png">
        </div>
        <p>
            Our mission is to craft more than just ice cream, we're here to create feel-good experiences. <br>
            From responsibly sourced ingredients to hand-churned textures, every scoop reflects our commitment <br>
            to quality, creativity, and community. We aim to turn ordinary moments into sweet celebrations, <br>
            one flavor at a time.
        </p>
        <a href="menu.php" class="btn">Explore Services"></a>
    </div>
    <!--Mission Ends-->

    <!--Vision-->
    <div class="container">
        <div class="box-container">
            <div class="img-box">
                <img src="image/flavors.JPG">
            </div>
            <div class="box">
                <div class="heading">
                    <h1>Variety of Flavours</h1>
                    <img src="image/separator-img.png">
                </div>
                <p>
                    At Crème & Co., we believe variety is the true flavor of life.<br><br>
                    From timeless classics like <strong>creamy vanilla</strong> and <strong>rich chocolate</strong> <br>
                    to bold fusions like <strong>raspberry cheesecake</strong> and <strong>matcha swirl</strong>, <br>
                    our menu is a celebration of taste and imagination.<br><br>
                    Whether you crave something fruity, nutty, or decadently indulgent,<br>
                    there's always a scoop waiting to match your mood and moment.
                </p>
                <a href="menu.php" class="btn">Explore Flavours</a>

            </div>
        </div>
    </div>
    <!--Vision Ends-->

    <!--Team-->
    <div class="team">
        <div class="heading">
            <span>Our Team</span>
            <h1>Meet Our Team</h1>
            <img src="image/separator-img.png">
        </div>

        <div class="box-container">
            <div class="box">
                <img src="image/team-3.jpg" class="img=">
                <div class="content">
                    <img src="image/shape-19.png" class="shap">
                    <h2>Alimi Oluwatunmise</h2>
                    <p>Founder & CEO</p>
                </div>
            </div>

            <div class="box">
                <img src="image/team-2.jpg" class="img">
                <div class="content">
                    <img src="image/shape-19.png" class="shap">
                    <h2>Rusi Anabel</h2>
                    <p>Head Baker</p>
                </div>
            </div>

            <div class="box">
                <img src="image/team-1.jpg" class="img">
                <div class="content">
                    <img src="image/shape-19.png" class="shap">
                    <h2>Chuka Adedayo</h2>
                    <p>Operations Manager</p>
                </div>
            </div>
        </div>
    </div>
    <!--Team Ends-->

    <!--Testinmonials-->
    <div class="testimonial">
        <div class="heading">
            <h1>What Our Customers Say</h1>
            <img src="image/separator-img.png">
        </div>
        <div class="testimonial-container">
            <div class="slide-row" id="slide">
                <div class="slide-col">
                    <div class="user-text">
                        <p>"The flavors are out of this world! Every scoop feels like a new adventure. <br>
                            Crème & Co. has completely redefined dessert for me."
                        </p>
                        <h2>Amaka Oladipo</h2>
                        <p>Food Blogger</p>
                    </div>
                    <div class="user-img">
                        <img src="image/testimonial (1).jpg" alt="">
                    </div>
                </div>

                <div class="slide-col">
                    <div class="user-text">
                        <p>"From the moment I walked in, I felt the warmth.<br>
                            The variety, the quality, the experience...absolutely delightful!"
                        </p>
                        <h2>James Adeyemi</h2>
                        <p>Creative Designer</p>
                    </div>
                    <div class="user-img">
                        <img src="image/testimonial (2).jpg" alt="">
                    </div>
                </div>

                <div class="slide-col">
                    <div class="user-text">
                        <p>"As someone who rarely indulges, I must say this is worth every bite.<br>
                            The mango sorbet is my personal favorite!"
                        </p>
                        <h2>Sarah Eze</h2>
                        <p>Nutritionist</p>
                    </div>
                    <div class="user-img">
                        <img src="image/testimonial (3).jpg" alt="">
                    </div>
                </div>

                <div class="slide-col">
                    <div class="user-text">
                        <p>"Their service is excellent, and the ice cream? Simply unforgettable!"</p>
                        <h2>Rita Akande</h2>
                        <p>Event Planner</p>
                    </div>
                    <div class="user-img">
                        <img src="image/testimonial (4).jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="indicator">
            <span class="btn1 active"></span>
            <span class="btn1"></span>
            <span class="btn1"></span>
            <span class="btn1"></span>
        </div>
    </div>
    <!--Testinmonials Ends-->

    <!--Offer-->
    <div class="offer">
        <div class="box-container">
            <div class="box">
                <div class="heading">
                    <h1>Special Offers</h1>
                    <img src="image/separator-img.png">
                </div>
                
                <div class="detail">
                    <div class="img-box">
                        <img src="image/mission.webp" alt="Mexican Chocolate">
                    </div>
                    <div>
                        <h2>Mexican Chocolate</h2>
                        <p>
                            Bold, rich and unapologetically smooth.<br>
                            Our Mexican Chocolate ice cream is a true taste adventure.<br>
                            Blended with premium cocoa, a touch of cinnamon and a hint of spice.<br>
                            Each spoonful brings warmth, character and deep satisfaction.<br>
                            Crafted for those who crave bold flavours with a unique twist.
                        </p>
                    </div>
                </div>

                <div class="detail">
                    <div class="img-box">
                        <img src="image/mission1.webp" alt="Vanilla with Honey">
                    </div>
                    <div>
                        <h2>Vanilla with Honey</h2>
                        <p>
                            Silky vanilla meets golden wildflower honey in this soft, creamy blend.<br>
                            Every scoop melts gently on the tongue, leaving a delicate sweetness.<br>
                            It's a classic flavour, reimagined with nature's finest nectar.<br>
                            Smooth, light, and endlessly comforting, a timeless favourite.
                        </p>
                    </div>
                </div>

                <div class="detail">
                    <div class="img-box">
                        <img src="image/mission2.webp" alt="Peppermint Chip">
                    </div>
                    <div>
                        <h2>Peppermint Chip</h2>
                        <p>
                            Cool peppermint swirled with crisp dark chocolate chips.<br>
                            Refreshing, bold and just the right amount of bite.<br>
                            Each scoop offers a burst of chill followed by a rich, chocolatey crunch.<br>
                            A vibrant, fresh take for those who love contrast in every bite.
                        </p>
                    </div>
                </div>

                <div class="detail">
                    <div class="img-box">
                        <img src="image/mission4.png" alt="Raspberry Sorbat">
                    </div>
                    <div>
                        <h2>Raspberry Sorbat</h2>
                        <p>
                            Bright, tangy and naturally vibrant, the essence of fresh raspberries.<br>
                            This dairy-free sorbet is bursting with juicy flavour and silky texture.<br>
                            It's clean, crisp and perfectly balanced to refresh your senses.<br>
                            A zesty delight that tastes like summer in every spoonful.
                        </p>
                    </div>
                </div>
            </div>
            <div class="box">
                <img src="image/form.png" class="img">
            </div>            
        </div>
    </div>
    <!--Offer Ends-->


    <?php 
        include "components/footer.php";
        include "components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="js/user_script.js"></script>

</body>
</html>