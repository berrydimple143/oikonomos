<?php
    require "./autoload.php";
    require_once './src/Functions/helpers.php';
    use App\Controllers\UsersController;
    $siteUrl = getOrigUrl();
    $query = getQueryStrings();
    $code = $query['code'];    
    $newUser = new UsersController();
    $info = $newUser->updatePlan($code);    
    if($info) {
        header("Location: $siteUrl/registration-successful.php");
        exit();
    } else {
        header("Location: $siteUrl/registration-failed.php");
        exit();
    }
?>