<header>
    <div class="logo">
        <img src="../image/logo.png" alt="" width="200">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bxs-menu"></i></div>
    </div>
    <div class="profile-detail">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM sellers WHERE id = ?");
        $select_profile->execute([$seller_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>

            <div class="profile">
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt=""
                    class="logo-img" width="150">
                <p><?= $fetch_profile['name']; ?></p>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">Profile</a>
                    <a href="../components/admin_logout.php"
                        onclick="return confirm('Are you sure you want to leave?');"
                        class="btn">Logout</a>
                </div>
            </div>
        <?php } ?>
    </div>
</header>

<div class="sidebar-container">
    <div class="sidebar">
        <?php
        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE id = ?");
        $select_seller->execute([$seller_id]);
        if ($select_seller->rowCount() > 0) {
            $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC);
        ?>
    
        <div class="profile">
            <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt=""
                class="logo-img" width="100">
            <p><?= $fetch_profile['name']; ?></p>
        </div>
            <?php } ?>

        <h5>Menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>Dashboard</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i>Add Products</a></li>
                <li><a href="view_products.php"><i class="bx bxs-food_menu"></i>View Products</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user_detail"></i>Accounts</a></li>
                <li><a href="../components/admin_logout.php"
                        onclick="return confirm('Are you sure you want to leave?');"><i class="bx bxs-log-out"></i>Dashboard</a></li>
            </ul>
        </div>

        <h5>Find Us</h5>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-twitter"></i>
            <i class="bx bxl-pinterest-alt"></i>
        </div>
    </div>
</div>