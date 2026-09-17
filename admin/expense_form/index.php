<?php
    require_once '../../src/Functions/helpers.php'; 
    $url = getFullUrl('expense_form').'/admin'; 
    header("Location: $url");
    exit();
?>