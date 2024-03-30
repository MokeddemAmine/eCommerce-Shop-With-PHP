

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
            
            $checkAdmin = query('select','users',['*'],[$username,$hashPass,1],['username','password','GroupID']);
            if($checkAdmin->rowCount() == 1){
                $getInfo = $checkAdmin->fetchObject();
                $_SESSION['useradmin'] = $getInfo->Username;
                header('Location: index.php');
            }
        }

        if(isset($_SESSION['useradmin'])){
            $latestReg  = 5;
            $latestItems = 5;
            $latestComments = 5;
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
                                <h6 class="text-center display-4"><a href="items.php" class="text-white"><?= query('select','Items',['*'])->rowCount(); ?></a></h6>
                            </div>
                        </div>
                    </div>
                    <div class="stats-box col-md-6 col-lg-3 p-2">
                        <div class="stats-box-content d-flex align-items-center justify-content-between bg-fourth-color p-2">
                        <i class="fa-solid fa-comments fa-3x"></i>
                            <div class="stats-box-content">
                                <h5 class="text-capitalize"><?= lang('total comments'); ?></h5>
                                <h6 class="text-center display-4"><a href="comments.php" class="text-white"><?= query('select','Comments',['*'])->rowCount(); ?></a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="latests my-5">
            <div class="container">
                <div class="row">
                    <div class="latest-registered col-lg-6">
                        <div class="card">
                            <div class="card-header bg-main-color text-white d-flex justify-content-between align-items-center">
                                <div class="card-title m-0 text-capitalize">
                                    <i class="fa-solid fa-users"></i>
                                    <?= lang('latest') ?> <?= $latestReg ?> <?= lang('registered user') ?>
                                </div>
                                <i class="fa-solid fa-minus toggle-latest"></i>
                            </div>
                            <div class="card-body">
                                <?php
                                $getLatestUsers = query('select','Users',['UserID','Username'],NULL,NULL,'UserID','DESC',$latestReg);
                                while($row = $getLatestUsers->fetchObject()){
                                    echo '<div class="d-flex justify-content-between align-items-center mb-1">';
                                        echo '<h6>'.$row->Username.'</h6>';
                                        echo '<a href="members.php?do=Edit&userid='.$row->UserID.'" class="btn btn-success btn-sm text-capitalize"><i class="fa-solid fa-edit"></i> edit</a>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="latest-items-added col-lg-6">
                        <div class="card">
                            <div class="card-header bg-main-color text-white d-flex justify-content-between align-items-center">
                                <div class="card-title m-0 text-capitalize">
                                    <i class="fa-solid fa-tag"></i>
                                    <?= lang('latest') ?> 5 <?= lang('added item') ?>
                                </div>
                                <i class="fa-solid fa-minus toggle-latest"></i>
                            </div>
                            <div class="card-body">
                                <?php
                                $getLatestItems = query('select','Items',['ItemID','Name'],NULL,NULL,'ItemID','DESC',$latestItems);
                                while($row = $getLatestItems->fetchObject()){
                                    echo '<div class="d-flex justify-content-between align-items-center mb-1">';
                                        echo '<h6>'.$row->Name.'</h6>';
                                        echo '<a href="items.php?do=Edit&itemid='.$row->ItemID.'" class="btn btn-success btn-sm text-capitalize"><i class="fa-solid fa-edit"></i> edit</a>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="latest-comments col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-header bg-main-color text-white d-flex justify-content-between align-items-center">
                                <div class="card-title m-0 text-capitalize">
                                    <i class="fa-solid fa-comments"></i>
                                    <?= lang('latest') ?> <?= $latestReg ?> <?= lang('comments') ?>
                                </div>
                                <i class="fa-solid fa-minus toggle-latest"></i>
                            </div>
                            <div class="card-body">
                                <?php
                                $getLatestComments = query('select','Comments INNER JOIN Users ON Comments.UserID = Users.UserID',['Comments.Comment AS Comment','Users.Username AS Username'],NULL,NULL,'CommentID','DESC',$latestComments);
                                while($row = $getLatestComments->fetchObject()){
                                    echo '<div class="d-flex align-items-center mb-1">';
                                        echo '<h6 class="
                                        username m-0 mr-3 mb-3">'.$row->Username.'</h6>';
                                        echo '<p class="comment m-0 mb-3 p-2">'.$row->Comment.'</p>'; 
                                    echo '</div>';
                                }
                                ?>
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
                        <h4 class="text-capitalize text-second-color"><?= lang('admin login') ?></h4>
                        <input type="text" name="username" data-text="" placeholder="<?= lang('username') ?>"  class="form-control my-4"/>
                        <input type="password" name="password" data-text="" placeholder="<?= lang('password') ?>" class="form-control my-4"/>
                        <input type="submit" value="log in" name="login" class="btn bg-second-color text-main-color text-uppercase">
                    </form>
                </div>
            </section>
            <?php
        }
        include $template.'footer.php';
        ob_end_flush();
    ?>
