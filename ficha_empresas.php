<?php
$page["nombrePag"] = "Ficha de empresas";
session_start();
$_SESSION["tipo"] = "administrador";

ob_start();?>
<script type="text/javascript">
fichaem();

</script>
<?php
$page["js"] = ob_get_clean();

ob_start();
?>
<h1>Ficha de empresas</h1>
<!--panel Alta nueva empresa -->
    <form>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Alta de nueva empresa</h4> 
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nombre de la empresa</label>
                            <input type="text" class="form-control " name="nombreEmpresa" value="" autofocus="autofocus" required="required" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control"  name="email" value="" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Introduzca un email valido" />
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="" >
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Web de la empresa</label>
                            <input type="text" class="form-control" name="webemp" value="" >
                        </div>
                    </div>   
					<!--<div class="col-md-3">
                        <div class="form-group">
                            <label>Extensión</label>
                            <input type="text" class="form-control" id="telefonoEmpresa" name="telefonoEmpresa" value="" >
                        </div>
                    </div>-->
                </div>
				<div class="row">
					<div class="col-md-5">
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" class="form-control" name="diremp" value="" >
                        </div>
					</div>                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Población</label>
                            <input type="text" class="form-control" name="poblacion" value="" >
                        </div>
                    </div> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Código Postal</label>
                            <input type="text" class="form-control"name="cpostal" value="" >
                        </div>
                    </div>
				</div>
				<div class="row">
					<div class="col-md-4">
                        <div class="form-group">
                            <label>Persona de contacto</label>
                            <input type="text" class="form-control" name="pcontacto" value="" >
                        </div>
					</div>  
				</div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Descripción</label><br>
                            <textarea class="form-control" rows="5" name="descEmpresa">

                            </textarea>
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
    </form>
    <!-- Fin panel Alta nueva empresa -->


<?php 
/** Guardamos el buffer del cuerpo del perfil **/
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
