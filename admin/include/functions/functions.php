<?php

    // redirect function:
    // function go to previous page or index page
    function redirectPage($page = NULL,$time = '3'){
        echo '<div class="alert alert-info">the page will redirect to ';
        if($page == NULL){
            echo 'Home page in '.$time.' second</div>';
            header("refresh:$time;url=index.php");

        }else{
            $page = $_SERVER['HTTP_REFERER'];
            echo 'Previous page in '.$time.' second</div>';
            header("refresh:$time;url=$page");
        }
        exit();
    }
    // function for all queries v1.0
    // v1.1 add negative values !=

    function query($type,$table,$props,$values = NULL,$wprops = NULL){
        global $pdo;
        try{
            if($type == 'select'){
                // get the columns 
                $select = '';
                foreach($props as $prop){
                    $select .=$prop.',';
                }
                $select = substr_replace($select,' ',-1);
                // get the where conditions columns
                $where = NULL;
                if($wprops){
                    $where = '';
                    foreach($wprops as $wprop){
                        if($wprop[0] == '!'){
                            $wprop = substr($wprop,1);
                            $where .=$wprop.' !=? AND ';
                        }
                        else{
                            $where .=$wprop.' =? AND ';
                        }
                    }
                    $where = 'WHERE '.substr_replace($where,' ',-4);
                }
                // get the query
                $query = $pdo->prepare("SELECT $select FROM $table $where ");
                $query->execute($values);
                return $query;
            }elseif ($type == 'insert'){
                $columns = '';
                $vals = '';
                foreach($props as $prop){
                    $columns.=$prop.',';
                    $vals .='?,';
                }
                $columns = substr_replace($columns,' ',-1);
                $vals = substr_replace($vals,' ',-1);
                $query = $pdo->prepare("INSERT INTO $table ($columns) VALUES ($vals)");  
                $query->execute($values);
                echo '<div class="alert alert-success">'.lang('Info added with success').'</div>';
            }
        }catch(PDOException $e){
            if(str_contains($e->getMessage(),'Duplicate entry')){
                if(str_contains($e->getMessage(),'Username')){
                    echo '<div class="alert alert-danger">'.lang('Username has been used').'</div>';
                    return false;
                }if(str_contains($e->getMessage(),'Email')){
                    echo '<div class="alert alert-danger">'.lang('Email has been used').'</div>';
                    return false;
                }
            }
        }
    }
?>