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
<!-- Etiquetas e idiomas -->
<form method="post">
    <div class="panel panel-default">

        <div class="panel-heading">
            <h4>
                Etiquetas e idiomas
            </h4> 
        </div>
        <div class="panel-body">
         <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Agregar una nueva etiqueta</label> 
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputetiq" name="inputetiq" placeholder="etiqueta">
                        <span class="input-group-btn">
                            <input type="hidden" name="token" id="tokenetq" value="<?php echo $idtoken;?>">  
                            <input class="btn btn-success" id="agreet" name="agreet" type="button"  value="Agregar etiqueta">
                        </span>
                    </div>                           
                </div>                        
            </div> 
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Todas las etiquetas</label> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-lg-12 conborde etiquetas">
                    <div class="row" id="divetiquetas">
                    <!--
                    <div class="col-md-4 col-lg-3 form-group" id="php">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" name="php" value="php">
                            </span>
                            <input type="text" class="form-control" value="php" disabled="disabled">
                        </div>
                    </div>  
                -->              
                <?php echo $adminclass->listarEtiquetas();?>
            </div> 
        </div>
    </div>
</div> 
<div class="row">
    <div class="col-md-12 text-right">
        <br>
        <input type="submit"  class="btn btn-danger" name="eliminaret" value="Eliminar selección">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Agregar un nuevo idioma</label> 
            <div class="input-group">
                <input type="text" class="form-control" id="inputidm" name="inputidm" placeholder="idioma">
                <span class="input-group-btn">
                    <input type="hidden" name="token" id="tokenidm" value="<?php echo $idtoken;?>">  
                    <input class="btn btn-success" id="agreidm" name="agreidm" type="button"  value="Agregar idioma">
                </span>
            </div>                           
        </div>                        
    </div> 
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Todos los idiomas</label> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-lg-12 conborde etiquetas">
            <div class="row" id="dividiomas">
                    <!--
                    <div class="col-md-4 col-lg-3 form-group" id="php">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" name="php" value="php">
                            </span>
                            <input type="text" class="form-control" value="php" disabled="disabled">
                        </div>
                    </div>  
                -->              
                <?php echo $adminclass->listarIdiomas();?>
            </div> 
        </div>
    </div>
</div> 
<div class="row">
    <div class="col-md-12 text-right">
        <br>
        <input type="submit"  class="btn btn-danger" name="eliminaridm" value="Eliminar selección">
    </div>
</div>
</div>

</div>
</form>

<!-- Fin etiquetas e idiomas -->
<?php
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
