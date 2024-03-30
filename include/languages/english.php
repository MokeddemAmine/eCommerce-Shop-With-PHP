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
            'Enter your comment to this product'=> 'Enter your comment to this product',
            'add new images to item'            => 'add new images to item',
            'Name must be not empty'            => 'Name must be not empty',
            'Username must be not empty'        => 'Username must be not empty',
            'email must be not empty'           => 'email must be not empty',
            'Name must has more than 3 characters'=> 'Name must has more than 3 characters',
            'Username must has more than 7 characters'=> 'Username must has more than 7 characters',
            'Passwrod must has more than 7 characters'=> 'Passwrod must has more than 7 characters',
            'Enter A Valid Email'               => 'Enter A Valid Email',
            'update informations'               => 'update informations',
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

            // main page
            'click here'                        => 'click here',
            'show more'                         => 'show more',

            // items page
            'item'                              => 'item',
            'items'                             => 'items',
            'add new item'                      => 'add new item',
            'Enter the title'                   => 'Enter the title',
            'Enter the description'             => 'Enter the description',
            'Enter the price'                   => 'Enter the price',
            'Country Made'                      => 'Country Made',
            'Status'                            => 'Status',
            'new'                               => 'new',
            'like new'                          => 'like new',
            'used'                              => 'used',
            'Category'                          => 'Category',
            'Sub Category'                      => 'Sub Category',
            'add images to item'                => 'add images to item',
            'title here'                        => 'title here',
            'description here'                  => 'description here',
            'show more images'                  => 'show more images',
            'name'                              => 'name',
            'username'                          => 'username',
            'email'                             => 'email',
            'description'                       => 'description',
            'country'                           => 'country',
            'price'                             => 'price',
            'category'                          => 'category',
            'status'                            => 'status',
            'added date'                        => 'added date',
            'edit'                              => 'edit',
            'delete'                            => 'delete',
            'You have to'                       => 'You have to',
            'For Comment'                       => 'For Comment',
            'comment'                           => 'comment',
            'comment date'                      => 'comment date',
            'edit item'                         => 'edit item',
            'delete item'                       => 'delete item',

            // profile page

            'profile'                           => 'profile',
            'information'                       => 'information',
            'comments'                          => 'comments',
            'There are no comment'              => 'There are no comment',
            'There are no item'                 => 'There are no item',

            // settings page
            'settings'                          => 'settings',
            'full name'                         => 'full name',
            'password'                          => 'password',



        );
        return $lang[$sentence];
    }
?>