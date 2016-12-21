<?php
session_start();
$_SESSION["tipo"] = "estudiante";
/**$page tendrá el resto del contenido que se mostrará en el cuerpo**/
/**Este es el nombre de la página, aparecerá en el title del cuerpo**/
$page["nombrePag"] = "Búsqueda de ofertas";
/**Llamada a la función perfil definida en el fichero /js/tetuanjobs.js
Se le llama en el cuerpo en las últimas líneas**/
ob_start();?>
<script type="text/javascript">
busqueda();

</script>
<?php
$page["js"] = ob_get_clean();
ob_start();?>

<h1>BÚSQUEDA DE OFERTAS</h1>
<div class="panel sinborde">    
    <!--<input type="hidden" name="key" value="<%=usuario.Key%>" />-->
    <input type="hidden" id="idtokken" name="idtokken" value="numero tokken" >
    <!--Panel Busqueda -->
    <form>
      <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Encuentra un empleo
            </h4> 
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre de la empresa</label>
                        <input type="text" class="form-control " id="nombreEmpresa" name="nombreEmpresa" value="" autofocus="autofocus">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre del puesto</label>
                        <input type="text" class="form-control " id="nombrepuesto" name="nombreEmpresa" value="" autofocus="autofocus">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Titulación mínima</label>
                        <div class="input-group">
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
                </div>			
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Requisitos</label>
                        <div class="input-group col-md-6">
                            <select class="form-control" name="etiqueta">
                                <option value="php">php</option>
                                <option value="php">java</option>
                                <option value="php">html</option>
                                <option value="php">css</option>
                            </select>
                            <span class="input-group-btn">
                                <input class="btn btn-success" name="ageex" type="button" value="Agregar requisito">
                            </span>
                        </div>               
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 form-group">                    
                    <div class="col-lg-12 conborde etiquetas">
                        <div class="row">
                            <div class="col-md-4 col-lg-3 form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" name="php" value="php">
                                    </span>
                                    <input type="text" class="form-control" value="php" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3 ">
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
                    <label>Carnet de conducir</label> <br>
                    <input type="checkbox" name="carnet" > Requiere carnet de conducir.
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de publicación</label>
                    <div class="input-group">
                        <select class="form-control" name="antiguedadoferta">
                            <option value="php">Hace 24 horas</option>
                            <option value="php">Última semana</option>
                            <option value="php">Último mes</option>
                            <option value="php">Indiferente</option>
                        </select>
                    </div>
                </div>
            </div>		
        </div>	
    </div>
    <div class="panel-footer">
        <div class="row">
           <div class="col-md-12 text-right">
              <input type="submit" class="btn btn-danger" name="limpiarfiltros" value="Limpiar filtros">
              <input type="submit" class="btn btn-green" name="buscarofertas" value="Buscar ofertas">
          </div>
      </div>
  </div>	

</div>
</form>
</div>

<!-- Fin panel Busqueda -->
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
        </div>

    </div>
</div>    
<!-- Fin Panel resultados -->

<?php 
/** Guardamos el buffer del cuerpo de la busqueda **/
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
