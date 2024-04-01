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
    if(isset($_SESSION['user']) || isset($_SESSION['useradmin'])){
        $username = $_SESSION['user']?$_SESSION['user']:$_SESSION['useradmin'];
        $getLang = query('select','Users',['Lang'],[$username],['Username'])->fetchObject()->Lang;
        include $languages.$getLang.'.php';
    }else{
        include $languages.'english.php';
    }

    include $template.'header.php';
?>