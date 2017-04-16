<?php
include_once("conexion.php");

class adminBBDD extends singleton{
	/*private $n = 0;*/
	/*public $meses = array("actualmente","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");*/
	function __construct(){
		parent::__construct();		
	}


	/** GESTION USUARIOS **/

	function listarUsuarios(){
		$html = "";
		$sql = "select identificador,email,estado, nombre, apellidos, ciclo  from listarUsuarios";
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

	/** Cambiar el estado Estudiantes **/

	function cambiarEstadoEst(){
		if(isset($_POST["cambiarest"])&&isset($_POST["ids"])){
			for ($i=0; $i < count($_POST["ids"]); $i++) { 
				$sql = "call cambiarEstadoEst(?)";

				$consulta = $this->Idb->prepare($sql);
				$consulta->execute(array($_POST["ids"][$i]));
			}	
		}
	}


	/** fin Cambiar el estado Estudiantes**/

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

	/** FIN GESTION USUARIOS **/

	/** GESTION EMPRESAS **/

	/** FILTRO EMPRESAS **/

	/** funcion para listar las empresas **/

	function listarEmpresas(){
		$html = "";
		$sql = "select nombre, identificador, estado, web,correo,telefono,contacto from listarEmpresas";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);

		$empresas = array();
		while ($row = $consulta->fetch()) {
			$empresas[] = $row;
		}


		for ($i=0; $i < count($empresas); $i++) { 
			echo "<tr>";
			foreach ($empresas[$i] as $clave => $valor) {

				if($clave == "identificador"){
					echo "<td><input type='checkbox' name='ids[]' value='$valor'></td>";
				}else{
					echo "<td><input type='hidden' name='".$clave."[".$empresas[$i]["identificador"]."]' value='$valor'>$valor</td>";
				}

			}
			echo "</tr>";
		}	

	}

	/** fin funcion para listar las empresas **/

	/** Cambiar el estado Empresas **/

	function cambiarEstadoEmp(){
		if(isset($_POST["cambiarest"])&&isset($_POST["ids"])){
			for ($i=0; $i < count($_POST["ids"]); $i++) { 
				$sql = "call cambiarEstadoEmp(?)";

				$consulta = $this->Idb->prepare($sql);
				$consulta->execute(array($_POST["ids"][$i]));
			}	
		}
	}


	/** fin Cambiar el estado Empresas**/

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
						$_SESSION["mensajeServidor"] = "Empresa(s) eliminada(s)";
					}else{
						$_SESSION["mensajeServidor"] = "No se ha podido eliminar la(s) empresa(s)";
					}

				}else{
					$_SESSION["mensajeServidor"] = "No se ha recibido respuesta.";
				}




			}	
		}

	}

	/** funcion para eliminar las empresas **/


	/** FIN GESTION EMPRESAS **/


	/** GESTION ETIQUETAS E IDIOMAS **/

	/** FUNCIÓN LISTAR ETIQUETAS**/
	function listarEtiquetas(){
		
		$sql = "select * from listarEtiquetas";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$etiquetas = array();
		while ($row = $consulta->fetch()) {
			$etiquetas[] = $row;
		}

		for ($i=0; $i < count($etiquetas); $i++) { 

			?>
			<div class="col-md-4 col-lg-3 form-group" >
				<div class="input-group">
					<span class="input-group-addon">
						<input type="checkbox" name="etiquetasel[]" value="<?php echo $etiquetas[$i]['nombre'];?>">
					</span>
					<input type="text" class="form-control" value="<?php echo $etiquetas[$i]["nombre"];?>" readonly>
				</div>
			</div>
			<?php
		}

	}

	/** FIN FUNCIÓN LISTAR ETIQUETAS **/

	/** función agregar nueva etiqueta **/
	function agregarEtiqueta(){
		if(isset($_POST["agreet"])&&isset($_POST["inputetiq"])){

			/*include_once("generalF.php");
			session_start();*/

			if(isset($_SESSION["tokens"])&&isset($_POST["token"])){
				$token = $_POST["token"];

				if($this->comprobarToken("gestetqidm", $token)){	


					$mensaje = "";
					$res = false;
					$sql = "call agregarEtiqueta(?,?)";
					$etiqueta = $this->limpiar($_POST["inputetiq"]);
					$consulta = $this->Idb->prepare($sql);

					$consulta->execute(array($_SESSION["usuario"]->identificador,$etiqueta));
					if($row = $consulta->fetch()){
						if($row["resultado"]){
							$mensaje =  "Etiqueta ".$etiqueta." agregada correctamente.";
							$res = true;
						}else{
							$mensaje = "No se ha podido agregar la etiqueta.";
						}
					}else{
						$mensaje = "No se ha recibido respuesta.";
					}

					echo json_encode(array("mensaje"=>$mensaje, "resultado"=>$res));

				}else{
					echo json_encode(array("mensaje"=>"El token no es válido"));
				}

			}else{
				echo json_encode(array("mensaje"=>"No hay token disponible"));
			}


		}
	}

	/* Fin función agregar nueva etiqueta */

	/** función eliminar etiqueta **/
	function eliminarEtiquetas(){
		if(isset($_POST["eliminaret"])&&isset($_POST["etiquetasel"])){

			$mensaje = "";
			for ($i=0; $i < count($_POST["etiquetasel"]); $i++) { 
				$sql = "call eliminarEtiqueta(?,?)";			
				$consulta = $this->Idb->prepare($sql);

				$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["etiquetasel"][$i]));

				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				if($row = $consulta->fetch()){
					if($row["resultado"]){
						$mensaje .= "Etiqueta ".$_POST["etiquetasel"][$i]." eliminada correctamente. <br>";
					}else{
						$mensaje .= "No se ha podido eliminar la etiqueta ".$_POST["etiquetasel"][$i].". <br>";
					}
				}else{
					$mensaje .= "No se ha obtenido respuesta con la etiqueta ".$_POST["etiquetasel"][$i].". <br>";
				}
			}

			$_SESSION["mensajeServidor"] = $mensaje;

		}
	}

	/* Fin función eliminar etiqueta */

	/** FUNCIÓN LISTAR Idiomas**/
	function listarIdiomas(){

		$sql = "select * from listarIdiomas";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$idiomas = array();
		while ($row = $consulta->fetch()) {
			$idiomas[] = $row;
		}

		for ($i=0; $i < count($idiomas); $i++) { 

			?>
			<div class="col-md-4 col-lg-3 form-group" >
				<div class="input-group">
					<span class="input-group-addon">
						<input type="checkbox" name="idiomasel[]" value="<?php echo $idiomas[$i]['nombre'];?>">
					</span>
					<input type="text" class="form-control" value="<?php echo $idiomas[$i]["nombre"];?>" readonly>
				</div>
			</div>
			<?php
		}

	}

	/** FIN FUNCIÓN LISTAR Idiomas **/

	/** función agregar nuevo idioma **/
	function agregarIdioma(){
		if(isset($_POST["agreidm"])&&isset($_POST["inputidm"])){
			/*include_once("generalF.php");
			session_start();*/

			if(isset($_SESSION["tokens"])&&isset($_POST["token"])){
				$token = $_POST["token"];

				if($this->comprobarToken("gestetqidm", $token)){	


					$mensaje = "";
					$res = false;
					$sql = "call agregarIdioma(?,?)";
					$idioma = $this->limpiar($_POST["inputidm"]);
					$consulta = $this->Idb->prepare($sql);

					$consulta->execute(array($_SESSION["usuario"]->identificador,$idioma));
					if($row = $consulta->fetch()){
						if($row["resultado"]){
							$mensaje =  "Idioma ".$idioma." agregado correctamente.";
							$res = true;
						}else{
							$mensaje = "No se ha podido agregar el idioma.";
						}
					}else{
						$mensaje = "No se ha recibido respuesta.";
					}

					echo json_encode(array("mensaje"=>$mensaje, "resultado"=>$res));
				}
			}
		}




	}

	/* Fin función agregar nuevo idioma */

	/** función eliminar idioma **/
	function eliminarIdiomas(){
		if(isset($_POST["eliminaridm"])&&isset($_POST["idiomasel"])){

			$mensaje = "";
			for ($i=0; $i < count($_POST["idiomasel"]); $i++) { 
				$sql = "call eliminarIdioma(?,?)";			
				$consulta = $this->Idb->prepare($sql);

				$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["idiomasel"][$i]));

				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				if($row = $consulta->fetch()){
					if($row["resultado"]){
						$mensaje .= "Idioma ".$_POST["idiomasel"][$i]." eliminado correctamente. <br>";
					}else{
						$mensaje .= "No se ha podido eliminar el idioma ".$_POST["idiomasel"][$i].". <br>";
					}
				}else{
					$mensaje .= "No se ha obtenido respuesta con el idioma ".$_POST["idiomasel"][$i].". <br>";
				}
			}

			$_SESSION["mensajeServidor"] = $mensaje;

		}
	}

	/* Fin función eliminar idioma */

	/** FIN GESTION ETIQUETAS E IDIOMAS **/

	/** FUNCIONES DESUSO **/

	/** funcion modificar empresa **/

	/*function modificarEmpresa(){

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

	}*/

	/** funcion modificar empresa **/

	/** FUNCION NUEVA EMPRESA**/
	/*public function nuevaEmpresa(){	
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
				
				$_SESSION["mensajeServidor"] = "Error al crear la nueva empresa.";*/
				/*unset( $_SESSION["nombre"]);
				unset( $_SESSION["idenficador"]);*/

			/*}       
		}
	}*/
	/** fin FUNCION NUEVA EMPRESA**/



	/** FIN FUNCIONES DESUSO **/




}

/*$adminclass = new adminBBDD;
$adminclass->agregarEtiqueta();
$adminclass->agregarIdioma();*/

?>