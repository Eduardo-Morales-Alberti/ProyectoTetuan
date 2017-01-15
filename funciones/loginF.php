<?php
include_once("generalF.php");
class loginBBDD {
	private $Idb; private $filas = array(); private static $instancia; // contenedor de la instancia
// un constructor privado evita crear nuevos objetos desde fuera de la clase
	private function __construct() { 
		$this->Idb = new PDO( "mysql:host=localhost; dbname=tetuanjobs", 'usertetuan','tetuanjobs'); 
	}
 //método singleton que crea instancia sí no está creada
	public static function singleton() { 
		if (!isset(self::$instancia)) {
			$miclase = __CLASS__;
			self::$instancia = new $miclase;
		}
		return self::$instancia;
	}
// Evita que el objeto se pueda clonar
	public function __clone(){ 
		trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR); 
	}

	public function entrar(){	

		if(isset($_POST['entrar'])&&isset($_POST['mail'])&&isset($_POST['contrlog'])){
			$query = "call compAcceso('".$_POST['mail']."', '".$_POST['contrlog']."')";
			$consulta = $this->Idb->prepare($query);
			$consulta->execute();
			$filas = array();
			if($consulta->rowCount()>0){
				$result = $consulta->fetch();	
			}

			if(!isset($result["mensaje"])){

				$_SESSION["nombre"] = $result["nombre"];
				$_SESSION["idenficador"] = $result["identificador"];
				$_SESSION["tipo"] = $result["tipo_usuario"];
				$_SESSION["mensajeServidor"] = "Usuario correcto";
				header("location: dashboard.php");

			}else{

				$_SESSION["mensajeServidor"] = "Usuario o Contraseña incorrectos";
				unset( $_SESSION["nombre"]);
				unset( $_SESSION["idenficador"]);

			}    
		}else{
			unset( $_SESSION["nombre"]);
			unset( $_SESSION["idenficador"]);
		}
	}

	public function nvContrEmail(){
		if(isset($_POST['recordar'])&&isset($_POST['mail'])){
			$query = "call compEmail('".$_POST['mail']."')";
			$consulta = $this->Idb->prepare($query);
			$consulta->execute();
			$filas = array();
			if($consulta->rowCount()>0){
				$result = $consulta->fetch();	
			}
			
			if($result["existe"]){
				$_SESSION["mensajeServidor"] = "Instrucciones enviadas al email para restablecer la contraseña";
				$emails = [$_POST['mail']];
				general::enviarEmail($emails,"Restablecer la contraseña", "Lo que sea 8");
				
			}else{
				$_SESSION["mensajeServidor"] = "El email no existe o el usuario no está activo.";
			}
		}
	}

}






?>