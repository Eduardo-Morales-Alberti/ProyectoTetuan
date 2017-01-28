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
}