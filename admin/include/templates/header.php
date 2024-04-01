<?php 
    $userLang = NULL;
    if(isset($_SESSION['useradmin'])) {
        $username   = $_SESSION['user']?$_SESSION['user']:$_SESSION['useradmin'];
        $userLang     = query('select','Users',['Lang'],[$username],['Username'])->fetchObject()->Lang;
    }
?>

<!DOCTYPE html>
<html lang="<?php if($userLang){ if($userLang == 'english') echo 'en'; elseif($userLang == 'french') echo 'fr';}else{echo 'en';} ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $css; ?>vendor/fonts/all.min.css"/>
    <link rel="stylesheet" href="<?= $css; ?>vendor/bootstrap_4.5.3.min.css"/>
    <link rel="stylesheet" href="<?= $css; ?>backend.css"/>
    <title><?php if(isset($pageTitle)) echo $pageTitle; else echo 'eCommerce'; ?></title>
</head>
<body>
