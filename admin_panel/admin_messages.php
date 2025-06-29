<?php

    include '../components/connect.php';
    $seller_id = ''; // Initialize $seller_id

    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        header('location: login.php');
        exit();
    }

    //delete message from database
    if(isset($_POST['delete_msg'])) {
        $delete_id = htmlspecialchars($_POST['delete_id'], ENT_QUOTES, 'UTF-8');
        
        $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
        $delete_message->execute([$delete_id]);

        if($delete_message->rowCount() > 0) {
            $success_msg[] = 'Message deleted successfully!';
        } else {
            $warning_msg[] = 'Message not found or already deleted.';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>

        <section class="message-container">
            <div class="heading">
                <img src="../image/separator-img.png">
                Unread Messages
                <img src="../image/separator-img.png">
            </div>

            <div class="box-container">
                <?php
                    $select_message = $conn->prepare("SELECT * FROM `message`");
                    $select_message->execute();

                    if($select_message->rowCount() > 0) {
                        while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {                            
                ?>

                <div class="box">
                    <h3 class="name"><?= $fetch_message['name'];?></h3>
                    <h4><?= $fetch_message['subject'];?></h4>
                    <p><?= $fetch_message['message'];?></p>
                    <form action="" method="post">
                        <input type="hidden" name="delete_id" value="<?= $fetch_message['id'];?>">
                        <input type="submit" name="delete_msg" value="Delete Message" class="btn"
                        onclick="return confirm('Are you sure you want to delete this message?');">
                    </form>
                </div>

                <?php
                        }
                    }   else {
                        echo '<div class="empty">
                            <p>No unread messages yet!</p>
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