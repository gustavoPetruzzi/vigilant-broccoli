<?php
    include_once("accesoDatos.php");

    class Persona {
        public $nombre;
        public $mail;
        public $sexo;
        protected $_password;

        function __construct($nombre = NULL, $mail = NULL, $sexo =NULL, $pass = NULL){
            if($nombre != NULL && $mail != NULL && $sexo != NULL && $pass != NULL){
                $this->nombre = $nombre;
                $this->mail = $mail;
                $this->sexo = $sexo;
                $this->_password = $pass;
            }
        }

            public function getPass(){
                return $this->_password;
            }

            public function setPass($nuevo){
                $this->_password = $nuevo;
            }

            public static function TraerPersona($mail, $password){
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->retornarConsulta("SELECT nombre, mail, sexo, password as _password FROM personas WHERE mail = :mail AND password =:password");
                $consulta->bindValue(":mail",$mail,PDO::PARAM_STR);
                $consulta->bindValue(":password",$password,PDO::PARAM_STR);
                $consulta->setFetchMode(PDO::FETCH_CLASS, "persona");
                $consulta->execute();
                $persona = $consulta->fetch();
                return $persona;
            }



            public static function TraerPersonas(){
                $listaPersonas = array();
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->retornarConsulta("SELECT nombre, mail, sexo, password as _password FROM personas");
                $consulta->execute();
                $listaPersonas= $consulta->fetchAll(PDO::FETCH_CLASS, "persona");
                return $listaPersonas;
            }
            public  function modificarEmpleado(){
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->RetornarConsulta("UPDATE personas SET nombre =:nombre, email =:email, sexo =:sexo password =:password ,  WHERE email =:email");
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":email", $this->email, PDO::PARAM_STR);
                $consulta->bindValue(":sexo", $this->sexo, PDO::PARAM_STR);
                $consulta->bindValue(":password", $this->_password, PDO::PARAM_STR);                
                $retorno = $consulta->execute();
                if($retorno && $consulta->rowCount() == 0){
                    $retorno = false;
                }
                return $retorno;
            }
            
            public  function guardarPersona(){
                $objetoGuardarDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoGuardarDatos->RetornarConsulta("INSERT INTO personas (nombre, mail,sexo, password)"
                                                                . " VALUES(:nombre, :mail, :sexo, :password)");
                //$activo = 0;
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);                                                             
                $consulta->bindValue(":mail", $this->mail, PDO::PARAM_STR);
                $consulta->bindValue(":sexo",$this->sexo, PDO::PARAM_STR);
                $consulta->bindValue(":password", $this->getPass(), PDO::PARAM_STR);
                $retorno = $consulta->execute();
                if($retorno && $consulta->rowCount() == 0){
                    $retorno = false;
                }
                return $retorno;
            }

            public static function borrarEmpleado($mail){
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->retornarConsulta("DELETE FROM personas WHERE mail= :mail");
                $consulta->bindValue(":mail", $mail, PDO::PARAM_STR);
                
                $retorno = $consulta->execute();
                if($retorno && $consulta->rowCount() == 0 ){
                    
                    $retorno = false;
                }
                            
                return $retorno;
            }







                /*
                        public static function buscarEmpleado($id){
                $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
                $consulta = $objetoAccesoDatos->retornarConsulta("SELECT id , nombre, apellido, usuario, pass as _pass, activo, admin FROM empleados
                                                                WHERE id = :id");
                $consulta->bindValue(":id", $id, PDO::PARAM_INT);
                $consulta->setFetchMode(PDO::FETCH_CLASS, "empleado");
                $consulta->execute();
                if($consulta->rowCount() == 0){
                    return false;
                }
                $empleado = $consulta->fetch();
                return $empleado;
            }
            */
        
    }
?>