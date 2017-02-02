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

		$mail->Password = "alumno";

		$mail->SetFrom("contacto@momentosenlata.es");

		$mail->Subject = $asunto;

		$mail->Body = $cuerpo;

		foreach ($emails as $valor) {
			$mail->AddAddress($valor);
		}

		if(!$mail->Send()) {

			/*echo "Error en el mail: " . $mail->ErrorInfo;*/
			return false;

		} else {

			/*echo "El mensaje ha sido enviado";*/
			return true;

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

	function listarEtiquetas(){

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
			
				$idiomasSELECT .= "<option value='".$idiomas[$i]['identificador']."'>";
				$idiomasSELECT .= $idiomas[$i]['nombre']."</option>";
					
			
		}
		return $idiomasSELECT;

	}

	/** fin función listar Idiomas **/

	
}


?>