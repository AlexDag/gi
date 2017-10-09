<?php session_start();
include ("conexion.php");
include ("common.php");


//file_put_contents("load1.log",print_r($_POST['datos'],true));
//file_put_contents("load2.log",print_r($_SESSION['usuario'],true));

$user = $_SESSION['usuario'];

if( (is_user($pdo, $user)) && (isset($_POST['datos']))  ) {
    $registr_unico = $_POST['datos'];

    $sql = "SELECT tipo_archivo, obras_socilales, cuil, codigo_certificado ,  DATE_FORMAT( vencim_certificado, '%d/%m/%Y' ) as vencim_certificado ".
           ", periodo_prestacion, cuit_prestador , tipo_comprobante , tipo_emision, DATE_FORMAT( fecha_emision, '%d/%m/%Y' ) as fecha_emision ".
           ", nro_cae, punto_venta, nro_comprobante ,importe_comprobante , 	importe_solicitado  ".
           ", codigo_practica, cantidad, provincia, dependencia FROM registros_descapacitados WHERE registro_unico = ?  AND user = ?";

    $smt = $pdo->prepare($sql);

    $smt->bindParam(1, $registr_unico, PDO::PARAM_STR, 20);
    $smt->bindParam(2, $user, PDO::PARAM_STR, 20);
    $smt->execute();


    $data = $smt->fetchAll(PDO::FETCH_ASSOC);


    header('Content-Type: application/json');
    echo json_encode(array('data' => $data));

}
?>