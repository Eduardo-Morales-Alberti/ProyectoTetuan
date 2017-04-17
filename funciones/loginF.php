<?php
include_once("generalF.php");

class loginBBDD extends General{

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

			if(isset($result["resultado"])){
				if($result["resultado"]){
					$_SESSION["mensajeServidor"] = $result["mensaje"];
					$_SESSION["entrar"] = true;
					/*$_SESSION["login"] = true;*/
					$_SESSION["usuario"] = new Usuario($_POST['mail'],$result["nombre"],$result["identificador"], $result["tipo_usuario"]);
					/*print_r($_SESSION);*/
					header("location: dashboard.php");
				}else{
					session_destroy();
					session_start();
					$_SESSION["mensajeServidor"] = $result["mensaje"];
				}

				

				/*$_SESSION["email"] = $_POST['mail'];
				$_SESSION["nombre"] = $result["nombre"];
				$_SESSION["identificador"] = $result["identificador"];
				$_SESSION["tipo"] = $result["tipo_usuario"];*/
				

			}else{
				session_destroy();
				session_start();
				$_SESSION["mensajeServidor"] = "No se ha obtenido respuesta";

			}      
		}/*else{
			session_destroy();
			session_start();

		}*/
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
					<a href='http://localhost/proyectofinal/restablecer_password.php?email=".urlencode($_POST['mail'])."&clave=".urlencode($result['hashing'])."'>
					Restablecer Contraseña</a>";
					$enviado = $this->enviarEmail($emails,"Restablecer la contraseña", $mensaje);

					if($enviado == "correcto"){

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
		/*print_r($_GET);*/
		if(isset($_GET["email"])&&isset($_GET["clave"])){
			
			if(isset($_SESSION["email"])&&isset($_SESSION["clave"])
				&&isset($_POST["restcontr"])&&isset($_POST["ncontr"])
				&&isset($_POST["ccontr"])){

				if($_POST["ccontr"]==$_POST["ncontr"]){

					$query = "call cambiarContrRest('".$_SESSION["email"]."','".$_SESSION["clave"]."','".$_POST["ccontr"]."')";
					$consulta = $this->Idb->prepare($query);
					$consulta->execute();

					session_destroy();
					session_start();
					
					if($consulta->rowCount()>0){

						$result = $consulta->fetch();

						if($result["resultado"]){

							$_SESSION["usuario"] = new Usuario($_SESSION["email"],$result["nombre"],$result["identificador"], $result["tipo_usuario"]);

							/*$_SESSION["nombre"] = $result["nombre"];
							$_SESSION["identificador"] = $result["identificador"];
							$_SESSION["tipo"] = $result["tipo_usuario"];*/
							$_SESSION["mensajeServidor"] = "La contraseña ha sido restablecida.";							
							header("location:dashboard.php");

						}else{

							
							$_SESSION["mensajeServidor"] = "No se ha podido restablecer la contraseña, error en la consulta";
							header("location:index.php");

						}

						
					}else{

						$_SESSION["mensajeServidor"] = "No se ha podido restablecer la contraseña, no se ha obtenido resultado";
						header("location:index.php");

					}

					
				}else{
					
					$_SESSION["mensajeServidor"] ="Las contraseñas no coinciden";
					$_SESSION["fallo"] = true;
				}
				

			}else{
				/*echo $_GET["email"]." clave: ".$_GET["clave"];*/
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
						header("location:index.php");

					}
				}else{

					session_destroy();
					header("location:index.php");

				}
			}

		}else{

			session_destroy();
			header("location:index.php");			

		}

	}

	/** Fin función restContr **/

	/** Función nuevo estudiante **/

	public function nvEstudiante(){
		if(isset($_POST['registrar'])&&isset($_POST['mail'])&&isset($_POST['nombre'])&&isset($_POST['modulo'])&&isset($_POST['tipo'])&&
			$_POST['tipo'] == "estudiante"&&isset($_POST['password'])&&isset($_POST['comppassword'])&&$_POST['password']==$_POST['comppassword']){
			$apellidos = null;

		if(isset($_POST['apellidos'])){
			$apellidos = $_POST['apellidos'];
		}

		$query = "call nuevoEstudiante('".$_POST['nombre']."','".$apellidos."','".$_POST['modulo']."','".$_POST['mail']."','".$_POST['password']."')";
		$consulta = $this->Idb->prepare($query);
		$consulta->execute();

		if($consulta->rowCount()>0){
			$result = $consulta->fetch();	
		}

		if(isset($result["resultado"])){
			session_reset();
			$_SESSION["mensajeServidor"] = "Usuario ".$result["usuario"]." creado correctamente.<br> Recibirá un correo para confirmar la cuenta.";

			$mensaje = "Para confirmar su cuenta vaya al siguiente enlace 
			<a href='http://localhost/proyectofinal/index.php?confirmar=true&email=".urlencode($_POST['mail'])."&clave=".urlencode($result['hashing'])."'>
			Confirmar</a>";
			$enviado = $this->enviarEmail(array($_POST['mail']),"Confirmar cuenta", $mensaje);

		}else{
			session_destroy();
			session_start();
			$_SESSION["mensajeServidor"] = "Error al crear el nuevo usuario.";
				/*unset( $_SESSION["nombre"]);
				unset( $_SESSION["idenficador"]);*/

			}    
		}
	}

	/** Fin función nvEstudiante **/

	/* Función para confirmar la cuenta */

	function confirmarCuenta(){
		if(isset($_GET["confirmar"])&&isset($_GET["email"])&&isset($_GET["clave"])){
			$query = "call confirmarUsuario(?,?);";

			$consulta = $this->Idb->prepare($query);
			$consulta->execute(array($_GET["email"],$_GET["clave"]));
			if($consulta->rowCount()>0){
				$result = $consulta->fetch();
				if($result["mensaje"]){
					$_SESSION["mensajeServidor"] = "Usuario confirmado correctamente";
					header("location: index.php");
				}else{
					$_SESSION["mensajeServidor"] = "No se ha podido confirmar";
					header("location: index.php");
					
				}
			}


		}
	}


	/* fin Función para confirmar la cuenta */

	/** Función nueva empresa **/

	public function nvEmpresa(){
		if(isset($_POST['registrar'])&&isset($_POST['mail'])&&isset($_POST['nombre'])&&isset($_POST['empresa'])&&isset($_POST['tipo'])&&
			$_POST['tipo'] == "empresa"&&isset($_POST['password'])){
			$nombre = $_POST['nombre'];

		if(isset($_POST['apellidos'])){
			$nombre .= " ".$_POST['apellidos'];
		}

		if(isset($_POST['webempresa'])){
			$web = $_POST['webempresa'];
		}

		$query = "call nuevaEmpresa(?,?,?,?,?,null)";

		$empresa = $_POST['empresa'];

		$mail = $_POST["mail"];

		$contr = $_POST["password"];

		$consulta = $this->Idb->prepare($query);
		$consulta->execute(array($empresa,$contr,$nombre,$web,$mail));

		if($consulta->rowCount()>0){
			$result = $consulta->fetch();	
		}

		if(isset($result["mensaje"])&&$result["mensaje"]){
			session_destroy();
			session_start();
			$_SESSION["mensajeServidor"] = "Empresa creada correctamente.<br> 
			El administrador se pondrá en contacto para activar su cuenta.";

		}else{
			session_reset();
			$_SESSION["mensajeServidor"] = "Error al crear la nueva empresa.";
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