<?php
$page["nombrePag"] = "Filtro de puestos";
include_once("funciones/generalF.php");
session_start();

if(!isset($_SESSION["usuario"])){
    header("location:login.php");
}else if($_SESSION["usuario"]->tipo != "administrador"){
    header("location:dashboard.php");
}

ob_start();?>
<script type="text/javascript">
filtropuestos();

</script>
<?php
$page["js"] = ob_get_clean();

ob_start();
?>
<h1 >Filtro de puestos
</h1>
<!--Panel Busqueda -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Buscar puesto
        </h4> 
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre de la empresa</label>
                    <select class="form-control" name="etiqueta">
                        <option value="coritel">Coritel</option>
                        <option value="kpmg">Kpmg</option>
                        <option value="microsoft">Microsoft</option>
                        <option value="apple">Apple</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Título del puesto</label>
                    <input type="text" class="form-control " id="titpuesto" name="titpuesto" value="" >
                </div>
            </div>
        </div>          
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Etiquetas</label>
                    <div class="input-group">
                        <select class="form-control" id="etiquetas" name="etiqueta">
                            <option value="nada">Ninguna</option>
                            <option value="php">php</option>
                            <option value="java">java</option>
                            <option value="html">html</option>
                            <option value="css">css</option>
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
                        <div class="col-md-4 col-lg-3 form-group" id="php">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="php" value="php">
                                </span>
                                <input type="text" class="form-control" value="php" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="javascript" value="javascript" >
                                </span>
                                <input type="text" class="form-control" value="javascript" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="html" value="html">
                                </span>
                                <input type="text" class="form-control" value="html" disabled="disabled">
                            </div>
                        </div>                           
                        <div class="col-md-4 col-lg-3 form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="css" value="css">
                                </span>
                                <input type="text" class="form-control" value="css" disabled="disabled">
                            </div>
                        </div>
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
                    <label>Titulación mínima</label>

                    <select class="form-control" name="nivel">
                        <option value="1">FP básica</option>
                        <option value="2">CF Grado medio</option>
                        <option value="3">Bachillerato</option>
                        <option value="4">CF Grado superior</option>
                        <option value="5">Grado universitario</option>
                        <option value="6">Master</option>
                        <option value="7">Certificado oficial</option>
                        <option value="8">Otro</option>
                    </select>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Experiencia</label>
                    <select class="form-control" name="experiencia">
                        <option value="1">Sin experiencia</option>
                        <option value="2">Con algo de experiencia</option>
                        <option value="3">Más de un año trabajando</option>
                    </select>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipo de contrado</label>
                    <select class="form-control" name="contrato">
                        <option value="0">Sin especificar</option>
                        <option value="indef">Indefinido</option>
                        <option value="pract">Prácticas</option>
                        <option value="obra">De obra</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipo de jornada</label>
                    <select class="form-control" name="jornada">
                        <option value="0">Sin especificar</option>
                        <option value="completa">Jornada completa</option>
                        <option value="man">Horario de mañanas</option>
                        <option value="tardes">Horario de tardes</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="row">
           <div class="col-md-12 text-right">
              <input type="button" class="btn btn-warning" name="limpiarfiltros" value="Limpiar filtros">
              <input type="submit" class="btn btn-green" name="buscarpuesto" value="Buscar puestos">
          </div>
      </div>
  </div>    

</div>
<!-- Panel resultados -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Resultado de la búsqueda</h4> 
    </div>
    <div class="panel-body">
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
                    <input type="submit" name="modificar" value="Modificar" class="btn btn-success">
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
                    <input type="submit" name="modificar" value="Modificar" class="btn btn-success">
                </form>
            </div>
        </div>

    </div>  
</div> 
<!-- Fin Panel resultados -->

<?php
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
