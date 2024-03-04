

    <?php
        ob_start();
        session_start();
        $pageTitle = 'Home';
        if(isset($_SESSION['useradmin'])){
            $navbar = 'include';
        }
        include 'init.php'; 

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashPass = sha1($password);
            
            $checkAdmin = query('select','users',['*'],[$username,$hashPass],['username','password']);
            if($checkAdmin->rowCount() == 1){
                $getInfo = $checkAdmin->fetchObject();
                $_SESSION['useradmin'] = $getInfo->Username;
                header('Location: index.php');
            }
        }

        if(isset($_SESSION['useradmin'])){
        ?>
        <section class="dashboard">
            <div class="container">
                <h2 class="text-center text-capitalize text-second-color my-5"><?= lang('dashboard'); ?></h2>
                <div class="dashboard-statistics row text-white">
                    <div class="stats-box col-md-6 col-lg-3  p-2">
                        <div class="stats-box-content d-flex align-items-center justify-content-between bg-main-color p-2">
                            <i class="fa-solid fa-users fa-3x"></i>
                            <div class="stats-box-content">
                                <h5 class="text-capitalize"><?= lang('total memebers'); ?></h5>
                                <h6 class="text-center display-4"><a href="members.php" class="text-white"><?= query('select','Users',['UserID'])->rowCount() -1; ?></a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="stats-box col-md-6 col-lg-3 p-2">
                        <div class="stats-box-content d-flex align-items-center justify-content-between bg-second-color p-2 text-center">
                            <i class="fa-solid fa-user-plus fa-2x"></i>
                            <div class="stats-box-content">
                                <h5 class="text-capitalize"><?= lang('pending members'); ?></h5>
                                <h6 class="text-center display-4"><a href="members.php?regStatus=0" class="text-white"><?= query('select','Users',['UserID'],[0],['RegStatus'])->rowCount() ?></a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="stats-box col-md-6 col-lg-3 p-2">
                        <div class="stats-box-content d-flex align-items-center justify-content-between bg-third-color p-2">
                            <i class="fa-solid fa-tag fa-3x"></i>
                            <div class="stats-box-content">
                                <h5 class="text-capitalize"><?= lang('total items'); ?></h5>
                                <h6 class="text-center display-4"><a href="items.php" class="text-white">3</a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="stats-box col-md-6 col-lg-3 p-2">
                        <div class="stats-box-content d-flex align-items-center justify-content-between bg-fourth-color p-2">
                        <i class="fa-solid fa-comments fa-3x"></i>
                            <div class="stats-box-content">
                                <h5 class="text-capitalize"><?= lang('total comments'); ?></h5>
                                <h6 class="text-center display-4"><a href="comments.php" class="text-white">53</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
        }else{
            ?>
            <section class="login-admin bg-main-color" style="height:100vh" >
                <div class="container text-center">
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="pt-5">
                        <h4 class="text-capitalize text-second-color">admin login</h4>
                        <input type="text" name="username" data-text="" placeholder="Username"  class="form-control my-4"/>
                        <input type="password" name="password" data-text="" placeholder="Password" class="form-control my-4"/>
                        <input type="submit" value="log in" name="login" class="btn bg-second-color text-main-color text-uppercase">
                    </form>
                </div>
            </section>
            <?php
        }
        include $template.'footer.php';
        ob_end_flush();
    ?>
