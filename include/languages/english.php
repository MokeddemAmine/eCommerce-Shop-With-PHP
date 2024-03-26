<?php
    function lang($sentence){
        static $lang = array(
            'welcome'           => 'welcome',
            // long sentences
            'Username (8 character minimun)'    => 'Username (8 character minimun)',
            'Password must be >= 8 characters'  => 'Password must be >= 8 characters',
            'Email must be valid'               => 'Email must be valid',
            'Enter your full name'              => 'Enter your full name',
            'add your avatar here'              => 'add your avatar here',
            'Info added with success'           => 'Info added with success',
            'Info updated with success'         => 'Info updated with success',
            'Username has been used'            => 'Username has been used',
            'Email has been used'               => 'Email has been used',
            'Same password if you don\'t enter' => 'Same password if you don\'t enter',
            'Info delete with success'          =>  'Info delete with success',
            
        );
        return $lang[$sentence];
    }
?>