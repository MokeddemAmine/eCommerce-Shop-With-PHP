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
            echo '<a class="btn bg-second-color text-capitalize text-main-color">'.lang('add member').'</a>';
        }else{
            header('Location: index.php');
            exit();
        }
        echo '</div>';
        echo '</section>';
    }
    
    include $template.'footer.php';
    ob_end_flush();
?>