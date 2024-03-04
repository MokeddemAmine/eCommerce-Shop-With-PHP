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
            'add new member'    => 'add new member',
            'username'          => 'username',
            'password'          => 'password',
            'email'             => 'email',
            'full name'         => 'full name',
            'avatar'            => 'avatar',
            'add member'        => 'add member',
            'insert member'     => 'insert member',
            'edit member'       => 'edit member',
            'update member'     => 'update member',
            'delete member'     => 'delete member',
            'approve member'    => 'approve member',
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
            'Info delete with success'          =>  'Info delete with success'
        );
        return $lang[$sentence];
    }
?>