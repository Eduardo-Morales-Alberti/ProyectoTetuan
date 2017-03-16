<?php

require_once('PHPMailer/class.phpmailer.php');
require_once('PHPMailer/class.smtp.php');
include_once("conexion.php");

class Usuario{
	public $mail;
	public $nombre;
	public $identificador;
	public $tipo;

	public function __construct($m,$nom,$id,$tp){
		$this->mail = $m;
		$this->nombre = $nom;
		$this->identificador = $id;
		$this->tipo = $tp;
	}
}


class General extends singleton{
	public $provincias = array();
	public $provinciasSELECT = "";

	function __construct(){

		parent::__construct();	
		$this->listarProvincias();
	}

	/*function __destruct() {
		session_set_cookie_params(0);
		session_destroy();
	}*/

	//Función para enviar email
	public static function enviarEmail($emails, $asunto, $cuerpo){
		$mail = new PHPMailer(); // create a new object

		$mail->IsSMTP(); // enable SMTP

		$mail->SMTPDebug = false; // debugging: 1 = errors and messages, 2 = messages only

		$mail->SMTPAuth = true; // authentication enabled

		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

		//$mail->Host = "smtp.gmail.com";

		$mail->Host = "cp204.webempresa.eu";
		$mail->Port = 465; // or 587

		$mail->IsHTML(true);

		$mail->CharSet = 'UTF-8';
		
		$mail->Username = "contacto@momentosenlata.es";

		$mail->Password = "contactotetuan";

		$mail->SetFrom("contacto@momentosenlata.es");

		$mail->Subject = $asunto;

		$mail->Body = $cuerpo;

		foreach ($emails as $valor) {
			$mail->AddAddress($valor);
		}

		if(!$mail->Send()) {

			return "Error en el mail: " . $mail->ErrorInfo;
			/*return false;*/

		} else {

			/*echo "El mensaje ha sido enviado";*/
			return "correcto";

		}
	}
	/**fin Función para enviar email **/

	/** funcion listar provincias**/

	function listarProvincias($seleccion = -1){

		$sql = "select * from listarProvincias";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);

		while ($row = $consulta->fetch()) {
			$this->provincias[] = $row;
		}
		$this->provinciasSELECT = " <option disabled selected value> -- Selecciona una opción -- </option>";
		for ($i=0; $i < count($this->provincias) ; $i++) { 
			if($seleccion == $this->provincias[$i]['identificador']){
				$this->provinciasSELECT .= "<option value='".$this->provincias[$i]['identificador']."' selected>";
				$this->provinciasSELECT .= $this->provincias[$i]['nombre']."</option>";
			}else{
				$this->provinciasSELECT .= "<option value='".$this->provincias[$i]['identificador']."'>";
				$this->provinciasSELECT .= $this->provincias[$i]['nombre']."</option>";
			}
			
		}
		$this->provinciasSELECT .= "";

	}

	/** fin funcion listar provincias**/

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
		$idiomasSELECT = " <option disabled selected value=''> -- Selecciona una opción -- </option>";
		for ($i=0; $i < count($idiomas) ; $i++) { 
			
				$idiomasSELECT .= "<option value='".$idiomas[$i]['identificador']."'>";
				$idiomasSELECT .= $idiomas[$i]['nombre']."</option>";
					
			
		}
		return $idiomasSELECT;

	}

	/** fin función listar Idiomas **/

	/** función select listar empresas **/

	function listarEmpresasSelect($seleccion = -1){

		$sql = "select * from listarEmpresasSelect";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_ASSOC);

		while ($row = $consulta->fetch()) {
			$this->empresas[] = $row;
		}
		$empresasSELECT = " <option disabled selected value> -- Selecciona una opción -- </option>";
		for ($i=0; $i < count($this->empresas) ; $i++) { 
			if($seleccion == $this->empresas[$i]['identificador']){
				$empresasSELECT .= "<option value='".$this->empresas[$i]['identificador']."' selected>";
				$empresasSELECT .= $this->empresas[$i]['nombre']."</option>";
			}else{
				$empresasSELECT .= "<option value='".$this->empresas[$i]['identificador']."'>";
				$empresasSELECT .= $this->empresas[$i]['nombre']."</option>";
			}
			
		}
		$empresasSELECT .= "";
		return $empresasSELECT;

	}

	/** fin función select listar empresas **/

	/** FUNCIÓN LISTAR ENUM **/
	function listarEnum($columna, $tabla,$seleccion = -1){
		$sql = "call obtenerEnum(?,?)";
		$consulta = $this->Idb->prepare($sql);
		$consulta->execute(array($columna, $tabla));
		$consulta->setFetchMode(PDO::FETCH_ASSOC);
		$ciclosSELECT = "";

		$row = $consulta->fetch();
		if($row["resultado"]){
			$ciclos = explode(",", $row["resultado"]) ;
			//print_r($ciclos);
			$ciclosSELECT = " <option disabled selected value=''> -- Selecciona una opción -- </option>";
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
	}

	/** FUNCIÓN LISTAR ENUM **/

	
}


?>