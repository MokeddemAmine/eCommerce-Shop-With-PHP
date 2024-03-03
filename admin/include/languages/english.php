<?php
    function lang($sentence){
        static $lang = array(
            'welcome'           => 'welcome',
            // header navbar
            'categories'        => 'categories',
            'items'             => 'items',
            'members'           => 'members',
            'comments'          => 'comments',
            'visit shop'        => 'visit shop',
            'settings'          => 'settings',
            'profile'           => 'profile',
            'log out'           => 'log out',
            // dashboard admin
            'dashboard'         => 'dashboard',
            'total memebers'    => 'total memebers',
            'pending members'   => 'pending members',
            'total items'       => 'total items',
            'total comments'    => 'total comments',
            // dashboard members
            'manage members'    => 'manage members',
            'no member exist'   => 'no member exist',
            'add member'        => 'add member',
        );
        return $lang[$sentence];
    }
?>