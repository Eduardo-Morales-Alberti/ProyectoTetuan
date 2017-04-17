<?php
include_once('funciones/empresaF.php');

session_start();

if(!isset($_SESSION["usuario"])){
    header("location:index.php");
}else if($_SESSION["usuario"]->tipo != "empresa"){
    header("location:dashboard.php");
}
/**$page tendrá el resto del contenido que se mostrará en el cuerpo**/
/**Este es el nombre de la página, aparecerá en el title del cuerpo**/
$page["nombrePag"] = "Perfil";


$empresacl = new empresaBBDD;



if(isset($_POST["token"])&&isset($_SESSION["tokens"])){
    $token = $_POST["token"];

    if($empresacl->comprobarToken("perfilemp", $token)){
        $empresacl->eliminarUsuario();
        $empresacl->cambiarContr();
        $empresacl->modificarinfo();
    }else{
        $_SESSION["mensajeServidor"] = "El tiempo de espera ha caducado o el formulario no es válido.<br>".
        "Recargue la página y vuelva a intentarlo";
    }

}



/**$empresacl->cambiarContr();
$empresacl->modificarinfo();*/


$informacion = $empresacl->listarInformacion();

$idtoken = $empresacl->generarToken('perfilemp');




ob_start();
?>

<h1>Perfil</h1>
<!--Panel Datos Personales -->
<form method="post" enctype="multipart/form-data">
    <div class="panel panel-default">        
        <div class="panel-heading" data-toggle="collapse" data-target=".collinfo">
            <h4>Información del perfil </h4> 
        </div>
        <div class="panel-body collapse in collinfo">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombre">Nombre de la empresa</label>                        
                        <input type="text" class="form-control" placeholder="Empresa" id="nombre" name="nombre" maxlength="25" value="<?php if(isset($informacion["nombre"])){echo $informacion["nombre"];}?>" autofocus="autofocus" required="required" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input  name="mail" id="mail" type="email" placeholder="Correo electrónico" class="form-control" required="required" value="<?php if(isset($informacion["email"])){echo $informacion["email"];}?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" class="form-control" placeholder="Teléfono" id="telefono" maxlength="9" size="9" name="telefono" value="<?php if(isset($informacion["telefono"])){echo $informacion["telefono"];}?>" >
                    </div>
                </div>                   
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contacto">Persona de contacto</label>                        
                        <input type="text" class="form-control " placeholder="Contacto" id="contacto" name="contacto" maxlength="50" value="<?php if(isset($informacion["contacto"])){echo $informacion["contacto"];}?>" required="required" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="web">Web</label>
                        <input type="text" class="form-control" id="web" name="web" placeholder="Web de la empresa" maxlength="50" value="<?php if(isset($informacion["web"])){echo $informacion["web"];}?>">
                    </div>
                </div>

            </div>

        </div>
        <div class="panel-footer collapse in collinfo" >
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="hidden" name="token" value="<?php echo $idtoken;?>">  
                    <input type="reset" class="btn btn-warning" name="limpiar" value="Limpiar">
                    <input type="submit" id="guardar" name="guardarinfo" value="Guardar" class="btn btn-green">
                </div>
            </div>
        </div>

    </div>
</form>
<!-- Fin panel Datos Personales -->
<!-- Panel Actualizar Contraseña -->
<form method="post">
    <div class="panel panel-default">

        <div class="panel-heading" data-toggle="collapse" data-target=".collcontr">
            <h4>Cambiar Contraseña</h4> 
        </div>
        <div class="panel-body collapse collcontr">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contr">Contraseña actual</label>
                        <input type="password" class="form-control"  id="contr" name="contr" value="" required="required" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ncontr">Nueva contraseña</label>
                        <input type="password" class="form-control" name="ncontr" id="ncontr" value="" required="required">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ccontr">Confirma la contraseña</label>
                        <input type="password" class="form-control"  name="ccontr" id="ccontr" value="" required="required">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer collapse collcontr">
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="hidden" name="token" value="<?php echo $idtoken;?>">  
                    <input type="submit" id="modcontr" name="modcontr" class="btn btn-green" value="Renovar">
                </div>
            </div>
        </div>

    </div>
</form>

<!-- Fin panel Actualizar Contraseña -->


<!-- Eliminar cuenta -->
<div class="panel panel-danger">
    <div class="panel-heading text-right">
        <form id="eliminarcuenta" method="post">
            <input type="hidden" name="token" value="<?php echo $idtoken;?>">  
            <input type="submit" name="elusuario" class="btn btn-danger" value="Eliminar cuenta">
        </form>
    </div>
</div>
<!-- Fin eliminar cuenta-->

<?php 
/** Guardamos el buffer del cuerpo del perfil **/
$page["cuerpo"] = ob_get_clean();
/**Llamada a la función perfil definida en el fichero /js/tetuanjobs.js
Se le llama en el cuerpo en las últimas líneas**/
ob_start();?>
<script type="text/javascript">
perfilempresa();
<?php 

?>
</script>
<?php
$page["js"] = ob_get_clean();

/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
