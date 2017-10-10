<?php session_start();
ob_start();
include ("conexion.php");
include ("common.php");

//1212016
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


function getFullDate7($fecha){
    $dia =substr($fecha,0,2);
    $mes=substr($fecha,1,1);
    $year=substr($fecha,3);
    return ''.$dia.'/'.'0'.$mes.'/'.$year;
}
function getFullDateForDataBase7($fecha){
    $dia =substr($fecha,0,2);
    $mes=substr($fecha,1,1);
    $year=substr($fecha,3);
    return $year.'/0'.$mes.'/'.$dia;
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

     //file_put_contents("1postLOg.log",print_r($_POST['datos'],true));
	 try {


		 $pdo->beginTransaction();

         $obrasarr = array();

         foreach ($datos as $res) {

             $registers = '';

			 $tipo_archivo = $res[1];
			 $obras = $res[2];
			 $cuil = $res[3];

             $res[4]= str_pad($res[4], 40, ' ', STR_PAD_RIGHT);
             $codigo_certificado = $res[4];

			 $fecha_vencim_certificado = $res[5];
			 $periodo_prestacion = $res[6];

             $res[7]= str_pad($res[7], 11, '0', STR_PAD_RIGHT);
			 $cuit_prestador = $res[7];

			 $tipo_comprobante = $res[8];
			 $tipo_emision = $res[9];
			 $fecha_emision = $res[10];

             $res[11] = str_pad($res[11], 14, '0', STR_PAD_LEFT);
			 $nro_cae = $res[11];

             $res[12] = str_pad($res[12], 4, '0', STR_PAD_LEFT);
			 $punto_venta = $res[12];

             $res[13] = str_pad($res[13], 8, '0', STR_PAD_LEFT);
             $nro_comprobante = $res[13];

             $res[14] =str_pad($res[14], 10, '0', STR_PAD_LEFT);
             $importe_cmprobante = $res[14];

             $res[15] =str_pad($res[15], 10, '0', STR_PAD_LEFT);
             $importe_solicitad = $res[15];
			 $codigo_ptractica = $res[16];


             $res[17] =str_pad($res[17], 6, '0', STR_PAD_LEFT);
			 $cantidad = $res[17];

			 $provincia = $res[18];
			 $registo_unico = $res[19];

             $dependencia = get_dependencia($pdo,$codigo_ptractica);





            if(strlen($fecha_vencim_certificado)==6){
                $fecha_vencim_certificado = getFullDateForDataBase6($fecha_vencim_certificado);
                $res[5] = getFullDate6( $res[5] );
            }
             if(strlen($fecha_emision)==6){
                 $fecha_emision = getFullDateForDataBase6($fecha_emision);
                 $res[10] =getFullDate6($res[10] );
             }

             if(strlen($fecha_vencim_certificado)==7){
                 $fecha_vencim_certificado = getFullDateForDataBase7($fecha_vencim_certificado);
                 $res[5] = getFullDate7( $res[5] );
             }
             if(strlen($fecha_emision)==7){
                 $fecha_emision = getFullDateForDataBase7($fecha_emision);
                 $res[10] =getFullDate7($res[10] );
             }

             if(strlen($fecha_vencim_certificado)==8){
                 $fecha_vencim_certificado = getFullDateForDataBase8($fecha_vencim_certificado);
                 $res[5] = getFullDate8( $res[5] );
             }
             if(strlen($fecha_emision)==8){
                 $fecha_emision = getFullDateForDataBase8($fecha_emision);
                 $res[10] =getFullDate8($res[10] );
             }
			/* $registers = $registers.$res[0].'|'.$res[1].'|'.$res[2].'|'.$res[3].'|'.$res[4].'|'.$res[5].'|'.$res[6].'|'
				 .$res[7].'|'.$res[8].'|'.$res[9].'|'.$res[10].'|'.$res[11].'|'.$res[12].'|'.$res[13].'|'
				 .$res[14].'|'.$res[15].'|'.$res[16].'|'.$res[17].'|'.$res[18]."\n";
*/

             $registers = $res[1].'|'.$res[2].'|'.$res[3].'|'.$res[4].'|'.$res[5].'|'.$res[6].'|'.$res[7].'|'
                 .$res[8].'|'.$res[9].'|'.$res[10].'|'.$res[11].'|'.$res[12].'|'.$res[13].'|'.$res[14].'|'
                 .$res[15].'|'.$res[16].'|'.$res[17].'|'.$res[18].'|'.$dependencia."\n";

                // se guarda los registros segun la obra social.




                $sql = "insert into registros_descapacitados VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
                $smt = $pdo->prepare($sql);

                $smt->execute(array($registo_unico, $tipo_archivo, $obras, $cuil, $codigo_certificado, $fecha_vencim_certificado, $periodo_prestacion,
                    $cuit_prestador, $tipo_comprobante, $tipo_emision, $fecha_emision, $nro_cae, $punto_venta, $nro_comprobante, $importe_cmprobante, $importe_solicitad,
                    $codigo_ptractica, $cantidad, $provincia, $dependencia, $user));



            // file_put_contents("aguardar.log",print_r($res[2],true));

             $ffile= str_pad($res[2], 6, '0', STR_PAD_LEFT);
             //file_put_contents("aguardar1.log",print_r($ffile,true));
             if(isset($obrasarr[$ffile]))   {
                 $obrasarr[$ffile].= $registers;
             } else {
                 $obrasarr[$ffile]= $registers;
             }


		 }//foreach
		 $pdo->commit();

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
		 //error_log(' error: ', 'tmp/insertError.log');
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

 }?>

