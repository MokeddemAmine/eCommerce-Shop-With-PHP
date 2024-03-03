<?php
    function lang($sentence){
        static $lang = array(
            'welcome'           => 'Willkommen'
        );
        return $lang($sentence);
    }
?>