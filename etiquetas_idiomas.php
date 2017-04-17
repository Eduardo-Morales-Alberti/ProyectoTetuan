<?php
$page["nombrePag"] = "Gestión Etiquetas e Idiomas";

include_once("funciones/adminF.php");

session_start();

if(!isset($_SESSION["usuario"])){
    header("location:index.php");
}else if($_SESSION["usuario"]->tipo != "administrador"){
    header("location:dashboard.php");
}



$adminclass = new adminBBDD;

if(isset($_POST["token"])&&isset($_SESSION["tokens"])){
    $token = $_POST["token"];
    if($adminclass->comprobarToken("gestetqidm", $token)){ 
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

$idtoken = $adminclass->generarToken('gestetqidm');

ob_start();?>
<script type="text/javascript">
etiquetasIdiomas();

</script>
<?php
$page["js"] = ob_get_clean();

ob_start();
?>
<h1>Gestión de etiquetas e idiomas</h1> 

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
