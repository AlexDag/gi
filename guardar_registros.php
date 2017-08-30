<?php session_start();
include ("conexion.php");
include ("common.php");
//cc
//file_put_contents("postLOg.log",print_r($points,true));
 $user = $_SESSION['usuario'];
//var_dump ($user);

 if( (is_user($pdo, $user)) && (isset($_POST['datos']))  ) {
	 $datos = $_POST['datos'] ;
	 try {
		 $pdo->beginTransaction();
		 $registers ='';
		 foreach ($datos as $res) {

			 $tipo_archivo = $res[0];
			 $obras = $res[1];
			 $cuil = $res[2];
			 $codigo_certificado = $res[3];
			 $vencim_certificado = $res[4];
			 $periodo_prestacion = $res[5];
			 $cuit_prestador = $res[6];
			 $tipo_comprobante = $res[7];
			 $tipo_emision = $res[8];
			 $fecha_emision = $res[9];
			 $nro_cae = $res[10];
			 $punto_venta = $res[11];
			 $nro_comprobante = $res[12];
			 $importe_cmprobante = $res[13];
			 $importe_solicitad = $res[14];
			 $codigo_ptractica = $res[15];
			 $cantidad = $res[16];
			 $provincia = $res[17];
			 $dependencia = $res[18];
			 $registers = $registers.$res[0].'|'.$res[1].'|'.$res[2].'|'.$res[3].'|'.$res[4].'|'.$res[5].'|'.$res[6]
				 .$res[7].'|'.$res[8].'|'.$res[9].'|'.$res[10].'|'.$res[11].'|'.$res[12].'|'.$res[13]
				 .$res[14].'|'.$res[15].'|'.$res[16].'|'.$res[17].'|'.$res[18];

			 $sql = "insert into registros_descapacitados VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
			 $smt = $pdo->prepare($sql);

			 $smt->execute(array($tipo_archivo, $obras, $cuil, $codigo_certificado, $vencim_certificado, $periodo_prestacion,
				 $cuit_prestador, $tipo_comprobante, $tipo_emision, $fecha_emision, $nro_cae, $punto_venta, $nro_comprobante, $importe_cmprobante, $importe_solicitad,
				 $codigo_ptractica, $cantidad, $provincia, $dependencia, $user));

		 }//foreach
		 $pdo->commit();

		 $ffile= 'file.txt';
		 $path ='files/'. $ffile;
		 $handle = fopen($path, "w");
		 fwrite($handle, $registers);
		 fclose($handle);

		 header('HTTP/1.1 200');
		 header('Content-Type: application/json; charset=UTF-8');
		 die(json_encode(array('message' => $ffile)));

	 } catch (Exception $e) {
		 error_log(' error: ', './tmp/insertError.log');
		 $pdo->rollBack();

		 header('HTTP/1.1 500 Error al insertar los registros...');
		 header('Content-Type: application/json; charset=UTF-8');
		 die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
	 }
 }
 else {

		 header('HTTP/1.1 500 Error al insertar los registros');
		 header('Content-Type: application/json; charset=UTF-8');
		 die(json_encode(array('message' => 'ERROR', 'code' => 1337)));

 }

				 //var_dump ($_POST);
				 //file_put_contents("postLOg.log",print_r($_POST,true));
/*
				 if(isset($_POST))
				 {
					 foreach($_POST as $inputName => $inputValue)
					 {
					 }
				 }
*/
?>
