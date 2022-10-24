<?php
$allowed_host = array('www.phpcluster.com', 'www.demos.phpcluster.com');

if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_host)) 
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    exit;
}
?> 
