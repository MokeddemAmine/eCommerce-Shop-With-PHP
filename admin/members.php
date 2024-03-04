<?php
    ob_start();
    session_start();
    $pageTitle = 'Members';
    if(isset($_SESSION['useradmin'])){
        $navbar = 'include';
        include 'init.php';
        $page = isset($_GET['do'])?$_GET['do']:'manage';
        echo '<section class="members">';
        echo '<div class="container">';
        if($page == 'manage'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">'. lang('manage members') .'</h2>';
            $getMembers = query('select','Users',['*'],[1],['!UserID']);
            if($getMembers->rowCount() > 0){
                ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-capitalize">#ID</th>
                            <th class="text-capitalize">username</th>
                            <th class="text-capitalize">email</th>
                            <th class="text-capitalize">full name</th>
                            <th class="text-capitalize">registered date</th>
                            <th class="text-capitalize">control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($row = $getMembers->fetchObject()){
                                echo '<tr>';
                                echo '<td>'.$row->UserID.'</td>';
                                echo '<td>'.$row->Username.'</td>';
                                echo '<td>'.$row->Email.'</td>';
                                echo '<td class="text-capitalize">'.$row->FullName.'</td>';
                                echo '<td>'.$row->RegDate.'</td>';
                                echo '<td class="text-center">'; 
                                    echo '<a href="" class="btn btn-success btn-sm text-capitalize mr-1"><i class="fa-solid fa-edit"></i> edit</a>';
                                    echo '<a href="" class="btn btn-danger btn-sm text-capitalize"><i class="fa-solid fa-close"></i> delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
                <?php
            }else{
                echo '<div class="alert alert-secondary text-capitalize text-fourth-color">'.lang('no member exist').'</div>';
            }
            echo '<a href="?do=add" class="btn bg-second-color text-capitalize text-main-color">'.lang('add member').'</a>';
        }elseif ($page == 'add'){?>
            <h2 class="text-capitalize text-second-color text-center my-5"><?= lang('add new member') ?></h2>
            <form action="?do=Insert" method="POST">
                <div class="form-group row align-items-center">
                    <label for="add-username" class="col-2 font-weight-bold text-capitalize text-second-color"><?= lang('username'); ?></label>
                    <div class="col-12 col-md-10 col-lg-6">
                        <input type="text" name="username" id="add-username" class="form-control" placeholder="<?= lang('Username (8 character minimun)'); ?>" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="add-password" class="col-2 font-weight-bold text-capitalize text-second-color"><?= lang('password'); ?></label>
                    <div class="col-12 col-md-10 col-lg-6">
                        <input type="password" name="password" id="add-password" placeholder="<?= lang('Password must be >= 8 characters'); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="add-email" class="col-2 font-weight-bold text-capitalize text-second-color"><?= lang('email'); ?></label>
                    <div class="col-12 col-md-10 col-lg-6">
                        <input type="email" name="email" id="add-email" placeholder="<?= lang('Email must be valid'); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="add-name" class="col-2 font-weight-bold text-capitalize text-second-color"><?= lang('full name') ?></label>
                    <div class="col-12 col-md-10 col-lg-6">
                        <input type="text" name="name" id="add-name" placeholder="<?= lang('Enter your full name'); ?>" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row align-items-center ">
                    <label for="add-avatar" class="col-2 font-weight-bold text-capitalize text-second-color"><?= lang('avatar'); ?></label>
                    <div class="col-12 col-md-10 col-lg-6">
                        <div class="custom-file">
                            <input type="file" name="avatar" id="add-avatar" class="custom-file-input">
                            <label for="add-avatar" class="custom-file-label text-capitalize"><?= lang('add your avatar here'); ?></label>
                        </div>
                        
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-8 mt-4">
                        <input type="submit" value="<?= lang('add member') ?>" class="btn btn-block bg-main-color text-second-color text-capitalize">
                    </div>
                </div>
            </form>
        <?php 
        }elseif($page == 'Insert'){
            echo '<h2 class="text-center text-second-color text-capitalize my-5">'.lang('insert member').'</h2>';
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $username   = $_POST['username'];
                $password   = $_POST['password'];
                $email      = $_POST['email'];
                $name       = $_POST['name'];

                $setMember = query('insert','Users',['Username','password','Email','FullName','RegStatus'],[$username,sha1($password),$email,$name,1]);
                
            }else{
                header('Location: index.php');
                exit();
            }
        }
        else{
            header('Location: index.php');
            exit();
        }
        echo '</div>';
        echo '</section>';
    }
    
    include $template.'footer.php';
    ob_end_flush();
?>