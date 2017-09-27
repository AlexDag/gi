<? session_start();
function is_user($pdo,$username)
{
    $sql = "SELECT username FROM users where username = ?";
    $query = $pdo->prepare($sql);
    $pdo->beginTransaction();
    $query->execute(array($username));
    $pdo->commit();

    while($row = $query->fetch()) {


        return $username== $row[username];
    }
    return false;
}



if(isset($_GET["p"])  ){




    define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
    define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
    define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
    define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
    define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));

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
//         file_put_contents("after.log",print_r($files,true));


        $filepath = array();
        foreach( $files as $value){
           // array_push ( $filepath , 'zfiles/'.$user.'/' . $value.'_ds.txt' );
            array_push ( $filepath ,  $value.'_ds.txt' );
        }



       $fecha = new DateTime();

      //  $zipname = 'zfiles/'.$user.'/gestion_integracion_'.$fecha->getTimestamp().'.zip';

            chdir('zfiles/'.$user);
            $zipname = 'gestion_integracion.zip';
            $zip = new ZipArchive;


        $zip->open($zipname, ZipArchive::CREATE);
        foreach ($filepath as $file) {
            $zip->addFile($file);
        }
        $zip->close();

        } catch(PDOException $e) {
            echo 'ERROR_pdo: ' . $e->getMessage();
            file_put_contents("error.log",print_r($e->getMessage(),true));
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

