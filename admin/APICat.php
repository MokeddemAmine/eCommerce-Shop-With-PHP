<?php
    include 'connect.php';
    $functions = 'include/functions/';
    include $functions.'functions.php';
    
    $cat = isset($_GET['catid']) && is_numeric($_GET['catid'])? $_GET['catid']:0;
    $verifyCat = query('select','Categories',['*'],[$cat],['CatID']);
    if($verifyCat->rowCount() == 1){
        $cat = $verifyCat->fetchObject();
        $getSubCats = query('select','Categories',['*'],[$cat->CatID],['Parent']);
        echo json_encode($getSubCats->fetchAll(PDO::FETCH_ASSOC));
    }
?>