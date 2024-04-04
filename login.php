<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    require 'vendor/autoload.php';

    ob_start();
    session_start();
    $pageTitle = 'Login';
    include 'init.php';

    
    if(isset($_SESSION['user'])){
        redirectPage(NULL,0);
    }else{
        $page = isset($_GET['do'])?$_GET['do']:'';
        if($page == 'confirmEmail'){
            $code   = isset($_GET['code']) && is_string($_GET['code'])?$_GET['code']:0;
            $email  = isset($_GET['email']) && is_string($_GET['email'])?$_GET['email']:0;

            if($code != 0 && $email != 0){
                $getCode = query('select','Users',['EmailConfirm'],[$email],['Email'])->fetchObject()->EmailConfirm;
                if($getCode == $code){
                    
                    echo '<div class="container pt-5">';
                        $confirmEmail = query('update','Users',['EmailConfirm'],[1,$email],['Email']);
                         echo '<div class="alert alert-success">Email confirm with success you can <a href="?do=login">login</a> now</div>';
                    echo '</div>';
                }else{
                    redirectPage(NULL,0);
                }
            }else{
                redirectPage(NULL,0);
            }

        }elseif($page == 'ForgetPassword'){
            ?>
            <section class="forget-password my-5">
                <div class="container">
                    <div class="w-50 m-auto bg-second-color text-white rounded p-3">
                        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST" class="">
                            <h2 class="text-capitalize text-center text-main-color mb-4">forget password</h2>
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Enter your email here"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Send Code To Email" name="forget_password" class="btn bg-main-color text-second-color btn-block">
                            </div>
                        </form>
                    </div> 
                </div>
            </section>
            <?php
        }elseif($page == 'ResetPassword'){
            $email      = isset($_GET['email'])?filter_var($_GET['email'],FILTER_SANITIZE_EMAIL):NULL;
            $code       = isset($_GET['code'])?filter_var($_GET['code'],FILTER_SANITIZE_STRING):0;
            $verifyCode = query('select','Users',['*'],[$email,$code],['Email','Password_Update']);
            if($verifyCode->rowCount() == 1){
                ?>
                <section class="reset-password my-5">
                <div class="container">
                    <div class="w-50 m-auto bg-second-color text-white rounded p-3">
                        <form action="<?= $_SERVER['PHP_SELF'].'?do=UpdatePassword&email='.$email.'&code='.$code ?>" method="POST" class=""> 
                            <h2 class="text-capitalize text-center text-main-color mb-4">reset password</h2>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Enter your new password here"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password-confirm" placeholder="Repeat your new password"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Update Password" name="update_password" class="btn bg-main-color text-second-color btn-block">
                            </div>
                        </form>
                    </div> 
                </div>
            </section>
                <?php
            }else{
                redirectPage(NULL,0);
            }
        }elseif($page == 'UpdatePassword'){
            echo '<div class="container pt-5">';
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $email      = isset($_GET['email'])?filter_var($_GET['email'],FILTER_SANITIZE_EMAIL):NULL;
                $code       = isset($_GET['code'])?filter_var($_GET['code'],FILTER_SANITIZE_STRING):0;
                $verifyCode = query('select','Users',['*'],[$email,$code],['Email','Password_Update']);
                if($verifyCode->rowCount() == 1){
                    $password       = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
                    $passwordConfirm= filter_var($_POST['password-confirm'],FILTER_SANITIZE_STRING);
                    
                    $formError = array();

                    if(empty($password)){
                        $formError[] = '<div class="alert alert-danger">Please Enter The password</div>';
                    }
                    if(strlen($password) < 8){
                        $formError[] = '<div class="alert alert-danger">Password must have at least 8 characters</div>';
                    }
                    if($password != $passwordConfirm){
                        $formError[] = '<div class="alert alert-danger">Please Enter The Same Password</div>';
                    }
                    if(!empty($formError)){
                        foreach($formError as $error){
                            echo $error;
                        }
                    }else{
                        $updatePassword = query('update','Users',['password','Password_Update'],[sha1($password),0,$email],['Email']);
                        redirectPage();
                    }
                }else{
                    redirectPage(NULL,0);
                }
            }else{
                redirectPage(NULL,0);
            }
            echo '</div>';
        }elseif($page == 'login' || $page == 'register'){
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
                        <a href="?do=ForgetPassword" class="text-main-color font-weight-bold text-capitalize">forget password</a>
                        <div class="text-center"><?= lang('You have not an acount'); ?> <a class="register-go text-capitalize text-main-color"> <?= lang('Register') ?></a></div>
                    </div> 
                </div>
            </section>
        <?php
        }
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

            echo '<div class="container mt-5">';
            if(!empty($form)){
                foreach($form as $error){
                    echo $error;
                }
            }
            else{
                
                $emailConfirm = createID();
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'mokeddemamine1707@gmail.com';                     //SMTP username
                    $mail->Password   = 'hfwc pscq lukp gurw';                               //SMTP password
                    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('mokeddemamine1707@gmail.com', 'eCommerce Website');
                    $mail->addAddress($email, $name);     //Add a recipient
                    $mail->addReplyTo('mokeddemamine1707@gmail.com', 'eCommerce Website');

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Confirmation Email registration';
                    $mail->Body    = "<div style='text-align:center;margin-top:1rem;'>
                    <h2 style='color:#343f71;font-weight: bold;'>eCommerce Website</h2>
                    <p style='font-size:1.5rem;'>Welcome to your home. You can buy and sell anything you want in our platform of ecommerce</p>
                    <p style='font-size:1.5rem;'>Thank you for register in our ecommerce site</p>
                    <a href='ecommerce.local/login.php?do=confirmEmail&email=$email&code=$emailConfirm' style='cursor:pointer;background-color: #FBC40E;color:#343f71;padding:.5rem 1rem;text-decoration: none;text-transform: capitalize;border-radius:.5rem;'>confirm email</a>
                </div>";

                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $addUser = query('insert','Users',['FullName','Username','Email','EmailConfirm','password'],[$name,$username,$email,$emailConfirm,sha1($pass1)]);

                if($addUser){
                    echo '<div class="alert alert-success">You added with success you must confirm your email</div>';
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
        }elseif(isset($_POST['forget_password'])){
            echo '<div class="container mt-5">';

            $email      = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            
            $formError = array();

            $verifyEmail = query('select','Users',['*'],[$email],['Email']);

            if($verifyEmail->rowCount() == 0){
                $formError[] = '<div class="alert alert-danger">Email doesn\'t exist </div>';
            }

            if(empty($email)){
                $formError[] = '<div class="alert alert-danger">Please Enter Your Email</div>';
            }

            if(!empty($formError)){  
                foreach($formError as $error){
                    echo $error;
                }
            }else{
                $newCode = createID();
                $user   = $verifyEmail->fetchObject();
                
                $setCode = query('update','Users',['Password_Update'],[$newCode,$email],['Email']);

                $mail = new PHPMailer(true);

                try {
                    
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    
                    $mail->isSMTP();                                          
                    $mail->Host       = 'smtp.gmail.com';                   
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'mokeddemamine1707@gmail.com';                  
                    $mail->Password   = 'hfwc pscq lukp gurw';                             
                    $mail->SMTPSecure = 'ssl';          
                    $mail->Port       = 465;                                   

                    //Recipients
                    $mail->setFrom('mokeddemamine1707@gmail.com', 'eCommerce Website');
                    $mail->addAddress($email,$user->FullName);     
                    $mail->addReplyTo('mokeddemamine1707@gmail.com', 'eCommerce Website');

                    //Content
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'Reset Password';
                    $mail->Body    = "<div style='text-align:center;margin-top:1rem;'>
                                        <h2 style='color:#343f71;font-weight: bold;'>eCommerce Website</h2>
                                        <p style='font-size:1.5rem;'>Welcome to your home. You can buy and sell anything you want in our platform of ecommerce</p>
                                        <p style='font-size:1.5rem;'>Now you can reset your password</p>
                                        <a href='ecommerce.local/login.php?do=ResetPassword&email=$email&code=$newCode' style='cursor:pointer;background-color: #FBC40E;color:#343f71;padding:.5rem 1rem;text-decoration: none;text-transform: capitalize;border-radius:.5rem;'>reset password</a>
                                      </div>";

                    $mail->send();
                    echo '<div class="alert alert-success">Cose has been send. Verify your email</div>';
                } catch (Exception $e) {
                    echo "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
                }
            }
            echo '</div>';
        }
    }
    include $template . 'footer.php';
    ob_end_flush();
?>