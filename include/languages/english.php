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
            'Search Categories or Items Here'   => 'Search Categories or Items Here',
            // login page
            'Registration'                      => 'Registration',
            'login'                             => 'login',
            'Enter your name here'              => 'Enter your name here',
            'Enter your username'               => 'Enter your username',
            'Enter a valid email'               => 'Enter a valid email',
            'Enter a password'                  => 'Enter a password',
            'Repeat your password'              => 'Repeat your password',
            'Sign up'                           => 'Sign up',
            'Enter your username or email here' => 'Enter your username or email here',
            'Enter your password'               => 'Enter your password',
            'You have an acount '               => 'You have an acount ',
            'You have not an acount'            => 'You have not an acount',
            'Register'                          => 'Register',

        );
        return $lang[$sentence];
    }
?>