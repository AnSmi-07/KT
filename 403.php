<?php
require_once 'src/Base.php';
header('HTTP/1.0 403 Forbidden');
$title = 'Доступ запрещён';
$content = '403';
require_once 'html/main.php';
?>