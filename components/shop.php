
    <div class="products">
        
        <div class="box-container">
            <?php
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE status = ? LIMIT 6");
                $select_products->execute(['active']);
                if ($select_products->rowCount() > 0) {
                    while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <form action="" method="post"
                    class="box <?php 
                            if($fetch_product['stock'] == 0) {echo 'disabled';}
                        ?>" 
            >
                <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="">
                <?php if($fetch_product['stock'] > 1) { ?>
                    <span class="stock" style="color:green;">In stock</span>
                <?php } elseif($fetch_product['stock'] > 0) { ?>
                    <span class="stock" style="color:orange;">Hurry... Only <?= $fetch_product['stock']; ?> left!</span>
                <?php } else { ?>
                    <span class="stock" style="color:red;">Out of stock</span>
                <?php } ?>

                <div class="content">
                    <img src="image/shape-19.png" class="shap" alt="">
                    <div class="button">
                        <div>
                            <h3 class="name"><?= $fetch_product['name']; ?></h3>
                        </div>
                        <div>
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            <button type="submit" name="add_to_wishlist"><i class="bx bx-heart-square"></i></button>
                            <a href="view_page.php?pid=<?= $fetch_product['id']; ?>" class="bx bxs-show"></a>
                        </div> 
                    </div>
                    <p class="price">Price: <?= $fetch_product['price']; ?></p>
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                    <div class="flex-btn">
                        <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Buy Now</a>
                        <input type="number" min="1" max="99" value="1" name="qty" class="qty" maxlength="2" required>
                    </div>
                </div>

            </form>
            <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>No products added yet!</p>
                        </div>
                    ';
                }
            ?>
        </div>
    </div>

    