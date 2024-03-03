<?php
    $dsn = 'mysql:host=localhost;dbname=ecommerceShop';
    $user = 'root';
    $pass = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
    
    try{
        $pdo = new PDO($dsn,$user,$pass,$option);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        if(str_contains($e->getMessage(),'Unknown database')){
            $pdo = new PDO('mysql:host=localhost;dbname=mysql','root','');
            $db = $pdo->prepare('CREATE DATABASE ecommerceShop');
            $db->execute();
            $pdo = new PDO($dsn,$user,$pass,$option);
            $query = $pdo->prepare('CREATE TABLE Users(
                UserID INT AUTO_INCREMENT NOT NULL,
                Username VARCHAR(30) NOT NULL UNIQUE,
                password VARCHAR(50) NOT NULL,
                Email VARCHAR(50) NOT NULL UNIQUE,
                FullName VARCHAR(50) NOT NULL,
                GroupID INT DEFAULT 0,
                TrustStatus INT,
                RegStatus INT DEFAULT 0,
                RegData DATE DEFAULT now(),
                CONSTRAINT usersPK PRIMARY KEY (UserID) 
            )');
            $query->execute();
        }
    }
?>