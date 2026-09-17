<?php
    require_once '../../src/Functions/helpers.php'; 
    $url = getFullUrl('attendance').'/admin'; 
    header("Location: $url");
    exit();
?>