<?php session_start();
include ("conexion.php");
include ("common.php");


function getFullDate6($fecha){
    $dia =substr($fecha,0,1);
    $mes=substr($fecha,1,1);
    $year=substr($fecha,2);
    return '0'.$dia.'/'.'0'.$mes.'/'.$year;
}
function getFullDateForDataBase6($fecha){
    $dia =substr($fecha,0,1);
    $mes=substr($fecha,1,1);
    $year=substr($fecha,2);
    return $year.'/0'.$mes.'/0'.$dia;
}

function getFullDate8($fecha){
    $dia =substr($fecha,0,2);
    $mes=substr($fecha,2,2);
    $year=substr($fecha,4);
    return $dia.'/'.$mes.'/'.$year;
}

//12122016
function getFullDateForDataBase8($fecha){
    $dia =substr($fecha,0,2);
    $mes=substr($fecha,2,2);
    $year=substr($fecha,4);
    return $year.'/'.$mes.'/'.$dia;
}

//cc
//file_put_contents("postLOg.log",print_r($points,true));
 $user = $_SESSION['usuario'];

//var_dump ($user);
//file_put_contents("postLOg.log",print_r($_POST['datos'],true));
 if( (is_user($pdo, $user)) && (isset($_POST['datos']))  ) {
	 $datos = $_POST['datos'] ;

	 try {
		 $pdo->beginTransaction();

         $obrasarr = array();

         foreach ($datos as $res) {

             $registers = '';

			 $tipo_archivo = $res[0];
			 $obras = $res[1];
			 $cuil = $res[2];
			 $codigo_certificado = $res[3];
			 $fecha_vencim_certificado = $res[4];
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
			 $registo_unico = $res[19];





            if(strlen($fecha_vencim_certificado)==6){
                $fecha_vencim_certificado = getFullDateForDataBase6($fecha_vencim_certificado);
                $res[4] = getFullDate6( $res[4] );
            }
             if(strlen($fecha_emision)==6){
                 $fecha_emision = getFullDateForDataBase6($fecha_emision);
                 $res[9] =getFullDate6($res[9] );
             }


             if(strlen($fecha_vencim_certificado)==8){
                 $fecha_vencim_certificado = getFullDateForDataBase8($fecha_vencim_certificado);
                 $res[4] = getFullDate8( $res[4] );
             }
             if(strlen($fecha_emision)==8){
                 $fecha_emision = getFullDateForDataBase8($fecha_emision);
                 $res[9] =getFullDate8($res[9] );
             }
			/* $registers = $registers.$res[0].'|'.$res[1].'|'.$res[2].'|'.$res[3].'|'.$res[4].'|'.$res[5].'|'.$res[6].'|'
				 .$res[7].'|'.$res[8].'|'.$res[9].'|'.$res[10].'|'.$res[11].'|'.$res[12].'|'.$res[13].'|'
				 .$res[14].'|'.$res[15].'|'.$res[16].'|'.$res[17].'|'.$res[18]."\n";
*/

             $registers = $res[0].'|'.$res[1].'|'.$res[2].'|'.$res[3].'|'.$res[4].'|'.$res[5].'|'.$res[6].'|'
                 .$res[7].'|'.$res[8].'|'.$res[9].'|'.$res[10].'|'.$res[11].'|'.$res[12].'|'.$res[13].'|'
                 .$res[14].'|'.$res[15].'|'.$res[16].'|'.$res[17].'|'.$res[18]."\n";

                // se guarda los registros segun la obra social.




			 $sql = "insert into registros_descapacitados VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
			 $smt = $pdo->prepare($sql);

			 $smt->execute(array($registo_unico,$tipo_archivo, $obras, $cuil, $codigo_certificado, $fecha_vencim_certificado, $periodo_prestacion,
				 $cuit_prestador, $tipo_comprobante, $tipo_emision, $fecha_emision, $nro_cae, $punto_venta, $nro_comprobante, $importe_cmprobante, $importe_solicitad,
				 $codigo_ptractica, $cantidad, $provincia, $dependencia, $user));

             $ffile= str_pad($res[1], 6, '0', STR_PAD_LEFT);
             $obrasarr[$ffile]=  $obrasarr[$ffile].$registers;

		 }//foreach
		 $pdo->commit();
//El nombre del archivo una vez generado debe ser 123456_ds.txt, en donde:





		$fileList = '';
		 foreach ($obrasarr as $key => $value){
             // save to file
             $path ='zfiles/'.$user.'/'. $key.'_ds.txt';
             $handle = fopen($path, "w");
             fwrite($handle, $obrasarr[$key]);
             fclose($handle);



             if(strlen($fileList)>0){
                 $fileList = $fileList.','.$key;
             }
             else{
                 $fileList = $key;
             }

		 }

		 header('Content-Type: application/json; charset=UTF-8');
		 die(json_encode(array('message' => $fileList)));

	 } catch (Exception $e) {
		 error_log(' error: ', 'tmp/insertError.log');
		 file_put_contents("tmp/error.log",print_r($e->getMessage(),true));
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
