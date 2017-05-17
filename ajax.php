<?php 
include_once('funciones/generalF.php');
session_start();

if(!isset($_SESSION["usuario"])){
	header("location:index.php");
}else if($_SESSION["usuario"]->tipo == "estudiante"){

	include_once('funciones/estudianteF.php');
	$estudiantecl = new EstudianteBBDD;
	$estudiantecl->aplicarPuesto();

}else if($_SESSION["usuario"]->tipo == "administrador"){
	include_once('funciones/adminF.php');
	$adminclass = new AdminBBDD;
	$adminclass->agregarEtiqueta();
	$adminclass->agregarIdioma();

}else{
	header("location:dashboard.php");
}




?>