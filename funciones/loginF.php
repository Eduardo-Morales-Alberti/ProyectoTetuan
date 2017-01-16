<?php
include_once("generalF.php");

class loginBBDD {

	private $Idb; private $filas = array(); private static $instancia; 


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

	/** Función para entrar en la web **/
	public function entrar(){	

		if(isset($_POST['entrar'])&&isset($_POST['mail'])&&isset($_POST['contrlog'])){

			$query = "call compAcceso('".$_POST['mail']."', '".$_POST['contrlog']."')";
			$consulta = $this->Idb->prepare($query);
			$consulta->execute();
			
			if($consulta->rowCount()>0){
				$result = $consulta->fetch();	
			}

			if(!isset($result["mensaje"])){

				$_SESSION["email"] = $_POST['mail'];
				$_SESSION["nombre"] = $result["nombre"];
				$_SESSION["identificador"] = $result["identificador"];
				$_SESSION["tipo"] = $result["tipo_usuario"];
				$_SESSION["mensajeServidor"] = "Usuario correcto";
				header("location: dashboard.php");

			}else{
				session_reset();
				$_SESSION["mensajeServidor"] = "Usuario o Contraseña incorrectos";
				/*unset( $_SESSION["nombre"]);
				unset( $_SESSION["idenficador"]);*/

			}    
		}else{
			session_reset();
			/*unset( $_SESSION["nombre"]);
			unset( $_SESSION["idenficador"]);*/

		}
	}

	/** Funcion para establecer una nueva contraseña en el servidor y enviar el enlace para hacerlo **/
	public function nvContrEmail(){

		if(isset($_POST['recordar'])&&isset($_POST['mail'])){

			$query = "call restEmail('".$_POST['mail']."')";
			$consulta = $this->Idb->prepare($query);
			$consulta->execute();
			

			if($consulta->rowCount()>0){

				$result = $consulta->fetch();
				if($result["existe"]){		

					$emails = [$_POST['mail']];
					$mensaje = "Para restablecer su contraseña vaya al siguiente enlace 
					<a href='http://localhost/proyectofinal/restablecercontr.php?
					email=".urlencode($_POST['mail'])."&clave=".urlencode($result['hashing'])."'>
					Restablecer Contraseña</a>";
					$enviado = general::enviarEmail($emails,"Restablecer la contraseña", $mensaje);

					if($enviado){

						$_SESSION["mensajeServidor"] = "Instrucciones enviadas al email para restablecer la contraseña.";

					}else{

						$_SESSION["mensajeServidor"] = "No se ha podido enviar el email, compruebe su conexión.";

					}


				}else{

					$_SESSION["mensajeServidor"] = "El email no existe o el usuario no está activo.";

				}
			}else{

				$_SESSION["mensajeServidor"] = "No se ha devuelto ningún resultado.";

			}
			
			
		}
	}

	/** Funcion para establecer una nueva contraseña con el enlace del email recibido **/
	public function restContr(){

		if(isset($_GET["email"])&&isset($_GET["clave"])){

			if(isset($_SESSION["email"])&&isset($_SESSION["clave"])
				&&isset($_POST["restcontr"])&&isset($_POST["ncontr"])
				&&isset($_POST["ccontr"])){

				if($_POST["ccontr"]==$_POST["ncontr"]){

					$query = "call cambiarContrRest('".$_SESSION["email"]."','".$_SESSION["clave"]."','".$_POST["ccontr"]."')";
					$consulta = $this->Idb->prepare($query);
					$consulta->execute();

					session_reset();
					
					if($consulta->rowCount()>0){

						$result = $consulta->fetch();

						if($result["resultado"]){

							$_SESSION["nombre"] = $result["nombre"];
							$_SESSION["identificador"] = $result["identificador"];
							$_SESSION["tipo"] = $result["tipo_usuario"];
							$_SESSION["mensajeServidor"] = "La contraseña ha sido restablecida.";							
							header("location:dashboard.php");

						}else{

							
							$_SESSION["mensajeServidor"] = "No se ha podido restablecer la contraseña";
							header("location:login.php");

						}

						
					}else{

						$_SESSION["mensajeServidor"] = "No se ha podido restablecer la contraseña";
						header("location:login.php");

					}

					
				}else{
					
					return '<script type="text/javascript">
					mensajeModal("Las constraseñas no coinciden");
					</script>';
				}
				

			}else{

				$query = "call testRestContr('".$_GET["email"]."','".$_GET["clave"]."')";
				$consulta = $this->Idb->prepare($query);				
				$consulta->execute();
				
				if($consulta->rowCount()>0){

					$result = $consulta->fetch();

					if($result["existe"] != 0){	

						$_SESSION["email"] = $_GET["email"];
						$_SESSION["clave"] = $_GET["clave"];

					}else{

						session_destroy();
						header("location:login.php");

					}
				}else{

					session_destroy();
					header("location:login.php");

				}
			}

		}else{

			session_destroy();
			header("location:login.php");			

		}



	}

}






?>