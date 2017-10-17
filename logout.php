<?php
ob_start();
unset($_SESSION['usuario']);
session_start();
session_destroy();
$_SESSION = [];
header ("Location: index.php");
exit;?>