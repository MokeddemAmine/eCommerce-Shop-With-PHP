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
            ?>
            <h2 class="text-center text-capitalize text-second-color my-5"><?= lang('manage comments') ?></h2>
            <?php 
                $getComments = query('select','Comments INNER JOIN Users ON Comments.UserID = Users.UserID INNER JOIN Items ON Comments.ItemID = Items.ItemID',['Comments.*','Users.Username AS Username','Items.Name AS ItemName']);
                if($getComments->rowCount() > 0){
            ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>#ID</th>
                        <th class="text-capitalize"><?= lang('comment') ?></th>
                        <th class="text-capitalize"><?= lang('comment date') ?></th>
                        <th class="text-capitalize"><?= lang('item name') ?></th>
                        <th class="text-capitalize"><?= lang('member') ?></th>
                        <th class="text-capitalize"><?= lang('control') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $getComments->fetchObject()){
                            //$itemName = query('select','Items',['ItemID','Name'],[$row->ItemID],['ItemID'])->fetchObject()->Name;
                            //$memberName = query('select','Users',['UserID','Username'],[$row->UserID],['UserID'])->fetchObject()->Username;
                            echo '<tr>';
                                echo '<td>'.$row->CommentID.'</td>';
                                echo '<td>'.$row->Comment.'</td>';
                                echo '<td>'.$row->Comment_Date.'</td>';
                                echo '<td>'.$row->ItemName.'</td>';
                                echo '<td>'.$row->Username.'</td>';
                                echo '<td>'; 
                                    echo '<a href="?do=Delete&commentid='.$row->CommentID.'" class="btn btn-danger btn-sm mr-1 confirm-delete">Delete</a>';
                                    if($row->Status == 0){
                                        echo '<a href="?do=Approve&commentid='.$row->CommentID.'" class="btn btn-info btn-sm">Approve</a>';
                                    }
                                echo'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
            <?php
                }else{
                    echo '<div class="bg-white">There are no comment</div>';
                }
        }elseif($page == 'Delete'){
            echo '<h2 class="text-centet text-capitalize text-second-color my-5">'.lang('delete comment').'</h2>';
            $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid'])?$_GET['commentid']:0;
            $verifyComment = query('select','Comments',['*'],[$commentid],['CommentID']);
            if($verifyComment->rowCount() == 1){
                $deleteComment = query('delete','Comments',['CommentID'],[$commentid]);
                redirectPage('back');
            }else{
                redirectPage();
            }
        }elseif($page == 'Approve'){
            echo '<h2 class="text-center text-capitalize text-second-color my-5">'.lang('approve comment').'</h2>';
            $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid'])?$_GET['commentid']:0;
            $verifyComment = query('select','Comments',['*'],[$commentid],['CommentID']);
            if($verifyComment->rowCount() == 1){
                $ApproveComment = query('update','Comments',['Status'],[1,$commentid],['CommentID']);
                redirectPage('back');
            }else{
                redirectPage();
            }
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