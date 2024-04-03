<?php
    ob_start();
    session_start();
    $pageTitle = 'settings';
    if(isset($_SESSION['user'])){
        include 'init.php';
        echo '<div class="container">';
        $page = isset($_GET['do'])?$_GET['do']:'manage';

        $getUser = query('select','Users',['*'],[$_SESSION['user']],['Username'])->fetchObject();
        if($page == 'manage'){
            ?>
            <h2 class="text-center text-second-color text-capitalize my-5"><?= lang('settings') ?></h2>
            <div class="card">
                <div class="card-body">
                    <form action="?do=UpdateUser" method="POST">
                        <input type="hidden" name="userid" value="<?= $getUser->UserID ?>">
                        <div class="form-group row align-items-center justify-content-center">
                            <label for="user-name" class="col-md-2 text-capitalize text-second-color font-weight-bold"><?= lang('full name') ?></label>
                            <div class="col-md-10 col-lg-8 col-xl-6">
                                <input type="text" name="name" value="<?= $getUser->FullName ?>" id="user-name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row align-items-center justify-content-center">
                            <label for="user-username" class="col-md-2 text-capitalize text-second-color font-weight-bold"><?= lang('username') ?></label>
                            <div class="col-md-10 col-lg-8 col-xl-6">
                                <input type="text" name="username" value="<?= $getUser->Username ?>" id="user-username" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row align-items-center justify-content-center">
                            <label for="user-email" class="col-md-2 text-capitalize text-second-color font-weight-bold"><?= lang('email') ?></label>
                            <div class="col-md-10 col-lg-8 col-xl-6">
                                <input type="email" name="email" value="<?= $getUser->Email ?>" class="form-control" id="user-email">
                            </div>  
                        </div>
                        <div class="form-group row align-items-center justify-content-center">
                            <label for="user-password" class="col-md-2 text-capitalize text-second-color font-weight-bold"><?= lang('password') ?></label>
                            <div class="col-md-10 col-lg-8 col-xl-6">
                                <input type="password" name="password" class="form-control" id="user-password" placeholder="Let it empty if you won't to change it">
                            </div>
                        </div>
                        <div class="form-group row align-items-center justify-content-center">
                            <div class="col-lg-10 col-xl-8">
                                <input type="submit" value="Update" class="btn btn-block bg-main-color text-second-color">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }elseif($page == 'UpdateUser'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">'.lang('update informations').'</h2>';
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $userid         = filter_var($_POST['userid'],FILTER_SANITIZE_NUMBER_INT);
                $name           = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
                $username       = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
                $email          = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                $password       = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

                $fomrError = array();

                if(empty($name)){
                    $formError[] = '<div class="alert alert-danger">'.lang('Name must be not empty').'</div>';
                }
                if(empty($username)){
                    $formError[] = '<div class="alert alert-danger">'.lang('Username must be not empty').'</div>';
                }
                if(empty($email)){
                    $formError[] = '<div class="alert alert-danger">'.lang('email must be not empty').'</div>';
                }
                if(strlen($name) < 4){
                    $formError[] = '<div class="alert alert-danger">'.lang('Name must has more than 3 characters').'</div>';
                }
                if(strlen($username) < 8){
                    $formError[] = '<div class="alert alert-danger">'.lang('Username must has more than 7 characters').'</div>';
                }
                if(strlen($password) > 0 && strlen($password) < 8){
                    $formError[] = '<div class="alert alert-danger">'.lang('Passwrod must has more than 7 characters').'</div>';
                }
                if(filter_var($email,FILTER_VALIDATE_EMAIL) != true){
                    $formError[] = '<div class="alert alert-danger">'.lang('Enter A Valid Email').'</div>';
                }
                if(!empty($formError)){
                    foreach($formError as $error){
                        echo $error;
                    }
                }else{
                    if(empty($password)){
                        $updateUser = query('update','Users',['FullName','Username','Email'],[$name,$username,$email,$userid],['UserID']);
                    }else{
                        $updateUser = query('update','Users',['FullName','Username','Email','Password'],[$name,$username,$email,sha1($password),$userid],['UserID']);
                    }
                    
                }
                redirectPage('back');

            }

        }
        echo '</div>';

    }else{
        redirectPage();
    }

    include $template.'footer.php';
    ob_end_flush();
?>