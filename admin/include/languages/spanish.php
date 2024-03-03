<?php
    function lang($sentence){
        static $lang = array(
            'welcome'           => 'bienvenida'
        );
        return $lang($sentence);
    }
?>