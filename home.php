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
    <title>Crème & Co. : Home Page</title>
    <link rel="stylesheet" href="css/user_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
   
    <?php
        include 'components/user_header.php';
    ?>
    
    <section class="home" id="home">
        <div class="swiper home-slide">
            <div class="swiper-wrapper wrapper">

                <div class="swiper-slide slide">
                    <div class="content">
                        <span>Welcome to</span>
                        <h3>The Classic Crème & Co.</h3>
                        <p>Indulge in our premium handcrafted ice cream, beautifully paired with fresh, seasonal berries for an unforgettable treat.</p>
                        <a href="#" class="btn">Order Now</a>
                    </div>
                    <div class="image">
                        <img src="./image/home-img-1.png" alt="Berry Ice Cream">
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="content">
                        <span>Welcome to</span>
                        <h3>The Classic Crème & Co.</h3>
                        <p>Enjoy our artisan-style scoops served in golden, crispy waffle cones, crafted fresh to elevate every bite.</p>
                        <a href="#" class="btn">Order Now</a>
                    </div>
                    <div class="image">
                        <img src="./image/home-img-2.png" alt="Waffle Cone Ice Cream">
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="content">
                        <span>Welcome to</span>
                        <h3>The Classic Crème & Co.</h3>
                        <p>Treat yourself to a gourmet experience, decadent ice cream fused with rich chocolate, smooth caramel, and tangy raspberries.</p>
                        <a href="#" class="btn">Order Now</a>
                    </div>
                    <div class="image">
                        <img src="./image/home-img-3.png" alt="Gourmet Ice Cream">
                    </div>
                </div>

            </div>

            <div class="swiper-pagination"></div>

        </div>
    </section>


    <!--Service Section-->
    <div class="service">
        <div class="box-container">

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services.png" class="img1">
                        <img src="image/services (1).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Delivery</h4>
                    <span>100% secure</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (2).png" class="img1">
                        <img src="image/services (3).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Payment</h4>
                    <span>100% secure</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (5).png" class="img1">
                        <img src="image/services (6).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Support</h4>
                    <span>24/7 Support</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (7).png" class="img1">
                        <img src="image/services (8).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Gift Service</h4>
                    <span>Support Gift Service</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/service.png" class="img1">
                        <img src="image/service (1).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Returns</h4>
                    <span>24/7 free return</span>
                </div>
            </div>

            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services.png" class="img1">
                        <img src="image/services (1).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>Delivery</h4>
                    <span>100% secure</span>
                </div>
            </div>

        </div>
    </div>

    <!--Service Section Ends-->

    <!--Categories Section-->
    <div class="categories">
        <div class="heading">
            <h1>Explore our Categories</h1>
            <img src="image/separator-img.png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/categories1.jpg" alt="">
                <a href="menu.php" class="btn">Sundases</a>
            </div>

            <div class="box">
                <img src="image/categories2.jpg" alt="">
                <a href="menu.php" class="btn">Ice cream Cones</a>
            </div>

            <div class="box">
                <img src="image/categories3.jpg" alt="">
                <a href="menu.php" class="btn">Milkshakes</a>
            </div>

            <div class="box">
                <img src="image/categories4.jpg" alt="">
                <a href="menu.php" class="btn">Seasonal Flavours</a>
            </div>
        </div>
    </div>
    
    <!--Categories Section Ends-->

    <!--Ingredients Section-->

    <img src="image/menu-banner.jpg" class="menu-banner">
        <div class="taste">
        <div class="heading">
            <span>Taste</span>
            <img src="image/separator-img.png" alt="Separator Image">
            <h1>Natural Ingredients</h1>
        </div>

        <div class="box-container">
            <div class="box vanilla">
                <img src="image/vanilla-image.webp" alt="Vanilla Ice Cream">
                <div class="detail">
                    <h1>Vanilla</h1>
                    <p>Made with authentic Bourbon vanilla beans, sustainably sourced from Madagascar for a smooth and rich flavor.</p>
                </div>
            </div>

            <div class="box chocolate">
                <img src="image/chocolate-image.webp" alt="Chocolate Ice Cream">
                <div class="detail">
                    <h1>Chocolate</h1>
                    <p>Crafted in partnership with Valrhona using premium single-origin cocoa and Grand Cru blends for true chocolate connoisseurs.</p>
                </div>
            </div>

            <div class="box milk">
                <img src="image/milk-image.avif" alt="Fresh Milk">
                <div class="detail">
                    <h1>Milk</h1>
                    <p>We use fresh milk from Jersey cows raised at Fucci Farm in Conselice, known for its exceptional creaminess and quality.</p>
                </div>
            </div>
        </div>
    </div>

    <!--Ingredients Section Ends-->

    <div class="ice-container">
        <div class="overlay"></div>
            <div class="detail">
                <h1>Ice Cream Turns Every Moment<br> Into Something Truly Special</h1>
                <address style="font-style: normal; font-size: 1.1rem; line-height: 1.7; color: #fff;">
                    With every creamy scoop, a world of flavor melts gently across your palate, cool, rich, and delightfully smooth. 
                    It's not just dessert, it's a moment of joy, a whisper of nostalgia, and an invitation to indulge in the simple luxury of happiness. 
                    Whether shared or savored alone, each bite transforms the ordinary into something extraordinary.
                </address>
                <br><br><br><br>
                <a href="menu.php" class="btn">Explore Menu</a>
            </div>
    </div>

    <!--Taste II Section-->
    <div class="taste2">
        <div class="t-banner">
            <div class="overlay"></div> 
            <div class="detail">
                <h1>Savor the Sweetness of Life</h1>
                <p>
                    Let every bite light up your senses and bring out that gorgeous smile ,  because life tastes better with a scoop of joy.
                </p>
            </div>
        </div>

        <div class="box-container">

            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type1.webp" alt="Fruit Ice Cream">
                <div class="box-details fadeIn-bottom">
                    <h1>Fruit Ice Cream</h1>
                    <p>A burst of natural fruit flavors that feel like summer in every spoonful.</p>
                    <a href="menu.php" class="btn">Explore More</a>
                </div> 
            </div>

            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type2.webp" alt="Strawberry & Lingonberry Ice Cream">
                <div class="box-details fadeIn-bottom">
                    <h1>Strawberry & Lingonberry</h1>
                    <p>A delightful pairing of sweet strawberries and tart lingonberries.</p>
                    <a href="menu.php" class="btn">Explore More</a>
                </div> 
            </div>

            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type3.webp" alt="Strawberry Coffee Cookies Ice Cream">
                <div class="box-details fadeIn-bottom">
                    <h1>Strawberry Coffee Cookies</h1>
                    <p>Where berry sweetness meets bold coffee and crunchy cookies.</p>
                    <a href="menu.php" class="btn">Explore More</a>
                </div> 
            </div>

            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type4.webp" alt="Bubbles Mochi Ice Cream">
                <div class="box-details fadeIn-bottom">
                    <h1>Bubbles Mochi Ice Cream</h1>
                    <p>Chewy mochi bites wrapped in a smooth, bubbly frozen delight.</p>
                    <a href="menu.php" class="btn">Explore More</a>
                </div> 
            </div>

            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type5.webp" alt="Mango Ice Cream">
                <div class="box-details fadeIn-bottom">
                    <h1>Mango Ice Cream</h1>
                    <p>Tropical, juicy mangoes churned into a rich, creamy indulgence.</p>
                    <a href="menu.php" class="btn">Explore More</a>
                </div> 
            </div>

            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type6.webp" alt="Chocolate Ice Cream">
                <div class="box-details fadeIn-bottom">
                    <h1>Chocolate Ice Cream</h1>
                    <p>Decadent dark chocolate with a silky, melt-in-your-mouth texture.</p>
                    <a href="menu.php" class="btn">Explore More</a>
                </div> 
            </div>

        </div>

    </div>

    <!--Taste II Section Ends-->

    <!--Flavour Section-->
    <div class="flavour">
        <div class="box-container">
            <img src="image/left-banner2.JPG" alt="Promotional Banner">
            <div class="detail">
                <h1>Hot Deal! Sale Up to <span>50% Off</span></h1>
                <p>Limited offer!!</p>
                <a href="menu.php" class="btn">Explore Menu</a>
            </div>
        </div>
    </div>

    <!--Flavour Section Ends-->
    
    <div class="usage">
        <div class="heading">
            <h1>How it works</h1>
            <img src="image/separator-img.png" alt="Separator Image">
        </div>
        <div class="row">
            <div class="box-container">
                <div class="box">
                    <img src="image/icon.avif" alt="Scoop Ice cream">
                    <div class="detail">
                        <h3>Scoop Ice cream</h3>
                        <p>Can't decide on a flavor? Let your cravings lead the way, every scoop promises a delicious little adventure.</p>
                    </div>
                </div>

                <div class="box">
                    <img src="image/icon0.avif" alt="Toppings">
                    <div class="detail">
                        <h3>Toppings</h3>
                        <p>Top it your way! Add a swirl of magic with sprinkles, sauces, and surprises that make every bite unforgettable.</p>
                    </div>
                </div>

                <div class="box">
                    <img src="image/icon1.avif" alt="Treat">
                    <div class="detail">
                        <h3>Enjoy your treat</h3>
                        <p>Can't decide on a flavor? Let your cravings lead the way, every scoop promises a delicious little adventure.</p>
                    </div>
                </div>
            </div>

            <!---->
            <img src="image/sub-banner.png" class="divider">
            <div class="box-container">
                <div class="box">
                    <img src="image/icon2.avif" alt="Scoop Ice cream">
                    <div class="detail">
                        <h3>Scoop Ice cream</h3>
                        <p>Can't decide on a flavor? Let your cravings lead the way, every scoop promises a delicious little adventure.</p>
                    </div>
                </div>

                <div class="box">
                    <img src="image/icon0.avif" alt="Toppings">
                    <div class="detail">
                        <h3>Mix flavours</h3>
                        <p>To create that unique salivating taste, mix your favourite flavours.</p>
                    </div>
                </div>

                <div class="box">
                    <img src="image/icon1.avif" alt="Serve & Savor">
                    <div class="detail">
                        <h3>Serve & Savor</h3>
                        <p>Serve your chosen ice cream and savor the delightful flavours. 
                            Enjoy the perfect combination of creaminess and sweetness in each bite.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Usage Section Ends-->

    <!--Pride Section-->
    <div class="pride">
        <div class="detail">
            <h1>Experience the Magic of Irresistible Flavours</h1>
            <p>Our unique ice cream creations are crafted with love to bring you the
                perfect blend of taste, texture, and pure happiness in every bite!
            </p>
            <a href="menu.php" class="btn">Explore Menu</a>
        </div>
    </div>

    <!--Pride Section Ends-->


    <?php 
        include "components/footer.php";
        include "components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="js/user_script.js"></script>

</body>
</html>