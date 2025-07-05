<header class="header">
  <section class="flex">
    <a href="home.php" class="logo">
      <img src="image/logo.png" alt="Logo" width="130px">
    </a>

    <nav class="navbar">
      <a href="home.php"><span>Home</span></a>
      <a href="about_us.php"><span>About</span></a>
      <a href="menu.php"><span>Menu</span></a>
      <a href="order.php"><span>Order</span></a>
      <a href="contact.php"><span>Contact</span></a>
    </nav>

    <form action="search_product.php" method="post" class="search-form">
      <input type="text" name="search_product" placeholder="product name..." maxlength="100" required>
      <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"></button>
    </form>

    <div class="icons">
      <div class="bx bx-list-plus" id="menu-btn"></div>
      <div class="bx bx-search-alt-2" id="search-btn"></div>

      <?php
        $count_wishlist_item = $conn->prepare("SELECT * FROM `wishlist` WHERE `user_id` = ?");
        $count_wishlist_item->execute([$user_id]);
        $total_wishlist_items = $count_wishlist_item->rowCount();
      ?>
      <a href="wishlist.php">
        <i class="bx bx-heart">
          <sup><?= $total_wishlist_items; ?></sup>
        </i>
      </a>

      <?php
        $count_cart_item = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
        $count_cart_item->execute([$user_id]);
        $total_cart_items = $count_cart_item->rowCount();
      ?>
      <a href="cart.php">
        <i class="bx bx-cart">
          <sup><?= $total_cart_items; ?></sup>
        </i>
      </a>

      <div class="bx bx-user" id="user-btn"></div>
    </div>

    <!-- Profile Detail  -->
    <div class="profile-detail">
      <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE `user_id` = ?");
        $select_profile->execute([$user_id]);
        if ($select_profile->rowCount() > 0) {
          $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
        <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="Profile Image">
        <h3 style="margin-bottom: 1rem;"><?= $fetch_profile['name']; ?></h3>
        <div class="flex-btn">
          <a href="profile.php" class="btn">View Profile</a>
          <a href="components/logout.php" onclick="return confirm('Are you sure you want to leave?');" class="btn">Logout</a>
        </div>
      <?php } else { ?>
        <h3 style="margin-bottom: 1rem;">Login/Register</h3>
        <div class="flex-btn">
          <a href="login.php" class="btn">Login</a>
          <a href="register.php" class="btn">Register</a>
        </div>
      <?php } ?>
    </div>
  </section>
</header>
