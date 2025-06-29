<?php

    include '../components/connect.php';
    $seller_id = ''; // Initialize $seller_id

    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        header('location: login.php');
        exit();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Accounts</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>

    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>

        <section class="user-container">
            <div class="heading">
                Registered Users
                <img src="../image/separator-img.png">
            </div>
            <div class="box-container">
                <?php
                    $select_user = $conn->prepare("SELECT user_id, image, name, email FROM `users`");
                    $select_user->execute();
                    if($select_user->rowCount() > 0) {
                        while($fetch_users = $select_user->fetch(PDO::FETCH_ASSOC)) {
                            $user_id = $fetch_users['user_id'];
                ?>
                <div class="box">
                    <img src="../uploaded_files/<?= htmlspecialchars($fetch_users['image']); ?>" alt="User's image">
                    <p>ID: <span><?=htmlspecialchars($user_id);?></span></p>
                    <p>Name: <span><?=htmlspecialchars($fetch_users['name']);?></span></p>
                    <p>Email: <span><?=htmlspecialchars($fetch_users['email']);?></span></p>
                </div>
                <?php
                        }
                    } else  {
                                echo '<div class="empty">
                                <p>No users registered yet!</p>
                                </div>
                                ';
                            }
                ?>
            </div>
        </section>
    </div>

    <?php 
        include "../components/alert.php";
        ob_end_flush(); 
    ?>
    <script src="../js/admin_script.js"></script>
</body>
</html>