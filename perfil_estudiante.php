<?php
include_once("funciones/generalF.php");
session_start();
/*$_SESSION["tipo"] = "estudiante";*/
if(!isset($_SESSION["usuario"])){
    header("location:login.php");
}else if($_SESSION["usuario"]->tipo != "estudiante"){
    header("location:dashboard.php");
}
/**$page tendrá el resto del contenido que se mostrará en el cuerpo**/
/**Este es el nombre de la página, aparecerá en el title del cuerpo**/
$page["nombrePag"] = "Perfil";
/**Llamada a la función perfil definida en el fichero /js/tetuanjobs.js
Se le llama en el cuerpo en las últimas líneas**/

ob_start();?>
<script type="text/javascript">
perfil();
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
                                <input type="text" class="conborde text-center" name="f1anio" placeholder="Año" required="required" maxlength="4" size="4" > - 
                                
                                <select class="conborde selact" name="f2mes">                                        
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
                                    <option value="0">actualmente</option>
                                </select>
                                <input type="text" name="f2anio" class="conborde text-center" placeholder="Año"  maxlength="4" size="4" >

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
                    <input type="button" class="btn btn-warning" name="limpiar" value="Limpiar">
                    <input type="submit" class="btn btn-green" value="Guardar">
                    <input type="button" class="btn btn-info" data-dismiss="modal" value="Cancelar">
                    <!-- Para cerrar todos los modales con data-dismiss-->
                </div>

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
                                <input type="text" class="conborde text-center" name="f1anio" placeholder="Año" required="required" maxlength="4" size="4" > - 
                                
                                <select class="conborde selact" name="f2mes">                                        
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
                                    <option value="0">actualmente</option>
                                </select>
                                <input type="text" name="f2anio" class="conborde text-center" placeholder="Año"  maxlength="4" size="4" >

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
                    <input type="button" class="btn btn-warning" name="limpiar" value="Limpiar">
                    <input type="submit" class="btn btn-green" value="Guardar">
                    <input type="button" class="btn btn-info" data-dismiss="modal" value="Cancelar">
                </div>

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
                                <label>Hablado</label>
                                <select name="nvh" class="form-control " >
                                    <option value="1">Bajo</option>
                                    <option value="2">Intermedio</option>
                                    <option value="3">Alto</option>
                                    <option value="4">Bilingüe</option>
                                </select>
                            </div>    
                        </div>  
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <label>Escrito</label>
                                <select name="nve" class="form-control ">
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
                    <input type="button" class="btn btn-warning" name="limpiar" value="Limpiar">
                    <input type="submit" class="btn btn-green" value="Guardar">
                    <input type="button" class="btn btn-info" data-dismiss="modal" value="Cancelar">
                </div>

            </div>
        </div>
    </div>
    <?php

    $page["modal"][2] = ob_get_clean();
    /* Fin Modal idioma */

    ob_start();
    ?>

    <h1>Perfil</h1>
    <!--Panel Datos Personales -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Información del perfil</h4> 
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control " id="nombre" name="nombre" value="" autofocus="autofocus" required="required" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Introduzca un email valido" />
                    </div>
                </div> 
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" value="" >
                    </div>
                </div>                   
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Provincia</label>
                        <input type="text" class="form-control" name="poblacion" value="" >
                    </div>
                </div>           
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Población</label>
                        <input type="text" class="form-control" name="poblacion" value="" >
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Código Postal</label>
                        <input type="text" class="form-control"name="cpostal" value="" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fotografía de perfil</label><br>
                        <input type="button" value="Subir Archivo" class="btn btn-info" onclick="document.getElementById('fotop').click();">
                        <input type="file" id="fotop" name="fotop" style="display:none">                        
                        <input type="button" class="btn btn-primary" id="mostrarf" name="mostrarf" value="Mostrar fotografía">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Subir Currículum Vitae</label><br>
                        <input type="button" value="Subir Archivo" class="btn btn-info" onclick="document.getElementById('cv').click();">
                        <input type="file" id="cv" name="cv" style="display:none"> 
                        <input type="button" class="btn btn-primary" id="mostrarcv" name="mostrarcv" value="Mostrar CV">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Descripción personal</label>
                        <textarea class="form-control" rows="5" name="descpersonal">

                        </textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Carnet de conducir</label>
                        <div class="input-group">  
                            <span class="input-group-addon">
                                <input type="checkbox" name="carnet" value="carnet">
                            </span>
                            <input type="text" class="form-control" value="Tengo carnet de conducir" disabled="disabled">
                        </div>
                    </div>                        
                </div> 
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="button" class="btn btn-warning" name="limpiar" value="Limpiar">
                    <input type="submit" id="guardar" name="guardar" value="Guardar" class="btn btn-green">
                </div>
            </div>
        </div>
    </div>

    <!-- Fin panel Datos Personales -->
    <!-- Panel Actualizar Contraseña -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Cambiar Contraseña</h4> 
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Contraseña actual</label>
                        <input type="text" class="form-control" id="contr" name="contr" value="" required="required" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nueva contraseña</label>
                        <input type="text" class="form-control" id="ncontr" name="ncontr" value="" required="required">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Confirma la contraseña</label>
                        <input type="text" class="form-control" id="ccontr" name="ccontr" value="" required="required">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="submit" id="modificar" name="modificar" class="btn btn-green" value="Renovar">
                </div>
            </div>
        </div>
    </div>

    <!-- Fin panel Actualizar Contraseña -->
    <!-- Experiencia -->        
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Experiencia</h4> 
        </div>
        <div class="panel-body">
            <div class="row">                        
                <div class="col-md-8"><h4><span class="spn">Título del puesto</span><input class="npt" type="text" value="" name="tituloEmp"><br>
                    <small><span class="spn">Nombre de la empresa</span><input class="npt" type="text" value="" name="nombreEmp"></small></h4>
                </div>
                <div class="col-md-4">
                    <small class="femp ">Período: <i><span class="spn">Mayo</span><select name="f1mes" class="npt">
                        <option value="Enero">Enero</option>
                        <option value="Febrero">Febrero</option>
                        <option value="Marzo">Marzo</option>
                        <option value="Abril">Abril</option>
                        <option value="Mayo">Mayo</option>
                        <option value="Junio">Junio</option>
                        <option value="Julio">Julio</option>
                        <option value="Agosto">Agosto</option>
                        <option value="Septiembre">Septiembre</option>
                        <option value="Octubre">Octubre</option>
                        <option value="Noviembre">Noviembre</option>
                        <option value="Diciembre">Diciembre</option>
                    </select>, 
                    <span class="spn">2015</span><input type="text" class="text-center npt" name="f1anio" placeholder="Año" required="required" maxlength="4" size="4" > - 

                    <span class="mod1"><span class="oculto">Junio</span>Junio, 2016<span class="oculto">2016</span></span>
                    <span class="mod2"><select class="selact" name="f2mes">                                        
                        <option value="Enero">Enero</option>
                        <option value="Febrero">Febrero</option>
                        <option value="Marzo">Marzo</option>
                        <option value="Abril">Abril</option>
                        <option value="Mayo">Mayo</option>
                        <option value="Junio">Junio</option>
                        <option value="Julio">Julio</option>
                        <option value="Agosto">Agosto</option>
                        <option value="Septiembre">Septiembre</option>
                        <option value="Octubre">Octubre</option>
                        <option value="Noviembre">Noviembre</option>
                        <option value="Diciembre">Diciembre</option>
                        <option value="actualmente">actualmente</option>
                    </select>&nbsp;
                    <input type="text" name="f2anio" class="text-center" placeholder="Año"  maxlength="4" size="4" ></span>
                </i></small>



            </div>   
            <div class="col-md-8">
                <p>  
                    <span class="spn">Esta es la descripción del puesto de trabajo.</span>
                    <textarea class="npt" name="desc" rows="5"></textarea>
                </p>
            </div>
            <div class="col-md-12 pie-acciones">

                <input type="hidden" name="ided" value="85135454">
                <input type="submit" name="elimemp" value="Eliminar" class="btn btn-danger">
                <input type="submit" name="modemp" value="Modificar" class="btn btn-green">
            </div>
        </div>
        <hr>
        <div class="row">                        
            <div class="col-md-8"><h4><span class="spn">Título del puesto</span><input class="npt" type="text" value="" name="tituloEmp"><br>
                <small><span class="spn">Nombre de la empresa</span><input class="npt" type="text" value="" name="nombreEmp"></small></h4>
            </div>
            <div class="col-md-4">
                <small class="femp ">Período: <i><span class="spn">Mayo</span><select name="f1mes" class="npt">
                    <option value="Enero">Enero</option>
                    <option value="Febrero">Febrero</option>
                    <option value="Marzo">Marzo</option>
                    <option value="Abril">Abril</option>
                    <option value="Mayo">Mayo</option>
                    <option value="Junio">Junio</option>
                    <option value="Julio">Julio</option>
                    <option value="Agosto">Agosto</option>
                    <option value="Septiembre">Septiembre</option>
                    <option value="Octubre">Octubre</option>
                    <option value="Noviembre">Noviembre</option>
                    <option value="Diciembre">Diciembre</option>
                </select>, 
                <span class="spn">2015</span><input type="text" class="text-center npt" name="f1anio" placeholder="Año" required="required" maxlength="4" size="4" > - 

                <span class="mod1"><span class="oculto">Junio</span>Junio, 2016<span class="oculto">2016</span></span>
                <span class="mod2"><select class="selact" name="f2mes">                                        
                    <option value="Enero">Enero</option>
                    <option value="Febrero">Febrero</option>
                    <option value="Marzo">Marzo</option>
                    <option value="Abril">Abril</option>
                    <option value="Mayo">Mayo</option>
                    <option value="Junio">Junio</option>
                    <option value="Julio">Julio</option>
                    <option value="Agosto">Agosto</option>
                    <option value="Septiembre">Septiembre</option>
                    <option value="Octubre">Octubre</option>
                    <option value="Noviembre">Noviembre</option>
                    <option value="Diciembre">Diciembre</option>
                    <option value="actualmente">actualmente</option>
                </select>&nbsp;
                <input type="text" name="f2anio" class="text-center" placeholder="Año"  maxlength="4" size="4" ></span>
            </i></small>

        </div>   
        <div class="col-md-8">
            <p>  
                <span class="spn">Esta es la descripción del puesto de trabajo.</span>
                <textarea class="npt" name="desc" rows="5"></textarea>
            </p>
        </div>
        <div class="col-md-12 pie-acciones">

            <input type="hidden" name="ided" value="85135454">
            <input type="submit" name="elimemp" value="Eliminar" class="btn btn-danger">
            <input type="submit" name="modemp" value="Modificar" class="btn btn-green">
        </div>
    </div>
</div>
<div class="panel-footer">
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button" id="nexp" class="btn btn-green" data-toggle="modal" data-target="#modalexp">Añadir otro puesto de trabajo</button>
        </div>
    </div>
</div>
</div>

<!-- Fin de Experiencia -->
<!-- Educación -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Educación</h4> 
    </div>
    <div class="panel-body">
        <div class="row">                        
            <div class="col-md-8">
                <h4><span class="spn">Desarrollo de aplicaciones web</span><input class="npt" type="text" value="" name="titeduc"><br>
                    <small><span class="spn">Instituto Ies Tetuan</span><input class="npt" type="text" value="" name="institucion"></small><br>
                    <small><span class="spn">Grado superior</span><select class="conborde npt" name="nivel">
                        <option value="Fp básica">Fp básica</option>
                        <option value="Grado medio">Grado medio</option>
                        <option value="Bachillerato">Bachillerato</option>
                        <option value="Grado superior">Grado superior</option>
                        <option value="Carrera">Carrera</option>
                        <option value="Master">Master</option>
                        <option value="Certificado oficial">Certificado oficial</option>
                        <option value="otro">otro</option>
                    </select></small>
                </h4>
            </div>
            <div class="col-md-4"><small class="femp ">Período: <i><span class="spn">Mayo</span><select name="f1mes" class="npt">
                <option value="Enero">Enero</option>
                <option value="Febrero">Febrero</option>
                <option value="Marzo">Marzo</option>
                <option value="Abril">Abril</option>
                <option value="Mayo">Mayo</option>
                <option value="Junio">Junio</option>
                <option value="Julio">Julio</option>
                <option value="Agosto">Agosto</option>
                <option value="Septiembre">Septiembre</option>
                <option value="Octubre">Octubre</option>
                <option value="Noviembre">Noviembre</option>
                <option value="Diciembre">Diciembre</option>
            </select>, 
            <span class="spn">2015</span><input type="text" class="text-center npt" name="f1anio" placeholder="Año" required="required" maxlength="4" size="4" > - 

            <span class="mod1"><span class="oculto">Junio</span>Junio, 2016<span class="oculto">2016</span></span>
            <span class="mod2"><select class="selact" name="f2mes">                                        
                <option value="Enero">Enero</option>
                <option value="Febrero">Febrero</option>
                <option value="Marzo">Marzo</option>
                <option value="Abril">Abril</option>
                <option value="Mayo">Mayo</option>
                <option value="Junio">Junio</option>
                <option value="Julio">Julio</option>
                <option value="Agosto">Agosto</option>
                <option value="Septiembre">Septiembre</option>
                <option value="Octubre">Octubre</option>
                <option value="Noviembre">Noviembre</option>
                <option value="Diciembre">Diciembre</option>
                <option value="0">actualmente</option>
            </select>&nbsp;
            <input type="text" name="f2anio" class="text-center" placeholder="Año"  maxlength="4" size="4" ></span>
        </i></small></div>   
        <div class="col-md-12">
            <p>   
                <span class="spn">Esta es la descripción de la educación.</span>
                <textarea class="npt" name="desc" rows="5"></textarea>  
            </p>

        </div>
        <div class="col-md-12 pie-acciones">
            <input type="hidden" name="ided" value="85135454">
            <input type="submit" name="elimed" value="Eliminar" class="btn btn-danger">
            <input type="button" name="moded" value="Modificar" class="btn btn-green">
        </div>

    </div>
    <hr>
    <div class="row">                        
        <div class="col-md-8 ">
            <h4><span class="spn">Desarrollo de aplicaciones web</span><input class="npt " type="text" value="" name="titeduc"><br>
                <small><span class="spn">Instituto Ies Tetuan</span><input class="npt " type="text" value="" name="institucion"></small><br>
                <small><span class="spn">Grado superior</span><select class="conborde npt" name="nivel">
                    <option value="Fp básica">Fp básica</option>
                    <option value="Grado medio">Grado medio</option>
                    <option value="Bachillerato">Bachillerato</option>
                    <option value="Grado superior">Grado superior</option>
                    <option value="Carrera">Carrera</option>
                    <option value="Master">Master</option>
                    <option value="Certificado oficial">Certificado oficial</option>
                    <option value="otro">otro</option>
                </select></small>
            </h4>
        </div>
        <div class="col-md-4"><small class="femp ">Período: <i><span class="spn">Mayo</span><select name="f1mes" class="npt">
            <option value="Enero">Enero</option>
            <option value="Febrero">Febrero</option>
            <option value="Marzo">Marzo</option>
            <option value="Abril">Abril</option>
            <option value="Mayo">Mayo</option>
            <option value="Junio">Junio</option>
            <option value="Julio">Julio</option>
            <option value="Agosto">Agosto</option>
            <option value="Septiembre">Septiembre</option>
            <option value="Octubre">Octubre</option>
            <option value="Noviembre">Noviembre</option>
            <option value="Diciembre">Diciembre</option>
        </select>, 
        <span class="spn">2015</span><input type="text" class="text-center npt" name="f1anio" placeholder="Año" required="required" maxlength="4" size="4" > - 

        <span class="mod1"><span class="oculto">Junio</span>Junio, 2016<span class="oculto">2016</span></span>
        <span class="mod2"><select class="selact" name="f2mes">                                        
            <option value="Enero">Enero</option>
            <option value="Febrero">Febrero</option>
            <option value="Marzo">Marzo</option>
            <option value="Abril">Abril</option>
            <option value="Mayo">Mayo</option>
            <option value="Junio">Junio</option>
            <option value="Julio">Julio</option>
            <option value="Agosto">Agosto</option>
            <option value="Septiembre">Septiembre</option>
            <option value="Octubre">Octubre</option>
            <option value="Noviembre">Noviembre</option>
            <option value="Diciembre">Diciembre</option>
            <option value="0">actualmente</option>
        </select>&nbsp;
        <input type="text" name="f2anio" class="text-center" placeholder="Año"  maxlength="4" size="4" ></span>
    </i></small></div>   
    <div class="col-md-12">
        <p>   
            <span class="spn">Esta es la descripción de la educación.</span>
            <textarea class="npt" name="desc" rows="5"></textarea>  
        </p>

    </div>
    <div class="col-md-12 pie-acciones">
        <input type="hidden" name="ided" value="85135454">
        <input type="submit" name="elimed" value="Eliminar" class="btn btn-danger">
        <input type="button" name="moded" value="Modificar" class="btn btn-green">
    </div>
</div>
</div>
<div class="panel-footer">
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button"  class="btn btn-green" data-toggle="modal" data-target="#modaleduc">Añadir otra educación</button>
        </div>
    </div>
</div>
</div>
<!-- Educación -->
<!-- Skills -->

<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Skills</h4> 
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-12">
                <div class="form-group">
                    <label>Tus etiquetas</label> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-12 text-right">
                <input type="button"  class="btn btn-danger" id="eliminarskills" name="eliminarskills" value="Eliminar selección">
                <input type="submit"  class="btn btn-green" name="guardarskills" value="Guardar Skills">
            </div>
        </div>
    </div>
</div>

<!-- Fin Skills -->
<!-- Idiomas -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Idiomas</h4> 
    </div>
    <div class="panel-body">
        <div class="row">                        
            <div class="col-xs-4">
                <h4>Idioma</h4>
            </div>                 
            <div class="col-xs-4">
                <h4>Hablado</h4>

            </div>
            <div class="col-xs-4">
                <h4>Escrito</h4>

            </div>
        </div>
        <div class="row idiomas">                        
            <div class="col-xs-4">
                <span class="spn">Inglés</span><input type="text" class="form-control npt" name="titeduc" value="" required="required" >
            </div>                 
            <div class="col-xs-4">
                <span class="spn">Intermedio</span>
                <select name="nvh" class="npt " >
                    <option value="Bajo">Bajo</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Alto">Alto</option>
                    <option value="Bilingüe">Bilingüe</option>
                </select>
            </div>
            <div class="col-xs-4">
               <span class="spn">Alto</span>
               <select name="nve" class="npt ">
                <option value="Bajo">Bajo</option>
                <option value="Intermedio">Intermedio</option>
                <option value="Alto">Alto</option>
                <option value="Bilingüe">Bilingüe</option>
            </select>

        </div>               
        <div class="col-xs-12 pie-acciones">

            <input type="hidden" name="ididio" value="85135454">
            <input type="submit" name="elimidio" value="Eliminar" class="btn btn-danger">
            <input type="button" name="modidio" value="Modificar" class="btn btn-green">
        </div>

    </div>
    <div class="row idiomas" >                        
        <div class="col-xs-4">
            <span class="spn">Inglés</span><input type="text" class="form-control npt" name="titeduc" value="" required="required" >
        </div>                 
        <div class="col-xs-4">
            <span class="spn">Intermedio</span>
            <select name="nvh" class="npt " >
                <option value="Bajo">Bajo</option>
                <option value="Intermedio">Intermedio</option>
                <option value="Alto">Alto</option>
                <option value="Bilingüe">Bilingüe</option>
            </select>
        </div>
        <div class="col-xs-4">
           <span class="spn">Alto</span>
           <select name="nve" class="npt ">
            <option value="Bajo">Bajo</option>
            <option value="Intermedio">Intermedio</option>
            <option value="Alto">Alto</option>
            <option value="Bilingüe">Bilingüe</option>
        </select>

    </div>               
    <div class="col-xs-12 pie-acciones">
        <input type="hidden" name="ididio" value="85135454">
        <input type="submit" name="elimidio" value="Eliminar" class="btn btn-danger">
        <input type="button" name="modidio" value="Modificar" class="btn btn-green">

    </div>

</div>
</div>
<div class="panel-footer">
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="button"  class="btn btn-green" data-toggle="modal" data-target="#modalidioma">Añadir otro idioma</button>
        </div>
    </div>
</div>
</div>
<!-- Fin Idiomas -->

<!-- Eliminar cuenta -->
<div class="panel panel-danger">
    <div class="panel-heading text-right">
        <button type="button" class="btn btn-danger">Eliminar cuenta</button>
    </div>
</div>
<!-- Fin eliminar cuenta-->

<?php 
/** Guardamos el buffer del cuerpo del perfil **/
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
