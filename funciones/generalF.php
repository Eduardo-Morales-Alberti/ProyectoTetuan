<?php

require_once('PHPMailer/class.phpmailer.php');
require_once('PHPMailer/class.smtp.php');

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


class General {
	protected $Idb; private static $instancia; 
	public $meses = array("actualmente","Enero","Febrero","Marzo","Abril",
		"Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	public $provincias = array();
	public $provinciasSELECT = "";

	// un constructor privado evita crear nuevos objetos desde fuera de la clase
	protected function __construct(){
		$this->Idb = new PDO( "mysql:host=localhost; dbname=tetuanjobs;charset=utf8", 
			'usertetuan','tetuanjobs'); 
		$this->listarProvincias();
	}

	//método singleton que crea instancia sí no está creada
	public static function singleton() { 

		if (!isset(self::$instancia)) {

			$miclase = __CLASS__;
			self::$instancia = new $miclase;

		}

		return self::$instancia;
	}

	// Evita que el objeto se pueda clonar
	public function __clone(){ 

		trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR); 		
	}

	/** funcion limpiar caracteres **/

	function limpiar($string) {

		$string = preg_replace('/[^A-Za-zñÑáéíóúÁÉÍÓÚ0-9\-\_]/', ' ', $string);
		$string = preg_replace ('/[ ]+/', ' ', $string);

		return $string; 
	}

	/** fin funcion limpiar caracteres **/

	function limpiarRuta($string) {
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$string = str_replace($no_permitidas, $permitidas ,$string);
		$string = preg_replace('/[^A-Za-z0-9\-\_]/', '_', $string);
		$string = preg_replace ('/[ ]+/', '_', $string);

		return strtolower($string); 
	}

	/* funcion generar tokens */

	function generarToken($form){
		// generar token de forma aleatoria
		$token = md5(uniqid(microtime(), true));

   		// generar fecha de generación del token
		$token_time = time();

   		// escribir la información del token en sesión para poder
   		// comprobar su validez cuando se reciba un token desde un formulario
		$_SESSION['tokens'][$form.'_token'] = array('token'=>$token, 'time'=>$token_time);
		
		return $token;
	}

	/* fin funcion generar tokens */

	/* funcion comprobar token */

	function comprobarToken($form, $token, $delta_time=60) {

   		// comprueba si hay un token registrado en sesión para el formulario
		if(!isset($_SESSION['tokens'][$form.'_token'])) {
			return false;
		}

   		// compara el token recibido con el registrado en sesión
		if ($_SESSION['tokens'][$form.'_token']['token'] !== $token) {
			unset($_SESSION['tokens'][$form.'_token']);
			return false;
		}

   		// si se indica un tiempo máximo de validez del ticket se compara la
   		// fecha actual con la de generación del ticket
		if($delta_time > 0){
			$token_age = time() - $_SESSION['tokens'][$form.'_token']['time'];
			if($token_age >= ($delta_time*60)){
				unset($_SESSION['tokens'][$form.'_token']);
				return false;
			}
		}
		
		return true;
	}
	/* fin funcion comprobar token*/

	//Función para enviar email
	public function enviarEmail($emails, $asunto, $cuerpo){
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

	/** fin FUNCIÓN LISTAR ENUM **/

	
}


?>