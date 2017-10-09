<?php




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