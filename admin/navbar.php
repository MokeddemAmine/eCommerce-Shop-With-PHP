<header class="bg-second-color">
    <div class="container">
    <div class="navbar navbar-expand-md navbar-dark">
            <a href="index.php" class="navbar-brand"><h1 class="text-uppercase text-main-color mb-0" style="font-size:2rem;">logo</h1></a>
            <button class="navbar-toggler bg-main-color" data-toggle="collapse" data-target="#main-navbar-content"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse justify-content-between" id="main-navbar-content">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="categories.php" class="nav-link text-white text-capitalize"><?= lang('categories'); ?></a></li>
                    <li class="nav-item"><a href="items.php" class="nav-link text-white text-capitalize"><?= lang('items'); ?></a></li>
                    <li class="nav-item"><a href="members.php" class="nav-link text-white text-capitalize"><?= lang('members'); ?></a></li>
                    <li class="nav-item"><a href="comments.php" class="nav-link text-white text-capitalize"><?= lang('comments'); ?></a></li>
                </ul>
                <div class="languages mb-3 mb-md-0 ml-md-5">
                        <form action="?do=changeLang" method="POST" id="languageForm">
                            <select name="language" id="languageSelect" class="custom-select custom-select-sm bg-main-color text-white">
                            <!-- $userLang was declared in header.php -->
                                <option value="english" <?php if($userLang){ if($userLang == 'english') echo 'selected';} ?>>En</option>
                                <option value="french" <?php if($userLang){ if($userLang == 'french') echo 'selected';} ?>>Fr</option>
                            </select>
                        </form>    
                    </div>
                <div class="sous-menu d-inline-block">
                    <h3 class="bg-main-color p-2 m-0 rounded sous-menu-name"><?= $_SESSION['useradmin']; ?></h3>
                    <ul class="links list-unstyled bg-main-color text-center py-3">
                        <li><a href="../index.php" class="text-second-color text-capitalize my-3 font-weight-bold"><?= lang('visit shop'); ?></a></li>
                        <li><a href="#" class="text-second-color text-capitalize my-3 font-weight-bold"><?= lang('settings'); ?></a></li>
                        <li><a href="#" class="text-second-color text-capitalize my-3 font-weight-bold"><?= lang('profile'); ?></a></li>
                        <li><a href="logout.php" class="text-second-color text-capitalize my-3 font-weight-bold"><?= lang('log out'); ?></a></li>
                    </ul>
                </div>
            </div>   
        </div>
    </div>
</header>

<?php 
        if(isset($_GET['do']) && $_GET['do'] == 'changeLang'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_SESSION['user']) || isset($_SESSION['useradmin'])){
                    $username   = $_SESSION['user']?$_SESSION['user']:$_SESSION['useradmin'];
                    $userid     = query('select','Users',['UserID'],[$username],['Username'])->fetchObject()->UserID;
                    $language   = $_POST['language'];
                    if($userid){
                        $updateLang = query('update','Users',['Lang'],[$language,$userid],['UserID']);
                    }
                    redirectPage(NULL,0);
                }
                

            }
        }
    ?>