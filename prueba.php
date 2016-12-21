<?php
session_start();
$_SESSION["tipo"] = "estudiante";
/**$page tendrá el resto del contenido que se mostrará en el cuerpo**/
/**Este es el nombre de la página, aparecerá en el title del cuerpo**/
$page["nombrePag"] = "Perfil";
/**Llamada a la función perfil definida en el fichero /js/tetuanjobs.js
Se le llama en el cuerpo en las últimas líneas**/

ob_start();?>
<script type="text/javascript">
perfil();
prueba();
</script>
<?php
$page["js"] = ob_get_clean();
/*Modal experiencia*/
/** Abro un buffer para alamacenar el html en el buffer**/
ob_start();?>
<!-- El id es importante en el modal porque através del atributo data-target="iddelmodal" con un botón
    lo vamos a invocar -->

    <div class="modal fade" id="modalexp" >
        <div class="modal-dialog modal-lg">

            <!-- Contenido del modal // Un modal es una ventana que se muestra encima del contenido -->
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Este boton sirve para cerrar el modal -->
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!-- Este es el título de la cabecera del modal -->
                    <h4 class="modal-title"><span id="titexp">Añadir un nuevo puesto de trabajo</span></h4>
                </div>
                <form>
                    <!-- Este es el cuerpo del modal -->
                    <div class="modal-body">
                        <!-- Esta es una fila dentro del cuerpo del modal -->
                        <div class="row">
                        <!-- Esta clase ocupa 6 columnas del grid de 12, lo que seria la mitad
                        pero cómo es md sólo se aplicará a una resolución de hasta 992 px-->
                        <div class="col-md-6">
                            <!-- La clase form-group da estilo al formulario-->
                            <div class="form-group">
                                <label>Título</label>
                                <!-- La clase form-control da estilo al input-->
                                <input type="text" class="form-control" name="tituloEmp" value="">
                            </div>    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Empresa</label>
                                <input type="text" class="form-control" name="nombreEmp" value="" >
                            </div>    
                        </div> 

                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Período</label><br>
                                <select class="conborde" name="f1mes">
                                    <option value="1">enero</option>
                                    <option value="2">febrero</option>
                                    <option value="3">marzo</option>
                                    <option value="4">abril</option>
                                    <option value="5">mayo</option>
                                    <option value="6">junio</option>
                                    <option value="7">julio</option>
                                    <option value="8">agosto</option>
                                    <option value="9">septiembre</option>
                                    <option value="10">octubre</option>
                                    <option value="11">noviembre</option>
                                    <option value="12">diciembre</option>
                                </select>
                                <input type="text" class="conborde" name="f1anio" required="required" maxlength="4" size="4" > - 
                                <span class="actSpan">
                                    <!-- Este input se enviará si está marcado el checkbox "actualmente"-->
                                    <input type="hidden" class="actInput" name="actInput" value="">
                                    actualmente
                                </span>
                                <div class="actDiv">
                                    <select class="conborde" name="f2mes">
                                        <option value="1">enero</option>
                                        <option value="2">febrero</option>
                                        <option value="3">marzo</option>
                                        <option value="4">abril</option>
                                        <option value="5">mayo</option>
                                        <option value="6">junio</option>
                                        <option value="7">julio</option>
                                        <option value="8">agosto</option>
                                        <option value="9">septiembre</option>
                                        <option value="10">octubre</option>
                                        <option value="11">noviembre</option>
                                        <option value="12">diciembre</option>
                                    </select>
                                    <input type="text" name="f2anio" class="conborde"  maxlength="4" size="4" >
                                </div>
                                <br>
                                <input type="checkbox" name="actualmente" class="actualmente conborde" >
                                Trabajo aquí actualmente
                            </div>    
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label><br>
                                <textarea name="desc" class="form-control" rows="5"></textarea>
                            </div>    
                        </div>                      
                    </div>
                </div>
                <!-- Este es el pie del modal -->
                <div class="modal-footer">
                    <input type="submit" class="btn btn-green" value="Guardar">
                    <!-- Para cerrar todos los modales con data-dismiss-->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
/** Obtenermos el buffer con todo el html anterior y limpiamos el buffer**/
$page["modal"][0] = ob_get_clean();


/*Fin Modal Experiencia*/

/*Modal Educación*/

ob_start();
?>
<div class="modal fade" id="modaleduc" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Añadir un nuevo estudio</h4>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control " name="titeduc" value="" required="required" >
                            </div>    
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Institución</label>
                                <input type="text" class="form-control " name="institucion" value=""  >
                            </div>    
                        </div>                      
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Período</label><br>
                                <select name="f1mes" class="conborde">
                                    <option value="1">enero</option>
                                    <option value="2">febrero</option>
                                    <option value="3">marzo</option>
                                    <option value="4">abril</option>
                                    <option value="5">mayo</option>
                                    <option value="6">junio</option>
                                    <option value="7">julio</option>
                                    <option value="8">agosto</option>
                                    <option value="9">septiembre</option>
                                    <option value="10">octubre</option>
                                    <option value="11">noviembre</option>
                                    <option value="12">diciembre</option>
                                </select>
                                <input type="text" class="conborde" name="f1anio" required="required" maxlength="4" size="4" > - 
                                <span class="actSpan">
                                    <input type="hidden" name="actInput" value="">
                                    actualmente
                                </span>
                                <div class="actDiv">
                                    <select class="conborde" name="f2mes">
                                        <option value="1">enero</option>
                                        <option value="2">febrero</option>
                                        <option value="3">marzo</option>
                                        <option value="4">abril</option>
                                        <option value="5">mayo</option>
                                        <option value="6">junio</option>
                                        <option value="7">julio</option>
                                        <option value="8">agosto</option>
                                        <option value="9">septiembre</option>
                                        <option value="10">octubre</option>
                                        <option value="11">noviembre</option>
                                        <option value="12">diciembre</option>
                                    </select>
                                    <input type="text" name="f2anio" class="conborde" maxlength="4" size="4" >
                                </div>
                                <br>
                                <input type="checkbox" name="actualmente" class="actualmente conborde">
                                Estudio aquí actualmente
                            </div>    
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nivel</label><br>
                                <select class="conborde" name="nivel">
                                    <option value="1">Fp básica</option>
                                    <option value="2">Grado medio</option>
                                    <option value="3">Bachillerato</option>
                                    <option value="4">Grado superior</option>
                                    <option value="5">Carrera</option>
                                    <option value="6">Master</option>
                                    <option value="7">Certificado oficial</option>
                                    <option value="8">otro</option>
                                </select>
                            </div>    
                        </div>                     
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label><br>
                                <textarea name="desc" class="form-control" rows="5"></textarea>
                            </div>    
                        </div>                      
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-green" value="Guardar">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$page["modal"][1] = ob_get_clean();

/*Fin Modal educ*/
/* Modal Idioma */

ob_start();
?>
<div class="modal fade" id="modalidioma" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Añadir un nuevo idioma</h4>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Idioma</label>
                                <input type="text" class="form-control " name="titeduc" value="" required="required" >
                            </div>    
                        </div>                     

                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <label>Hablado</label><br>
                                <select name="nvh" class="conborde">
                                    <option value="1">Bajo</option>
                                    <option value="2">Intermedio</option>
                                    <option value="3">Alto</option>
                                    <option value="4">Bilingüe</option>
                                </select>
                            </div>    
                        </div>  
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <label>Escrito</label><br>
                                <select name="nve" class="conborde">
                                    <option value="1">Bajo</option>
                                    <option value="2">Intermedio</option>
                                    <option value="3">Alto</option>
                                    <option value="4">Bilingüe</option>
                                </select>
                            </div>    
                        </div>                     
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-green" value="Guardar">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

$page["modal"][2] = ob_get_clean();
/* Fin Modal idioma */

ob_start();
?>

<h1>PERFIL</h1>
<div class="panel sinborde">    
    <!--<input type="hidden" name="key" value="<%=usuario.Key%>" />-->
    <input type="hidden" id="idtokken" name="idtokken" value="numero tokken" >    
    <!-- Carnet de conducir -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Otra información</h4> 
        </div>
        <div class="panel-body">
            
            <table id="example" class="display t-responsive" cellspacing="0" width="100%">
               <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011/04/25</td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>Garrett Winters</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                    <td>63</td>
                    <td>2011/07/25</td>
                    <td>$170,750</td>
                </tr>
            </table>               
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="submit"  class="btn btn-green" name="guardarcarnet" value="Guardar">
                </div>
            </div>
        </div>
    </div>    
    <!-- Fin carnet de conducir -->
    <!-- Eliminar cuenta -->
    <div class="panel panel-danger">
        <div class="panel-heading text-right">
            <button type="button" class="btn btn-danger">Eliminar cuenta</button>
        </div>
    </div>
    <!-- Fin eliminar cuenta-->
</div>

<?php 
/** Guardamos el buffer del cuerpo del perfil **/
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
