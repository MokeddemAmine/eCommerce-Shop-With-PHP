<?php
    ob_start();
    session_start();
    $pageTitle = 'Login';
    include 'init.php';

    
    if(isset($_SESSION['user'])){
        redirectPage();
    }else{
        $page = isset($_GET['do'])?$_GET['do']:'';
        ?>
            <section class="register my-5" <?php if($page == 'login'){
                echo 'style="display:none"';
            } ?>>
                <div class="container">
                    <div class="w-50 m-auto bg-second-color text-white rounded p-3">
                        <form action="" method="POST" class="">
                            <h2 class="text-capitalize text-center text-main-color mb-4">Registration</h2>
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Enter your name here"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" placeholder="Enter your username"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Enter a valid email"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Enter a password" >
                            </div>
                            <div class="form-group">
                                <input type="password" name="password-confirm" placeholder="Repeat your password"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Sign up" name="sign_up" class="btn bg-main-color text-second-color btn-block">
                            </div>
                        </form>
                        <div class="text-center">You have an acount <a class="login-go text-capitalize text-main-color"> login</a></div>
                    </div> 
                </div>
            </section>
            <section class="login my-5" <?php if($page == 'register'){
                echo 'style="display:none"';
            } ?>>
                <div class="container">
                    <div class="w-50 m-auto bg-second-color text-white rounded p-3">
                        <form action="" method="POST" class="">
                            <h2 class="text-capitalize text-center text-main-color mb-4">login</h2>
                            <div class="form-group">
                                <input type="text" name="user" placeholder="Enter your username or email here"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Enter your password"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="login" name="sign_in" class="btn bg-main-color text-second-color btn-block">
                            </div>
                        </form>
                        <div class="text-center">You have not an acount <a class="register-go text-capitalize text-main-color"> Register</a></div>
                    </div> 
                </div>
            </section>
        <?php
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['sign_up'])){
            $name       = $_POST['name'];
            $username   = $_POST['username'];
            $email      = $_POST['email'];
            $pass1      = $_POST['password'];
            $pass2      = $_POST['password-confirm'];

            echo '<div class="container">';
            if($pass1 == $pass2){
                

                query('insert','Users',['FullName','Username','Email','password'],[$name,$username,$email,sha1($pass1)]);
                
                echo '<div class="alert alert-success">User Added with success you will wait to approve from admin</div>';
                redirectPage(NULL,6);
            
            }else{
                echo '<div class="alert alert-danger">You must enter the same password</div>';
            }
            echo '</div>';
        }elseif(isset($_POST['sign_in'])){
            $user       = $_POST['user'];
            $pass      = $_POST['password'];

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