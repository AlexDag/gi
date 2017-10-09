<?php session_start();
ob_start();
include ("conexion.php");
include ("common.php");
//cc
//file_put_contents("postLOg.log",print_r($points,true));
 $user = $_SESSION['usuario'];

//var_dump ($user);
//file_put_contents("postLOg.log",print_r($_POST['datos'],true));
 if( (is_user($pdo, $user)) && (isset($_POST['datos']))  ) {
	 $datos = $_POST['datos'] ;

	 try {


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
			// $registo_unico = $res[19];


             $registers = $res[0].'|'.$res[1].'|'.$res[2].'|'.$res[3].'|'.$res[4].'|'.$res[5].'|'.$res[6].'|'
                 .$res[7].'|'.$res[8].'|'.$res[9].'|'.$res[10].'|'.$res[11].'|'.$res[12].'|'.$res[13].'|'
                 .$res[14].'|'.$res[15].'|'.$res[16].'|'.$res[17].'|'.$res[18]."\n";



             $ffile= str_pad($res[1], 6, '0', STR_PAD_LEFT);

             if(isset($obrasarr[$ffile]))   {
                 $obrasarr[$ffile].= $registers;
             } else {
                 $obrasarr[$ffile]= $registers;
             }

		 }//foreach

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
         file_put_contents("error.log",print_r($e->getMessage(),true));
		 header('HTTP/1.1 500 Error al re-crear los archivos...');
		 header('Content-Type: application/json; charset=UTF-8');
		 die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
	 }
 }
 else {
		 header('HTTP/1.1 500 Error al re-crear los archivos');
		 header('Content-Type: application/json; charset=UTF-8');
		 die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
 }
?>