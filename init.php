<?php
    // apply for database 
    include 'admin/connect.php';
    // Routes
    $languages = 'include/languages/';
    $functions = 'include/functions/';
    $template = 'include/templates/';
    $css = 'layout/css/';
    $js = 'layout/js/';

    //include the important files
    include $functions.'functions.php';
    

    include $template.'header.php';
?>