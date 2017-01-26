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
					echo "<td><b>$valor</b></td>";
				}else{
					echo "<td><input type='text' name='".$clave."[".$usuarios[$i]["identificador"]."]' value='$valor'> <span class='oculto'>$valor</span></td>";
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

	/** FUNCION NUEVA EMPRESA**/
	public function nuevaEmpresa(){
		if(isset($_POST['agregaremp'])&&isset($_POST['mailemp'])&&isset($_POST['nemp'])){			
			
			$nombre = "";

			if(isset($_POST['contemp'])){
				$nombre = $_POST['contemp'];
			}
			

			$web = "";
			if(isset($_POST['webemp'])){
				$web = $_POST['webemp'];
			}

			$telf = "";
			if(isset($_POST["telfemp"])){
				$telf = $_POST["telfemp"];
			}

			

			$empresa = $_POST['nemp'];

			$mail = $_POST["mailemp"];



			$query = "call nuevaEmpresa(?,?,?,?,?)";	

			$consulta = $this->Idb->prepare($query);
			$consulta->execute(array($empresa,$nombre,$web,$mail,$telf));
			
			if($consulta->rowCount()>0){
				$result = $consulta->fetch();	
			}

			if(isset($result["mensaje"])&&$result["mensaje"]){
				
				$_SESSION["mensajeServidor"] = "Empresa creada correctamente";

			}else{
				
				$_SESSION["mensajeServidor"] = "Error al crear la nueva empresa.";
				/*unset( $_SESSION["nombre"]);
				unset( $_SESSION["idenficador"]);*/

			}       
		}
	}
	/** FUNCION NUEVA EMPRESA**/

	/** FIN FILTRO EMPRESAS **/
}

?>