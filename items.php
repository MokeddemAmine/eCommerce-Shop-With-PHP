<?php
    ob_start();
    session_start();
    $pageTitle = 'Items';
    include 'init.php';

    include $template.'footer.php';
    ob_end_flush();
?>