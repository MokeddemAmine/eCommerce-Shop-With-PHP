<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $css; ?>vendor/fonts/all.min.css"/>
    <link rel="stylesheet" href="<?= $css; ?>vendor/bootstrap_4.5.3.min.css"/>
    <link rel="stylesheet" href="<?= $css; ?>frontend.css"/>
    <title><?php if(isset($pageTitle)) echo $pageTitle; else echo 'eCommerce'; ?></title>
</head>
<body>
    <!-- add the upperbar for login and registration -->
    
    <!-- add the navbar here because all pages need it -->
    <section class="bg-second-color p-0">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark p-0">
                <a href="index.php" class="navbar-brand"><h1 class="text-main-color m-0">LOGO</h1></a>
                <button class="navbar-toggler bg-main-color" data-toggle="collapse" data-target="#main-navbar" aria-expanded="true"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse justify-content-betwen" id="main-navbar">
                    <div class="flex-grow-1 mb-2 mb-md-0 search-input">
                        <input type="search" name="search" id="search" placeholder="Search Categories or Items Here" class="form-control">
                        <i class="fa-solid fa-search search-icon"></i>
                    </div>
                    <div class="languages mb-3 mb-md-0 ml-md-5">
                        <select name="language" id="language" class="custom-select custom-select-sm bg-main-color text-white">
                            <option value="en">En</option>
                            <option value="ar">Ar</option>
                        </select>
                    </div>
                    <ul class="navbar-nav flex-grow-1 justify-content-end">
                        
                        <li class="nav-item"><a href="login.php" class="nav-link text-second-color text-uppercase btn btn-sm bg-main-color mr-md-1 mb-2 mb-md-0">login</a></li>
                        <li class="nav-item"><a href="login.php?do=register" class="nav-link text-second-color text-uppercase btn btn-sm bg-main-color">register</a></li>
                    </ul>
                    
                </div>
            </nav>
        </div>
    </section>
    <section class="bg-dark py-2">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="categories text-white col-md-10">
                    <?php
                        $getLatestCategories = query('select','Categories',['*'],NULL,NULL,'CatID','DESC',5);
                        if($getLatestCategories->rowCount() > 0){
                            while($cat = $getLatestCategories->fetchObject()){
                                echo '<a href="items.php?catid='.$cat->CatID.'" class="btn btn-light btn-sm mr-2">'.$cat->Name.'</a>';
                            }
                        }
                    ?>
                </div>
                <form action="items.php" method="GET" class="col-md-2">
                    <select name="catid" id="cat-menu" class="custom-select custom-select-sm">
                        <?php
                            $getAllCategories  = query('select','Categories',['*']);
                            echo '<option value="0">All</option>';
                            if($getAllCategories->rowCount() > 0){ 
                                while($cat = $getAllCategories->fetchObject()){
                                    echo '<option value="'.$cat->CatID.'">'.$cat->Name.'</option>';
                                }
                            }
                        ?>
                    </select>
                </form>
                
            </div>
            
        </div>
    </section>
