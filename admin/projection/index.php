<?php
    require_once '../../src/Functions/helpers.php'; 
    $url = getFullUrl('projection').'/admin'; 
    header("Location: $url");
    exit();
?>