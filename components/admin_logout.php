<?php

    include 'connect.php';
    setcookie('seller_id', '', time() -1, '/');
    header('location: ../admin_panel/login.php');
    exit();

?>