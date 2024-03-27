<?php
    ob_start();
    session_start();
    include 'init.php';
    if(isset($_SESSION['user'])){
        $getUser = query('select','Users',['*'],[$_SESSION['user']],['Username'])->fetchObject();
        ?>
        <section class="user">
            <div class="container">
                <h2 class="text-center text-capitalize text-second-color my-5">profile</h2>
                <div class="card user-info mb-3">
                    <div class="card-header bg-main-color text-second-color">
                        <h4 class="card-title">Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-second-color font-weight-bold">Name</td>
                                    <td><?= $getUser->FullName ?></td>
                                </tr>
                                <tr>
                                    <td class="text-second-color font-weight-bold">Username</td>
                                    <td><?= $getUser->Username ?></td>
                                </tr>
                                <tr>
                                    <td class="text-second-color font-weight-bold">Email</td>
                                    <td><?= $getUser->Email ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card user-items mb-3">
                    <div class="card-header bg-main-color text-second-color">
                        <h4 class="card-title">Items</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                                $getAllItems = query('select','Items',['*'],[$getUser->UserID],['MemberID']);
                                if($getAllItems->rowCount() > 0){
                                    while($item = $getAllItems->fetchObject()){
                                        ?>
                                                <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                                                    <div class="card" style="height:400px">
                                                        <div class="card-body">
                                                            <img src="imgs/item.jpg" alt="" class="card-img-top" style="max-height:200px"/>
                                                            <h6 class="card-title"><?= $item->Name ?></h6>
                                                            <p class="card-text"><?= $item->Description ?></p>
                                                            <a href="items.php?itemid=<?= $item->ItemID ?>" class="card-link">Click Here</a>
                                                            <span class="price"><?= $item->Price ?> <?= $item->Currency ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                    }
                                }else{
                                    echo '<alert class="alert-white">There are no item</alert>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card user-comments mb-3">
                    <div class="card-header bg-main-color text-second-color">
                        <h4 class="card-title">Comments</h4>
                    </div>
                    <div class="card-body">
                        <?php
                            $getAllComments = query('select','Comments INNER JOIN Items ON Comments.ItemID = Items.ItemID',['Comments.*','Items.Name AS ItemName'],[$getUser->UserID],['Comments.UserID']);
                            if($getAllComments->rowCount() > 0){
                                ?>
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Comment</th>
                                            <th>Item</th>
                                            <th>Comment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        while($comment = $getAllComments->fetchObject()){
                                            echo '<tr>';
                                                echo '<td style="width:50%">'.$comment->Comment.'</td>';
                                                echo '<td>'.$comment->ItemName.'</td>';
                                                echo '<td>'.$comment->Comment_Date.'</td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            }else{
                                echo '<div class="alert alert-white">There are no comment</div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }else{
        redirectPage(NULL,0);
    }

    include $template. 'footer.php';
    ob_end_flush();
?>