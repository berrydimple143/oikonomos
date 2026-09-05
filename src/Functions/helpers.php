<?php
    if(!function_exists('includeWithArgs') || !function_exists('truncateText') || !function_exists('getFullUrl')) {

        function includeWithArgs($filePath, $args = []) {
            if (file_exists($filePath)) {
                // Extract array keys into local variables
                extract($args); 
                include $filePath;
            }
        }

        function truncateText($text, $limit) {
            $short_text = $text;
            if (strlen($text) > $limit) {
                // Cut the text, then find the position of the last space to avoid cutting a word
                $short_text = substr($text, 0, $limit);
                $short_text = substr($short_text, 0, strrpos($short_text, ' ')) . '...';
            }
            return $short_text;
        }

        function getFullUrl() {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $uri = $_SERVER['REQUEST_URI'];
            $full_url = $protocol . '://' . $host . $uri;
            return str_replace("/admin/", "", $full_url);
        }
    }
?>