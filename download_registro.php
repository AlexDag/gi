<?php
session_start();
function is_user($pdo,$username)
{
    $sql = "SELECT username FROM users where username = ?";
    $query = $pdo->prepare($sql);
    $pdo->beginTransaction();
    $query->execute(array($username));
    $pdo->commit();

    while($row = $query->fetch()) {
        return $username== $row['username'];
    }
    return false;
}



if(isset($_GET["p"])  ){


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

    if (is_user($pdo,$_SESSION['usuario'])) {
        try {
        $user = $_SESSION['usuario'];


        //$files = urldecode($_GET["p"]); // Decode URL-encoded string
        $files = explode(',',urldecode($_GET["p"]));

        $files =   str_replace(".","",$files);
        $files =   str_replace("..","",$files);
        $files =   str_replace("/","",$files);
        $files =   str_replace(" ","",$files);
        $files =   str_replace("!","",$files);
        $files =   str_replace("*","",$files);



        $filepath = array();
        foreach( $files as $value){
           // array_push ( $filepath , 'zfiles/'.$user.'/' . $value.'_ds.txt' );
            array_push ( $filepath ,  $value.'_ds.txt' );
        }

       $fecha = new DateTime();

            chdir('zfiles/'.$user);
            $zipname = 'gestion_integracion.zip';
            $zip = new ZipArchive;


        $zip->open($zipname, ZipArchive::CREATE);

        foreach ($filepath as $file) {
            $zip->addFile($file);
        }
        $zip->close();




        } catch(Exception $e) {
            echo 'ERROR_pdo: ' . $e->getMessage();
            file_put_contents("download_error.log",print_r($e->getMessage(),true));
        }
        header('Content-Description: File Transfer');
       // header('Content-Type: application/octet-stream');
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipname) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zipname));
        flush(); // Flush system output buffer
        readfile($zipname);

        unlink($zipname);



        exit;

    }
}
?>