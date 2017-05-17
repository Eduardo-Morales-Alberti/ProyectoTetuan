<?php
$page["nombrePag"] = "Filtro de puestos";

include_once("funciones/empresaF.php");

session_start();

if(!isset($_SESSION["usuario"])){
    header("location:index.php");
}else if($_SESSION["usuario"]->tipo != "empresa"){
    header("location:dashboard.php");
}



$empresacl = new EmpresaBBDD;

if(isset($_POST["token"])&&isset($_SESSION["tokens"])){
    $token = $_POST["token"];

    if($empresacl->comprobarToken("filtro", $token)){
        $empresacl->eliminarPuestos();
    }else{
        $_SESSION["mensajeServidor"] = "El tiempo de espera ha caducado o el formulario no es válido.<br>".
        "Recargue la página y vuelva a intentarlo";
    }

}
$idtoken = $empresacl->generarToken('filtropuesto');

/**$empresacl->eliminarPuestos();*/
$empresacl->modificarPuesto();


ob_start();
?>
<h1 >Filtro de puestos
</h1>
<!--Panel Busqueda -->
<form method="post" >
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Buscar puesto
        </h4> 
    </div>
     <div class="panel-body">
            <table id="respuestos" class="display t-responsive" cellspacing="0" width="100%">
               <thead>
                <tr>
                    <th style="">Puesto</th>
                    <th>Acciones</th>   
                    <th>Provincia</th>
                    <th>Descripción</th>   
                    <th>Interesados</th>                                
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Puesto</th>
                    <th>Acciones</th> 
                    <th>Provincia</th>
                    <th>Descripción</th>   
                    <th>Interesados</th>                                 
                </tr>
            </tfoot>
            <tbody>
                
                <?php 
                $empresacl->listarPuestos();                
                ?>
            </tbody>
        </table>               
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-12 text-right">
                <input type="hidden" name="token" value="<?php echo $idtoken;?>">  
                <input type="reset" class="btn btn-warning" name="limpiar" value="Limpiar">
                <input type="submit" class="btn btn-danger" name="eliminarpst" value="Eliminar selección">
                
            </div>
        </div>
    </div>  

</div>
</form>

<?php

ob_start();?>
<script type="text/javascript">
filtroPuestos();
<?php 
if(isset($_SESSION["etiquetas"])){
    echo 'agregarEtiquetas('.$_SESSION["etiquetas"].');';
    unset($_SESSION["etiquetas"]);
}
?>
</script>
<?php
$page["js"] = ob_get_clean();

$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
