<?php session_start();
include ("conexion.php");
include ("common.php");


//file_put_contents("load1.log",print_r($_POST['datos'],true));
//file_put_contents("load2.log",print_r($_SESSION['usuario'],true));

$user = $_SESSION['usuario'];

if( (is_user($pdo, $user)) && (isset($_POST['datos']))  ) {
    $fecha = $_POST['datos'];




    $sql = "SELECT registro_unico, fecha_creacion FROM registros_descapacitados WHERE DATE_FORMAT( fecha_creacion, '%d-%m-%Y' ) = ?  AND user = ? GROUP BY registro_unico order by fecha_creacion desc";
  // $sql = "SELECT registro_unico, fecha_creacion FROM registros_descapacitados ";

        //file_put_contents("load4.log",'inside ....'.$sql,true);


    $smt = $pdo->prepare($sql);

    $smt->bindParam(1, $fecha, PDO::PARAM_STR, 12);
    $smt->bindParam(2, $user, PDO::PARAM_STR, 20);
    $smt->execute();


    $data = $smt->fetchAll(PDO::FETCH_ASSOC);


    header('Content-Type: application/json');
    echo json_encode(array('data' => $data));

}
?>