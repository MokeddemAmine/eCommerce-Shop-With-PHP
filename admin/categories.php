<?php
    ob_start();
    session_start();
    $pageTitle = 'Categories';
    if(isset($_SESSION['useradmin'])){
        $navbar = 'include';
        include 'init.php';
        $page = isset($_GET['do'])?$_GET['do']:'manage';
        echo '<section class="categories">';
        echo '<div class="container">';
        if($page == 'manage'){
            ?>
                <h2 class="text-capitalize text-second-color text-center my-5"><?= lang('manage categories'); ?></h2>
                <div class="card">
                    <div class="card-header categories-header">
                        <div class="row align-items-center">
                            <div class="col-lg-3 text-capitalize text-second-color font-weight-bold"><i class="fa-solid fa-edit"></i> manage categories</div>
                            <form method="GET" action="" class="col-lg-6 order my-2 my-lg-0">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-capitalize text-second-color font-weight-bold mb-1 mb-md-0">
                                    <i class="fa-solid fa-sort"></i>order:
                                    </div>
                                    <div class="col-md-3">
                                        <select name="order-by" class="custom-select custom-select-sm">
                                            <option value="Name">Name</option>
                                            <option value="Ordering">Ordering</option>
                                        </select>
                                    </div>
                                    <div class="col-md-7 my-2 my-md-0">
                                        <div class="row align-items-center">
                                            <div class="col-md-7">
                                                <div class="custom-control custom-control-inline custom-radio">
                                                    <input type="radio" name="order" value="ASC" id="order-asc" class="custom-control-input"/>
                                                    <label for="order-asc" class="custom-control-label">ASC</label>
                                                </div>
                                                <div class="custom-control custom-control-inline custom-radio">
                                                    <input type="radio" name="order" value="DESC" id="order-desc" class="custom-control-input"/>
                                                    <label for="order-desc" class="custom-control-label">DESC</label>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                    <input type="submit" value="Order" class="btn form-control bg-second-color text-main-color my-2 my-md-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-lg-3 view">
                                <div class="row align-items-center">
                                <div class="col-lg-6 font-weight-bold text-second-color"><i class="fa-solid fa-eye"></i> view:</div>
                                <div class="col-lg-6 text-capitalize"><span class="view-mode " data-mode="classic">classic</span> | <span class="view-mode active" data-mode="full">full</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            $getCategories = query('select','categories',['*'],[true],['Parent IS NULL']);
                            if(isset($_GET['order-by']) && isset($_GET['order'])){
                                $getCategories = query('select','categories',['*'],null,null,$_GET['order-by'],$_GET['order']);
                            }
                            if($getCategories->rowCount() > 0){
                                while($cat = $getCategories->fetchObject()){
                                    ?>
                                    <div class="category mb-3">
                                        <div class="category-content p-2 rounded mb-2">
                                            <h3 class="text-capitalize text-fourth-color category-title"><?= $cat->Name ?></h3>
                                            <div class="category-info">
                                                <p><?= $cat->Description ?></p>
                                                <div class="category-info text-capitalize">
                                                    <span class="btn btn-sm <?php if($cat->Visibility == 1) echo 'btn-success'; else echo 'btn-danger'; ?> text-white"><i class="fa-solid fa-eye"></i> visible</span>
                                                    <span class="btn btn-sm <?php if($cat->Allow_Comments == 1) echo 'btn-success'; else echo 'btn-danger'; ?> text-white"><i class="fa-solid fa-comment"></i> comments</span>
                                                    <span class="btn btn-sm <?php if($cat->Allow_Ads == 1) echo 'btn-success'; else echo 'btn-danger'; ?> text-white"><i class="fa-solid fa-tag"></i> ads</span>
                                                </div>
                                                <?php
                                                $getSubCats = query('select','Categories',['*'],[$cat->CatID],['Parent']);
                                                if($getSubCats->rowCount() > 0){
                                                    echo '<div class="my-2">';
                                                    echo '<span class="text-second-color font-weight-bold">Subs : </span>';
                                                    while($subCat = $getSubCats->fetchObject()){
                                                        echo '<div class="sub-category d-inline-block">';
                                                            echo '<span class="btn btn-info btn-sm sub-category-name mx-1">'.$subCat->Name.'</span>';
                                                            echo '<div class="sub-cat-btn">
                                                                    <a href="categories.php?do=Edit&catid='. $subCat->CatID .'" class="btn btn-success btn-sm text-capitalize"> edit</a>
                                                                    <a href="categories.php?do=Delete&catid='. $subCat->CatID .'" class="btn btn-danger btn-sm text-capitalize confirm-delete"> delete</a>
                                                                </div>';
                                                        echo '</div>';
                                                    }
                                                    echo '</div>';
                                                }
                                                ?>
                                            </div>
                                            <div class="category-btn">
                                                <a href="categories.php?do=Edit&catid=<?= $cat->CatID ?>" class="btn btn-success btn-sm text-capitalize"><i class="fa-solid fa-edit"></i> edit</a>
                                                <a href="categories.php?do=Delete&catid=<?= $cat->CatID ?>" class="btn btn-danger btn-sm text-capitalize confirm-delete"><i class="fa-solid fa-close"></i> delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }else{
                                echo '<h5 class="text-capitalize text-second-color">There are no category</h5>';
                            }
                        ?>
                    </div>
                </div>
                <a href="?do=Add" class="btn bg-second-color text-main-color text-capitalize mt-3">add category</a>
            <?php
        }elseif($page == 'Add'){
            ?>
            <h2 class="text-second-color text-center text-capitalize my-5"><?= lang('add new category') ?></h2>
            <form action="?do=Insert" method="POST">
                <div class="form-group row align-items-center">
                    <label for="cat-name" class="col-2 text-capitalize font-weight-bold"><?= lang('name'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <input type="text" name="name" placeholder="<?= lang("Name of the category"); ?>" id="cat-name" class="form-control">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="cat-desc" class="col-2 text-capitalize font-weight-bold"><?= lang('description'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <input type="text" name="description" placeholder="<?= lang('Describe the category') ?>" id="cat-desc" class="form-control">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="cat-order" class="col-2 text-capitalize font-weight-bold"><?= lang('ordering'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <input type="number" name="ordering" placeholder="<?= lang('Number to arrange the categories') ?>" id="cat-order" class="form-control">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="cat-parent" class="col-2 text-capitalize font-weight-bold">parent</label>
                    <div class="col-md-8 col-lg-6">
                        <select name="parent" id="cat-parent" class="custom-select">
                            <option>None</option>
                            <?php 
                                $getParentCats = query('select','Categories',['*'],[true],['Parent IS NULL']);
                                if($getParentCats->rowCount() > 0){
                                    while($cat = $getParentCats->fetchObject()){
                                        echo '<option value="'.$cat->CatID.'">'.$cat->Name.'</option>';
                                    }
                                    
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="cat-visible" class="col-2 text-capitalize font-weight-bold"><?= lang('visible'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="visible" id="visible-yes" value="1" class="custom-control-input" checked>
                            <label for="visible-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="visible" id="visible-no" value="0" class="custom-control-input">
                            <label for="visible-no" class="custom-control-label text-capitalize"><?= lang('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row text-align-center">
                    <label for="" class="col-2 text-capitalize font-weight-bold"><?= lang('Comments'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="comments" value="1" id="comments-yes" class="custom-control-input" checked>
                            <label for="comments-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="comments" value="0" id="comments-no" class="custom-control-input">
                            <label for="comments-no" class="custom-control-label text-capitalize"><?= lang('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row text-align-center">
                    <label for="" class="col-2 text-capitalize font-weight-bold"><?= lang('ads'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="ads" value="1" id="ads-yes" class="custom-control-input" checked/>
                            <label for="ads-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="ads" value="0" id="ads-no" class="custom-control-input"/>
                            <label for="ads-no" class="custom-control-label text-capitalize"><?= lang('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10 col-lg-8">
                        <input type="submit" value="<?= lang('add category'); ?>" class="btn btn-block bg-main-color text-capitalize">
                    </div>
                </div>
            </form>
            <?php
        }elseif($page == 'Insert'){
            echo '<h2 class="text-capitalize text-center my-5 text-second-color">'.lang('insert category').'</h2>';
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $order      = $_POST['ordering'];
                $visible    = intval($_POST['visible']);
                $comments   = intval($_POST['comments']);
                $ads        = intval($_POST['ads']);
                $parent     = intval($_POST['parent']);

                if(empty($parent)){
                    $setCategory = query('insert','categories',['Name','Description','Ordering','Visibility','Allow_Comments','Allow_Ads'],[$name,$desc,$order,$visible,$comments,$ads]);
                }else{
                    $setCategory = query('insert','categories',['Name','Description','Ordering','Visibility','Allow_Comments','Allow_Ads','Parent'],[$name,$desc,$order,$visible,$comments,$ads,$parent]);
                }
                

                redirectPage('back');

            }else{
                redirectPage();
            }
        }elseif($page == 'Edit'){
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])?$_GET['catid']:0;
            $getCategory = query('select','Categories',['*'],[$catid],['CatID']);
            if($getCategory->rowCount() == 1){
                $cat = $getCategory->fetchObject();
            ?>
            <h2 class="text-second-color text-center text-capitalize my-5"><?= lang('edit category') ?></h2>
            <form action="?do=Update" method="POST">
                <input type="hidden" name="catid" value="<?= $cat->CatID; ?>">
                <div class="form-group row align-items-center">
                    <label for="cat-name" class="col-2 text-capitalize font-weight-bold"><?= lang('name'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <input type="text" name="name" value="<?= $cat->Name; ?>" placeholder="<?= lang("Name of the category"); ?>" id="cat-name" class="form-control">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="cat-desc" class="col-2 text-capitalize font-weight-bold"><?= lang('description'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <input type="text" name="description" value="<?= $cat->Description; ?>" placeholder="<?= lang('Describe the category') ?>" id="cat-desc" class="form-control">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="cat-order" class="col-2 text-capitalize font-weight-bold"><?= lang('ordering'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <input type="number" name="ordering" value="<?= $cat->Ordering; ?>" placeholder="<?= lang('Number to arrange the categories') ?>" id="cat-order" class="form-control">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="cat-parent" class="col-2 text-capitalize font-weight-bold">parent</label>
                    <div class="col-md-8 col-lg-6">
                        <select name="parent" id="cat-parent" class="custom-select">
                            <option>None</option>
                            <?php 
                                $getParentCats = query('select','Categories',['*'],[true],['Parent IS NULL']);
                                if($getParentCats->rowCount() > 0){
                                    while($cats = $getParentCats->fetchObject()){
                                        echo '<option value="'.$cats->CatID.'"'; 
                                            if($cats->CatID == $cat->Parent){
                                                echo 'selected';
                                            }
                                        echo '>'.$cats->Name.'</option>';
                                    }
                                    
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="cat-visible" class="col-2 text-capitalize font-weight-bold"><?= lang('visible'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="visible" id="visible-yes" value="1" class="custom-control-input" <?php if($cat->Visibility == 1) echo 'checked'; ?>>
                            <label for="visible-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="visible" id="visible-no" value="0" class="custom-control-input" <?php if($cat->Visibility == 0) echo 'checked'; ?>>
                            <label for="visible-no" class="custom-control-label text-capitalize"><?= lang('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row text-align-center">
                    <label for="" class="col-2 text-capitalize font-weight-bold"><?= lang('Comments'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="comments" value="1" id="comments-yes" class="custom-control-input" <?php if($cat->Allow_Comments == 1) echo 'checked'; ?>>
                            <label for="comments-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="comments" value="0" id="comments-no" class="custom-control-input" <?php if($cat->Allow_Comments == 0) echo 'checked'; ?>>
                            <label for="comments-no" class="custom-control-label text-capitalize"><?= lang('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row text-align-center">
                    <label for="" class="col-2 text-capitalize font-weight-bold"><?= lang('ads'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="ads" value="1" id="ads-yes" class="custom-control-input" <?php if($cat->Allow_Ads == 1) echo 'checked'; ?>/>
                            <label for="ads-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="ads" value="0" id="ads-no" class="custom-control-input" <?php if($cat->Allow_Ads == 0) echo 'checked'; ?>/>
                            <label for="ads-no" class="custom-control-label text-capitalize"><?= lang('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10 col-lg-8">
                        <input type="submit" value="<?= lang('update category'); ?>" class="btn btn-block bg-main-color text-capitalize">
                    </div>
                </div>
            </form>
            <?php
            }else{
                redirectPage();
            }
        }elseif($page == 'Update'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">'.lang('update category').'</h2>';
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $catid      = $_POST['catid'];
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $order      = $_POST['ordering'];
                $visible    = intval($_POST['visible']);
                $comments   = intval($_POST['comments']);
                $ads        = intval($_POST['ads']);
                $parent     = intval($_POST['parent']);

                if(empty($parent)){
                    $updateCategory = query('update','categories',['Name','Description','Ordering','Visibility','Allow_Comments','Allow_Ads'],[$name,$desc,$order,$visible,$comments,$ads,$catid],['CatID']);
                }else{
                    $updateCategory = query('update','categories',['Name','Description','Ordering','Visibility','Allow_Comments','Allow_Ads','Parent'],[$name,$desc,$order,$visible,$comments,$ads,$parent,$catid],['CatID']);
                }
                

                redirectPage('back');
            }else{
                redirectPage();
            }
        }elseif($page == 'Delete'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">'.lang('delete category').'</h2>';
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])?$_GET['catid']:0;
            $verifyCategory = query('select','Categories',['*'],[$catid],['CatID']);
            if($verifyCategory->rowCount() == 1){
                $deleteCategory = query('delete','Categories',['CatID'],[$catid]);
                redirectPage('back');
            }else{
                redirectPage();
            }
        }
        else{
            redirectPage();
        }
        echo '</div>';
        echo '</section>';
    }else{
        redirectPage();
    }
    include $template.'footer.php';
    ob_end_flush();
?>