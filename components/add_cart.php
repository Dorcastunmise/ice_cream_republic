<?php

    if(isset($_POST['add_to_cart'])) {
        if($user_id != '') {
            $id = unique_id();
            $product_id = $_POST['product_id'];
            $qty = htmlspecialchars($_POST['qty'], ENT_QUOTES, 'UTF-8');

            $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ? AND `product_id` = ?");
            $verify_cart->execute([$user_id, $product_id]);
            
            $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
            $max_cart_items->execute([$user_id]);
            
            if($verify_cart->rowCount() > 0) {
                $warning_msg[] = 'Product already exists in cart!';
            } elseif ($max_cart_items->rowCount() > 20) {
                $warning_msg[] = 'Cart limit reached!';
            } elseif($user_id != '') {
                $select_price = $conn->prepare("SELECT * FROM `products` WHERE `id` = ? LIMIT 1");
                $select_price->execute([$product_id]);

                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);
                $insert_cart = $conn->prepare("INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`) VALUES (?, ?, ?, ?)");
                $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price']]);

                $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price']]);
                $success_msg[] = 'Product successfully added to cart!';
            }
        } else {
            $warning_msg[] = 'Please login to continue!';
        }

    }

?>