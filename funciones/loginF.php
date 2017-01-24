<?php
include_once("generalF.php");
include_once("conexion.php");
class loginBBDD extends singleton{

	function __construct() {
       parent::__construct();
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


				$_SESSION["usuario"] = new Usuario($_POST['mail'],$result["nombre"],$result["identificador"], $result["tipo_usuario"]);

				/*$_SESSION["email"] = $_POST['mail'];
				$_SESSION["nombre"] = $result["nombre"];
				$_SESSION["identificador"] = $result["identificador"];
				$_SESSION["tipo"] = $result["tipo_usuario"];*/
				$_SESSION["mensajeServidor"] = "Usuario correcto";
				header("location: dashboard.php");

			}else{
				session_reset();
				$_SESSION["mensajeServidor"] = "Usuario o Contraseña incorrectos";

			}    
		}else{
			session_reset();

		}
	}

	/** fin función entrar **/

	/** Funcion para establecer una nueva clave para restablecer en el servidor y 
	enviar el enlace con esa clave **/
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
					$enviado = General::enviarEmail($emails,"Restablecer la contraseña", $mensaje);

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

	/** Fin función nvContrEmail **/

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

	/** Fin función restContr **/

	/** Función nuevo estudiante **/

	public function nvEstudiante(){
		if(isset($_POST['registrar'])&&isset($_POST['mail'])&&isset($_POST['nombre'])&&isset($_POST['modulo'])&&isset($_POST['tipo'])&&
			$_POST['tipo'] == "estudiante"){
			$apellidos = null;

			if(isset($_POST['apellidos'])){
				$apellidos = $_POST['apellidos'];
			}

			$query = "call nuevoEstudiante('".$_POST['nombre']."','".$apellidos."','".$_POST['modulo']."','".$_POST['mail']."')";
			$consulta = $this->Idb->prepare($query);
			$consulta->execute();
			
			if($consulta->rowCount()>0){
				$result = $consulta->fetch();	
			}

			if(isset($result["mensaje"])){
				session_reset();
				$_SESSION["mensajeServidor"] = $result["mensaje"];

			}else{
				session_reset();
				$_SESSION["mensajeServidor"] = "Error al crear el nuevo usuario.";
				/*unset( $_SESSION["nombre"]);
				unset( $_SESSION["idenficador"]);*/

			}    
		}
	}

	/** Fin función nvEstudiante **/

	/** Función nueva empresa **/

	public function nvEmpresa(){
		if(isset($_POST['registrar'])&&isset($_POST['mail'])&&isset($_POST['nombre'])&&isset($_POST['empresa'])&&isset($_POST['tipo'])&&
			$_POST['tipo'] == "empresa"){
			$nombre = $_POST['nombre'];

			if(isset($_POST['apellidos'])){
				$nombre .= " ".$_POST['apellidos'];
			}

			if(isset($_POST['webempresa'])){
				$web = $_POST['webempresa'];
			}

			$query = "call nuevaEmpresa('".$_POST['empresa']."','".$nombre."','".$web."','".$_POST['mail']."')";
			$consulta = $this->Idb->prepare($query);
			$consulta->execute();
			
			if($consulta->rowCount()>0){
				$result = $consulta->fetch();	
			}

			if(isset($result["mensaje"])){
				session_reset();
				$_SESSION["mensajeServidor"] = $result["mensaje"];

			}else{
				session_reset();
				$_SESSION["mensajeServidor"] = "Error al crear la nuevo empresa.";
				/*unset( $_SESSION["nombre"]);
				unset( $_SESSION["idenficador"]);*/

			}    
		}
	}

	/** Fin función nvEmpresa **/

	/** Funcion salir **/

	public function logOut(){
		if(isset($_REQUEST["logout"])){
			session_destroy();
		}
		
	}

	/** Fin funcion salir **/

}






?>