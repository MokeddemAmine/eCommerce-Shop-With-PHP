<?php
    function lang($sentence){
        static $lang = array(
            'welcome'           => 'welcome'
        );
        return $lang($sentence);
    }
?>