<?php
    function lang($sentence){
        static $lang = array(
            'welcome'           => 'Bienvenue'
        );
        return $lang($sentence);
    }
?>