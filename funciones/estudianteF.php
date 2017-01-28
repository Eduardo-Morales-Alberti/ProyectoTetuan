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

	/** FIN PERFIL ESTUDIANTE **/

}

?>