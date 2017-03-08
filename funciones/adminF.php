<?php
include_once("conexion.php");

class adminBBDD extends singleton{
	private $n = 0;
	public $meses = array("actualmente","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	function __construct(){
		parent::__construct();		
	}


	function limpiarRuta($string) {
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$string = str_replace($no_permitidas, $permitidas ,$string);
		$string = preg_replace('/[^A-Za-z0-9\-\_]/', '_', $string);
		$string = preg_replace ('/[ ]+/', '_', $string);

		return strtolower($string); 
	}

	/** FILTRO USUARIOS**/

	function listarUsuarios(){
		$html = "";
		$sql = "select identificador,email, nombre, apellidos, ciclo, estado from listarUsuarios";
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

	/** FUNCIÓN LISTAR Funciones DEL puesto **/
	function listarFuncionesPst(){
		if(isset($_SESSION["idpst"])){
			$sql = "call listarFuncionesPuesto(?,?)";
			$consulta = $this->Idb->prepare($sql);
			//echo $_SESSION["idpst"]."<br>";
			//echo $_SESSION["usuario"]->identificador."<br>";
			$consulta->execute(array($_SESSION["idpst"],$_SESSION["usuario"]->identificador));
			$consulta->setFetchMode(PDO::FETCH_ASSOC);		
			$funciones = array();
			while ($row = $consulta->fetch()) {
				$funciones[] = $row;
			}
			$_SESSION["funciones"] = json_encode($funciones);
			//print_r($etiquetas);
			//$this->$n;
			for ($i=0; $i < count($funciones); $i++) { 
				$id = substr($this->limpiarRuta($funciones[$i]["nombre"]),0,5).$this->n;
				$this->n++;
				?>
				<div class="col-md-4 col-lg-3 form-group" id="<?php echo $id.'elemento';?>">
					<div class="input-group">
						<span class="input-group-addon">
							<input type="checkbox" id="check<?php echo $id;?>" name="etiquetasel[]" value="<?php echo $id;?>">
						</span>
						<input type="text" class="form-control" id="input<?php echo $id;?>" name="funciones[]" value="<?php echo $funciones[$i]["nombre"];?>" readonly>
					</div>
				</div>
				<?php
			}

		}


	}

	/** FIN FUNCIÓN LISTAR Funciones DEL puesto **/

	/** función listar etiquetas **/

	function listarTodasEtiquetas(){
		if(isset($_SESSION["idpst"])){
			$sql = "call listarEtiquetasPst(?,true);";
			$consulta = $this->Idb->prepare($sql);

			$consulta->execute(array($_SESSION["idpst"]));
		}else{
			$sql = "select * from listarEtiquetas";
			$consulta = $this->Idb->prepare($sql);			
			$consulta->execute();
		}
		
		
		
		
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

	/** FUNCIÓN LISTAR ETIQUETAS DEL puesto **/
	function listarEtiquetasPst(){
		if(isset($_SESSION["idpst"])){

			$sql = "call listarSkillsPuesto(?,?)";
			$consulta = $this->Idb->prepare($sql);
			//echo $_SESSION["idpst"]."<br>";
			//echo $_SESSION["usuario"]->identificador."<br>";
			$consulta->execute(array($_SESSION["idpst"],$_SESSION["usuario"]->identificador));
			$consulta->setFetchMode(PDO::FETCH_ASSOC);		
			$etiquetas = array();
			while ($row = $consulta->fetch()) {
				$etiquetas[] = $row;
			}
			$_SESSION["etiquetas"] = json_encode($etiquetas);
			//print_r($etiquetas);
			//$this->$n;
			for ($i=0; $i < count($etiquetas); $i++) { 
				$id = substr($this->limpiarRuta($etiquetas[$i]["nombre"]),0,5).$this->n;
				$this->n++;
				?>
				<div class="col-md-4 col-lg-3 form-group" id="<?php echo $id.'elemento';?>">
					<div class="input-group">
						<span class="input-group-addon">
							<input type="checkbox" id="check<?php echo $id;?>" name="etiquetasel[]" value="<?php echo $id;?>">
						</span>
						<input type="text" class="form-control" id="input<?php echo $id;?>" name="etiquetas[]" value="<?php echo $etiquetas[$i]["nombre"];?>" readonly>
					</div>
				</div>
				<?php
			}

		}


	}

	/** FIN FUNCIÓN LISTAR ETIQUETAS DEL puesto **/

	/** función listar Idiomas **/

	function listarIdiomas(){
		if(isset($_SESSION["idpst"])){
			$sql = "call listarIdiomasPst(?,true);";
			$consulta = $this->Idb->prepare($sql);

			$consulta->execute(array($_SESSION["idpst"]));
		}else{
			$sql = "select * from listarIdiomas";
			$consulta = $this->Idb->prepare($sql);			
			$consulta->execute();
		}
		
		
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

	/** FUNCIÓN LISTAR ETIQUETAS DEL puesto **/
	function listarIdiomasPst(){
		if(isset($_SESSION["idpst"])){
			$sql = "call listarIdiomasPuesto(?,?)";
			$consulta = $this->Idb->prepare($sql);

			$consulta->execute(array($_SESSION["idpst"],$_SESSION["usuario"]->identificador));
			$consulta->setFetchMode(PDO::FETCH_ASSOC);		
			$idiomas = array();
			while ($row = $consulta->fetch()) {
				$idiomas[] = $row;
			}			

			$_SESSION["idiomas"] = json_encode($idiomas);

			for ($i=0; $i < count($idiomas); $i++) { 
				$id = substr($this->limpiarRuta($idiomas[$i]["nombre"]),0,5).$this->n;
				$this->n++;
				?>
				<div class="col-md-4 col-lg-3 form-group" id="<?php echo $id.'elemento';?>">
					<div class="input-group">
						<span class="input-group-addon">
							<input type="checkbox" id="check<?php echo $id;?>" name="etiquetasel[]" value="<?php echo $id;?>">
						</span>
						<input type="text" class="form-control" id="input<?php echo $id;?>" name="idiomas[]" value="<?php echo $idiomas[$i]["nombre"];?>" readonly>
					</div>
				</div>
				<?php
			}

		}


	}

	/** FIN FUNCIÓN LISTAR ETIQUETAS DEL puesto **/

	/** función agregar puesto**/
	function agregarPuesto(){
		if(isset($_POST["guardarpuesto"])&&isset($_POST["titpuesto"])&&isset($_POST["empresa"])&&isset($_POST["descpuesto"])){
			
			if(!isset($_POST["idpuesto"])){
				$sql = "call agregarPuesto(?,?,?,?,?,?,?,?,?,?)";
			}else if(isset($_POST["idpuesto"])){
				$sql = "call modificarPuesto(?,?,?,?,?,?,?,?,?,?)";
			}

			$consulta = $this->Idb->prepare($sql);	

			$empresa = null;

			if(isset($_POST["empresa"])){
				$empresa = $_POST["empresa"];
			}

			$nombre = null;

			if(isset($_POST["titpuesto"])){
				$nombre = $_POST["titpuesto"];
			}		



			$desc = null;

			if(isset($_POST["descpuesto"])){
				$desc = $_POST["descpuesto"];
			}

			$carnet = 0;

			if(isset($_POST["carnet"])){
				$carnet = 1;
			}	

			$provincia = null;

			if(isset($_POST["provincia"])){
				$provincia = $_POST["provincia"];
			}

			$exp = 1;

			if(isset($_POST["experiencia"])){
				$exp = $_POST["experiencia"];
			}

			$contrato = 1;

			if(isset($_POST["contrato"])){
				$contrato = $_POST["contrato"];
			}

			$jornada= 1;

			if(isset($_POST["jornada"])){
				$jornada = $_POST["jornada"];
			}

			$titulacion = 1;

			if(isset($_POST["nivel"])){
				$titulacion = $_POST["nivel"];
			}

			$params = array();

			if(!isset($_POST["idpuesto"])){

				array_push($params,$_SESSION["usuario"]->identificador,$empresa,
					$nombre,$desc,$carnet,$provincia,$exp,$contrato,$jornada, $titulacion);

			}else if(isset($_POST["idpuesto"])){

				array_push($params,$_POST["idpuesto"],$_SESSION["usuario"]->identificador,
					$nombre,$desc,$carnet,$provincia,$exp,$contrato,$jornada, $titulacion);
			}
			


			//print_r($params);
			$consulta->execute($params);

			if($consulta->rowCount()>0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);

				$row = $consulta->fetch();

				if($row["resultado"]){
					$id;
					$mensaje = "";
					if(isset($_POST["idpuesto"])){
						$mensaje = "Puesto modificado correctamente."."<br>";
						$_SESSION["idpst"] = $_POST["idpuesto"];
						$id = $_SESSION["idpst"];
					}else{
						$mensaje = "Puesto agregado correctamente."."<br>";
						$id = $row["identificador"];
					}

					$correcto = true;
					

					$sql = "call eliminarSkillsPuesto(?,?)";

					$consulta = $this->Idb->prepare($sql);
					$consulta->execute(array($_SESSION["usuario"]->identificador,$id));

					$consulta->setFetchMode(PDO::FETCH_ASSOC);
					$row = $consulta->fetch();

					/** Agregar etiquetas al puesto **/
					if(isset($_POST["etiquetas"])){
						for ($i=0; $i < count($_POST["etiquetas"]); $i++) { 
							$sql = "call agregarSkillsPuesto(?,?,?)";

							$consulta = $this->Idb->prepare($sql);
							$consulta->execute(array($_SESSION["usuario"]->identificador,$id,$_POST["etiquetas"][$i]));
							$consulta->setFetchMode(PDO::FETCH_ASSOC);
							$row = $consulta->fetch();

							if($row["resultado"]){
								$mensaje .= $_POST["etiquetas"][$i]." guardada correctamente <br> ";
							}else{
								$correcto = false;
							}

						}
						if($correcto){
							if(strlen($mensaje)>0){
								$mensaje .= "<br>";
							}else{
								$mensaje .="Sin etiquetas"."<br>";
							}
						}else{

							$mensaje .="No se ha podido agregar bien las etiquetas <br>";
						}
					}else{
						$mensaje .="Sin etiquetas"."<br>";
					}

					/** Fin Agregar etiquetas al puesto **/

					/** Agregar idiomas al puesto **/

					if(isset($_POST["idiomas"])){
						for ($i=0; $i < count($_POST["idiomas"]); $i++) { 
							$sql = "call agregarIdiomaPuesto(?,?,?)";

							$consulta = $this->Idb->prepare($sql);
							$consulta->execute(array($_SESSION["usuario"]->identificador,$id,$_POST["idiomas"][$i]));
							$consulta->setFetchMode(PDO::FETCH_ASSOC);
							$row = $consulta->fetch();

							if($row["resultado"]){
								$mensaje .= $_POST["idiomas"][$i]." guardado correctamente <br> ";
							}else{
								$correcto = false;
							}

						}
						if($correcto){
							if(strlen($mensaje)>0){
								$mensaje .="<br>";
							}else{
								$mensaje .="Sin idiomas"."<br>";
							}
						}else{

							$mensaje .="No se ha podido agregar bien los idiomas <br>";
						}
					}else{
						$mensaje .="Sin idiomas"."<br>";
					}

					/** Fin Agregar idiomas al puesto **/

					if(isset($_POST["funciones"])){
						for ($i=0; $i < count($_POST["funciones"]); $i++) { 
							$sql = "call agregarFuncionPuesto(?,?,?)";

							$consulta = $this->Idb->prepare($sql);
							$consulta->execute(array($_SESSION["usuario"]->identificador,$id,$_POST["funciones"][$i]));
							$consulta->setFetchMode(PDO::FETCH_ASSOC);
							$row = $consulta->fetch();

							if($row["resultado"]){
								$mensaje .= $_POST["funciones"][$i]." guardado correctamente <br> ";
							}else{
								$correcto = false;
							}

						}
						if($correcto){
							if(strlen($mensaje)>0){
								$mensaje .="<br>";
							}else{
								$mensaje .="Sin funciones"."<br>";
							}
						}else{

							$mensaje .="No se ha podido agregar bien las funciones <br>";
						}
					}else{
						$mensaje .="Sin funciones"."<br>";
					}

					/*}*/

					$_SESSION["mensajeServidor"] = $mensaje;

				}else{
					if(isset($_POST["idpuesto"])){
						$_SESSION["mensajeServidor"] = "No se ha podido modificar el puesto.";
					}else{
						$_SESSION["mensajeServidor"] = "No se ha podido agregar el puesto.";
					}

				}

			}else{
				$_SESSION["mensajeServidor"] = "No se ha obtenido ningún resultado.";
			}
		}
	}

	/** fin función agregar puesto**/

	/** FUNCIÓN PARA LISTAR INFORMACION Puesto **/

	function listarInformacionPuesto(){
		if(isset($_SESSION["idpst"])){

			$sql = "call cargarInfoPuesto(?,?)";
			$consulta = $this->Idb->prepare($sql);
			$consulta->execute(array($_SESSION["idpst"],$_SESSION["usuario"]->identificador));
			$consulta->setFetchMode(PDO::FETCH_ASSOC);			

			return $consulta->fetch();
		}

	}


	/** FIN FUNCIÓN PARA LISTAR INFORMACION Puesto **/

	/** función para cancelar modificaciones puesto **/

	function cancelarPuesto(){
		if(isset($_POST["cancelarpuesto"])){
			unset($_SESSION["idpst"]);
		}
	}




	/** fin función para cancelar modificaciones puesto **/

	/* Función para listar los estudiantes que tiene un puesto*/
	function listarEstudiantesPuesto($puesto){

		if(isset($_SESSION["idpst"])&&isset($puesto["interesados"])&&$puesto["interesados"]>0){
			?>
			<div class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-target=".interesados"><h4>Lista de interesados</h4></div>
				<div class="panel-body collapse interesados out">

					<?php

					$sql = "call listarEstPuesto(?,?)";
					$consulta = $this->Idb->prepare($sql);
					$consulta->execute(array($_SESSION["idpst"],$_SESSION["usuario"]->identificador));
					$consulta->setFetchMode(PDO::FETCH_ASSOC);

					$usuarios = array();
					$cont = 1;
					while ($usuario = $consulta->fetch()) {
						$usuarios[] = $usuario;
					}
				//print_r($usuario);
				//$usuarios[] = $row;
					for ($u=0; $u < count($usuarios); $u++) { 

						$identificador = $usuarios[$u]["identificador"];
						?>
						

						<div class="panel panel-default">
							<div class="panel-heading" data-toggle="collapse" data-target=".est<?php echo $cont;?>">
								<div class="row">
									<div class="col-md-8"><h4><?php echo $usuarios[$u]["nombre"];?><br>
										<small><b><?php echo $usuarios[$u]["email"];?></b>
											<?php
											if(isset($usuarios[$u]["telefono"])){
												echo " - <b>".$usuarios[$u]["telefono"]."</b>";
											}
											?>
											<?php
											if(isset($usuarios[$u]["provincia"])){
												echo " - <b>".$usuarios[$u]["provincia"]."</b>";
											}
											?>
										</small></h4>
									</div> 

								</div>
							</div>
							<div class="panel-body collapse out est<?php echo $cont; $cont++;?>" >          
								<?php
								if(isset($usuarios[$u]["foto"])&&isset($usuarios[$u]["descripcion"])){
									?>
									
									<p>  
										<h4>Sobre el estudiante:</h4>
										<?php
										if(isset($usuarios[$u]["foto"])){
											echo '<img src="subidas/'.$usuarios[$u]["foto"].'" style="float:left; padding-right:10px">';
										}

										if(isset($usuarios[$u]["descripcion"])){
											echo $usuarios[$u]["descripcion"];
										}
										?>
										<br style="clear: left;"><br>
										<?php
										if(isset($usuarios[$u]["cv"])){
											echo '<a href="subidas/'.$usuarios[$u]["cv"].'" target="_blank">Mostrar Currículum vitae </a>';
										}
										?>
									</p>
									<?php
								}


								/* experiencia */

								$sql = "select * from listarExperiencia where estudiante = ?";
								$consulta = $this->Idb->prepare($sql);
								$consulta->execute(array($identificador));
								$consulta->setFetchMode(PDO::FETCH_ASSOC);
								$experienciafilas = array();
								while ($row = $consulta->fetch()) {
									$experienciafilas[] = $row;
								}
								
								for ($i=0; $i < count($experienciafilas); $i++) { 
									echo "<hr>";			
									if($i == 0){
										
										echo "<h4>Experiencia:</h4>";
									}
									?>
									<div class="row">                        
										<div class="col-md-8"><b><?php echo $experienciafilas[$i]["titulo"];?><br>
											<small>Empresa: <?php echo $experienciafilas[$i]["empresa"];?></small></b>
										</div>
										<div class="col-md-4">
											<small class="femp ">Período: <i> <?php 

											$fechaini = $experienciafilas[$i]["fecha_ini"];
											$mes = date("n",strtotime($fechaini));
											$anio = date("Y",strtotime($fechaini));
											echo $this->meses[$mes].", ".$anio;

											?>- <?php 

											$fechafin = $experienciafilas[$i]["fecha_fin"];
											if($fechafin != "actualmente"){
												$mes = date("n",strtotime($fechafin));
												$anio = date("Y",strtotime($fechafin));
												echo $this->meses[$mes].", ".$anio;
											}else{
												echo $fechafin;
											}


											?> </i></small>
										</div>   
										<div class="col-md-8">
											<p>-Descripción: <br>  
												<?php echo $experienciafilas[$i]["descripcion"];?>
											</p>
										</div>									
									</div>

									<?php

								}
								/* fin experiencia*/

								/* educacion */

								$sql = "select * from listarEducacion where estudiante = ?";
								$consulta = $this->Idb->prepare($sql);
								$consulta->execute(array($identificador));
								$consulta->setFetchMode(PDO::FETCH_ASSOC);
								$educacionfilas = array();
								while ($row = $consulta->fetch()) {
									$educacionfilas[] = $row;
								}

								for ($i=0; $i < count($educacionfilas); $i++) { 			
									echo "<hr>";
									if($i == 0){
										echo "<h4>Educación:</h4>";
									}
									?>
									<div class="row">                        
										<div class="col-md-8"><b><?php echo $educacionfilas[$i]["titulo"];?><br>
											<small>Institución: <?php echo $educacionfilas[$i]["institucion"];?><br>
												<?php echo $educacionfilas[$i]["grado"];?>
											</small></b>
										</div>
										<div class="col-md-4">
											<small class="femp ">Período: <i> <?php 

											$fechaini = $educacionfilas[$i]["fecha_ini"];
											$mes = date("n",strtotime($fechaini));
											$anio = date("Y",strtotime($fechaini));
											echo $this->meses[$mes].", ".$anio;

											?> - <?php 

											$fechafin = $educacionfilas[$i]["fecha_fin"];

											if($fechafin != 0){
												$mes = date("n",strtotime($fechafin));
												$anio = date("Y",strtotime($fechafin));
												echo $this->meses[$mes].", ".$anio;
											}else{
												echo "actualmente";
											}


											?> </i></small>
										</div>   
										<div class="col-md-8">
											<p>-Descripción: <br>
												<?php echo $educacionfilas[$i]["descripcion"];?>
											</p>
										</div>
									</div>

									<?php
									
								}

								/* fin educación */

								/* Idiomas */
								$sql = "select * from listarIdiomasEst where estudiante = ?";
								$consulta = $this->Idb->prepare($sql);
								$consulta->execute(array($identificador));
								$consulta->setFetchMode(PDO::FETCH_ASSOC);
								$idiomasfilas = array();
								while ($row = $consulta->fetch()) {
									$idiomasfilas[] = $row;
								}

								for ($i=0; $i < count($idiomasfilas); $i++) {
									if($i == 0 ){
										echo "<hr><h4>Idiomas:</h4><p>";
									}

									echo $idiomasfilas[$i]["nombre"]." / ";


									if($i == count($idiomasfilas)-1){
										echo "</p>";
									}
								}

								/* Fin idiomas*/
								/* skills */
								$sql = "call listarEtiquetasEst(?,false)";
								$consulta = $this->Idb->prepare($sql);
								$consulta->execute(array($identificador));
								$consulta->setFetchMode(PDO::FETCH_ASSOC);		
								$etiquetas = array();
								while ($row = $consulta->fetch()) {
									$etiquetas[] = $row;
								}

								for ($i=0; $i < count($etiquetas); $i++) { 
									if($i == 0 ){
										echo "<hr><h4>Skills:</h4><p>";
									}

									echo $etiquetas[$i]["nombre"]." / ";


									if($i == count($etiquetas)-1){
										echo "</p>";
									}
								}

								/* fin skills */
								?> 


								<?php
								if(isset($usuarios[$u]["carnet"])){
									echo "<hr><b>Tiene carnet de conducir</b><br>";
								}
								?>

							</div>                               

						</div>



						<?php 
					} ?>
				</div>
			</div>
			<?php
		}
	}

	/* fin Función para listar los estudiantes que tiene un puesto*/

	/** FIN FICHA PUESTOS **/

	/**Filtro puestos **/

	/** funcion para listar los puestos **/

	function listarPuestos(){
		$html = "";
		$sql = "select nombre, identificador, empresa,provincia,descripcion, interesados from listarPuestos";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);

		$puestos = array();
		while ($row = $consulta->fetch()) {
			$puestos[] = $row;
		}


		for ($i=0; $i < count($puestos); $i++) { 
			echo "<form method='post'><tr>";
			foreach ($puestos[$i] as $clave => $valor) {

				if($clave == "identificador"){
					echo "<td><input type='checkbox' name='ids[]' value='$valor'> &nbsp; <button type='submit' name='modpst' value='$valor' class='btn btn-success'>
					<i class='fa fa-edit' aria-hidden='true'></i>
					</button></td>";
				}else{
					echo "<td><input type='hidden' name='".$clave."[".$puestos[$i]["identificador"]."]' value='$valor'>$valor</td>";
				}

			}
			echo "</tr></form>";
		}	

	}

	/** fin funcion para listar los puestos **/

	/** funcion para eliminar los puestos **/

	function eliminarPuestos(){

		if(isset($_POST["eliminarpst"])&&isset($_POST["ids"])){

			for ($i=0; $i < count($_POST["ids"]); $i++) { 

				$sql = "call eliminarPuesto(?,?)";

				$consulta = $this->Idb->prepare($sql);
				$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["ids"][$i]));
				if($consulta->rowCount() > 0){
					$row = $consulta->fetch();
					if($row["resultado"]){
						$_SESSION["mensajeServidor"] = "Puesto eliminado";
					}else{
						$_SESSION["mensajeServidor"] = "No se ha podido eliminar el puesto";
					}

				}else{
					$_SESSION["mensajeServidor"] = "No se ha recibido respuesta.";
				}




			}	
			//header("location:filtro_puestos.php");
		}

	}



	/** funcion para eliminar los puestos **/

	/* funcion para enviar id a modificar a la ficha */

	function modificarPuesto(){
		if(isset($_POST["modpst"])){
			$_SESSION["idpst"] = $_POST["modpst"];
			header("location:ficha_puestos.php");
		}
	}

	/* fin funcion para enviar id a modificar a la ficha */

	/** fin Filtro puestos **/
}

?>