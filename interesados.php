<?php
$page["nombrePag"] = "Interesados";

include_once("funciones/empresaF.php");

session_start();

if(!isset($_SESSION["usuario"])){
    header("location:index.php");
}else if($_SESSION["usuario"]->tipo != "empresa"){
    header("location:dashboard.php");
}



$empresacl = new empresaBBDD;
/*$empresacl->eliminarPuestos();
$empresacl->modificarPuesto();*/
if(isset($_POST["limpiar"])){
    $_POST = array();
}

ob_start();
?>
<h1 >Filtro de interesados
</h1>
<!--Panel Busqueda -->
<form method="post">      
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Encuentra un empleado
            </h4> 
        </div>
        <div class="panel-body">
            <div class="row">                
                <div class="col-md-6">
                 <div class="form-group">
                    <label>Provincia</label>
                    <select class="form-control" name="provincia">
                        <?php
                        $prov = null;
                        if(isset($_POST["provincia"])){$prov = $_POST["provincia"];}?>
                        <?php $empresacl->listarProvincias($prov); 
                        echo $empresacl->provinciasSELECT;?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre del puesto</label>
                    <select class="form-control" name="puesto">

                        <?php 
                        $pst = null;
                        if(isset($_POST["puesto"])){$pst = $_POST["puesto"];}
                        echo $empresacl->listarSelectPuestos($pst); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Formación</label>                       
                    <select class="form-control" name="formacion">
                        <?php
                        $cont = null;
                        if(isset($_POST["formacion"])){$cont = $_POST["formacion"];}
                        echo $empresacl->listarEnum("formacion_clasificacion","formacion",$cont); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
             <div class="form-group">
                <label>
                    Experiencia
                </label>                     
                <select class="form-control" name="experiencia">

                    <?php 
                    $exp = null;
                    if(isset($_POST["experiencia"])){$exp = $_POST["experiencia"];}
                    echo $empresacl->listarEnum("experiencia","puestos",$exp); ?>
                </select>
            </div>
        </div>          
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label>Etiquetas</label>
                <div class="input-group">
                    <select class="form-control" id="etiquetas" name="etiqueta">
                            <!--<option value="nada">Ninguna</option>
                            <option value="php">php</option>
                            <option value="java">java</option>
                            <option value="html">html</option>
                            <option value="css">css</option>-->
                            <?php echo $empresacl->listarTodasEtiquetas(); ?>
                        </select>
                        <span class="input-group-btn">
                            <input class="btn btn-success" id="ageex" name="ageex" type="button" value="Agregar etiqueta">
                        </span>
                    </div>               
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 form-group">                    
                <div class="col-lg-12 conborde etiquetas">
                    <div class="row" id="divetiquetas">
                        <?php 
                        /* echo $estudiantecl->listarEtiquetasOfer();*/
                        echo $empresacl->listarEtiquetasInter()
                        ?>
                        <!--<div class="col-md-4 col-lg-3 form-group" id="php">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="php" value="php">
                                </span>
                                <input type="text" class="form-control" value="php" disabled="disabled">
                            </div>
                        </div>-->
                        
                    </div>  
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="button" class="btn btn-danger" id="elimrequisito" name="elimrequisito" value="Eliminar selección">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de selección del puesto</label>
                    <select class="form-control" name="antiguedad" id="antiguedad" >
                        <option disabled selected value=''> -- Selecciona una opción -- </option>
                        <option value="" >Indiferente</option>
                        <option value="1">Hace 24 horas</option>
                        <option value="2">Última semana</option>
                        <option value="3">Último mes</option>                    
                    </select>
                </div>
            </div>      
        </div>  
    </div>
    <div class="panel-footer">
        <div class="row">
           <div class="col-md-12 text-right">

                <input type="submit" class="btn btn-warning" name="limpiar" value="Limpiar filtros">
       
            <input type="submit" class="btn btn-green" name="buscarinteresados" value="Buscar interesados">
        </div>
    </div>
</div>  
</div>

</form>

<?php
$empresacl->listarInteresados();

$page["cuerpo"] = ob_get_clean();

ob_start();?>
<script type="text/javascript">

<?php 
if(isset($_SESSION["etiquetas"])){
    echo 'agregarEtiquetas('.$_SESSION["etiquetas"].',elementosreq);';
    unset($_SESSION["etiquetas"]);
}
?>
interesados();
</script>
<?php
$page["js"] = ob_get_clean();


/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
