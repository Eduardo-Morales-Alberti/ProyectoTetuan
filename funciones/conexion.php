<?php


class singleton {

	protected $Idb; private static $instancia; 
	public $meses = array("actualmente","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	// un constructor privado evita crear nuevos objetos desde fuera de la clase
	protected function __construct() { 

		$this->Idb = new PDO( "mysql:host=localhost; dbname=tetuanjobs;charset=utf8", 'usertetuan','tetuanjobs'); 
		
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
		unset($_SESSION['tokens'][$form.'_token']);
		return true;
	}
}

?>