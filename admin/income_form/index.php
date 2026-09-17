<?php
    require_once '../../src/Functions/helpers.php'; 
    $url = getFullUrl('income_form').'/admin'; 
    header("Location: $url");
    exit();
?>