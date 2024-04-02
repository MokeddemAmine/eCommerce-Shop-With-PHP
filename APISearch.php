<?php

    include 'admin/connect.php';

    $search = isset($_GET['search'])?$_GET['search']:'';

    $getItems = $pdo->prepare("SELECT ItemID, Name FROM Items WHERE Name LIKE ? limit 5");
    $getItems->execute(["%$search%"]);

    $result = array();

    if($getItems->rowCount() > 0){
        while($item = $getItems->fetchObject()){
            $result[] = '<a href="items.php?do=ShowItem&itemid='.$item->ItemID.'">'.$item->Name.'</a>';
        }
    }

    if(count($result) < 5){
        $getCats = $pdo->prepare('SELECT CatID, Name FROM Categories WHERE Name Like ? limit 5');
        $getCats->execute(["%$search%"]);
        if($getCats->rowCount() > 0){
            while($cat = $getCats->fetchObject()){
                $result[] = '<a href="items.php?do=ShowCategory&catid='.$cat->CatID.'">'.$cat->Name.'</a>';
                if(count($result) == 5){
                    break;
                }
            }
        }
    }
    
    echo json_encode($result);
?>