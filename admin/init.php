<?php
    // apply for database 
    include 'connect.php';
    // Routes
    $languages = 'include/languages/';
    $functions = 'include/functions/';
    $template = 'include/templates/';
    $css = 'layout/css/';
    $js = 'layout/js/';

    //include the important files
    include $functions.'functions.php';
    include $languages.'english.php';
    include $template.'header.php';
    if(isset($navbar)){
        include 'navbar.php';
    }


?>