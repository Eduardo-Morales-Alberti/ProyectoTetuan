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
				
				$_SESSION["mensajeServidor"] = "Información del usuario actualizada";
			}else{
				$_SESSION["mensajeServidor"] = "Información del usuario no actualizada";
			}
		}
	}

	/** FIN FUNCIÓN MODIFICAR USUARIO ESTUDIANTE **/

	/** FIN PERFIL ESTUDIANTE **/

}

?>