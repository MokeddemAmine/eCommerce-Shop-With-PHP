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
    if(isset($_SESSION['useradmin'])){
        $getLang = query('select','Users',['Lang'],[$_SESSION['useradmin']],['Username'])->fetchObject()->Lang;
        include $languages.$getLang.'.php';
    }else{
        include $languages.'english.php';
    }
    
    include $template.'header.php';
    if(isset($navbar)){
        include 'navbar.php';
    }
?>