<?php
    // function for all queries v1.0

    function query($type,$table,$props,$values = NULL,$wprops = NULL){
        global $pdo;
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
                    $where .=$wprop.'=? AND ';
                }
                $where = 'WHERE '.substr_replace($where,' ',-4);
            }
            // get the query
            $query = $pdo->prepare("SELECT $select FROM $table $where ");
            $query->execute($values);
            return $query;
        }
    }
?>