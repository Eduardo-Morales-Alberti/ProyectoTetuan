<?php

/**$page tendrá el resto del contenido que se mostrará en el cuerpo**/
/**Este es el nombre de la página, aparecerá en el title del cuerpo**/
$page["nombrePag"] = "Búsqueda de ofertas";
include_once('funciones/estudianteF.php');

session_start();


if(!isset($_SESSION["usuario"])){
    header("location:index.php");
}else if($_SESSION["usuario"]->tipo != "estudiante"){
    header("location:dashboard.php");
}


$estudiantecl = new EstudianteBBDD;

/* Con esto limpiamos el formulario*/
if(isset($_POST["limpiar"])){
    $_POST = array();
}






ob_start();?>
<h1>Búsqueda de ofertas
</h1>
<form method="post">      
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Encuentra un empleo
            </h4> 
        </div>
        <div class="panel-body">
            <div class="row">                
                <div class="col-md-6">
                 <div class="form-group">
                    <label>Provincia</label>
                    <select class="form-control" name="provincia">
                        <?php

                        if(isset($_POST["provincia"])){$prov = $_POST["provincia"];}?>
                        <?php $estudiantecl->listarProvincias($prov); 
                        echo $estudiantecl->provinciasSELECT;?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre de la empresa</label>
                    <select class="form-control" name="empresa">

                        <?php 
                        if(isset($_POST["empresa"])){$emp = $_POST["empresa"];}
                        echo $estudiantecl->listarEmpresasSelect($emp); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipo de contrato</label>                       
                    <select class="form-control" name="contrato">
                        <?php
                        if(isset($_POST["contrato"])){$cont = $_POST["contrato"];}
                        echo $estudiantecl->listarEnum("tipo_contrato","puestos",$cont); ?>
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
                    if(isset($_POST["experiencia"])){$exp = $_POST["experiencia"];}
                    echo $estudiantecl->listarEnum("experiencia","puestos",$exp); ?>
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
                            <?php echo $estudiantecl->listarTodasEtiquetas(); ?>
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
                        echo $estudiantecl->listarEtiquetasOfer();
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
                <label>
                    Jornada
                </label>                     
                <select class="form-control" name="jornada">
                    <?php 
                    if(isset($_POST["jornada"])){$jorn = $_POST["jornada"];}
                    echo $estudiantecl->listarEnum("jornada","puestos",$jorn); ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Fecha de publicación</label>
                <select class="form-control" name="antiguedad" id="antiguedad" >
                    <!--<option disabled selected value='nada'> -- Selecciona una opción -- </option>-->
                    <option value="" selected>Indiferente</option>
                    <option value="1">Hace 24 horas</option>
                    <option value="2">Última semana</option>
                    <option value="3">Último mes</option>                    
                </select>
            </div>
        </div>		
    </div>	
    <div class="row">
         <div class="col-md-6">
            <div class="form-group">
                <label>Estado del puesto</label>
                <select class="form-control" name="estadop" id="estadop" >
                    <!--<option disabled selected value='nada'> -- Selecciona una opción -- </option>-->
                    <option value="" selected>Indiferente</option>
                    <option value="1">Aplicado</option>
                    <option value="2">No aplicado</option>                  
                </select>
            </div>
        </div>
    </div>
</div>
<div class="panel-footer">
    <div class="row">
       <div class="col-md-12 text-right">

        <input type="submit" class="btn btn-warning" name="limpiar" value="Limpiar filtros">

        <input type="submit" class="btn btn-green" name="buscarofertas" value="Buscar ofertas">
    </div>
</div>
</div>	
</div>
</form>


<!-- Fin panel Busqueda -->
<!-- Panel resultados -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Resultado de la búsqueda</h4> 
    </div>
    <div class="panel-body">
        <!--<div class="row">                        
            <div class="col-md-8">
                <h4>Título del puesto <br>
                    <small>Empresa</small>
                </h4>
            </div>
            <div class="col-md-4"><small class="femp">Fecha Publicación: <i>Mayo, 2016</i></small></div>   
            <div class="col-md-12">
                <p>   
                    Esta es la descripción del puesto de trabajo.

                </p>
            </div> 
            <div class="col-md-12 pie-acciones">
                <form>
                    <input type="hidden" name="idapli" value="85135454">
                    <input type="submit" name="aplicar" value="Aplicar" class="btn btn-success">
                </form>
            </div>
        </div>
        <hr>
        <div class="row">                        
            <div class="col-md-8">
                <h4>Título del puesto <br>
                    <small>Empresa</small>
                </h4>
            </div>
            <div class="col-md-4"><small class="femp">Fecha Publicación: <i>Mayo, 2016</i></small></div>   
            <div class="col-md-12">
                <p>   
                    Esta es la descripción del puesto de trabajo.

                </p>
            </div> 
            <div class="col-md-12 pie-acciones">
                <form>
                    <input type="hidden" name="idapli" value="85135454">
                    <input type="submit" name="aplicar" value="Aplicar" class="btn btn-success">
                </form>
            </div>
        </div>-->

        <?php $estudiantecl->listarPuestos();?>

    </div>  
</div> 
<!-- Fin Panel resultados -->

<?php 
/** Guardamos el buffer del cuerpo de la busqueda **/
$page["cuerpo"] = ob_get_clean();

/**Llamada a la función perfil definida en el fichero /js/tetuanjobs.js
Se le llama en el cuerpo en las últimas líneas**/
ob_start();?>
<script type="text/javascript">

<?php 
if(isset($_SESSION["etiquetas"])){
    echo 'agregarEtiquetas('.$_SESSION["etiquetas"].',elementosreq);';
    unset($_SESSION["etiquetas"]);
}
?>
busquedaofer();
<?php if(isset($_POST["antiguedad"])){ 

    ?>

    $("#antiguedad").val(<?php echo $_POST["antiguedad"];?>);
    <?php
}
?>

<?php if(isset($_POST["estadop"])){ 

    ?>


    $("#estadop").val(<?php if(isset($_POST['estadop'])) echo $_POST['estadop'] ?>);
    <?php
}
?>

</script>
<?php
$page["js"] = ob_get_clean();

/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
