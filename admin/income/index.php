<?php
    require_once '../../src/Functions/helpers.php'; 
    $url = getFullUrl('income').'/admin'; 
    header("Location: $url");
    exit();
?>