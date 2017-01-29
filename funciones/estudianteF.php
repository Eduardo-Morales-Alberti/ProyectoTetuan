<?php
include_once("conexion.php");

class estudianteBBDD extends singleton{

	function __construct(){
		parent::__construct();		
	}

	/** PERFIL ESTUDIANTE **/

	/** FUNCIÓN PARA LISTAR INFORMACION ESTUDIANTE **/

	function listarInformacion(){
		$sql = "call cargarInfoEstudiante(?)";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute(array($_SESSION["usuario"]->identificador));
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$info = array();
		$usuarios = array();

		return $consulta->fetch();
	}


	/** FIN FUNCIÓN PARA LISTAR INFORMACION ESTUDIANTE **/

	/** FUNCIÓN PARA CAMBIAR CONTRASEÑA ESTUDIANTE **/

	function cambiarContr(){
		/*print_r($_POST);

		ECHO "<BR>";
		print_r($_SESSION);*/

		/*echo $_SESSION["usuario"]->identificador."<br>";
		echo $_SESSION["usuario"]->tipo."<br>";*/
		
		if(isset($_SESSION["usuario"])&&$_SESSION["usuario"]->tipo=="estudiante"&&
			isset($_POST["modcontr"])&&isset($_POST["contr"])&&isset($_POST["ncontr"])&&isset($_POST["ccontr"])){

			if($_POST["ncontr"] == $_POST["ccontr"]){

				$sql = "call cambiarContr(?,?,?)";
				$consulta = $this->Idb->prepare($sql);			
				$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["contr"],$_POST["ncontr"]));
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$row = $consulta->fetch();

				if($row["cambiada"]){
					$_SESSION["mensajeServidor"] = "Contraseña modificada.";
				}else{
					$_SESSION["mensajeServidor"] = "No se ha podido cambiar la contraseña.";
				}

			}else{
				$_SESSION["mensajeServidor"] = "Las contraseñas no coinciden";
			}


		}
	}


	/** FIN FUNCIÓN PARA CAMBIAR CONTRASEÑA ESTUDIANTE **/

	/** FUNCIÓN MODIFICAR USUARIO ESTUDIANTE **/

	function modificarInfo(){
		//echo $this->limpiar("hol@@@        qu€     <>    tal?");
		if (isset($_POST["guardarinfo"])) {
			$mensaje = "<p>";
			$sql = "call modificarUsuario(?,?,?,?,?,?,?,?,?,?,?)";
			$consulta = $this->Idb->prepare($sql);

			$nombre = null;
			$apellidos = null;
			$telefono = null;
			$provincia = null;
			$pobl = null;
			$codpos = null;
			$foto = null;
			$cv = null;
			$descp = null;
			$carnet = null;

			if(isset($_POST["nombre"])&&strlen($_POST["nombre"])<=25){
				$nombre = $this->limpiar($_POST["nombre"]);
			}

			if(isset($_POST["apellidos"])&&strlen($_POST["apellidos"])<=50){
				$apellidos = $this->limpiar($_POST["apellidos"]);
			}
			
			if(isset($_POST["telefono"])&&strlen($_POST["telefono"])==9&&is_numeric($_POST["telefono"])){
				
				$telefono = $this->limpiar($_POST["telefono"]);
			}

			if(isset($_POST["provincia"])&&strlen($_POST["provincia"])<=2&&is_numeric($_POST["provincia"])){
				$provincia = $this->limpiar($_POST["provincia"]);
			}

			if(isset($_POST["poblacion"])){
				$pobl = $this->limpiar($_POST["poblacion"]);
			}
			
			if(isset($_POST["cpostal"])&&strlen($_POST["cpostal"])==5&&is_numeric($_POST["cpostal"])){
				$codpos = $this->limpiar($_POST["cpostal"]);
			}

			if(is_uploaded_file($_FILES['fotop']['tmp_name'])){
				
				$tipo = $_FILES['fotop']["type"];

				if($tipo == "image/jpeg"){
					//print_r($_FILES['fotop']);
					list($ancho, $alto, $tipo, $atributos) = getimagesize($_FILES['fotop']['tmp_name']);

					if($ancho == "90" && $alto == "90"){

						$nomDir = getcwd()."/subidas/";
						/*if(!is_dir($nomDir)){
							mkdir($nomDir);
						}*/

						$nomFich = $this->limpiarRuta($_SESSION["usuario"]->mail)."_fotop.jpg";
						$nomComp = $nomDir.$nomFich;		


						if(is_file($nomComp)){
							/*$idUn = time();
							$nomFich = $idUn."_".$nomFich;*/
							unlink($nomComp);
						}

						move_uploaded_file($_FILES['fotop']['tmp_name'], $nomDir.$nomFich); 
						$foto = $nomFich; 
					}else{
						$mensaje = "La imagen tiene que tener un ancho y un alto de 90 px. <br> ";
					}   

				}else{
					$mensaje = "Sólo se aceptan imágenes jpg. <br> ";
				}
			}

			if(is_uploaded_file($_FILES['cv']['tmp_name'])){
				
				$tipo = $_FILES['cv']["type"];
				//echo $tipo;
				$kbytes = filesize($_FILES['cv']['tmp_name']);
				//echo $kbytes;

				if($tipo == "application/pdf" ){
					//print_r($_FILES['fotop']);
					

					if($kbytes < 500000){

						$nomDir = getcwd()."/subidas/";
						/*if(!is_dir($nomDir)){
							mkdir($nomDir);
						}*/

						$nomFich = $this->limpiarRuta($_SESSION["usuario"]->mail)."_cv.pdf";
						$nomComp = $nomDir.$nomFich;		


						if(is_file($nomComp)){
							/*$idUn = time();
							$nomFich = $idUn."_".$nomFich;*/
							unlink($nomComp);
						}

						move_uploaded_file($_FILES['cv']['tmp_name'], $nomDir.$nomFich); 
						$cv = $nomFich; 
					}else{
						$mensaje = "El PDF no puede superar los 500KB <br> ";
					}   

				}else{
					$mensaje = "Sólo se aceptan pdfs. <br> ";
				}
			}


			if(isset($_POST["descpersonal"])){
				$descp = $this->limpiar($_POST["descpersonal"]);
			}

			if(isset($_POST["carnet"])){				
				$carnet = true;
			}else{
				$carnet = false;
			}

			$params = array($_SESSION["usuario"]->identificador,$nombre,$apellidos, $telefono, $provincia, $pobl, $codpos,
				$foto,$cv,$descp,$carnet);

			//print_r($params);

			$consulta->execute($params);

			if($consulta->rowCount()>0){
				if(isset($_POST["nombre"])){
					$_SESSION["usuario"]->nombre = $nombre;
				}

				$mensaje .= "Información del usuario actualizada </p>";
			}else{
				$mensaje .= "Información del usuario no actualizada </p>";
			}
			$_SESSION["mensajeServidor"] = $mensaje;
		}
	}

	/** FIN FUNCIÓN MODIFICAR USUARIO ESTUDIANTE **/

	function limpiarRuta($string) {

		$string = preg_replace('/[^A-Za-z0-9\-\_]/', '_', $string);
		$string = preg_replace ('/[ ]+/', '_', $string);

		return $string; 
	}

	/** FUNCIÓN PARA ELIMINAR USUARIO **/
	function eliminarUsuario(){
		if(isset($_POST["elusuario"])&&isset($_SESSION["usuario"]->identificador)&&$_SESSION["usuario"]->tipo=="estudiante"){

			$sql = "call eliminarUsuario(?)";
			$consulta = $this->Idb->prepare($sql);
			$consulta->execute(array($_SESSION["usuario"]->identificador));
			session_destroy();
			session_start();
			$_SESSION["mensajeServidor"] = "Usuario eliminado correctamente";
			header("location:login.php");

		}
	}
	/** FUNCIÓN PARA ELIMINAR USUARIO **/

	/** FIN PERFIL ESTUDIANTE **/

}

?>