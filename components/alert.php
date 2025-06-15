<?php
function show_alerts($key, $type) {
    if (!empty($_SESSION[$key])) {
        foreach ($_SESSION[$key] as $msg) {
            echo '<div class="alert alert-' . htmlspecialchars($type) . '">
                    <span class="alert-close" onclick="this.parentElement.style.display=\'none\';">&times;</span>'
                 . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') .
                 '</div>';
        }
        // Clear messages after showing
        unset($_SESSION[$key]);
    }
}

show_alerts('success_msg', 'success');
show_alerts('warning_msg', 'warning');
show_alerts('error_msg', 'error');
show_alerts('info_msg', 'info');
?>
