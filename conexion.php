<?php


/*
define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
*/
define('DB_HOST', 'localhost');
define('DB_PORT',3306);
define('DB_USER','id3066980_alex23ua');
define('DB_PASS','F0st1rR4Cnn');
define('DB_NAME','id3066980_gi');


$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;



try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR_pdo: ' . $e->getMessage();
}




/*try {
    $pdo = new PDO("mysql:host=//".$OPENSHIFT_MYSQL_DB_HOST.":".$OPENSHIFT_MYSQL_DB_PORT."/;dbname=gi,adminms6waN4,uVjp4Qaxw7DH",
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
c
*/
?>