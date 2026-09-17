<?php
    require_once '../../src/Functions/helpers.php'; 
    $url = getFullUrl('expense').'/admin'; 
    header("Location: $url");
    exit();
?>