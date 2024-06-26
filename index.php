<?php
    ob_start();
    session_start();
    $pageTitle = 'Home Page';
    include 'init.php';

    ?>
    <section class="cats-items my-5">
        <div class="container">
            <?php
                $getCategories = query('select','Categories',['*'],[true],['Parent IS NULL'],'Ordering');
                if($getCategories->rowCount() > 0){
                    while($cat = $getCategories->fetchObject()){
                        //$getItemsToCat = query('select','Items ',['*'],[$cat->CatID,1],['CatID','Approve'],'ItemID','DESC',4);
                        $getItemsToCat = $pdo->prepare('SELECT * FROM Items WHERE Approve = ? AND CatID IN (SELECT CatID FROM Categories WHERE CatID = ? OR Parent = ?) ORDER BY ItemID DESC limit 4');
                        $getItemsToCat->execute([1,$cat->CatID,$cat->CatID]);
                        if($getItemsToCat->rowCount() > 0){
                            echo '<h4 class="text-center text-capitalize my-4 bg-second-color py-1 text-white rounded">'.$cat->Name.'</h4>';
                            echo '<div class="row">';
                                while($item = $getItemsToCat->fetchObject()){
                                    $firstImage = NULL;
                                    $images = json_decode($item->Image);
                                    if(count($images) > 0){
                                        $firstImage = $images[0];
                                    }
                                    
                                    ?>
                                        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                                            <div class="card p-1" style="height:400px">
                                                <div class="card-body">
                                                    <div style="height:200px;">
                                                        <img src="admin/imgs/<?= $firstImage?$firstImage:'item.jpg' ?>" alt="image of item" class="card-img-top" style="max-height: 200px;object-fit:cover"/>
                                                    </div>
                                                    <h6 class="card-title"><?= $item->Name ?></h6>
                                                    <p class="card-text"><?= $item->Description ?></p>
                                                    <a href="items.php?do=ShowItem&itemid=<?= $item->ItemID ?>" class="card-link text-capitalize"><?= lang('click here') ?> ...</a>
                                                    <span class="price"><?= $item->Price ?> <?= $item->Currency ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            echo '</div>';
                        }
                    }
                }
            ?>
        </div>
    </section>
    <?php

    include $template.'footer.php';
    ob_end_flush();
?>