<?php


class singleton {

	protected $Idb; private static $instancia; 


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

	/* funcion generar tokens */

	function generarToken($form){
		// generar token de forma aleatoria
		$token = md5(uniqid(microtime(), true));

   		// generar fecha de generación del token
		$token_time = time();

   		// escribir la información del token en sesión para poder
   		// comprobar su validez cuando se reciba un token desde un formulario
		$_SESSION['tokens'][$form.'_token'] = array('token'=>$token, 'time'=>$token_time);; 

		return $token;
	}

	/* fin funcion generar tokens */

	/* funcion comprobar token */

	function comprobarToken($form, $token, $delta_time=30) {

   // comprueba si hay un token registrado en sesión para el formulario
		if(!isset($_SESSION['tokens'][$form.'_token'])) {
			return false;
		}

   // compara el token recibido con el registrado en sesión
		if ($_SESSION['tokens'][$form.'_token']['token'] !== $token) {
			return false;
		}

   // si se indica un tiempo máximo de validez del ticket se compara la
   // fecha actual con la de generación del ticket
		if($delta_time > 0){
			$token_age = time() - $_SESSION['tokens'][$form.'_token']['time'];
			if($token_age >= ($delta_time*60)){
				return false;
			}
		}

		return true;
	}
}

?>