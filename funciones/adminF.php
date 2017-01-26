<?php
include_once("conexion.php");

class adminBBDD extends singleton{
	
	function __construct(){
		parent::__construct();		
	}

	/** FILTRO USUARIOS**/

	function listarUsuarios(){
		$html = "";
		$sql = "select * from listarUsuarios";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);

		$usuarios = array();
		while ($row = $consulta->fetch()) {
			$usuarios[] = $row;
		}
		

		for ($i=0; $i < count($usuarios); $i++) { 
			echo "<tr>";
			foreach ($usuarios[$i] as $clave => $valor) {
				if($clave == "identificador"){
					echo "<td><input type='checkbox' name='ids[]' value='$valor'></td>";
				}else{
					echo "<td>$valor</td>";
				}

			}
			echo "</tr>";
		}	

	}

	/** Cambiar el estado **/

	function cambiarEstado(){
		if(isset($_POST["cambiarest"])&&isset($_POST["ids"])){
			for ($i=0; $i < count($_POST["ids"]); $i++) { 
				$sql = "call cambiarEstado(?)";

				$consulta = $this->Idb->prepare($sql);
				$consulta->execute(array($_POST["ids"][$i]));
			}	
		}
	}


	/** fin Cambiar el estado **/

	/** Eliminar usuarios **/

	function eliminarUsuarios(){
		if(isset($_POST["eliminarus"])&&isset($_POST["ids"])){
			for ($i=0; $i < count($_POST["ids"]); $i++) { 
				$sql = "call eliminarUsuario(?)";

				$consulta = $this->Idb->prepare($sql);
				$consulta->execute(array($_POST["ids"][$i]));
			}	
		}
	}

	/** Eliminar usuarios **/

	/** FIN FILTRO USUARIOS**/

	/** FILTRO EMPRESAS **/

	/** funcion para listar las empresas **/

	function listarEmpresas(){
		$html = "";
		$sql = "select * from listarEmpresas";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);

		$usuarios = array();
		while ($row = $consulta->fetch()) {
			$usuarios[] = $row;
		}
		

		for ($i=0; $i < count($usuarios); $i++) { 
			echo "<tr>";
			foreach ($usuarios[$i] as $clave => $valor) {

				if($clave == "identificador"){
					echo "<td><input type='checkbox' name='ids[]' value='$valor'></td>";
				}else if($clave == "nombre"){
					echo "<td>$valor</td>";
				}else{
					echo "<td><input type='text' name='".$clave."[".$usuarios[$i]["identificador"]."]' value='$valor'> </td>";
				}

			}
			echo "</tr>";
		}	

	}

	/** fin funcion para listar las empresas **/

	/** funcion para eliminar las empresas **/

	function eliminarEmpresas(){

		if(isset($_POST["eliminaremp"])&&isset($_POST["ids"])){

			for ($i=0; $i < count($_POST["ids"]); $i++) { 

				$sql = "call eliminarEmpresa(?)";

				$consulta = $this->Idb->prepare($sql);
				$consulta->execute(array($_POST["ids"][$i]));

			}	
		}

	}

	/** funcion para eliminar las empresas **/

	/** funcion modificar empresa **/

	function modificarEmpresas(){
	
		if(isset($_POST["modificaremp"])&&isset($_POST["ids"])&&isset($_POST["web"])){

			for ($i=0; $i < count($_POST["ids"]); $i++) { 

				$sql = "call modificarEmpresa(?,?,?,?,?)";

				$id = $_POST["ids"][$i];
				

				$web = $_POST["web"][$id];
				$mail = $_POST["correo"][$id];
				$telf = $_POST["telefono"][$id];
				$cont = $_POST["contacto"][$id];

				$consulta = $this->Idb->prepare($sql);
				$consulta->execute(array($id,$web,$mail, $telf,$cont));

			}	
		}

	}

	/** funcion modificar empresa **/


	/** FIN FILTRO EMPRESAS **/
}

?>