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
                    <label for="cat-visible" class="col-2 text-capitalize font-weight-bold"><?= lang('visible'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="visible" id="visible-yes" value="yes" class="custom-control-input" checked>
                            <label for="visible-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="visible" id="visible-no" value="no" class="custom-control-input">
                            <label for="visible-no" class="custom-control-label text-capitalize"><?= lang('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row text-align-center">
                    <label for="" class="col-2 text-capitalize font-weight-bold"><?= lang('Comments'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="comments" value="yes" id="comments-yes" class="custom-control-input" checked>
                            <label for="comments-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="comments" value="no" id="comments-no" class="custom-control-input">
                            <label for="comments-no" class="custom-control-label text-capitalize"><?= lang('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row text-align-center">
                    <label for="" class="col-2 text-capitalize font-weight-bold"><?= lang('ads'); ?></label>
                    <div class="col-md-8 col-lg-6">
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="ads" value="yes" id="ads-yes" class="custom-control-input" checked/>
                            <label for="ads-yes" class="custom-control-label text-capitalize"><?= lang('yes'); ?></label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" name="ads" value="no" id="ads-no" class="custom-control-input"/>
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
        }else{
            header('Location: index.php');
            exit();
        }
        echo '</div>';
        echo '</section>';
    }else{
        header('Location: index.php');
        exit();
    }
    include $template.'footer.php';
    ob_end_flush();
?>