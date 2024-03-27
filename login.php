<?php
    ob_start();
    session_start();
    $pageTitle = 'Login';
    include 'init.php';

    
    if(isset($_SESSION['user'])){
        redirectPage(NULL,0);
    }else{
        $page = isset($_GET['do'])?$_GET['do']:'';
        ?>
            <section class="register my-5" <?php if($page == 'login'){
                echo 'style="display:none"';
            } ?>>
                <div class="container">
                    <div class="w-50 m-auto bg-second-color text-white rounded p-3" <?php if($page == '') echo 'style="display:none;"' ?>>
                        <form action="<?= $_SERVER['PHP_SELF'].'?do=register' ?>" method="POST" class="">
                            <h2 class="text-capitalize text-center text-main-color mb-4"><?= lang('Registration') ?></h2>
                            <div class="form-group">
                                <input type="text" name="name" placeholder="<?= lang('Enter your name here') ?>"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" placeholder="<?= lang('Enter your username') ?>"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="<?= lang('Enter a valid email') ?>"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="<?= lang('Enter a password') ?>" >
                            </div>
                            <div class="form-group">
                                <input type="password" name="password-confirm" placeholder="<?= lang('Repeat your password') ?>"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="<?= lang('Sign up') ?>" name="sign_up" class="btn bg-main-color text-second-color btn-block">
                            </div>
                        </form>
                        <div class="text-center"><?= lang('You have an acount '); ?><a class="login-go text-capitalize text-main-color"> <?= lang('login') ?></a></div>
                    </div> 
                </div>
            </section>
            <section class="login my-5" <?php if($page == 'register'){
                echo 'style="display:none"';
            } ?>>
                <div class="container">
                    <div class="w-50 m-auto bg-second-color text-white rounded p-3">
                        <form action="<?= $_SERVER['PHP_SELF'].'?do=login' ?>" method="POST" class="">
                            <h2 class="text-capitalize text-center text-main-color mb-4"><?= lang('login') ?></h2>
                            <div class="form-group">
                                <input type="text" name="user" placeholder="<?= lang('Enter your username or email here'); ?>"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="<?= lang('Enter your password'); ?>"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="<?= lang('login') ?>" name="sign_in" class="btn bg-main-color text-second-color btn-block">
                            </div>
                        </form>
                        <div class="text-center"><?= lang('You have not an acount'); ?> <a class="register-go text-capitalize text-main-color"> <?= lang('Register') ?></a></div>
                    </div> 
                </div>
            </section>
        <?php
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['sign_up'])){

            $name       = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $username   = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
            $email      = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $pass1      = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $pass2      = filter_var($_POST['password-confirm'],FILTER_SANITIZE_STRING);

            $form = array();

            if(strlen($name) < 4){
                $form[] = '<div class="alert alert-danger">Name must be has more than 4 characters</div>';
            }
            if(strlen($username) < 6){
                $form[] = '<div class="alert alert-danger">Username must be has more than 6 characters</div>';
            }
            if(empty($email)){
                $form[] = '<div class="alert alert-danger">Email must be entered</div>';
            }
            if(filter_var($email,FILTER_VALIDATE_EMAIL) != true){
                $form[] = '<div class="alert alert-danger">Enter a Valid Email</div>';
            }
            if(empty($pass1)){
                $form[] = '<div class="alert alert-danger">Password must be not empty</div>';
            }
            if(strlen($pass1) < 8){
                $form[] = '<div class="alert alert-danger">Password must have more than 8 characters</div>';
            }
            if($pass1 != $pass2){
                $form[] = '<div class="alert alert-danger">Please enter the same password</div>';
            }

            echo '<div class="container">';
            if(!empty($form)){
                foreach($form as $error){
                    echo $error;
                }
            }
            else{
                

                $addUser = query('insert','Users',['FullName','Username','Email','password'],[$name,$username,$email,sha1($pass1)]);

                if($addUser){
                    echo '<div class="alert alert-success">User Added with success you will wait to approve from admin</div>';
                }
                
            
            }
            echo '</div>';
        }elseif(isset($_POST['sign_in'])){
            $user       = filter_var($_POST['user'],FILTER_SANITIZE_STRING);
            $pass       = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

            $login = $pdo->prepare("SELECT * FROM Users WHERE (Username = ? OR Email = ?) AND password = ?");
            $login-> execute([$user,$user,sha1($pass)]);
            
            if($login->rowCount() == 1){
                $userlogin = $login->fetchObject();
                $_SESSION['user'] = $userlogin->Username;
                redirectPage(NULL,0);
            }
        }
    }
    include $template . 'footer.php';
    ob_end_flush();
?>