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
		$sql = "select nombre, identificador, web,correo,telefono,contacto from listarEmpresas";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);

		$usuarios = array();
		while ($row = $consulta->fetch()) {
			$usuarios[] = $row;
		}
		

		for ($i=0; $i < count($usuarios); $i++) { 
			echo "<form method='post'><tr>";
			foreach ($usuarios[$i] as $clave => $valor) {

				if($clave == "identificador"){
					echo "<td><input type='checkbox' name='ids[]' value='$valor'> &nbsp; <button type='submit' name='modemp' value='$valor' class='btn btn-success'>
					<i class='fa fa-edit' aria-hidden='true'></i>
					</button></td>";
				}else{
					echo "<td><input type='hidden' name='".$clave."[".$usuarios[$i]["identificador"]."]' value='$valor'>$valor</td>";
				}

			}
			echo "</tr></form>";
		}	

	}

	/** fin funcion para listar las empresas **/

	/** funcion para eliminar las empresas **/

	function eliminarEmpresas(){

		if(isset($_POST["eliminaremp"])&&isset($_POST["ids"])){

			for ($i=0; $i < count($_POST["ids"]); $i++) { 

				$sql = "call eliminarEmpresa(?,?)";

				$consulta = $this->Idb->prepare($sql);
				$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["ids"][$i]));
				if($consulta->rowCount() > 0){
					$row = $consulta->fetch();
					if($row["resultado"]){
						$_SESSION["mensajeServidor"] = "Empresas eliminada";
					}else{
						$_SESSION["mensajeServidor"] = "No se ha podido eliminar las empresas";
					}
				
				}else{
					$_SESSION["mensajeServidor"] = "No se ha recibido respuesta.";
				}


				

			}	
		}

	}

	/** funcion para eliminar las empresas **/

	/** funcion modificar empresa **/

	function modificarEmpresa(){

		if(isset($_POST["modificaremp"])&&isset($_POST["id"])&&isset($_POST["webemp"])){



			$sql = "call modificarEmpresa(?,?,?,?,?)";

			$id = $_POST["id"];	
			$web = $_POST["webemp"];
			$mail = $_POST["email"];
			$telf = $_POST["telfemp"];
			$cont = $_POST["contemp"];

			$consulta = $this->Idb->prepare($sql);
			$consulta->execute(array($id,$web,$mail, $telf,$cont));

			$_SESSION["mensajeServidor"] = "Empresa modificada";

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

	/** FICHA PUESTOS **/

	/** función listar etiquetas **/

	function listarTodasEtiquetas(){

		$sql = "select * from listarEtiquetas";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$etiquetasSELECT = "";

		while ($row = $consulta->fetch()) {
			$etiquetas[] = $row;
		}
		$etiquetasSELECT = " <option disabled selected value='nada'> -- Selecciona una opción -- </option>";
		for ($i=0; $i < count($etiquetas) ; $i++) { 			
			$etiquetasSELECT .= "<option value='".$etiquetas[$i]['nombre']."'>";
			$etiquetasSELECT .= $etiquetas[$i]['nombre']."</option>";
			
			
		}
		return $etiquetasSELECT;

	}

	/** fin función listar etiquetas **/

	/** función listar Idiomas **/

	function listarIdiomas(){

		$sql = "select * from listarIdiomas";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$idiomasSELECT = "";

		while ($row = $consulta->fetch()) {
			$idiomas[] = $row;
		}
		$idiomasSELECT = " <option disabled selected value='nada'> -- Selecciona una opción -- </option>";
		for ($i=0; $i < count($idiomas) ; $i++) { 
			
				$idiomasSELECT .= "<option value='".$idiomas[$i]['nombre']."'>";
				$idiomasSELECT .= $idiomas[$i]['nombre']."</option>";
					
			
		}
		return $idiomasSELECT;

	}

	/** fin función listar Idiomas **/

	/** FIN FICHA PUESTOS **/
}

?>