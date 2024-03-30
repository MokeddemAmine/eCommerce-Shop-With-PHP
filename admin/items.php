<?php
    ob_start();
    session_start();
    $pagetTitle = 'Items';
    if(isset($_SESSION['useradmin'])){
        $navbar = 'include';
        include 'init.php';
        $page = isset($_GET['do'])?$_GET['do']:'manage';
        echo '<section class="items">';
        echo '<div class="container">';
        if($page == 'manage'){
            echo '<h2 class="text-center text-second-color text-capitalize my-5">'.lang('manage items').'</h2>';
            $getItems = query('select','Items',['*']);
            if($getItems->rowCount() > 0){
                ?>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Added Date</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Member Added</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($row = $getItems->fetchObject()){
                                    $memberName = query('select','Users',['Username'],[$row->MemberID],['UserID'])->fetchObject()->Username;
                                    $catName = query('select','Categories',['Name'],[$row->CatID],['CatID'])->fetchObject()->Name;
                                    echo '<tr>';
                                        echo '<td>'.$row->ItemID.'</td>';
                                        echo '<td>'.$row->Name.'</td>';
                                        echo '<td>'.$row->Price.' '.$row->Currency.'</td>';
                                        echo '<td>'.$row->Add_Date.'</td>';
                                        echo '<td>'.$row->Country_Name.'</td>';
                                        echo '<td>'.$row->Status.'</td>';
                                        echo '<td>'.$catName.'</td>';
                                        echo '<td>'.$memberName.'</td>';
                                        echo '<td>';
                                            echo '<a href="?do=Edit&itemid='.$row->ItemID.'" class="btn btn-success btn-sm mr-1"><i class="fa-solid fa-edit"></i> Edit</a>';
                                            echo '<a href="?do=Delete&itemid='.$row->ItemID.'" class="btn btn-danger btn-sm  confirm-delete mr-1"><i class="fa-solid fa-close"></i> Delete</a>';
                                            if($row->Approve == 0){
                                                echo '<a href="?do=Approve&itemid='.$row->ItemID.'" class="btn btn-info btn-sm">Approve</a>';
                                            }
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                <?php
            }else{
                echo '<div class="alert alert-light bg-white">There are no item</div>';
            }
            echo '<a href="items.php?do=Add" class="btn bg-second-color text-main-color text-capitalize">add item</a>';
        }elseif($page == 'Add'){
            ?>
                <h2 class="text-center text-second-color text-capitalize my-5"><?=lang('add item')?></h2>
                <form action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <div class="form-group row align-items-center">
                        <label for="item-name-create" class="col-md-2 text-capitalize font-weight-bold">name</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <input type="text" name="name" placeholder="Name of the item" id="item-name-create" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-desc-create" class="col-md-2 text-capitalize font-weight-bold">description</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <input type="text" name="description" placeholder="Description of the item" id="item-desc-create" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-price-create" class="col-md-2 text-capitalize font-weight-bold">price</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <div class="input-group">
                                <input type="number" name="price" id="item-price-create" placeholder="Price ici" class="form-control"/>
                                <div class="input-group-append">
                                    <select name="currency" id="" class="custom-select">
                                        <option value="$">$</option>
                                        <option value="€">€</option>
                                        <option value="£">£</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-status-create" class="col-md-2 text-capitalize font-weight-bold">status</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="status" id="" class="custom-select">
                                <option value="new">New</option>
                                <option value="like new">Like New</option>
                                <option value="used">Used</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-country-create" class="col-md-2 text-capitalize font-weight-bold">country made</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="country_made" id="" class="custom-select">
                                <?php 
                                    foreach($countries as $country){
                                        echo "<option value=".$country.">".$country."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-image-create" class="col-md-2 text-capitalize font-weight-bold">Images</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <div class="custom-file">
                                <input type="file" name="images[]" id="image-item" class="custom-file-input" accept="image/*" multiple/>
                                <label for="image-item" class="custom-file-label text-capitalize">add images of item</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-catid-create" class="col-md-2 text-capitalize font-weight-bold">Category</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="catid" id="item-catid-create" class="custom-select">
                                <option hidden>None</option>
                                <?php
                                    $getCategories = query('select','Categories',['CatID','Name'],[true],['Parent IS NULL']);
                                    if($getCategories->rowCount() > 0){
                                        while($row = $getCategories->fetchObject()){
                                            echo '<option value="'.$row->CatID.'">'.$row->Name.'</option>';
                                        }
                                    }else{
                                        echo 'There are no category';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-subcatid-create" class="col-md-2 text-capitalize font-weight-bold">sub category</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="catid2" id="item-subcatid-create" class="custom-select">
                                <option hidden>None</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-memberid-create" class="col-md-2 text-capitalize font-weight-bold">Member</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="memberid" id="item-memberid-create" class="custom-select">
                                <?php
                                    $getMembers = query('select','Users',['UserID','Username']);
                                    if($getMembers->rowCount() > 0){
                                        while($row = $getMembers->fetchObject()){
                                            echo '<option value="'.$row->UserID.'">'.$row->Username.'</option>';
                                        }
                                    }else{
                                        echo 'There are no category';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-10 col-xl-8">
                        <input type="submit" value="Add Item" class="btn btn-block bg-main-color text-second-color">
                        </div>
                    </div>
                </form>
            <?php
        }elseif($page == 'Insert'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">'.lang('insert item').'</h2>';
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nameItem   = $_POST['name'];
                $desc       = $_POST['description'];
                $price      = $_POST['price'];
                $currency   = $_POST['currency'];
                $country    = $_POST['country_made'];
                $status     = $_POST['status'];
                $catid1      = $_POST['catid'];
                $catid2      = $_POST['catid2'];
                $memberid   = $_POST['memberid'];

                $catid = $catid2 == 'None'?$catid1:$catid2;

                // start taken of images

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

                    
                    $setItem = query('insert','Items',['Name','Description','Price','Currency','Country_Name','Status','CatId','MemberID','image','Approve'],[$nameItem,$desc,$price,$currency,$country,$status,$catid,$memberid,$imagesUpload,1]);

                }
                redirectPage('back');

                
            }else{
                redirectPage();
            }
        }elseif($page == 'Edit'){
            echo '<h2 class="text-center text-second-color text-capitalize my-5">'.lang('edit item').'</h2>';
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])?$_GET['itemid']:0;
            $getItem = query('select','Items',['*'],[$itemid],['ItemID']);
            if($getItem->rowCount() == 1){
                $item = $getItem->fetchObject();
            ?>
                <form action="?do=Update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="itemid" value="<?= $itemid ?>">
                    
                        <?php 
                            $getImages = json_decode($item->Image);
                            if(count($getImages) > 0){
                                $n = 1;
                                echo '<div class="row align-items-center my-4 imgs-item">';
                                foreach($getImages as $img){

                                    ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3 show-img-item">
                                        <div class="img-item">
                                            <span class="close text-danger confirm-delete">&times;</span>
                                            <div style="height:200px;" class="img d-flex justify-content-center align-items-center">
                                                <img src="imgs/<?= $img ?>" alt="" class="card-img-top w-100" style="max-height:200px; ">
                                            </div> 
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
                    
                    <div class="form-group row align-items-center">
                        <label for="item-name-create" class="col-md-2 text-capitalize font-weight-bold">name</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <input type="text" name="name" placeholder="Name of the item" id="item-name-create" class="form-control" value="<?= $item->Name ?>">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-desc-create" class="col-md-2 text-capitalize font-weight-bold">description</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <input type="text" name="description" placeholder="Description of the item" id="item-desc-create" class="form-control" value="<?= $item->Description ?>">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-price-create" class="col-md-2 text-capitalize font-weight-bold">price</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <div class="input-group">
                                <input type="number" name="price" id="item-price-create" placeholder="Price ici" class="form-control" value="<?= $item->Price ?>"/>
                                <div class="input-group-append">
                                    <select name="currency" id="" class="custom-select">
                                        <option value="$" <?php if($item->Currency == '$') echo 'selected' ?>>$</option>
                                        <option value="€" <?php if($item->Currency == '€') echo 'selected' ?>>€</option>
                                        <option value="£" <?php if($item->Currency == '£') echo 'selected' ?>>£</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-status-create" class="col-md-2 text-capitalize font-weight-bold">status</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="status" id="" class="custom-select">
                                <option value="new" <?php if($item->Status == 'new') echo 'selected'; ?>>New</option>
                                <option value="like new" <?php if($item->Status == 'like new') echo 'selected'; ?>>Like New</option>
                                <option value="used" <?php if($item->Status == 'used') echo 'selected'; ?>>Used</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-country-create" class="col-md-2 text-capitalize font-weight-bold">country made</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="country_made" id="" class="custom-select">
                                <?php 
                                    foreach($countries as $country){
                                        echo "<option value='".$country."'";
                                        if($item->Country_Name == $country)
                                            echo ' selected ';
                                        echo ">".$country."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-image-create" class="col-md-2 text-capitalize font-weight-bold">Image</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <div class="custom-file">
                                <input type="file" name="images[]" id="image-item" class="custom-file-input" accept="image/*" multiple>
                                <label for="image-item" class="custom-file-label text-capitalize">add new images to item</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-catid-create" class="col-md-2 text-capitalize font-weight-bold">Category</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="catid" id="item-catid-create" class="custom-select">
                                <?php
                                    $getCategories = query('select','Categories',['CatID','Name'],[true],['Parent IS NULL']);
                                    if($getCategories->rowCount() > 0){
                                        while($row = $getCategories->fetchObject()){
                                            echo '<option value="'.$row->CatID.'"';
                                            if($item->CatID == $row->CatID)
                                                echo 'selected';
                                            echo '>'.$row->Name.'</option>';
                                        }
                                    }else{
                                        echo 'There are no category';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-subcatid-create" class="col-md-2 text-capitalize font-weight-bold">sub category</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="catid2" id="item-subcatid-create" class="custom-select">
                                <option hidden>None</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="item-memberid-create" class="col-md-2 text-capitalize font-weight-bold">Member</label>
                        <div class="col-md-10 col-lg-8 col-xl-6">
                            <select name="memberid" id="item-memberid-create" class="custom-select">
                                <?php
                                    $getMembers = query('select','Users',['UserID','Username']);
                                    if($getMembers->rowCount() > 0){
                                        while($row = $getMembers->fetchObject()){
                                            echo '<option value="'.$row->UserID.'"';
                                            if($item->MemberID == $row->UserID)
                                                echo 'selected';
                                            echo '>'.$row->Username.'</option>';
                                        }
                                    }else{
                                        echo 'There are no category';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-10 col-xl-8">
                        <input type="submit" value="Update Item" class="btn btn-block bg-main-color text-second-color">
                        </div>
                    </div>
                </form>
                <?php 
                        $getComments = query('select','Comments INNER JOIN Users ON Comments.UserID = Users.UserID',['Comments.Comment AS Comment','Comments.Comment_Date AS Comment_Date','Users.Username AS Username'],[$itemid],['Comments.ItemID']);
                        if($getComments->rowCount() > 0){
                            ?>
                                <table class="table mt-5 table-sm">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Comment</th>
                                            <th>Comment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($comment = $getComments->fetchObject()){
                                                echo '<tr>';
                                                    echo '<td>'.$comment->Username.'</td>';
                                                    echo '<td>'.$comment->Comment.'</td>';
                                                    echo '<td>'.$comment->Comment_Date.'</td>';
                                                echo '</tr>';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            <?php

                        }else{
                            echo '<div class="text-center my-4">There are no Comment for this item</div>';
                        }
                    ?>
                
            <?php
            }else{
                redirectPage();
            }
        }elseif($page == 'Update'){
            echo '<h2 class="text-center text-second-color text-capitalize my-5">'.lang('update item').'</h2>';

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $itemid         = $_POST['itemid'];
                $nameitem       = $_POST['name'];
                $desc           = $_POST['description'];
                $price          = $_POST['price'];
                $currency       = $_POST['currency'];
                $status         = $_POST['status'];
                $country        = $_POST['country_made'];
                $catid1          = $_POST['catid'];
                $catid2         = $_POST['catid2'];
                $memberid       = $_POST['memberid'];

                
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
                


                $catid = $catid2 == 'None'?$catid1:$catid2;

                // start taken of images

                $UserName    = query('select','Users',['Username'],[$memberid],['UserID'])->fetchObject()->Username;

                $images     = $_FILES['images'];

                //die(json_encode($images));

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
                            move_uploaded_file($tmp,'imgs/'.$newNames[$n]);
                            $n++;
                        }

                        // collect new images with images state
                        foreach($imgsState as $state){
                            array_push($newNames,$state);
                        }
                        $imagesUpload = json_encode($newNames);
                        
                        $setItem = query('update','Items',['Name','Description','Price','Currency','Country_Name','Status','CatId','MemberID','image'],[$nameitem,$desc,$price,$currency,$country,$status,$catid,$memberid,$imagesUpload,$itemid],['ItemID']);

                    }

                }else{

                    $imagesUpload = json_encode($imgsState);
                    $setItem = query('update','Items',['Name','Description','Price','Currency','Country_Name','Status','CatID','MemberID','Image'],[$nameitem,$desc,$price,$currency,$country,$status,$catid,$memberid,$imagesUpload,$itemid],['ItemID']);

                    
                }
                
                redirectPage('back');
                

            }else{
                redirectPage();
                
            }
        }elseif($page == 'Delete'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">'.lang('delete item').'</h2>';
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? $_GET['itemid']:0;
            $getItem = query('select','Items',['*'],[$itemid],['ItemID']);
            if($getItem->rowCount() == 1){

                $deleteItem = query('delete','Items',['ItemID'],[$itemid]);

                redirectPage('back');
            }else{
                redirectPage();
            }
        }elseif($page == 'Approve'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">'.lang('approve item').'</h2>';
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? $_GET['itemid']:0;
            $getItem = query('select','Items',['*'],[$itemid],['ItemID']);
            if($getItem->rowCount() == 1){
                $approveItem = query('update','Items',['Approve'],[1,$itemid],['ItemID']);
                redirectPage('back');
            }else{
                redirectPage();
            }
        }else{
            redirectPage(NULL,0);
        }

        echo '</div>';
        echo '</section>';
    }else{
        redirectPage();
    }

    include $template .'footer.php';
    ob_end_flush();
?>