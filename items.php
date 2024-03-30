<?php
    ob_start();
    session_start();
    $pageTitle = 'Items';
    include 'init.php';

    $page = isset($_GET['do'])?$_GET['do']:'manage';

    echo '<div class="container my-5">';

    if($page == 'manage'){
        $getAllItems = query('select','Items',['*'],[1],['Approve'],'ItemID','DESC');
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
                                <a href="?do=ShowItem&itemid=<?= $item->ItemID ?>" class="card-link">Show More</a>
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
    }elseif($page == 'ShowCategory'){
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])?$_GET['catid']:0;
        if($catid == 0){
            redirectPage('items.php',0);
        }else{
            $verifyCat = query('select','Categories',['*'],[$catid],['CatID']);
            if($verifyCat->rowCount() == 1){
                $cat = $verifyCat->fetchObject();
                ?>
                    <h3 class="text-center text-capitalize text-second-color my-5"><?= $cat->Name ?></h3>
                    <div class="row">
                        <?php
                        //$getCatItems = query('select','Items',['*'],[$catid,1],['CatID','Approve']);
                        $getCatItems = $pdo->prepare('SELECT * FROM Items WHERE Approve = ? AND CatID IN (SELECT CatID FROM Categories WHERE CatID = ? OR Parent = ?)');
                        $getCatItems->execute([1,$catid,$catid]);
                        if($getCatItems->rowCount() > 0){
                            while($item = $getCatItems->fetchObject()){
                            ?>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="card" style="height:400px;">
                                        <div class="card-body">
                                            <img src="imgs/item.jpg" alt="" class="card-img-top" style="max-height:200px;">
                                            <h6 class="card-title"><?= $item->Name ?></h6>
                                            <p class="card-text"><?= $item->Description ?></p>
                                            <a href="items.php?do=ShowItem&itemid=<?= $item->ItemID ?>">Show More</a>
                                            <span class="price"><?= $item->Price ?> <?= $item->Currency ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        }else{
                            echo '<div class="alert alert-white text-center">There are no items</div>';
                        }
                        ?>
                    </div>
                <?php
            }else{
                redirectPage();
            }
        }
    }elseif($page == 'AddItem'){
        if(isset($_SESSION['user'])){
            $getUser = query('select','Users',['*'],[$_SESSION['user']],['Username'])->fetchObject();
            if($getUser->RegStatus == 1){
                ?>
                <h2 class="text-center text-capitalize text-second-color mb-5">Add New Item</h2>
                <div class="row border p-3">
                    <div class="col-lg-8">
                        <form action="?do=InsertItem" method="POST" enctype="multipart/form-data">
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
                                <select name="category" id="category-item" class="custom-select">
                                    <option hidden>Category</option>
                                    <?php 
                                        $getCats = query('select','Categories',['CatID','Name'],[true],['Parent IS NULL'],'Ordering');
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
                                <select name="sub-category" id="sub-category-item" class="custom-select">
                                    <option hidden>Sub Category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-file col-12">
                                    <input type="file" name="images[]" class="custom-file-input add-image-item" accept="image/*" multiple/>
                                    <label for="image-item" class="custom-file-label text-capitalize">add images of item</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Add Item" class="btn bg-main-color text-second-color btn-block">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="card" style="height:400px">
                            <div class="card-body">
                                <img src="imgs/item.jpg" alt="" class="card-img-top imagine-image-item" style="max-height:200px;">
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
    }elseif($page == 'ShowItem'){
        $itemid = isset($_GET['itemid'])?$_GET['itemid']:0;
        $getItem = query('select','Items INNER JOIN Categories ON Items.CatID = Categories.CatID INNER JOIN Users ON Items.MemberID = Users.UserID',['Items.*','Categories.Name AS Cat_Name','Users.Username AS Username'],[$itemid],['Items.ItemID']);
        if($getItem->rowCount() == 1){
            $getItem = $getItem->fetchObject();
            if($getItem->Approve == 1 || ($getItem->Username == $_SESSION['user'])){
            ?>
                <h2 class="text-center text-second-color text-capitalize my-5"><?= $getItem->Name ?></h2>
                <div class="row border p-3">
                    <div class="col-lg-4">
                        <img src="imgs/item.jpg" alt="" class="w-100">
                    </div>
                    <div class="col-lg-8">
                        <table class="table table-striped table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-capitalize font-weight-bold">Name</td>
                                    <td><?= $getItem->Name ?></td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize font-weight-bold">description</td>
                                    <td><?= $getItem->Description ?></td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize font-weight-bold">price</td>
                                    <td><?= $getItem->Price ?> <?= $getItem->Currency ?></td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize font-weight-bold">country</td>
                                    <td><?= $getItem->Country_Name ?></td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize font-weight-bold">status</td>
                                    <td class="text-capitalize"><?= $getItem->Status ?></td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize font-weight-bold">category</td>
                                    <td>
                                        <a href="items.php?do=ShowCategory&catid=<?= $getItem->CatID ?>"><?= $getItem->Cat_Name ?></a>
                                        <?php
                                            $parentCat = query('select','Categories',['*'],[false,$getItem->CatID],['Parent IS NULL','CatID']);
                                            if($parentCat->rowCount() > 0){
                                                $subcat = $parentCat->fetchObject();
                                                $getParent = query('select','Categories',['*'],[$subcat->Parent],['CatID'])->fetchObject();
                                                echo '<a href="items.php?do=ShowCategory&catid='. $getParent->CatID .'">'. $getParent->Name .'</a>';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-capitalize font-weight-bold">added date</td>
                                    <td><?= $getItem->Add_Date ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if($getItem->Username == $_SESSION['user']){ ?>
                            <div class="text-right">
                                <a href="items.php?do=EditItem&itemid=<?= $getItem->ItemID ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-edit"></i> Edit</a>
                                <a href="items.php?do=DeleteItem&itemid=<?= $getItem->ItemID ?>" class="btn btn-danger btn-sm confirm-delete"><i class="fa-solid fa-close"></i> Delete</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="comments">
                    <?php 
                        if(isset($_SESSION['user'])){
                            ?>
                            <hr class="comment-lines">
                            <form action="?do=InsertComment" method="POST">
                                <div class="row">
                                    <div class="col-md-9 mb-3 mb-md-0">
                                        <input type="hidden" name="itemid" value="<?= $getItem->ItemID ?>">
                                        <input type="text" name="comment" placeholder="Enter your comment to this product" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="submit" value="Comment" class="btn btn-block bg-main-color text-second-color">
                                    </div>
                                </div>
                            </form>
                            <hr class="comment-lines">
                            <?php
                        }else{
                            ?>
                            <hr class="comment-lines">
                            <p class="text-center">You have to <a href="login.php?do=login">Login</a> for comment</p>
                            <hr class="comment-lines">
                            <?php
                        }
                        $getComments = query('select','Comments INNER JOIN Users ON Comments.UserID = Users.UserID',['Comments.*','Users.Username'],[$getItem->ItemID],['Comments.ItemID']);
                        if($getComments->rowCount() > 0){
                            ?>
                            <h4 class="text-second-color my-4">Comments:</h4>
                            <table class="table table-striped table-borderless">
                                <tbody>
                                    <?php
                                    while($comment = $getComments->fetchObject()){
                                        ?>
                                        <tr>
                                            <td><?= $comment->Username ?></td>
                                            <td style="width:66%;"><?= $comment->Comment ?></td>
                                            <td><?= $comment->Comment_Date ?></td>
                                        </tr>
                                        <?php
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
            <?php
            }else{
                echo '<div class="alert alert-white text-center">The Item is not approve yet</div>';
            }
        }else{
            redirectPage(NULL,0);
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
            $subcat     = filter_var($_POST['sub-category'],FILTER_SANITIZE_NUMBER_INT);

            $catid = $subcat == ''?$category:$subcat;

            $UserName    = query('select','Users',['Username'],[$memberid],['UserID'])->fetchObject()->Username;

            $images     = $_FILES['images'];

            // extensions accept for images
            $exAccept   = array('jpeg','jpg','png','gif');

            $length     = count($images['name']);

            $names      = $images['name'];
            $sizes      = $images['size'];
            $tmp_names  = $images['tmp_name'];

            $formError = array();

            foreach ($names as $name){
                if(!in_array(pathinfo($name,PATHINFO_EXTENSION),$exAccept)){
                    $formError[] = '<div class="alert alert-danger">Extension must be : jpeg, png and gif</div>';
                    break;
                }
            }

            foreach($sizes as $size){
                if($size > 2097152){
                    $formError[] = '<div class="alert alert-danger">Size must be less then <b>2 MB</b></div>';
                    break;
                }
            }

            if(empty($title)){
                $formError[] = '<div class="alert alert-danger">Title must be entered</div>';
            }
            if(empty($desc)){
                $formError[] = '<div class="alert alert-danger">Description must be not empty</div>'; 
            }
            if(empty($price)){
                $formError[] = '<div class="alert alert-danger">price must be not empty</div>';
            }
            if($country == 'Country Made'){
                $formError[] = '<div class="alert alert-danger">Country must be not empty</div>';
            }
            if($status == 'Status'){
                $formError[] = '<div class="alert alert-danger">Status must be not empty</div>';
            }
            if(empty($category)){
                $formError[] = '<div class="alert alert-danger">Category must be not empty</div>';
            }

            if(!empty($formError)){
                foreach($formError as $error){
                    echo $error;
                }
            }else{
                $newNames = array();
                foreach($names as $name){
                    $newNames[] = $UserName.'-'.createID().'.'.pathinfo($name,PATHINFO_EXTENSION);
                }
                $imagesUpload = json_encode($newNames);
                $n = 0;
                foreach($tmp_names as $tmp){
                    move_uploaded_file($tmp,'imgs/'.$newNames[$n]);
                    $n++;
                }

                
                $setItem = query('insert','Items',['Name','Description','Price','Currency','Country_Name','Status','CatId','MemberID','image'],[$title,$desc,$price,$currency,$country,$status,$catid,$memberid,$imagesUpload]);

                redirectPage('back');

            }

        }else{
            redirectPage();
        }
    }elseif($page == 'EditItem'){
        if(isset($_SESSION['user'])){
            $itemid = isset($_GET['itemid'])?$_GET['itemid']:0;
            $getItem = query('select','Items',['*'],[$itemid],['ItemID']);
            if($getItem->rowCount() == 1){
                $item = $getItem->fetchObject();
                ?>
                <h2 class="text-center text-capitalize text-second-color mb-5">Edit Item</h2>
                
                
                        
                    <form action="?do=UpdateItem" method="POST" enctype="multipart/form-data">
                        <?php 
                            $getImages = json_decode($item->Image);
                            $firstImage = NULL;
                            if(count($getImages) > 0){
                                $firstImage = $getImages[0];
                                $n = 1;
                                echo '<div class="row align-items-center my-4 imgs-item">';
                                foreach($getImages as $img){

                                    ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3 show-img-item">
                                        <div class="img-item">
                                            <span class="close text-danger confirm-delete">&times;</span>
                                            <img src="admin/imgs/<?= $img ?>" alt="" class="w-100" style="height:300px;" /> 
                                            <?php 
                                                echo '<input type="hidden" name="imgState'.$n.'" value="'.$img.'"/>';
                                                $n++;
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                echo '</div>';
                            }
                         ?>
                        <div class="row border p-3">
                        <div class="col-lg-8">
                            <input type="hidden" name="itemid" value="<?= $item->ItemID ?>">
                            <input type="hidden" name="MemberID" value="<?= $item->MemberID ?>">
                            <div class="form-group">
                                <input type="text" name="name" value="<?= $item->Name ?>"  class="form-control input-change">
                            </div>
                            <div class="form-group">
                                <input type="text" name="description" value="<?= $item->Description ?>"  class="form-control input-change">
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" name="prices" value="<?= $item->Price ?>" class="form-control input-change">
                                <div class="input-group-append">
                                    <select name="currency" class="custom-select input-change-currency">
                                        <option value="$" <?php if($item->Currency == '$') echo 'selected' ?>>$</option>
                                        <option value="€" <?php if($item->Currency == '€') echo 'selected' ?>>€</option>
                                        <option value="£" <?php if($item->Currency == '£') echo 'selected' ?>>£</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <select name="country" class="custom-select">
                                    <?php 
                                        foreach($countries as $country){
                                            echo '<option value="'.$country.'"'; 
                                            if($item->Country_Name == $country){
                                                echo 'selected';
                                            }
                                            echo '>'.$country.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="status" class="custom-select">
                                    <option value="new" <?php if($item->Status == 'new') echo 'selected' ?>>New</option>
                                    <option value="like new" <?php if($item->Status == 'like new') echo 'selected' ?>>Like New</option>
                                    <option value="used" <?php if($item->Status == 'used') echo 'selected' ?>>Used</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="category" id="category-item" class="custom-select">
                                    <option hidden>Category</option>
                                    <?php 
                                        $getCats = query('select','Categories',['CatID','Name','Parent'],[true],['Parent IS NULL'],'Ordering');
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
                                <select name="sub-category" id="sub-category-item" class="custom-select">
                                    <option hidden>Sub Category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="custom-file col-12">
                                    <input type="file" name="images[]" id="image-item"  class="custom-file-input add-image-item" accept="image/*" multiple/>
                                    <label for="image-item" class="custom-file-label text-capitalize">add new images of item</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Update Item" class="btn bg-main-color text-second-color btn-block">
                            </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card" style="height:400px">
                                    <div class="card-body">
                                        <img src="admin/imgs/<?php echo $firstImage?$firstImage:'item.jpg' ?>" alt="" class="card-img-top imagine-image-item" style="max-height:200px;">
                                        <h6 class="card-title name"><?= $item->Name ?></h6>
                                        <p class="card-text description"><?= $item->Description ?></p>
                                        <a href="items.php?do=ShowItem&itemid=<?= $item->ItemID ?>" class="card-link">show more</a>
                                        <span class="price"><span class="prices"><?= $item->Price ?></span><span class="currency"><?= $item->Currency ?></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                <?php
            }else{
                redirectPage(NULL,0);
            }
        }
    }elseif($page == 'UpdateItem'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['user'])){
                $itemid     = filter_var($_POST['itemid'],FILTER_SANITIZE_NUMBER_INT);
                $memberid   = filter_var($_POST['MemberID'],FILTER_SANITIZE_NUMBER_INT);
                $title      = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
                $desc       = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
                $price      = filter_var($_POST['prices'],FILTER_SANITIZE_NUMBER_FLOAT);
                $currency   = filter_var($_POST['currency'],FILTER_SANITIZE_STRING);
                $country    = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
                $status     = filter_var($_POST['status'],FILTER_SANITIZE_STRING);
                $category   = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
                $subcat     = filter_var($_POST['sub-category'],FILTER_SANITIZE_NUMBER_INT);

                // check if there are imgs deleted from the item , and get the images state
                $imgsDelete = array();
                $imgsState = array();

                foreach($_POST as $key => $value){
                    if(str_contains($key,'imgDelete')){
                        array_push($imgsDelete,filter_var($value,FILTER_SANITIZE_STRING));
                    }
                    if(str_contains($key,'imgState')){
                        array_push($imgsState,filter_var($value,FILTER_SANITIZE_STRING));
                    }
                }
                
                // delete images from imgs folder in our storage
                foreach($imgsDelete as $img){
                    if(file_exists($img)){
                        unlink($img);
                    }
                }

                $catid = $subcat == ''?$category:$subcat;

                // start taken of images

                $UserName    = query('select','Users',['Username'],[$memberid],['UserID'])->fetchObject()->Username;

                $images     = $_FILES['images'];

                if($images['size'] != [0]){
                    // extensions accept for images
                    $exAccept   = array('jpeg','jpg','png','gif');

                    $length     = count($images['name']);

                    $names      = $images['name'];
                    $sizes      = $images['size'];
                    $tmp_names  = $images['tmp_name'];

                    $formError = array();

                    foreach ($names as $name){
                        if(!in_array(pathinfo($name,PATHINFO_EXTENSION),$exAccept)){
                            $formError[] = '<div class="alert alert-danger">Extension must be : jpeg, png and gif</div>';
                            break;
                        }
                    }

                    foreach($sizes as $size){
                        if($size > 2097152){
                            $formError[] = '<div class="alert alert-danger">Size must be less then <b>2 MB</b></div>';
                            break;
                        }
                    }

                    if(empty($title)){
                        $formError[] = '<div class="alert alert-danger">Title must be entered</div>';
                    }
                    if(empty($desc)){
                        $formError[] = '<div class="alert alert-danger">Description must be not empty</div>'; 
                    }
                    if(empty($price)){
                        $formError[] = '<div class="alert alert-danger">price must be not empty</div>';
                    }
                    if($country == 'Country Made'){
                        $formError[] = '<div class="alert alert-danger">Country must be not empty</div>';
                    }
                    if($status == 'Status'){
                        $formError[] = '<div class="alert alert-danger">Status must be not empty</div>';
                    }
                    if(empty($category)){
                        $formError[] = '<div class="alert alert-danger">Category must be not empty</div>';
                    }

                    if(!empty($formError)){
                        foreach($formError as $error){
                            echo $error;
                        }
                    }else{
                        $newNames = array();
                        foreach($names as $name){
                            //$newNames[] = $UserName.'-'.createID().'.'.pathinfo($name,PATHINFO_EXTENSION);
                            array_push($newNames,$UserName.'-'.createID().'.'.pathinfo($name,PATHINFO_EXTENSION));
                        }
                        
                        $n = 0;
                        foreach($tmp_names as $tmp){
                            move_uploaded_file($tmp,'admin/imgs/'.$newNames[$n]);
                            $n++;
                        }

                        // collect new images with images state
                        foreach($imgsState as $state){
                            array_push($newNames,$state);
                        }
                        $imagesUpload = json_encode($newNames);
                        
                        $setItem = query('update','Items',['Name','Description','Price','Currency','Country_Name','Status','CatId','MemberID','Image'],[$title,$desc,$price,$currency,$country,$status,$catid,$memberid,$imagesUpload,$itemid],['ItemID']);

                    }

                }else{

                    $imagesUpload = json_encode($imgsState);
                    $setItem = query('update','Items',['Name','Description','Price','Currency','Country_Name','Status','CatID','MemberID','Image'],[$title,$desc,$price,$currency,$country,$status,$catid,$memberid,$imagesUpload,$itemid],['ItemID']);

                    
                }
                redirectPage('back');

            }else{
                redirectPage();
            }
        }else{
            redirectPage();
        }
    }elseif($page == 'DeleteItem'){
        $itemid = isset($_GET['itemid'])?$_GET['itemid']:0;
        if(isset($_SESSION['user'])){
            $confirmSelfItem = query('select','Items INNER JOIN Users ON Items.MemberID = Users.UserID',['Items.*'],[$itemid,$_SESSION['user']],['Items.ItemID','Users.Username']);
            if($confirmSelfItem->rowCount() == 1){
                $deleteItem = query('delete','Items',['ItemID'],[$itemid]);
                redirectPage('profile.php');
            }
        }
    }elseif($page == 'InsertComment'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_SESSION['user'])){
                $getUserID  = query('select','Users',['*'],[$_SESSION['user']],['Username'])->fetchObject()->UserID;
                $itemid     = filter_var($_POST['itemid'],FILTER_SANITIZE_NUMBER_INT);
                $comment    = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                
                $form = array();

                if(empty($comment)){
                    $form[] = '<div class="alert alert-danger">Comment must be not empty</div>';
                }

                if(!empty($form)){
                    foreach($form as $error){
                        echo $error;
                    }
                }else{
                    $setComment = query('insert','Comments',['Comment','ItemID','UserID'],[$comment,$itemid,$getUserID]);
                }
                redirectPage('back');
            }
        }
    }
    echo '</div>';
    include $template.'footer.php';
    ob_end_flush();
?>