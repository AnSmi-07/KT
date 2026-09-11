<?php
require_once 'src/Base.php';
unset($_SESSION['user_id']);
redirect('index.php');
?>