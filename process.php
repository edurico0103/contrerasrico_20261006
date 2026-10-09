<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Header: Origin, x-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Max-Age:1000');
header('Access-Control-Allow-Credentials: true');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');
require('classes/estudiante.class.php');

$Estudiante = new Estudiante();

//pregunto por el metodo enviado
if($_SERVER["REQUEST_METHOD"] === "GET"){
    //obtengo el valor del parametro enviado por la URL
    $tipo_peticion = ((isset($_GET["t"])) ? (($_GET["t"])!="" ? $_GET["t"] : null): null);
    //evaluo el valor del parametro
    switch($tipo_peticion){
        case "selectAll":
            //devuelve todos los registros
            $resultado = $Estudiante->obtenerEstudiantes();
        break;
        case "select":
            //devuelve un registro
            $id = ((isset($_GET["id"])) ? (($_GET["id"]!="") ? intval($_GET["id"]) : 0) : 0);//obtengo el valor del parametro id
            if($id > 0){
                //obtengo los datos del estudiante en especifico
                $resultado = $Estudiante->obtenerEstudiante($id);
            }else{
                //no existe un valor para el parametro ID
                header('HTTP/1.1 412 Precondition Failed');
                $resultado = array("mensaje"=>"El parametro ID no es correcto","valores"=>"");
            }
        break;
        case "insert":
            //inserta un registro
            if(array_key_exists("fecha_nac",$_GET) and array_key_exists("id_genero",$_GET)){
                //si se enviaron valores desde el metodo GET
                if($_GET["fecha_nac"]!="" and $_GET["id_genero"]!=""){
                    $resultado = $Estudiante->nuevoEstudiante($_GET["fecha_nac"],$_GET["id_genero"]);
                }else{
                    //uno de los parametros enviados no posee valores
                    header('HTTP/1.1 400 Bad Request');
                    $resultado = array("mensaje"=>"Verifique el valor de la fecha de nacimiento o del genero","valores"=>"");
                }
            }else{
                //no se han enviado valores desde el metodo GET
                header('HTTP/1.1 400 Bad Request');
                $resultado = array("mensaje"=>"No se han enviado los parametros requeridos","valores"=>"");
            }
        break;
        default:
            //no se definio el tipo de peticion
            header('HTTP/1.1 403 Forbidden');
            $resultado = array("mensaje"=>"Debe indicar el tipo de procesamiento que se realizara","valores"=>"");
        break;
    }
}elseif($_SERVER["REQUEST_METHOD"] === "POST"){
            //inserta un registro
            if(array_key_exists("fecha_nac",$_POST) and array_key_exists("id_genero",$_POST)){
                //si se enviaron valores desde el metodo GET
                if($_POST["fecha_nac"]!="" and $_POST["id_genero"]!=""){
                    $resultado = $Estudiante->nuevoEstudiante($_GET["fecha_nac"],$_POST["id_genero"]);
                }else{
                    //uno de los parametros enviados no posee valores
                    header('HTTP/1.1 400 Bad Request');
                    $resultado = array("mensaje"=>"Verifique el valor de la fecha de nacimiento o del genero","valores"=>"");
                }
            }else{
                //no se han enviado valores desde el metodo GET
                header('HTTP/1.1 400 Bad Request');
                $resultado = array("mensaje"=>"No se han enviado los parametros requeridos","valores"=>"");
            }
}else{
     header('HTTP/1.1 400 Bad Request');
     $resultado = array("mensaje"=>"¿?", "valores"=>"");
}
header('Content-type: application/json');
echo(json_encode($resultado));
?>