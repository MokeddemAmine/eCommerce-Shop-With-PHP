<?php
    ob_start();
    session_start();
    $pageTitle = 'Home Page';
    include 'init.php';

    ?>
    <section class="cats-items my-5">
        <div class="container">
            <?php
                $getCategories = query('select','Categories',['*'],NULL,NULL,'Ordering');
                if($getCategories->rowCount() > 0){
                    while($cat = $getCategories->fetchObject()){
                        $getItemsToCat = query('select','Items',['*'],[$cat->CatID],['CatID'],'ItemID','DESC',4);
                        if($getItemsToCat->rowCount() > 0){
                            echo '<h4 class="text-center text-capitalize my-4 bg-second-color py-1 text-white rounded">'.$cat->Name.'</h4>';
                            echo '<div class="row">';
                                while($item = $getItemsToCat->fetchObject()){
                                    ?>
                                        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                                            <div class="card p-1" style="height:400px">
                                                <div class="card-body">
                                                    <img src="imgs/item.jpg" alt="image of item" class="card-img-top" style="max-height:200px"/>
                                                    <h4 class="card-title"><?= $item->Name ?></h4>
                                                    <p class="card-text"><?= $item->Description ?></p>
                                                    <a href="items.php?itemid=<?= $item->ItemID ?>" class="card-link">Click Here ...</a>
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