<?php
    ob_start();
    session_start();
    $pageTitle = 'Orders';
    if(isset($_SESSION['user'])){
        include 'init.php';
        echo '<section class="sell-buy">';
        echo '<div class="container">';
        $page = isset($_GET['do'])?$_GET['do']:'manage';
        $getUser = query('select','Users',['*'],[$_SESSION['user']],['Username'])->fetchObject();
        if($getUser->RegStatus == 1 && $getUser->EmailConfirm == 1){
        $userId = $getUser->UserID;
        if($page == 'Sellings'){
            echo '<h2 class="text-center text-capitalize my-5 text-second-color">sellings</h2>';
            $getSellings = query('select','Orders INNER JOIN Items ON Orders.ItemID = Items.ItemID',['Orders.*','Items.Name AS Item_Name','Items.Price AS Item_Price','Items.Currency AS Item_Currency','Items.MemberID'],[$userId],['MemberID'],'OrderID','DESC');
            if($getSellings->rowCount() > 0){
                ?>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#ID</th>
                                <th>Item</th>
                                <th>Customer Name</th>
                                <th>Quantity</th>
                                <th>Control</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($sel = $getSellings->fetchObject()){
                                    echo '<tr>';
                                        echo '<td>'.$sel->OrderID.'</td>';
                                        echo '<td>'.$sel->Item_Name.'</td>';
                                        echo '<td>'.$sel->CustomerName.'</td>';
                                        echo '<td>'.$sel->Quantity.'</td>';
                                        echo '<td>'; 
                                            if($sel->SellerConfirm == 0){
                                                echo '<a href="?do=ConfirmOrder&orderid='.$sel->OrderID.'" class="btn btn-sm btn-success text-capitalize mr-1">confirm</a>';
                                                echo '<a href="?do=DeleteOrder&orderid='.$sel->OrderID.'" class="btn btn-sm btn-danger text-capitalize confirm-delete">delete</a>';
                                            }else{
                                                
                                                if($sel->CustomerConfirm == 0){
                                                    echo '<p class="text-success m-0">You has been confirmed</p>';
                                                    echo '<p class="text-warning m-0">Wait customer confirm</p>';
                                                }else{
                                                    echo '<p class="text-success m-0">Confirmed by customer</p>';
                                                }
                                            }
                                            
                                        echo '</td>';
                                        echo '<td>'; 
                                            echo '<a href="?do=ShowOrder&orderid='.$sel->OrderID.'" class="btn btn-sm btn-info text-capitalize">show more info</a>';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                <?php
            }else{
                echo '<div class="alert alert-info">There are no product selled</div>';
            }
        }elseif($page == 'Buyings'){
            echo '<h2 class="text-center text-capitalize my-5 text-second-color">buyings</h2>';
            $getBuyings = query('select','Orders INNER JOIN Items ON Orders.ItemID = Items.ItemID',['Orders.*','Items.Name AS Item_Name','Items.Price AS Item_Price','Items.Currency AS Item_Currency','Items.MemberID'],[$userId],['CustomerID'],'OrderID','DESC');
            if($getBuyings->rowCount() > 0){
                ?>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#ID</th>
                                <th>Item</th>
                                <th>Customer Name</th>
                                <th>Quantity</th>
                                <th class="text-center">Control</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($sel = $getBuyings->fetchObject()){
                                    echo '<tr>';
                                        echo '<td>'.$sel->OrderID.'</td>';
                                        echo '<td>'.$sel->Item_Name.'</td>';
                                        echo '<td>'.$sel->CustomerName.'</td>';
                                        echo '<td>'.$sel->Quantity.'</td>';
                                        echo '<td class="text-center">'; 
                                            if($sel->SellerConfirm == 0){
                                                echo '<a href="?do=DeleteOrder&orderid='.$sel->OrderID.'" class="btn btn-sm btn-danger text-capitalize confirm-delete">delete</a>';
                                            }else{
                                                
                                                if($sel->CustomerConfirm == 0){
                                                    echo '<p class="text-success m-0">Seller has been confirmed</p>';
                                                    echo '<a href="?do=ConfirmOrder&orderid='.$sel->OrderID.'" class="btn btn-sm btn-success text-capitalize mr-1">confirm access</a>';
                                                }else{
                                                    echo '<p class="text-success m-0">Request Arrives</p>';
                                                }
                                            }
                                            
                                        echo '</td>';
                                        echo '<td>'; 
                                            echo '<a href="?do=ShowOrder&orderid='.$sel->OrderID.'" class="btn btn-sm btn-info text-capitalize">show more info</a>';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                <?php
            }else{
                echo '<div class="alert alert-info">There are no product bougth</div>';
            }            
        }elseif($page == 'ShowOrder'){
            $orderid    = isset($_GET['orderid']) && is_numeric($_GET['orderid'])?$_GET['orderid']:0;

            $verifyCurrentUserOrder = $pdo->prepare('SELECT Orders.*, Items.MemberID, Items.Name, Items.Price, Items.Currency, Items.Country_Name, Items.Image, Items.Status, Items.Image FROM Orders INNER JOIN Items ON Orders.ItemID = Items.ItemID WHERE OrderID = ? AND ( CustomerID = ? OR MemberID = ?)');
            $verifyCurrentUserOrder->execute([$orderid,$userId,$userId]);
            if($verifyCurrentUserOrder->rowCount() == 1){
                $order = $verifyCurrentUserOrder->fetchObject();
                echo '<h2 class="text-center text-second-color text-capitalize my-5">'.$order->Name.' order</h2>';
                ?>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <table class="table table-striped">
                            <tr class="row bg-main-color">
                                <td class="col-4">#ID</td>
                                <td class="col-8"><?= $order->OrderID ?></td>
                            </tr>
                            <tr class="row">
                                <td class="col-4">Customer Name</td>
                                <td class="col-8"><?= $order->CustomerName ?></td>
                            </tr>
                            <tr class="row">
                                <td class="col-4">Customer Phone</td>
                                <td class="col-8"><?= $order->Phone ?></td>
                            </tr>
                            <tr class="row">
                                <td class="col-4">Customer Address</td>
                                <td class="col-8"><?= $order->Address ?></td>
                            </tr>
                            <tr class="row">
                                <td class="col-4">Product Name</td>
                                <td class="col-8"><?= $order->Name ?></td>
                            </tr>
                            <tr class="row">
                                <td class="col-4">Product Country</td>
                                <td class="col-8"><?= $order->Country_Name ?></td>
                            </tr>
                            <tr class="row">
                                <td class="col-4">Product Status</td>
                                <td class="col-8"><?= $order->Status ?></td>
                            </tr>
                            <tr class="row">
                                <td class="col-4">Product Unit Price</td>
                                <td class="col-8"><?= $order->Price ?> <?= $order->Currency ?></td>
                            </tr>
                            <tr class="row">
                                <td class="col-4">Quantity</td>
                                <td class="col-8"><?= $order->Quantity ?></td>
                            </tr>
                            <tr class="row bg-main-color">
                                <td class="col-4">Product Total Price</td>
                                <td class="col-8"><?= $order->Quantity * $order->Price ?> <?= $order->Currency ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-4 image-order">
                        <?php
                            $images = json_decode($order->Image);
                            if(count($images) > 0){
                                ?>
                                    <img src="admin/imgs/<?= $images[0]; ?>" alt="" class="w-100">
                                <?php
                            }else{
                                ?>                          
                                        <img src="admin/imgs/item.jpg" alt="" class="w-100">
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }else{
                redirectPage(NULL,0);
            }

            
        }elseif($page == 'ConfirmOrder'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">confirm order</h2>';
            $orderid    = isset($_GET['orderid']) && is_numeric($_GET['orderid'])?$_GET['orderid']:0;

            $orderSeller = query('select','Orders INNER JOIN Items ON Orders.ItemID = Items.ItemID',['MemberID'],[$orderid,$userId],['OrderID','MemberID']);
            $orderBuyyer = query('select','Orders',['*'],[$orderid,$userId],['OrderID','CustomerID']);
            if($orderSeller->rowCount() > 0){
                $updateOrder = query('update','Orders',['SellerConfirm'],[1,$orderid],['OrderID']);
                redirectPage('back');
            }elseif($orderBuyyer->rowCount() > 0){
                $updateOrder = query('update','Orders',['CustomerConfirm'],[1,$orderid],['OrderID']);
                redirectPage('back');
            }else{
                redirectPage(NULL,0);
            }
        }elseif($page == 'DeleteOrder'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">delete order</h2>';

            $orderid    = isset($_GET['orderid']) && is_numeric($_GET['orderid'])?$_GET['orderid']:0;

            $orderUser = $pdo->prepare('SELECT Orders.* , Items.MemberID FROM Orders INNER JOIN Items ON Orders.ItemID = Items.ItemID WHERE OrderID = ? AND ( CustomerID = ? OR MemberID = ?)');
            $orderUser->execute([$orderid,$userId,$userId]);
            if($orderUser->rowCount() == 1){
                $deleteOrder = query('delete','Orders',['OrderID'],[$orderid]);
                redirectPage('back');
            }
        }else{
            redirectPage(NULL,0);
        }
        }else{
            redirectPage(NULL,0);
        }
        echo '</div>';
        echo '</section>';
    }else{
        redirectPage(NULL,0);
    }
    
    include $template .'footer.php';
    ob_end_flush();
?>