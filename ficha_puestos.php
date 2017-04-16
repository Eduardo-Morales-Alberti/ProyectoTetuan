<?php
$page["nombrePag"] = "Ficha de puestos";
include_once("funciones/generalF.php");
include_once("funciones/empresaF.php");
session_start();
if(!isset($_SESSION["usuario"])){
    header("location:index.php");
}else if($_SESSION["usuario"]->tipo != "empresa"){
    header("location:dashboard.php");
}

$generacl = new General;
$empresacl = new empresaBBDD;

if(isset($_POST["token"])&&isset($_SESSION["tokens"])){
    $token = $_POST["token"];

    if($empresacl->comprobarToken("fichpuesto", $token)){
        $empresacl->agregarPuesto();
    }else{
        $_SESSION["mensajeServidor"] = "El tiempo de espera ha caducado o el formulario no es válido.<br>".
        "Recargue la página y vuelva a intentarlo";
    }

}
$idtoken = $empresacl->generarToken('fichpuesto');


/**$empresacl->agregarPuesto();*/
$empresacl->cancelarPuesto();
$puesto = $empresacl->listarInformacionPuesto();
//print_r($puesto);

ob_start();
?>
<h1 >Ficha de puestos
</h1>  
<form method="post">
    <div class="panel panel-default">
        <div class="panel-heading" <?php  /*if(isset($_SESSION["idpst"])&&isset($puesto["interesados"])&&$puesto["interesados"]>0){echo 'data-toggle="collapse" data-target=".modificarpst"';}*/ ?> >
            <h4>
               <?php 
               if(isset($_SESSION["idpst"])){echo "Modificar Puesto '".$puesto['nombre']."'";}else{echo "Añadir un nuevo puesto";}
               ?>
           </h4> 
       </div>
       <div class="panel-body <?php  /*if(isset($_SESSION['idpst'])&&isset($puesto['interesados'])&&$puesto['interesados']>0){echo 'collapse out modificarpst';}*/ ?>">
        <div class="row">
            <!--<div class="col-md-6">
                <div class="form-group">
                    <label>Nombre de la empresa</label>
                    <select class="form-control"   <?php if(isset($puesto["id_emp"])){ echo "disabled";}else{echo 'name="empresa"';}?> >
                        <?php /*if(isset($puesto["id_emp"])){echo $generacl->listarEmpresasSelect($puesto["id_emp"]);
                    }else{echo $generacl->listarEmpresasSelect();
                    } */?>
                </select>
                <?php /*if(isset($puesto["id_emp"])){ echo '<input type="hidden" name="empresa" value="'.$puesto["id_emp"].'" >';}*/ ?>
            </div>
        </div>-->
        <div class="col-md-6">
            <div class="form-group">
                <label for="titpuesto">Título del puesto</label>
                <input type="text" class="form-control " id="titpuesto" name="titpuesto" value="<?php if(isset($puesto["nombre"])){echo $puesto["nombre"];}?>" >
            </div>
        </div>
    <!--</div>
    <div class="row">-->
        <div class="col-md-6">
            <div class="form-group">
                <label for="provincia">Provincia</label>
                <select class="form-control" name="provincia">
                    <?php if(isset($puesto["idprov"])){$generacl->listarProvincias($puesto["idprov"]);}?>
                    <?php echo $generacl->provinciasSELECT;?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="descpuesto">Descripción del puesto</label><br>
                <textarea class="form-control" rows="5" id="descpuesto" required name="descpuesto"><?php if(isset($puesto["descripcion"])){echo $puesto["descripcion"];}?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label>Funciones</label><br>
                <div class="input-group">
                    <input type="text" class="form-control " id="funciones"  >                            
                    <span class="input-group-btn">
                        <input type="button" class="btn btn-success" id="afuncion" name="afuncion" value="Agregar función">
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 form-group">                    
            <div class="col-lg-12 conborde etiquetas">
                <div class="row" id="divfunciones">
                    <?php echo $empresacl->listarFuncionesPst();?>
                        <!--<div class="col-md-6 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="el" value="Manejo de Gestores de contenido">
                                </span>
                                <input type="text" class="form-control" value="Manejo de Gestores de contenido" disabled="disabled">
                            </div>
                        </div>-->       
                    </div>  
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="button" class="btn btn-danger" id="elimfunc" name="elimfunc" value="Eliminar selección">
                </div>
            </div>
        </div>            
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Etiquetas</label>
                    <div class="input-group">
                        <select class="form-control" id="etiquetas" name="etiqueta">
                            <?php echo $empresacl->listarTodasEtiquetas();?>
                            
                        </select>
                        <span class="input-group-btn">
                            <input class="btn btn-success" id="ageex" name="ageex" type="button" value="Agregar etiqueta">
                        </span>
                    </div>               
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Agregar una nueva etiqueta</label> 
                    <div class="input-group">
                        <input type="text" class="form-control" id="etiquetasinput" placeholder="etiqueta">
                        <span class="input-group-btn">
                            <input class="btn btn-success" id="ageet" name="agreet" type="button" value="Agregar etiqueta">
                        </span>
                    </div>                           
                </div>                        
            </div> 
        </div>
        <div class="row">
            <div class="col-lg-12 form-group">                    
                <div class="col-lg-12 conborde etiquetas">
                    <div class="row" id="divetiquetas">
                        <?php $empresacl->listarEtiquetasPst(); ?>
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
            <div class="col-md-5">
                <div class="form-group">
                    <label>Idiomas</label>
                    <div class="input-group">
                        <select class="form-control" id="idiomas" name="idioma">
                            <?php echo $empresacl->listarIdiomas();?>
                        </select>
                        <span class="input-group-btn">
                            <input class="btn btn-success" id="ageidi" name="ageidi" type="button" value="Agregar idioma">
                        </span>
                    </div>               
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 form-group">                    
                <div class="col-lg-12 conborde etiquetas">
                    <div class="row" id="dividiomas">
                        <?php $empresacl->listarIdiomasPst(); ?>
                        <!--<div class="col-md-4 col-lg-3 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="ingles" value="ingles">
                                </span>
                                <input type="text" class="form-control" value="inglés" disabled="disabled">
                            </div>
                        </div>-->                      
                    </div>  
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="button" class="btn btn-danger" id="elimidi" name="elimidi" value="Eliminar selección">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                <label>Carnet de conducir</label> <br>

                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" name="carnet" value="carnet" <?php if(isset($puesto["carnet"])&&$puesto["carnet"]){echo "checked";}?> >
                    </span>
                    <input type="text" class="form-control" value="Requiere carnet de conducir" disabled="disabled">                        
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Experiencia</label>
                <select class="form-control" name="experiencia">
                    <?php
                    $exp = 1;
                    if(isset($puesto["experiencia"])){$exp = $puesto["experiencia"];}?>
                    <?php echo $generacl->listarEnum("experiencia","puestos",$exp); ?>
                </select>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tipo de contrado</label>
                <select class="form-control" name="contrato">
                    <?php
                    $contr = 1;
                    if(isset($puesto["contrato"])){$contr = $puesto["contrato"];}?>
                    <?php echo $generacl->listarEnum("tipo_contrato","puestos",$contr); ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Tipo de jornada</label>
                <select class="form-control" name="jornada">
                    <?php
                    $jorn = 1;
                    if(isset($puesto["jornada"])){$jorn = $puesto["jornada"];}?>
                    <?php echo $generacl->listarEnum("jornada","puestos",$jorn); ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Titulación mínima</label>

                <select class="form-control" name="nivel">
                    <?php
                    $tit = 1;
                    if(isset($puesto["titulacion"])){$tit = $puesto["titulacion"];}?>
                    <?php echo $generacl->listarEnum("titulacion_minima","puestos",$tit); ?>
                </select>

            </div>
        </div>    
        <div class="col-md-6 col-md-offset-2">
            <div class="form-group">
                <label>Mostrar para los ciclos</label>              
                <div class="row">
                    <div class="col-xs-4">
                        <?php 
                        $ciclos = array();
                        if (isset($puesto["ciclos"])) {
                            $ciclos = explode(",", $puesto["ciclos"]);
                            $ciclos = array_flip($ciclos);
                        }
                        ?>
                        <div class="checkbox">
                            <label>

                                <input type="checkbox" 
                                <?php 
                                if (isset($ciclos["DAW"])) {
                                    echo "checked";
                                }
                                ?> name="daw" value="daw">
                                DAW
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" 
                                <?php 
                                if (isset($ciclos["ASIR"])) {
                                    echo "checked";
                                }
                                ?>
                                name="asir" value="asir">
                                ASIR
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                <?php 
                                if (isset($ciclos["TURISMO"])) {
                                    echo "checked";
                                }
                                ?>
                                 name="turismo" value="turismo">
                                TURISMO
                            </label>
                        </div>
                    </div>
                </div>
            </div>      
            
            
            
        </div>



    </div>
</div>
<div class="panel-footer <?php  /*if(isset($_SESSION['idpst'])&&isset($puesto['interesados'])&&$puesto['interesados']>0){echo 'collapse out modificarpst';} */?>">
    <div class="row">
     <div class="col-md-12 text-right">
        <input type="hidden" name="token" value="<?php echo $idtoken;?>">  
        <?php 
        if(isset($_SESSION["idpst"])){
            echo '<input type="submit" class="btn btn-danger" name="cancelarpuesto" value="Cancelar">';
            echo '<input type="hidden" name="idpuesto" value="'.$_SESSION["idpst"].'">';
            //unset($_SESSION["idpst"]);
        }
        ?>
        <input type="reset" class="btn btn-warning" name="limpiar" value="Limpiar">
        <input type="submit" class="btn btn-green" name="guardarpuesto" id="guardarpuesto" value="Guardar puesto">

    </div>
</div>
</div>    

</div>
</form>

<?php
/* $empresacl->listarEstudiantesPuesto($puesto);*/
?>


<?php
$page["cuerpo"] = ob_get_clean();

/*if(isset($_SESSION["idpst"])){

    unset($_SESSION["idpst"]);
}*/

ob_start();?>
<script type="text/javascript">
fichapuestos();
<?php 
if(isset($_SESSION["funciones"])){
    echo 'agregarEtiquetas('.$_SESSION["funciones"].',elementosfunc);';
    unset($_SESSION["funciones"]);
}


if(isset($_SESSION["etiquetas"])){
    echo 'agregarEtiquetas('.$_SESSION["etiquetas"].',elementosreq);';
    unset($_SESSION["etiquetas"]);
}
if(isset($_SESSION["idiomas"])){
    echo 'agregarEtiquetas('.$_SESSION["idiomas"].',elementosidm);';
    unset($_SESSION["idiomas"]);
}

?>
</script>
<?php
$page["js"] = ob_get_clean();

/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
