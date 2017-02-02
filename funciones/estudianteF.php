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

	/** FUNCIÓN PARA AÑADIR UNA NUEVA EXPERIENCIA **/
	function nuevaExperiencia(){
		
		if(isset($_POST["nuevaexp"])&&isset($_POST["tituloEmp"])){
			$sql = "call nuevaExperiencia(?,?,?,?,?,?,?)";
			$consulta = $this->Idb->prepare($sql);			
			
			$empresa = null;

			if(isset($_POST["nombreEmp"])){
				$empresa = $_POST["nombreEmp"];
			}

			$fecha1 = null;

			if(isset($_POST["f1mes"])&&isset($_POST["f1anio"])){
				$mes = 1;
				if($_POST["f1mes"] > 0 && $_POST["f1mes"] <= 12){
					$mes = $_POST["f1mes"];
				}
				$t=time();				
				$anio = date("Y",$t);

				if($_POST["f1anio"] > 1900 && $_POST["f1anio"] <= date("Y",$t)){
					$anio = $_POST["f1anio"];
				}

				$f = mktime(0,0,0,$mes,1,$anio);
				$fecha1 = date("Y-m-d H:i:s",$f);
			}

			$fecha2 = null;
			$actualmente = null;

			if(isset($_POST["f2mes"])&&$_POST["f2mes"]!=0&&isset($_POST["f2anio"])){
				$mes = 1;
				if($_POST["f2mes"] > 0 && $_POST["f2mes"] <= 12){
					$mes = $_POST["f2mes"];
				}
				$t=time();				
				$anio = date("Y",$t);

				if($_POST["f2anio"] > 1900 && $_POST["f2anio"] <= date("Y",$t)){
					$anio = $_POST["f2anio"];
				}

				$f = mktime(0,0,0,$mes,1,$anio);
				$fecha2 = date("Y-m-d H:i:s",$f);
			}elseif(isset($_POST["f2mes"])&&$_POST["f2mes"]==0){
				$actualmente = true;
			}

			$desc = null;

			if(isset($_POST["desc"])){
				$desc = $_POST["desc"];
			}	

			$params = array();
			array_push($params,$_SESSION["usuario"]->identificador,$_POST["tituloEmp"],$empresa,
				$fecha1,$fecha2,$actualmente,$desc);
			//print_r($params);
			$consulta->execute($params);

			if($consulta->rowCount()>0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);

				$row = $consulta->fetch();

				if($row["resultado"]){
					$_SESSION["mensajeServidor"] = "Experiencia insertada correctamente";
				}else{
					$_SESSION["mensajeServidor"] = "No se ha podido insertar la experiencia";
				}
				
			}else{
				$_SESSION["mensajeServidor"] = "No se ha podido insertar la experiencia";
			}
		}
	}
	/** fin FUNCIÓN PARA AÑADIR UNA NUEVA EXPERIENCIA **/

	/** FUNCIÓN PARA AÑADIR UNA NUEVA Formacion **/
	function nuevaFormacion(){
		
		if(isset($_POST["nuevaform"])&&isset($_POST["tituloeduc"])){
			$sql = "call nuevaFormacion(?,?,?,?,?,?,?,?)";
			$consulta = $this->Idb->prepare($sql);			
			
			$institucion = null;

			if(isset($_POST["institucion"])){
				$institucion = $_POST["institucion"];
			}

			$fecha1 = null;

			if(isset($_POST["f1mes"])&&isset($_POST["f1anio"])){
				$mes = 1;
				if($_POST["f1mes"] > 0 && $_POST["f1mes"] <= 12){
					$mes = $_POST["f1mes"];
				}
				$t=time();				
				$anio = date("Y",$t);

				if($_POST["f1anio"] > 1900 && $_POST["f1anio"] <= date("Y",$t)){
					$anio = $_POST["f1anio"];
				}

				$f = mktime(0,0,0,$mes,1,$anio);
				$fecha1 = date("Y-m-d H:i:s",$f);
			}

			$fecha2 = null;
			$actualmente = null;

			if(isset($_POST["f2mes"])&&$_POST["f2mes"]!=0&&isset($_POST["f2anio"])){
				$mes = 1;
				if($_POST["f2mes"] > 0 && $_POST["f2mes"] <= 12){
					$mes = $_POST["f2mes"];
				}
				$t=time();				
				$anio = date("Y",$t);

				if($_POST["f2anio"] > 1900 && $_POST["f2anio"] <= date("Y",$t)){
					$anio = $_POST["f2anio"];
				}

				$f = mktime(0,0,0,$mes,1,$anio);
				$fecha2 = date("Y-m-d H:i:s",$f);
			}elseif(isset($_POST["f2mes"])&&$_POST["f2mes"]==0){
				$actualmente = true;
			}

			$desc = null;

			if(isset($_POST["desc"])){
				$desc = $_POST["desc"];
			}	

			$nivel = null;

			if(isset($_POST["nivel"])&&is_numeric($_POST["nivel"])){
				$nivel = $_POST["nivel"];
			}

			$params = array();
			array_push($params,$_SESSION["usuario"]->identificador,$_POST["tituloeduc"],$institucion,
				$fecha1,$fecha2,$actualmente,$desc,$nivel);
			//print_r($params);
			$consulta->execute($params);

			if($consulta->rowCount()>0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);

				$row = $consulta->fetch();

				if($row["resultado"]){
					$_SESSION["mensajeServidor"] = "Formación insertada correctamente";
				}else{
					$_SESSION["mensajeServidor"] = "No se ha podido insertar la formación";
				}
				
			}else{
				$_SESSION["mensajeServidor"] = "No se ha podido insertar la formación";
			}
		}
	}
	/** fin FUNCIÓN PARA AÑADIR UNA NUEVA Formacion **/

	/** Función nuevo idioma **/

	function nuevoIdioma(){
		
		if(isset($_POST["nuevoidioma"])&&isset($_POST["idioma"])){
			$sql = "call nuevoIdioma(?,?,?,?)";
			$consulta = $this->Idb->prepare($sql);		
			$params = array();
			$hablado = 1;
			if(isset($_POST["nvh"])&&is_numeric($_POST["nvh"])){
				$hablado = $_POST["nvh"];
			}
			$escrito = 1;

			if(isset($_POST["nve"])&&is_numeric($_POST["nve"])){
				$escrito = $_POST["nve"];
			}

			array_push($params,$_SESSION["usuario"]->identificador,$_POST["idioma"],$hablado,
				$escrito);
			//print_r($params);
			$consulta->execute($params);

			if($consulta->rowCount()>0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);

				$row = $consulta->fetch();

				if($row["resultado"]){
					$_SESSION["mensajeServidor"] = "Idioma insertado correctamente";
				}else{
					$_SESSION["mensajeServidor"] = "No se ha podido insertar el idioma";
				}
				
			}else{
				$_SESSION["mensajeServidor"] = "No se ha podido insertar el idioma";
			}
		}
	}

	/** Fin Función nuevo idioma **/

	/** FUNCIÓN LISTAR EXPERIENCIA **/

	function listarExperiencia(){
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$sql = "select * from listarExperiencia where estudiante = ?";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute(array($_SESSION["usuario"]->identificador));
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$experienciafilas = array();
		while ($row = $consulta->fetch()) {
			$experienciafilas[] = $row;
		}
		//print_r($experienciafilas);
		for ($i=0; $i < count($experienciafilas); $i++) { 			

			?>
			<div class="row">                        
				<div class="col-md-8"><h4><?php echo $experienciafilas[$i]["titulo"];?><br>
					<small><?php echo $experienciafilas[$i]["empresa"];?></small></h4>
				</div>
				<div class="col-md-4">
					<small class="femp ">Período: <i> <?php 

					$fechaini = $experienciafilas[$i]["fecha_ini"];
					$mes = date("n",strtotime($fechaini));
					$anio = date("Y",strtotime($fechaini));
					echo $meses[$mes-1].", ".$anio;

					?>- <?php 

					$fechafin = $experienciafilas[$i]["fecha_fin"];
					if($fechafin != "actualmente"){
						$mes = date("n",strtotime($fechafin));
						$anio = date("Y",strtotime($fechafin));
						echo $meses[$mes-1].", ".$anio;
					}else{
						echo $fechafin;
					}
					
					
					?> </i></small>
				</div>   
				<div class="col-md-8">
					<p>  
						<?php echo $experienciafilas[$i]["descripcion"];?>
					</p>
				</div>
				<div class="col-md-12 pie-acciones">
					<form method="post">
						<input type="hidden" name="idexp" value="<?php echo $experienciafilas[$i]["identificador"];?>">
						<input type="submit" name="elimexp" value="Eliminar" class="btn btn-danger">
						<input type="submit" name="modexp" value="Modificar" class="btn btn-green">
					</form>
				</div>
			</div>

			<?php
			if($i<count($experienciafilas)-1){
				echo "<hr>";
			}
		}

		
	}


	/** FIN FUNCIÓN LISTAR EXPERIENCIA **/

	/** FUNCIÓN ELIMINAR EXPERIENCIA **/

	function eliminarExperiencia(){
		if(isset($_POST["elimexp"])&&isset($_POST["idexp"])){
			$sql = "call eliminarExperiencia(?,?)";
			$consulta = $this->Idb->prepare($sql);
			$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["idexp"]));
			if($consulta->rowCount() > 0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$row = $consulta->fetch();
				if($row["resultado"]){
					$_SESSION["mensajeServidor"] = "Experiencia eliminada correctamente";
				}else{
					$_SESSION["mensajeServidor"] = "No se ha eliminado la experiencia";
				}
				
			}else{
				$_SESSION["mensajeServidor"] = "No se ha obtenido ningún resultado";
			}
			
			
		}
	}

	/** FIN FUNCIÓN ELIMINAR EXPERIENCIA **/

	

	/** FUNCIÓN LISTAR EDUCACIÓN **/

	function listarEducacion(){
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$sql = "select * from listarEducacion where estudiante = ?";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute(array($_SESSION["usuario"]->identificador));
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$educacionfilas = array();
		while ($row = $consulta->fetch()) {
			$educacionfilas[] = $row;
		}
		//print_r($experienciafilas);
		for ($i=0; $i < count($educacionfilas); $i++) { 			

			?>
			<div class="row">                        
				<div class="col-md-8"><h4><?php echo $educacionfilas[$i]["titulo"];?><br>
					<small><?php echo $educacionfilas[$i]["institucion"];?><br>
						<?php echo $educacionfilas[$i]["grado"];?>
					</small></h4>
				</div>
				<div class="col-md-4">
					<small class="femp ">Período: <i> <?php 

					$fechaini = $educacionfilas[$i]["fecha_ini"];
					$mes = date("n",strtotime($fechaini));
					$anio = date("Y",strtotime($fechaini));
					echo $meses[$mes-1].", ".$anio;

					?>- <?php 

					$fechafin = $educacionfilas[$i]["fecha_fin"];
					if($fechafin != "actualmente"){
						$mes = date("n",strtotime($fechafin));
						$anio = date("Y",strtotime($fechafin));
						echo $meses[$mes-1].", ".$anio;
					}else{
						echo $fechafin;
					}
					
					
					?> </i></small>
				</div>   
				<div class="col-md-8">
					<p>  
						<?php echo $educacionfilas[$i]["descripcion"];?>
					</p>
				</div>
				<div class="col-md-12 pie-acciones">
					<form method="post">
						<input type="hidden" name="idedc" value="<?php echo $educacionfilas[$i]["identificador"];?>">
						<input type="submit" name="elimedc" value="Eliminar" class="btn btn-danger">
						<input type="submit" name="modedc" value="Modificar" class="btn btn-green">
					</form>
				</div>
			</div>

			<?php
			if($i<count($educacionfilas)-1){
				echo "<hr>";
			}
		}

		
	}


	/** FIN FUNCIÓN LISTAR EDUCACIÓN **/

	/** FUNCIÓN ELIMINAR Educacion **/

	function eliminarEducacion(){
		if(isset($_POST["elimedc"])&&isset($_POST["idedc"])){
			$sql = "call eliminarEducacion(?,?)";
			$consulta = $this->Idb->prepare($sql);

			$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["idedc"]));
			if($consulta->rowCount() > 0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$row = $consulta->fetch();
				if($row["resultado"]){
					$_SESSION["mensajeServidor"] = "Formación eliminada correctamente";
				}else{
					$_SESSION["mensajeServidor"] = "No se ha eliminado la formación";
				}
				
			}else{
				$_SESSION["mensajeServidor"] = "No se ha obtenido ningún resultado";
			}
			
			
		}
	}

	/** FIN FUNCIÓN ELIMINAR Educacion **/

	/** FUNCIÓN LISTAR Idiomas **/

	function listarIdiomas(){
		
		$sql = "select * from listarIdiomasEst where estudiante = ?";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute(array($_SESSION["usuario"]->identificador));
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$idiomasfilas = array();
		while ($row = $consulta->fetch()) {
			$idiomasfilas[] = $row;
		}
		//print_r($experienciafilas);
		for ($i=0; $i < count($idiomasfilas); $i++) { 			

			?>
			
			<div class="row idiomas">                        
				<div class="col-xs-4">
					<?php echo $idiomasfilas[$i]["nombre"];?>

				</div>                 
				<div class="col-xs-4">
					<?php echo $idiomasfilas[$i]["hablado"];?>
				</div>
				<div class="col-xs-4">
					<?php echo $idiomasfilas[$i]["escrito"];?>

				</div>               
				<div class="col-xs-12 pie-acciones">
					<form method="post">
						<input type="hidden" name="ididio" value="<?php echo $idiomasfilas[$i]["identificador"];?>">
						<?php 
							foreach ($idiomasfilas[$i] as $valor) {
								?>
								<input type="hidden" name="filas[]" value="<?php echo $valor;?>">
							
								<?php
							}
						?>
						
						<input type="submit" name="elimidio" value="Eliminar" class="btn btn-danger">
						<input type="submit" name="modidio" value="Modificar" class="btn btn-green">
					</form>
				</div>

			</div>
			

			<?php
		}

		
	}


	/** FIN FUNCIÓN LISTAR Idiomas **/

	/** FUNCIÓN ELIMINAR Idioma **/

	function eliminarIdioma(){
		if(isset($_POST["elimidio"])&&isset($_POST["ididio"])){
			$sql = "call eliminarIdioma(?,?)";
			$consulta = $this->Idb->prepare($sql);
			
			$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["ididio"]));
			if($consulta->rowCount() > 0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$row = $consulta->fetch();
				//echo($_POST["ididio"]);
				if($row["resultado"]){
					$_SESSION["mensajeServidor"] = "Idioma eliminado correctamente";
				}else{
					$_SESSION["mensajeServidor"] = "No se ha eliminado el idioma";
				}
				
			}else{
				$_SESSION["mensajeServidor"] = "No se ha obtenido ningún resultado";
			}
			
			
		}
	}

	/** FIN FUNCIÓN ELIMINAR Idioma **/

	/** FUNCION Mostrar modal MODIFICAR IDIOMA **/

	function modalModificarIdioma(){
		$niveles = array("Bajo","Intermedio","Alto","Bilingüe");
		if(isset($_POST["modidio"])&&isset($_POST["filas"])){
			$generacl = new General;
			?>
			<form method="post">
				<input type="hidden" name="ididioma" value="<?php echo $_POST["filas"][0]; ?>">
				<div class="modal fade" id="modificarmodal" role="dialog">
					<div class="modal-dialog modal-lg">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Modificar idioma <?php echo $_POST["filas"][1]; ?></h4>
							</div>

							<div class="modal-body">
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Idioma</label>
											<input type="text" class="form-control" value="<?php echo $_POST["filas"][1]; ?>" disabled> 
												
											
										</div>    
									</div>                     

									<div class="col-xs-6 col-md-3">
										<div class="form-group">
											<label>Hablado</label>
											<select name="nvh" class="form-control " >
												<?php 
													for ($i=0; $i < count($niveles); $i++) { 
														if($niveles[$i] == $_POST["filas"][2]){
															echo "<option value=".($i+1)." selected>".$niveles[$i]."</option>";
														}else{
															echo "<option value=".($i+1).">".$niveles[$i]."</option>";
														}														
													}
												?>
												
											</select>
										</div>    
									</div>  
									<div class="col-xs-6 col-md-3">
										<div class="form-group">
											<label>Escrito</label>
											<select name="nve" class="form-control ">
												<?php 
													for ($i=0; $i < count($niveles); $i++) { 
														if($niveles[$i] == $_POST["filas"][3]){
															echo "<option value=".($i+1)." selected>".$niveles[$i]."</option>";
														}else{
															echo "<option value=".($i+1).">".$niveles[$i]."</option>";
														}														
													}
												?>
											</select>
										</div>    
									</div>                     
								</div>
							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-warning" name="limpiar" value="Limpiar">
								<input type="submit" name="modificaridioma" class="btn btn-green" value="Guardar">
								<input type="button" class="btn btn-info" data-dismiss="modal" value="Cancelar">
							</div>

						</div>
					</div>
				</div>
			</form>
			<?php
			$_SESSION["modificar"] = "";
		}
	}

	/** FIN FUNCION Mostrar modal MODIFICAR IDIOMA **/

	/** FUNCION MODIFICAR IDIOMA **/
	function modificarIdioma(){
		if(isset($_POST["modificaridioma"])&&isset($_POST["ididioma"])&&isset($_POST["nve"])&&isset($_POST["nvh"])){

			$sql = "call modificarIdioma(?,?,?,?)";

			$params = array($_SESSION["usuario"]->identificador,$_POST["ididioma"],$_POST["nvh"],$_POST["nve"]);

			$consulta = $this->Idb->prepare($sql);
			$consulta->execute($params);

			if($consulta->rowCount()>0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$row = $consulta->fetch();
				if($row["resultado"]){
					$mensaje = "Idioma actualizado";
				}else{
					$mensaje = "No se ha actualizado el idioma";
				}

				
			}else{
				$mensaje = "No se obtenido filas de la base de datos.";
			}
			$_SESSION["mensajeServidor"] = $mensaje;
		}
	}

	/** FIN FUNCION MODIFICAR IDIOMA **/

	/** FIN PERFIL ESTUDIANTE **/

}

?>