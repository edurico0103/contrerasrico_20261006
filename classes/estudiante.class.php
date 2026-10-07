<?php 
require("classes/conn.class.php");
require("classes/validaciones.inc.php");
class Estudiante{
    public $idestudiante;
    public $fechanacimiento;
    public $estadoregistroestudiante;
    public $idgenero;
    public $conexion;
    public $validacion;

    public function __construct(){
        $this->conexion = new DB();
        $this->validacion = new Validaciones();

    }

    public function setIdEstudiante($idestudiante){
        $this->idestudiante = intval($idestudiante);
    }

    public function getIdEstudiante(){
        return intval($this->idestudiante);
    }

    public function setFechaNacimiento($fechanacimiento){
        $this->fechanacimiento = $fechanacimiento;
    }

    public function getFechaNacimiento(){
        return $this->fechanacimiento;
    }

    public function setIdGenero($idgenero){
        $this->idgenero = $idgenero;
    }

    public function getIdEstudiante(){
        return $this->idgenero;
    }

    //metodo para obtener el registro de un restudiante 
    public function obtenerEstudiante(int $idestudiante){
        $this->setIdEstudiante($idestudiante);
        if($this->idestudiante >0){
            $resultado = $this->conexion('SELECT * FROM estudiante where id_estudiante=' .$this->idestudiante.';');
            $array = array("mensaje"=>"Registros encontrados","valores"=>$resultado->fetch());
            return $array;
        }else{
            return array("mensaje"=>"No se puede ejecutar la consulta, el parametro is es incorrecto","Valores"=>"");
        }
    }

    //metodo para obtener los registros de todos los estudiantes 
    public function obtenerEstudiantes(){
        $resultado = $this->conexion('SELECT * FROM estudiante;');
        $array =array("mensaje"=>"Registros encontrados","Valores"=>$resultado->fetch());
        return $array;
    }

    //Metodo para insertar un registro de estudiante
    public function nuevoEstudiante($fechanacimiento,$idgenero){
        if(!empty($fechanacimiento) and !empty($idgenero)){
            $parametros = array(
                "fecha_nac" => $fechanacimiento,
                "id_genero" => $idgenero
            );
            $resultado = $this->conexion('INSERT INTO estudiante(fecha_nacimiento_estudiante,id_genero)VALUES(:fecha_nac,:id_genero);',$parametros);
            if($this->conexion->n > 0 and $this->conexion->id > 0){
                $resultado = $this->obtenerEstudiante($this->conexion->id);
                $array = array("mensaje"=>"Registros encontrados","Valores"=>$resultado["Valores"]);
                return $array;
            }else{
                return array("mensaje"=>"No se pudo realizar el insert","Valores"=>"");
            }
        }else{
            return array("mensaje"=>"Parametros enviados vacios","Valores"=>"");
        }
    }

}
?>