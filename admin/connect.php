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
            // create instance object of PDO class 
            $pdo = new PDO('mysql:host=localhost;dbname=mysql','root','');
            // create database ecommerceShop:
            $db = $pdo->prepare('CREATE DATABASE ecommerceShop');
            $db->execute();
            // redefine instance object with my new database
            $pdo = new PDO($dsn,$user,$pass,$option);
            // create table Users
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
            // create table Categories
            $query  = $pdo->prepare('CREATE TABLE Categories(
                CatID SMALLINT AUTO_INCREMENT NOT NULL,
                Name VARCHAR(50) NOT NULL UNIQUE,
                Description TEXT,
                Ordering INT,
                Visibility TINYINT DEFAULT 1,
                Allow_Comments TINYINT DEFAULT 1,
                Allow_Ads TINYINT DEFAULT 1,
                CONSTRAINT categoriesPK PRIMARY KEY (CatID)
            )');
            $query->execute();
            $query = $pdo->prepare('CREATE TABLE Items(
                ItemID INT AUTO_INCREMENT NOT NULL,
                Name VARCHAR(50) NOT NULL,
                Description TEXT NOT NULL,
                Price DOUBLE not null,
                Currency Varchar(2) NOT NULL,
                Add_Date DATE default now(),
                Country_Name VARCHAR(20),
                Image VARCHAR(255),
                Status VARCHAR(50),
                Rating SMALLINT,
                CatID SMALLINT NOT NULL,
                MemberID INT NOT NULL,
                CONSTRAINT ItemIDPK PRIMARY KEY (ItemID),
                CONSTRAINT CatIDFK FOREIGN KEY (CatID) REFERENCES categories (CatID) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT MemberIDFK FOREIGN KEY (MemberID) REFERENCES Users (UserID) ON DELETE CASCADE ON UPDATE CASCADE
            )');
            $query->execute();
        }
    }
?>