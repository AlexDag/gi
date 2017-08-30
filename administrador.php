<? session_start();


include_once ("conexion.php");
require ("lib/password.php")
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title>Gestion Integracion></title>

        
        <link rel="stylesheet" href="css/style.css" />

        <link rel="stylesheet" href="css/tabla.css" />
        <link rel="stylesheet" href="css/jquery.mobile-1.3.1.min.css" />

        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.datepicker.min.js"></script>
        <script type="text/javascript" src="js/bcrypt.min.js"></script>


    </head>
    <body>
        <!-- Home -->
        <div data-role="page" id="page1">
                 <?php


                 $usuario=$_POST['usuario'];
				 $clave=$_POST['clave'];

                 $query = $pdo->prepare("SELECT   psswd  from users  WHERE  username = ? ");
                 $pdo->beginTransaction();
                 $query->execute(array($usuario));
                 $pdo->commit();

                 if($query) {

                     $row = $query->fetch(PDO::FETCH_ASSOC);
                     $ppss = $row['psswd'];

                 

                        // password failed
                     if( !password_verify($clave, $ppss)){
                         echo "<p>  Error al identificar el usuario </p>";
                         return;
                     }



					$_SESSION['usuario'] = $usuario;

					include "header.php";
					include "menu_principal.php";

						
				}
				else{

                    echo "<p>  Error al identificar el usuario </p>";
					 
				}
				  ?>
				

				
        </div>
    </body>
</html>