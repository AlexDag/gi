<?php



/***********************************************************************************************************
**	string function add_options(array anArray, [int valueToBeSelected]):
**		The first argument is an array to make with them the options and the second argument is optional is a
**  value that gonna be selected in the option. Return the options for a select (combo), with the key of the 
**  array as value of the option and the value of the array in the visible part of the option
***/
function add_options()
{
    $theArray = func_get_arg(0);


    if(func_num_args() > 1)
    {
        $valueToBeSelected = func_get_arg(1);
        if (!is_array($valueToBeSelected)){
		$valueToBeSelected = array($valueToBeSelected);
		}


        foreach ( $theArray as $key => $value )
        {
            if($valueToBeSelected != "" && in_array($key,$valueToBeSelected))
            {
                $options .= "<option selected value = \"$key\">$value</option>";
            }
            else
            {
                $options .= "<option value = \"$key\">$value</option>";                
            }
        }


        return $options;            
    }
    else
    {
        foreach ( $theArray as $key => $value )
        {
            $options .= "<option value = \"$key\">$value</option>";            
        }   
        return $options;        
    }
}

function get_tipo_archivo($pdo)
{
	$sql = "SELECT tipo,valor FROM tipo_archivo ORDER BY valor ASC";
    $query = $pdo->prepare($sql);
    $pdo->beginTransaction();
    $query->execute();
    $pdo->commit();
    $ret='';
    while($row = $query->fetch()) {
        $id =  ( $row[tipo] );
        $ret[$id] = ( $row[valor]);
    }
    return $ret;
}

function get_provincias($pdo)
{
    $sql = "SELECT code,name FROM provincias ORDER BY name ASC";
    $query = $pdo->prepare($sql);
    $pdo->beginTransaction();
    $query->execute();
    $pdo->commit();
    $ret='';
    while($row = $query->fetch()) {
        $id =  ( $row[code] );
        $ret[$id] = ( $row[name]);
    }
    return $ret;
}

function get_obras_sociales($pdo)
{
    $sql = "SELECT codigo,valor FROM obras_socilaes ORDER BY valor ASC";
    $query = $pdo->prepare($sql);
    $pdo->beginTransaction();
    $query->execute();
    $pdo->commit();
    $ret='';
    while($row = $query->fetch()) {
        $id =  ( $row[codigo] );
        $ret[$id] = ( $row[valor]);
    }
    return $ret;
}

function get_practicas($pdo)
{
    $sql = "SELECT codigo,practica FROM practicas ORDER BY practica ASC";
    $query = $pdo->prepare($sql);
    $pdo->beginTransaction();
    $query->execute();
    $pdo->commit();
    $ret='';
    while($row = $query->fetch()) {
        $id =  ( $row[codigo] );
        $ret[$id] = ( $row[practica]);
    }
    return $ret;
}


function get_dependencias($pdo)
{
$sql = "SELECT codigo,valor FROM dependencias ORDER BY valor ASC";
    $query = $pdo->prepare($sql);
    $pdo->beginTransaction();
    $query->execute();
    $pdo->commit();
    $ret='';
    while($row = $query->fetch()) {
        $id =  ( $row[codigo] );
        $ret[$id] = ( $row[valor]);
    }
    return $ret;
}

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


function get_user2($pdo,$username)
{
    $query = $pdo->prepare("SELECT  username  from users  WHERE  username = ? ");
    $pdo->beginTransaction();
    $query->execute(array($username));
    $pdo->commit();

    while($row = $query->fetch()) {


        return $username==  $row['username'];
    }
    return false;
}
function in_array_r($needle, $haystack) {
    foreach ($haystack as $key => $value){

       if ($needle==$key)
           return true;
    }
    return false;
}

function sanitizion($str){
    file_put_contents("asanitis.log",print_r($str,true));
    $str = str_replace("?","",$str);
    $str = str_replace(".","",$str);
    $str = str_replace("..","",$str);
    $str = str_replace("'","",$str);
    $str = str_replace('"','',$str);
    $str = str_replace("(","",$str);
    $str = str_replace(")","",$str);
    $str = str_replace("?","",$str);
    $str = str_replace("{","",$str);
    $str = str_replace("}","",$str);
    $str = str_replace("[","",$str);
    $str = str_replace("]","",$str);
    $str = str_replace("*","",$str);
    $str = str_replace("!","",$str);
    $str = str_replace("%","",$str);
    $str = str_replace("/","",$str);
    $str = str_replace("\\","",$str);
    $str = str_replace("|","",$str);
    $str = str_replace("!","",$str);
    $str=preg_replace('/\s+/', '', $str);


    file_put_contents("asanitisdone.log",print_r($str,true));

    return $str;
}

?>