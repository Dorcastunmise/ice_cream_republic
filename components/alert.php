<?php

    
    // Show warning messages
    if (!empty($warning_msg)) {
        foreach ($warning_msg as $msg) {
            echo '<div class="alert alert-warning"><span class="alert-close" onclick="this.parentElement.style.display=\'none\';">&times;</span>' . $msg . '</div>';
        }
    }

    // Show success messages
    if (!empty($success_msg)) {
        foreach ($success_msg as $msg) {
            echo '<div class="alert alert-success"><span class="alert-close" onclick="this.parentElement.style.display=\'none\';">&times;</span>' . $msg . '</div>';
        }
    }

    // Show error messages
    if (!empty($error_msg)) {
        foreach ($error_msg as $msg) {
            echo '<div class="alert alert-error"><span class="alert-close" onclick="this.parentElement.style.display=\'none\';">&times;</span>' . $msg . '</div>';
        }
    }
    

    if (isset($info_msg)) {
        foreach ($info_msg as $msg) {
            echo '<div class="alert alert-error"><span class="alert-close" onclick="this.parentElement.style.display=\'none\';">&times;</span>' . $msg . '</div>';
        }
    }
