<?php
    ob_start();
    session_start();
    if(isset($_SESSION['useradmin'])){
        $navbar = 'include';
        include 'init.php';
        $page = isset($_GET['do'])?$_GET['do']:'manage';
        echo '<section class="Comments">';
        echo '<div class="container">';
        if($page == 'manage'){

        }elseif($page == 'Edit'){

        }elseif($page == 'Update'){

        }elseif($page == 'Delete'){

        }else{
            redirectPage(NULL,0);
        }
        echo '</div>';
        echo '</section>';
    }else{
        redirectPage();
    }

    include $template . 'footer.php';
    ob_end_flush();
?>