<?php
require_once 'src/Base.php';
session_unset();
session_destroy();
redirect('index.php');
?>