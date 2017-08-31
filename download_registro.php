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
        $file = urldecode($_GET["p"]); // Decode URL-encoded string


        $filepath = 'files/' . $file;

        // Process download
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit;
        }
    }
}
?>

