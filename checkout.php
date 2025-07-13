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

if (isset($_POST['place_order'])) {
    $name = trim(htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'));
    $email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));
    $number = trim(htmlspecialchars($_POST['number'], ENT_QUOTES, 'UTF-8'));
    $address_type = trim(htmlspecialchars($_POST['address_type'], ENT_QUOTES, 'UTF-8'));
    $address = $_POST['flat'] . ',' . $_POST['street'] . ',' . $_POST['city'] . ',' . $_POST['country'] . ',' . $_POST['zip'];
    $address = trim(htmlspecialchars($address, ENT_QUOTES, 'UTF-8'));
    $method = trim(htmlspecialchars($_POST['method'], ENT_QUOTES, 'UTF-8'));

    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verify_cart->execute([$user_id]);

    if (isset($_GET['get_id'])) {
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);

        if ($get_product->rowCount() > 0) {
            while ($fetch_product = $get_product->fetch(PDO::FETCH_ASSOC)) {
                $seller_id = $fetch_product['seller_id'];

                $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, seller_id, name, email, number, address, 
                                                    address_type, method, product_id, price, qty) 
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                                    ");
                $insert_order->execute([
                    unique_id(),
                    $user_id,
                    $seller_id,
                    $name,
                    $email,
                    $number,
                    $address,
                    $address_type,
                    $method,
                    $fetch_product['id'],
                    $fetch_product['price'],
                    1
                ]);
                header('Location: order.php');
            }
        } else {
            $warning_msg[] = "Something went wrong";
        }
    } else if ($verify_cart->rowCount() > 0) {
        while ($fetch_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$fetch_cart['product_id']]);
            $each_product = $select_products->fetch(PDO::FETCH_ASSOC);

            $seller_id = $each_product['seller_id'];

            $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, seller_id, name, email, number, address, 
                                                address_type, method, product_id, price, qty) 
                                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                                ");
            $insert_order->execute([
                unique_id(),
                $user_id,
                $seller_id,
                $name,
                $email,
                $number,
                $address,
                $address_type,
                $method,
                $fetch_cart['product_id'],
                $each_product['price'],
                $fetch_cart['qty']
            ]);
        }

        if ($insert_order) {
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);
            $success_msg[] = "Order placed successfully!";
            header("Location: order.php");
        } else {
            $warning_msg[] = "Something went wrong";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crème & Co. : User's Checkout Page</title>
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
            <h1>Ready to Scoop and Checkout</h1>
            <p>
                You're just one step away from sweet satisfaction. <br>
                Review your order, confirm your details, and get ready to enjoy every bite. <br>
                Your cravings are about to be delivered! <br>
            </p>
            <span>
                <a href="home.php">Home</a>
                <i class="bx bx-right-arrow-alt"></i>Checkout
            </span>
        </div>
    </div>

    <div class="checkout">
        <div class="heading">
            <h1>Checkout Summary</h1>
            <img src="image/separator-img.png">
        </div>
        <div class="row">
            <form class="register" method="post">
                <input type="hidden" name="product_id" value="<?= $get_id; ?>" />
                <h3>Billing Details</h3>

                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>Name <span>*</span></p>
                            <input class="input"
                                type="text" name="name"
                                placeholder="Enter your name"
                                maxlength="50"
                                required>
                        </div>

                        <div class="input-field">
                            <p>Contact <span>*</span></p>
                            <input class="input"
                                type="text" name="number"
                                placeholder="Enter your phone/mobile number"
                                maxlength="50"
                                required>
                        </div>

                        <div class="input-field">
                            <p>Email <span>*</span></p>
                            <input class="input"
                                type="email" name="email"
                                placeholder="Enter your email address"
                                maxlength="50"
                                required>
                        </div>

                        <div class="input-field">
                            <p>Payment Method <span>*</span></p>
                            <select name="method" class="input">
                                <option value="credit card">Credit Card</option>
                                <option value="debit card">Debit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="cash on delivery">Pay on Delivery</option>
                                <option value="gift card">Redeem a Gift Card</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <p>Address Type <span>*</span></p>
                            <select name="address_type" class="input">
                                <option value="home">Home</option>
                                <option value="office">Office</option>
                            </select>
                        </div>
                    </div>
                    <div class="box">
                            <div class="input-field">
                                <p>Address line 01 <span>*</span></p>
                                <input class="input"
                                    type="text" name="flat"
                                    placeholder="Building name or apartment/flat name"
                                    maxlength="50"
                                    required>
                            </div>
                            <div class="input-field">
                                <p>Address line 02 <span>*</span></p>
                                <input class="input"
                                    type="text" name="street"
                                    placeholder="Enter your street's name"
                                    maxlength="50"
                                    required>
                            </div>
                            <div class="input-field">
                                <p>City <span>*</span></p>
                                <input class="input"
                                    type="text" name="city"
                                    placeholder="Enter your city's name"
                                    maxlength="50"
                                    required>
                            </div>
                            <div class="input-field">
                                <p>Country <span>*</span></p>
                                <input class="input"
                                    type="text" name="country"
                                    placeholder="Enter your country's name"
                                    maxlength="50"
                                    required>
                            </div>
                            <div class="input-field">
                                <p>Zip Code<span>*</span></p>
                                <input class="input"
                                    type="number" name="zip"
                                    placeholder="Enter your zip/postal code e.g 123456"
                                    maxlength="6"
                                    required>
                            </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">Place Order</button>
            </form>
            <div class="summary">
                <h3>My Shopping Bag</h3>
                <div class="box-container">
                    <?php
                        $grand_total = 0;
                        if(isset($_GET['get_id'])) {
                            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_product->execute([$_GET['get_id']]);

                            while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                                $grand_total += $fetch_product['price'];
                            
                    ?>
                        <div class="flex">
                            <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                <h3 class="price">$<?= $fetch_product['price']; ?></h3>
                            </div>
                        </div>
                    <?php
                            }                            
                        } else {
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                            $select_cart->execute([$user_id]);

                            if($select_cart->rowCount() > 0) {
                                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                    $chosen_items = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                    $chosen_items->execute([$fetch_cart['product_id']]);

                                    $fetch_selected_items = $chosen_items->fetch(PDO::FETCH_ASSOC);
                                    $grand_total += $fetch_selected_items['price'] * $fetch_cart['qty'];
                    ?>
                        <div class="flex">
                            <img src="uploaded_files/<?= $fetch_selected_items['image']; ?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_selected_items['name']; ?></h3>
                                <p class="price"><?= $fetch_selected_items['price']; ?> x <?= $fetch_cart['qty']; ?></p>
                            </div>
                        </div>
                    <?php
                                }
                            } else {
                                echo ' <p class="empty">No scoops yet! Time to add your favorites.</p>';
                            }
                        }
                    ?>
                </div>
                <div class="grand-total">
                    <span>Total Payable Amount: </span>
                    <p>$<?= $grand_total;?></p>
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