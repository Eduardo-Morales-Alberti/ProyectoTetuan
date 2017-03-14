<?php
include_once("conexion.php");

class estudianteBBDD extends singleton{
	public $meses = array("actualmente","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

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
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$string = str_replace($no_permitidas, $permitidas ,$string);
		$string = preg_replace('/[^A-Za-z0-9\-\_]/', '_', $string);
		$string = preg_replace ('/[ ]+/', '_', $string);

		return strtolower($string); 
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

	/** FUNCIÓN LISTAR CICLOS **/
	/*function listarNiveles($seleccion = -1){
		$sql = "call obtenerEnum('formacion_clasificacion','formacion')";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$ciclosSELECT = "";

		$row = $consulta->fetch();
		if($row["resultado"]){
			$ciclos = explode(",", $row["resultado"]) ;
			//print_r($ciclos);
			$ciclosSELECT = " <option disabled selected value='nada'> -- Selecciona una opción -- </option>";
			for ($i=0; $i < count($ciclos) ; $i++) { 
				if($seleccion == $i+1){
					$ciclosSELECT .= "<option value='".($i+1)."' selected>";
					$nombre = preg_replace('/\'/', '', $ciclos[$i]);
					$ciclosSELECT .= $nombre."</option>";
				}else{
					$ciclosSELECT .= "<option value='".($i+1)."'>";
					$nombre = preg_replace('/\'/', '', $ciclos[$i]);
					$ciclosSELECT .= $nombre."</option>";
				}

			}
		}		

		return $ciclosSELECT;
	}*/

	/** FUNCIÓN LISTAR CICLOS **/

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
					<p>  
						<?php echo $experienciafilas[$i]["descripcion"];?>
					</p>
				</div>
				<div class="col-md-12 pie-acciones">
					<form method="post">
						<input type="hidden" name="idexp" value="<?php echo $experienciafilas[$i]["identificador"];?>">						
						<?php 
						foreach ($experienciafilas[$i] as $clave => $valor) {
							?>
							<input type="hidden" name="filas[<?php echo $clave;?>]" value="<?php echo $valor;?>">

							<?php
						}
						?>
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

	/** FUNCION Mostrar modal MODIFICAR Experiencia **/

	function modalModificarExperiencia(){
		if(isset($_POST["modexp"])&&isset($_POST["filas"])){			

			$generacl = new General;
			?>
			<form method="post">
				<input type="hidden" name="idexperiencia" value="<?php echo $_POST['filas']['identificador']; ?>">
				<div class="modal fade" id="modificarmodal" role="dialog">
					<div class="modal-dialog modal-lg">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Modificar <?php echo $_POST["filas"]["titulo"]; ?></h4>
							</div>

							<div class="modal-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Título</label>
											<input type="text" class="form-control " name="titulo"  value="<?php echo $_POST['filas']['titulo']; ?>" >
										</div>    
									</div>  
									<div class="col-md-6">
										<div class="form-group">
											<label>Empresa</label>
											<input type="text" class="form-control " name="empresa" value="<?php echo $_POST['filas']['empresa']; ?>" >
										</div>    
									</div>                      
								</div>                    
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Período</label><br>											
											<select name="f1mes" class="conborde">
												<?php 

												$mes1 = date("m",strtotime($_POST["filas"]["fecha_ini"]));
												$anio1 = date("Y",strtotime($_POST["filas"]["fecha_ini"]));
												$mes1 = $mes1-1;


												for ($i=1; $i < count($this->meses); $i++) {
													$mes =  $this->meses[$i];
													if($mes1 == $i){
														echo "<option value='".($i)."' selected> ".$mes."</option>";
													}else{
														echo "<option value='".($i)."'> ".$mes."</option>";
													}

												}
												?>
											</select>
											<input type="text" class="conborde text-center" name="f1anio" value="<?php echo $anio1;?>" placeholder="Año" required="required" maxlength="4" size="4" > - 

											<select class="conborde selact" name="f2mes">                                        
												<?php 
												if($_POST["filas"]["fecha_fin"] != "actualmente"){
													$mes2 = date("m",strtotime($_POST["filas"]["fecha_fin"]));
													$anio2 = date("Y",strtotime($_POST["filas"]["fecha_fin"]));
													$mes2 = $mes2-1;
												}else{
													$mes2 = 0;
													$anio2 = "";
												}


												for ($i=0; $i < count($this->meses); $i++) {
													$mes =  $this->meses[$i];
													if($mes2 == $i){
														echo "<option value='".($i)."' selected> ".$mes."</option>";
													}else{
														echo "<option value='".($i)."'> ".$mes."</option>";
													}

												}
												?>
												<!--<option value="0">actualmente</option>-->
											</select>
											<input type="text" name="f2anio"
											<?php 
											if($_POST["filas"]["fecha_fin"] == "actualmente"){
												echo "style='display:none;'";
											}
											?>value="<?php echo $anio2;?>" class="conborde text-center" placeholder="Año"  maxlength="4" size="4" >

										</div>    
									</div>  									                     
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Descripción</label><br>
											<textarea name="desc" class="form-control" rows="5"><?php echo $_POST["filas"]["descripcion"]; ?></textarea>
										</div>    
									</div>                      
								</div>
							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-warning" name="limpiar" value="Limpiar">
								<input type="submit" name="modificarexp" class="btn btn-green" value="Guardar">
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

	/** FIN FUNCION Mostrar modal MODIFICAR Experiencia **/

	/** FUNCION MODIFICAR Experiencia **/
	function modificarExperiencia(){
		if(isset($_POST["modificarexp"])&&isset($_POST["idexperiencia"])){

			$empresa = null;

			if(isset($_POST["empresa"])){
				$empresa = $_POST["empresa"];
			}

			$titulo = null;

			if(isset($_POST["titulo"])){
				$titulo = $_POST["titulo"];
			}

			$descripcion = null;

			if(isset($_POST["desc"])){
				$descripcion = $_POST["desc"];
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




			$sql = "call modificarExperiencia(?,?,?,?,?,?,?,?)";

			$params = array($_SESSION["usuario"]->identificador,$_POST["idexperiencia"],$titulo,$empresa,$descripcion,
				$fecha1,$fecha2,$actualmente);

			$consulta = $this->Idb->prepare($sql);
			$consulta->execute($params);

			if($consulta->rowCount()>0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$row = $consulta->fetch();
				if($row["resultado"]){
					$mensaje = "Experiencia actualizada";
				}else{
					$mensaje = "No se ha actualizado la experiencia";
				}


			}else{
				$mensaje = "No se obtenido filas de la base de datos.";
			}
			$_SESSION["mensajeServidor"] = $mensaje;
		}
	}

	/** FIN FUNCION MODIFICAR Experiencia **/

	/** FUNCIÓN LISTAR EDUCACIÓN **/

	function listarEducacion(){
		//$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
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
					<p>  
						<?php echo $educacionfilas[$i]["descripcion"];?>
					</p>
				</div>
				<div class="col-md-12 pie-acciones">
					<form method="post">
						<input type="hidden" name="idedc" value="<?php echo $educacionfilas[$i]["identificador"];?>">
						<?php 
						foreach ($educacionfilas[$i] as $clave => $valor) {
							?>
							<input type="hidden" name="filas[<?php echo $clave;?>]" value="<?php echo $valor;?>">

							<?php
						}
						?>
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

	/** FUNCION Mostrar modal MODIFICAR Educacion **/

	function modalModificarEducacion(){
		if(isset($_POST["modedc"])&&isset($_POST["filas"])){			
			$niveles = ["Fp básica","Grado medio","Bachillerato","Grado superior","Grado Universitario",
			"Máster","Certificado oficial","otro"];


			$generacl = new General;
			?>
			<form method="post">
				<input type="hidden" name="ideducacion" value="<?php echo $_POST['filas']['identificador']; ?>">
				<div class="modal fade" id="modificarmodal" role="dialog">
					<div class="modal-dialog modal-lg">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Modificar <?php echo $_POST["filas"]["titulo"]; ?></h4>
							</div>

							<div class="modal-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Título</label>
											<input type="text" class="form-control "  value="<?php echo $_POST['filas']['titulo']; ?>" disabled>
										</div>    
									</div>  
									<div class="col-md-6">
										<div class="form-group">
											<label>Institución</label>
											<input type="text" class="form-control " name="institucion" value="<?php echo $_POST['filas']['institucion']; ?>" >
										</div>    
									</div>                      
								</div>                    
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Período</label><br>											
											<select name="f1mes" class="conborde">
												<?php 

												$mes1 = date("m",strtotime($_POST["filas"]["fecha_ini"]));
												$anio1 = date("Y",strtotime($_POST["filas"]["fecha_ini"]));
												$mes1 = $mes1-1;


												for ($i=1; $i < count($this->meses); $i++) {
													$mes =  $this->meses[$i];
													if($mes1 == $i){
														echo "<option value='".($i)."' selected> ".$mes."</option>";
													}else{
														echo "<option value='".($i)."'> ".$mes."</option>";
													}

												}
												?>
											</select>
											<input type="text" class="conborde text-center" name="f1anio" value="<?php echo $anio1;?>" placeholder="Año" required="required" maxlength="4" size="4" > - 

											<select class="conborde selact" name="f2mes">                                        
												<?php 
												if($_POST["filas"]["fecha_fin"] != "actualmente"){
													$mes2 = date("m",strtotime($_POST["filas"]["fecha_fin"]));
													$anio2 = date("Y",strtotime($_POST["filas"]["fecha_fin"]));
													$mes2 = $mes2-1;
												}else{
													$mes2 = 0;
													$anio2 = "";
												}


												for ($i=0; $i < count($this->meses); $i++) {
													$mes =  $this->meses[$i];
													if($mes2 == $i){
														echo "<option value='".($i)."' selected> ".$mes."</option>";
													}else{
														echo "<option value='".($i)."'> ".$mes."</option>";
													}

												}
												?>
												<!--<option value="0">actualmente</option>-->
											</select>
											<input type="text" name="f2anio" 

											<?php 
											if($_POST["filas"]["fecha_fin"] == "actualmente"){
												echo "style='display:none;'";
											}
											?>

											value="<?php echo $anio2;?>" class="conborde text-center" placeholder="Año"  maxlength="4" size="4" >

										</div>    
									</div>  
									<div class="col-md-6">
										<div class="form-group">
											<label>Nivel</label><br>

											<select class="conborde" name="nivel">
												<?php 
												for ($i=0; $i < count($niveles); $i++) { 
													$nivel = $niveles[$i];
													if($nivel == $_POST["filas"]["grado"]){
														$nivel = $_POST["filas"]["grado"];
													}
													echo "<option value='".($i+1)."'> ".$nivel."</option>";
												}
												?>

											</select>
										</div>    
									</div>                     
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Descripción</label><br>
											<textarea name="desc" class="form-control" rows="5"><?php echo $_POST["filas"]["descripcion"]; ?></textarea>
										</div>    
									</div>                      
								</div>
							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-warning" name="limpiar" value="Limpiar">
								<input type="submit" name="modificarform" class="btn btn-green" value="Guardar">
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

	/** FIN FUNCION Mostrar modal MODIFICAR Educacion **/

	/** FUNCION MODIFICAR Formacion **/
	function modificarFormacion(){
		if(isset($_POST["modificarform"])&&isset($_POST["ideducacion"])){

			$institucion = null;

			if(isset($_POST["institucion"])){
				$institucion = $_POST["institucion"];
			}

			$clasificacion = null;

			if(isset($_POST["nivel"])){
				$clasificacion = $_POST["nivel"];
			}

			$descripcion = null;

			if(isset($_POST["desc"])){
				$descripcion = $_POST["desc"];
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




			$sql = "call modificarFormacion(?,?,?,?,?,?,?,?)";

			$params = array($_SESSION["usuario"]->identificador,$_POST["ideducacion"],$institucion,$clasificacion,$descripcion,
				$fecha1,$fecha2,$actualmente);

			$consulta = $this->Idb->prepare($sql);
			$consulta->execute($params);

			if($consulta->rowCount()>0){
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$row = $consulta->fetch();
				if($row["resultado"]){
					$mensaje = "Formación actualizada";
				}else{
					$mensaje = "No se ha actualizado la formación";
				}


			}else{
				$mensaje = "No se obtenido filas de la base de datos.";
			}
			$_SESSION["mensajeServidor"] = $mensaje;
		}
	}

	/** FIN FUNCION MODIFICAR Formacion **/

	/**Funcion select de skills estudiante **/

	function listarSkillsSelect(){

		$sql = "call listarEtiquetasEst(?,true)";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute(array($_SESSION["usuario"]->identificador));
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$etiquetasSELECT = "";
		$etiquetas = array();
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

	/** fin Funcion select de skills estudiante**/

	/** FUNCIÓN LISTAR ETIQUETAS DEL ESTUDIANTE **/
	function listarEtiquetasEst(){
		$sql = "call listarEtiquetasEst(?,false)";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute(array($_SESSION["usuario"]->identificador));
		$consulta->setFetchMode(PDO::FETCH_ASSOC);		
		$etiquetas = array();
		while ($row = $consulta->fetch()) {
			$etiquetas[] = $row;
		}
		$_SESSION["etiquetas"] = json_encode($etiquetas);

		$n = 0;
		for ($i=0; $i < count($etiquetas); $i++) { 
			$id = substr($this->limpiarRuta($etiquetas[$i]["nombre"]),0,5).$n;
			$n++;
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

	/** FIN FUNCIÓN LISTAR ETIQUETAS DEL ESTUDIANTE **/



	/** FUNCIÓN AGREGAR ETIQUETAS **/

	function agregarSkills(){		
		if(isset($_POST["guardarskills"])){
			$correcto = true;
			$mensaje = "";
			
			$sql = "call eliminarSkills(?)";

			$consulta = $this->Idb->prepare($sql);
			$consulta->execute(array($_SESSION["usuario"]->identificador));

			$consulta->setFetchMode(PDO::FETCH_ASSOC);
			$row = $consulta->fetch();

			if(isset($_POST["etiquetas"])){
				for ($i=0; $i < count($_POST["etiquetas"]); $i++) { 
					$sql = "call agregarSkills(?,?)";

					$consulta = $this->Idb->prepare($sql);
					$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["etiquetas"][$i]));
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
						$_SESSION["mensajeServidor"] = $mensaje;
					}else{
						$_SESSION["mensajeServidor"] = "Sin etiquetas";
					}

				}else{

					$_SESSION["mensajeServidor"] = "No se ha podido completar la operación";
				}
			}else{
				$_SESSION["mensajeServidor"] = "Sin etiquetas";
			}




		}
	}

	/** FIN FUNCIÓN AGREGAR ETIQUETAS **/

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

	/** Busqueda de puestos **/

	/** FUNCIÓN LISTAR Puestos **/

	function listarPuestos(){

		$condicion = "";
		if(isset($_POST["provincia"])){
			$condicion = " where idprovincia = ".$_POST["provincia"];
		}

		if(isset($_POST["empresa"])){
			if(strlen($condicion)>0){
				$condicion .= " and idempresa =".$_POST["empresa"];
			}else{
				$condicion = " where idempresa =".$_POST["empresa"];
			}
		}

		if(isset($_POST["contrato"])){
			if(strlen($condicion)>0){
				$condicion .= " and idcontrato =".$_POST["contrato"];
			}else{
				$condicion = " where idcontrato =".$_POST["contrato"];
			}
		}

		if(isset($_POST["experiencia"])){
			if(strlen($condicion)>0){
				$condicion .= " and idexperiencia =".$_POST["experiencia"];
			}else{
				$condicion = " where idexperiencia =".$_POST["experiencia"];
			}
		}

		if(isset($_POST["jornada"])){
			if(strlen($condicion)>0){
				$condicion .= " and idjornada =".$_POST["jornada"];
			}else{
				$condicion = " where idjornada =".$_POST["jornada"];
			}
		}
		/* select nombre, empresa, publicacion from listarPuestos where publicacion > date_sub(curdate(), interval 1 day); */
		if(isset($_POST["antiguedad"])){
			switch ($_POST["antiguedad"]) {
				case '1':
				if(strlen($condicion)>0){
					$condicion .= " and publicacion > date_sub(curdate(), interval 1 day)";
				}else{
					$condicion = " where publicacion > date_sub(curdate(), interval 1 day)";
				}
				break;
				case '2':
					if(strlen($condicion)>0){
						$condicion .= " and publicacion > date_sub(curdate(), interval 1 week)";
					}else{
						$condicion = " where publicacion > date_sub(curdate(), interval 1 week)";
					}
				break;
				case '3':
					if(strlen($condicion)>0){
						$condicion .= " and publicacion > date_sub(curdate(), interval 1 month)";
					}else{
						$condicion = " where publicacion > date_sub(curdate(), interval 1 month)";
					}
				break;
			}
		}

				/*if(isset($_POST["etiquetas"])){
					if(strlen($condicion)>0){
						$condicion .= " and ";
						for ($i=0; $i < count($_POST["etiquetas"]); $i++) {
							if($i == 0){
								$condicion .= " lower(nombre_etiqueta) = lower('".$_POST["etiquetas"][$i]."') ";
							}else{
								$condicion .= " or lower(nombre_etiqueta) = lower('".$_POST["etiquetas"][$i]."') ";
							}
							
						}
					}else{
						$condicion = " ";
						for ($i=0; $i < count($_POST["etiquetas"]); $i++) {
							if($i == 0){
								$condicion .= " lower(nombre_etiqueta) = lower('".$_POST["etiquetas"][$i]."') ";
							}else{
								$condicion .= " or lower(nombre_etiqueta) = lower('".$_POST["etiquetas"][$i]."') ";
							}
							
						}
					}
				}*/
				

				if(strlen($condicion)>0){
					$sql = "select * from listarPuestos ".$condicion;
					//echo $sql;
				}else{
					$sql = "select * from listarPuestos";
				}
				
				$consulta = $this->Idb->prepare($sql);
				$consulta->execute();
				$consulta->setFetchMode(PDO::FETCH_ASSOC);
				$puestosfilas = array();
				while ($row = $consulta->fetch()) {
					$puestosfilas[] = $row;
				}

				//$nombres = array();
				$sql = 'select true as existe from listarPstEtqEst where identificador = ? and lower(nombre_etiqueta) = lower(?)';


				
				for ($i=0; $i < count($puestosfilas); $i++) { 		
					/*if(!in_array($puestosfilas[$i]["nombre"], $nombres)){*/

						$id = $puestosfilas[$i]["identificador"];
						$existe = true;
						if(isset($_POST["etiquetas"])){
							$existe = false;
							for ($o=0; $o < count($_POST["etiquetas"])&&!$existe; $o++) {
								$consulta = $this->Idb->prepare($sql);
								$consulta->execute(array($id,$_POST["etiquetas"][$o]));
								$consulta->setFetchMode(PDO::FETCH_ASSOC);
								$row = $consulta->fetch();
								if($row["existe"]){
									$existe = true;
								}
							}
						}

						$sql = 'select true as aplicado from listarPstEtqEst where identificador = ? and idusuario = ?';
						$aplicado = false;	
						$consulta = $this->Idb->prepare($sql);
						$consulta->execute(array($id,$_SESSION["usuario"]->identificador));
						$consulta->setFetchMode(PDO::FETCH_ASSOC);
						$row = $consulta->fetch();
						if($row["aplicado"]){
							$aplicado = true;
						}

						if($existe){

							/*array_push($nombres, $puestosfilas[$i]["nombre"]);*/
							?>
							<div class="panel <?php if($aplicado){echo 'panel-success';}else{echo 'panel-default';}?>">
								<div class="panel-heading " data-toggle="collapse" data-target=".puesto<?php echo $i;?>">
									<div class="row">
										<div class="col-md-8"><h4><?php echo $puestosfilas[$i]["nombre"];?><br>
											<small><b>Empresa: </b> <?php echo $puestosfilas[$i]["empresa"]; ?> -
												<b>Correo: </b> <?php echo $puestosfilas[$i]["email"]; ?> - 
												<b>Contacto: </b> <?php echo $puestosfilas[$i]["contacto"]; ?>
											</small></h4>
										</div>						
										<div class="col-md-4">
											<small class="femp ">Fecha Publicación: <i> <?php 

											$fecha = $puestosfilas[$i]["publicacion"];
											$mes = date("n",strtotime($fecha));
											$anio = date("Y",strtotime($fecha));
											echo $this->meses[$mes].", ".$anio;

											?> </i></small>
										</div>
									</div>
								</div>
								<div class="panel-body collapse puesto<?php echo $i;?>" >		   

									<p>  
										<b>Descripción del puesto:</b><br>
										<?php echo $puestosfilas[$i]["descripcion"];?><br><br>
										<b>Condiciones:</b><br>
										<?php

										if($puestosfilas[$i]["idcontrato"] != 0){
											echo "<i>Contrato: </i> ".$puestosfilas[$i]["contrato"]."<br>";
										} 

										if($puestosfilas[$i]["idexperiencia"] != 0){
											echo "<i>Experiencia: </i> ".$puestosfilas[$i]["experiencia"]."<br>";
										}

										if($puestosfilas[$i]["idjornada"] != 0){
											echo "<i>Jornada: </i> ".$puestosfilas[$i]["jornada"]."<br>";
										}

										?> 
									</p>
									<?php 
									$sql = "call listarFuncionesPuesto(?)";
									$consulta = $this->Idb->prepare($sql);

									$consulta->execute(array($puestosfilas[$i]["identificador"]));
									$consulta->setFetchMode(PDO::FETCH_ASSOC);		
									$funciones = array();
									if($consulta->rowCount() > 0){
										while ($row = $consulta->fetch()) {
											$funciones[] = $row;
										}
										echo "<p> <b>Funciones:</b><br><ul>";
										for ($o=0; $o < count($funciones); $o++) { 
											echo "<li>".$funciones[$o]["nombre"]."</li>";
										}
										echo "</ul></p>";
									}
									?>
									<p>  
										<b>Provincia:</b>
										<?php echo $puestosfilas[$i]["provincia"];?>
									</p>
									<?php 
									$sql = "call listarIdiomasPuesto(?)";
									$consulta = $this->Idb->prepare($sql);

									$consulta->execute(array($puestosfilas[$i]["identificador"]));
									$consulta->setFetchMode(PDO::FETCH_ASSOC);		
									$idiomas = array();

									if($consulta->rowCount() > 0){

										while ($row = $consulta->fetch()) {
											$idiomas[] = $row;
										}		


										echo "<p> <b>Idiomas:</b><br>";
										for ($o=0; $o < count($idiomas); $o++) { 
											echo $idiomas[$o]["nombre"]." / ";
										}
										echo "</p>";

									}

									$sql = "call listarSkillsPuesto(?)";
									$consulta = $this->Idb->prepare($sql);

									$consulta->execute(array($puestosfilas[$i]["identificador"]));
									$consulta->setFetchMode(PDO::FETCH_ASSOC);		
									$etiquetas = array();
									if($consulta->rowCount() > 0){
										while ($row = $consulta->fetch()) {
											$etiquetas[] = $row;
										}

										echo "<p> <b>Skills:</b><br>";
										for ($o=0; $o < count($etiquetas); $o++) { 
											echo $etiquetas[$o]["nombre"]." / ";
										}
										echo "</p>";
									}

									if($puestosfilas[$i]["carnet"]){
										echo "<b>Requiere carnet de conducir</b><br>";
									}



									?>


								</div>
								<div class="panel-footer collapse puesto<?php echo $i;?>">
									<div class="row">
										<div class="col-md-12 pie-acciones">
											<form method="post" class="aplicarform">
												<input type="hidden" name="idpuesto" value="<?php echo $puestosfilas[$i]["identificador"];?>">								
												<?php 
												if($aplicado){
													echo '<input type="button" disabled value="Puesto ya aplicado" class="btn btn-success">';
												}else{
													echo '<input type="submit" name="aplicar"  value="Aplicar" class="btn btn-success">';
												}
												?>
												
											</form>
										</div>
									</div>
								</div>

							</div>

							<?php
					/*if($i<count($puestosfilas)-1){
						echo "<hr>";
					}*/
				}
			}	


		}


		/** FIN FUNCIÓN LISTAR Puestos **/

		/* FUNCION LISTAR ETIQUETAS OFERTAS*/
		function listarEtiquetasOfer(){
			if(isset($_POST["etiquetas"])){
				$n = 0;
				$etiquetas = array();				
				for ($i=0; $i < count($_POST["etiquetas"]); $i++) { 
					$id = substr($this->limpiarRuta($_POST["etiquetas"][$i]),0,5).$n;
					$n++;
					?>
					<div class="col-md-4 col-lg-3 form-group" id="<?php echo $id.'elemento';?>">
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" id="check<?php echo $id;?>" name="etiquetasel[]" value="<?php echo $id;?>">
							</span>
							<input type="text" class="form-control" id="input<?php echo $id;?>" name="etiquetas[]" value="<?php echo $_POST["etiquetas"][$i];?>" readonly>
						</div>
					</div>
					<?php
					$etiquetas[$i]["nombre"] = $_POST["etiquetas"][$i];
				}

				$_SESSION["etiquetas"] = json_encode($etiquetas);
			}
		}
		/* fin FUNCION LISTAR ETIQUETAS OFERTAS*/

		/* funcion para aplicar a un puesto */

		function aplicarPuesto(){
			if(isset($_POST["aplicar"])&&isset($_POST["idpuesto"])){
				$sql = "call aplicarPuesto(?,?)";
				$consulta = $this->Idb->prepare($sql);
				include_once("generalF.php");
				session_start();
				//echo "Usuario: ".$_SESSION["usuario"]->identificador." // Puesto: ".$_POST["idpuesto"];
				$consulta->execute(array($_SESSION["usuario"]->identificador,$_POST["idpuesto"]));
				$consulta->setFetchMode(PDO::FETCH_ASSOC);	

				if($consulta->rowCount() > 0){
					$row = $consulta->fetch();
					if($row["resultado"]){
						echo "correcto";
					}else{
						echo "fallo";
					}
				}else{
					echo "fallo";
				}
			}
		}

		/* fin funcion para aplicar a un puesto */

		/** Fin Busqueda de puestos **/

	}


	
	$estudiantecl = new estudianteBBDD;

	$estudiantecl->aplicarPuesto();
	

	?>