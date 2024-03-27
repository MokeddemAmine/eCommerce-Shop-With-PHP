<?php
    ob_start();
    session_start();
    $pageTitle = 'Items';
    include 'init.php';
    $page = isset($_GET['do'])?$_GET['do']:'manage';
    echo '<div class="container my-5">';
    if($page == 'manage'){
        $getAllItems = query('select','Items',['*'],NULL,NULL,'ItemID','DESC');
        if($getAllItems->rowCount() > 0){
            
            echo '<div class="row">';
            while($item = $getAllItems->fetchObject()){
                ?>
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="card" style="height:400px;">
                            <div class="card-body">
                                <img src="imgs/item.jpg" alt="" class="card-img-top" style="max-height:200px;">
                                <h6 class="card-title"><?= $item->Name ?></h6>
                                <p class="card-text"><?= $item->Description ?></p>
                                <a href="?do=OneItem&itemid=<?= $item->ItemID ?>" class="card-link">Show More</a>
                                <span class="price"><?= $item->Price ?> <?= $item->Currency ?></span>
                            </div>
                        </div>
                    </div>
                <?php
            }
            echo '</div>';
        }else{
            echo '<div class="alert alert-white">There are no item</div>';
        }
    }elseif($page == 'AddItem'){
        if(isset($_SESSION['user'])){
            $getUser = query('select','Users',['*'],[$_SESSION['user']],['Username'])->fetchObject();
            if($getUser->RegStatus == 1){
                ?>
                <h2 class="text-center text-capitalize text-second-color mb-5">Add New Item</h2>
                <div class="row border p-3">
                    <div class="col-lg-8">
                        <form action="?do=InsertItem" method="POST">
                            <input type="hidden" name="MemberID" value="<?= $getUser->UserID ?>">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Enter the title"  class="form-control input-change">
                            </div>
                            <div class="form-group">
                                <input type="text" name="description" placeholder="Enter the description"  class="form-control input-change">
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" name="prices" placeholder="Enter the price" class="form-control input-change">
                                <div class="input-group-append">
                                    <select name="currency" class="custom-select input-change-currency">
                                        <option value="$">$</option>
                                        <option value="€">€</option>
                                        <option value="£">£</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <select name="country" class="custom-select">
                                    <option hidden>Country Made</option>
                                    <?php 
                                        foreach($countries as $country){
                                            echo '<option value="'.$country.'">'.$country.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="status" class="custom-select">
                                    <option hidden>Status</option>
                                    <option value="new">New</option>
                                    <option value="like new">Like New</option>
                                    <option value="used">Used</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="category" class="custom-select">
                                    <option hidden>Category</option>
                                    <?php 
                                        $getCats = query('select','Categories',['CatID','Name'],NULL,NULL,'Ordering');
                                        if($getCats->rowCount() > 0){
                                            while($cat = $getCats->fetchObject()){
                                                echo '<option value="'.$cat->CatID.'">'.$cat->Name.'</option>';
                                            }
                                        }else{
                                            echo '<option>None</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Add Item" class="btn bg-main-color text-second-color btn-block">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="card" style="height:400px">
                            <div class="card-body">
                                <img src="imgs/item.jpg" alt="" class="card-img-top" style="max-height:200px;">
                                <h6 class="card-title name">title here</h6>
                                <p class="card-text description">description here</p>
                                <a href="#" class="card-link">show more</a>
                                <span class="price"><span class="prices">0</span><span class="currency">$</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                redirectPage(NULL,0);
            }
        }
    }elseif($page == 'InsertItem'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $memberid   = filter_var($_POST['MemberID'],FILTER_SANITIZE_NUMBER_INT);
            $title      = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $desc       = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $price      = filter_var($_POST['prices'],FILTER_SANITIZE_NUMBER_FLOAT);
            $currency   = filter_var($_POST['currency'],FILTER_SANITIZE_STRING);
            $country    = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $status     = filter_var($_POST['status'],FILTER_SANITIZE_STRING);
            $category   = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);

            $form = array();

            if(empty($title)){
                $form[] = '<div class="alert alert-danger">Title must be entered</div>';
            }
            if(empty($desc)){
                $form[] = '<div class="alert alert-danger">Description must be not empty</div>'; 
            }
            if(empty($price)){
                $form[] = '<div class="alert alert-danger">price must be not empty</div>';
            }
            if($country == 'Country Made'){
                $form[] = '<div class="alert alert-danger">Country must be not empty</div>';
            }
            if($status == 'Status'){
                $form[] = '<div class="alert alert-danger">Status must be not empty</div>';
            }
            if(empty($category)){
                $form[] = '<div class="alert alert-danger">Category must be not empty</div>';
            }

            if(!empty($form)){
                foreach($form as $error){
                    echo $error;
                }
                redirectPage('back');
            }else{
                $setItem = query('insert','Items',['Name','Description','Price','Currency','Country_Name','Status','CatID','MemberID'],[$title,$desc,$price,$currency,$country,$status,$category,$memberid]);
                redirectPage('back');
            }

        }else{
            redirectPage();
        }
    }
    echo '</div>';
    include $template.'footer.php';
    ob_end_flush();
?>