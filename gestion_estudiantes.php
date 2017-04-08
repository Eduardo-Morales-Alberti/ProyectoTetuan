<?php
$page["nombrePag"] = "Gestión de Usuarios";
include_once("funciones/generalF.php");


session_start();

if(!isset($_SESSION["usuario"])){
    header("location:index.php");
}else if($_SESSION["usuario"]->tipo != "administrador"){
    header("location:dashboard.php");
}

include_once("funciones/adminF.php");

$adminclass = new adminBBDD;

if(isset($_POST["token"])&&isset($_SESSION["tokens"])){
    $token = $_POST["token"];
    if($adminclass->comprobarToken("gestest", $token)){
        $adminclass->cambiarEstadoEst();
        $adminclass->eliminarUsuarios();
        $adminclass->eliminarEtiquetas();
        $adminclass->eliminarIdiomas();
    }else{
        $_SESSION["mensajeServidor"] = "El tiempo de espera ha caducado o el formulario no es válido.<br>".
        "Recargue la página y vuelva a intentarlo";
    }

}


/**$adminclass->cambiarEstadoEst();
$adminclass->eliminarUsuarios();*/
/*$adminclass->agregarEtiqueta();*/
/**$adminclass->eliminarEtiquetas();
$adminclass->eliminarIdiomas();*/

$idtoken = $adminclass->generarToken('gestest');

ob_start();?>
<script type="text/javascript">
filtrous();

</script>
<?php
$page["js"] = ob_get_clean();

ob_start();
?>
<h1>Gestión de estudiantes</h1> 
<form method="post">
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4>
                Lista de Estudiantes
            </h4> 
        </div>
        <div class="panel-body">
            <table id="resultado" class="display t-responsive" cellspacing="0" width="100%">
               <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Ciclo</th>
                    
                </tr>
            </thead>        
            <tbody>
                <?php 
                $adminclass->listarUsuarios();                
                ?>         
            </tbody>
            <tfoot>
                <tr>
                    <th>Seleccionar</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Ciclo</th>

                </tr>
            </tfoot>
        </table>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-12 text-right">
                <input type="hidden" name="token" value="<?php echo $idtoken;?>">  
                <input type="submit" class="btn btn-danger" name="eliminarus" value="Eliminar selección">
                <input type="submit" class="btn btn-green" name="cambiarest" value="Cambiar estado">
            </div>
        </div>
    </div>

</div>
</form>
<!-- Fin Usuarios encontrados -->
<?php
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
