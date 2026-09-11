<?php
require_once 'src/config.php';
require_once 'src/Database.php';
require_once 'src/Request.php';

$db = Database::getDBO();
$request = new Request();

require_once 'src/Auth.php';   

function to404(){
    header('Location: 404.php');
    exit;
}

function redirect($url){
    header('Location: ' . $url);
    exit;
}
?>