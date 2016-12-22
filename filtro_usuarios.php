<?php
$page["nombrePag"] = "Gestión de Usuarios";
session_start();
$_SESSION["tipo"] = "administrador";

ob_start();?>
<script type="text/javascript">
filtrous();

</script>
<?php
$page["js"] = ob_get_clean();

ob_start();
?>
<h1>GESTIÓN DE USUARIOS</h1> 
    <div class="panel panel-default">
     <div class="panel-heading">
        <h4>
            Gestiona usuarios
        </h4> 
    </div>
    <div class="panel-body">
       <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Ciclos formativos</label>
                <select class="form-control" name="ciclo">
                    <option value="todos">Todos</option>
                    <option value="daw">DAW</option>
                    <option value="asir">ASIR</option>

                </select>
            </div>
        </div>     
        <div class="col-md-6">
            <div class="form-group">
                <label>Estado</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" name="pendientes" value="pendientes de confirmar">
                    </span>
                    <input type="text" class="form-control" value="pendientes de confirmar" disabled="disabled">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
         <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="email" name="email" value="" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Introduzca un email valido" />
        </div>
    </div> 
</div>          
</div>
<div class="panel-footer">
    <div class="row">
        <div class="col-md-12 text-right">
         <input type="submit" class="btn btn-green" name="buscar" value="Buscar usuarios">
     </div>
 </div>
</div>  
</div>
<!-- Usuarios encontrados -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>
            Usuarios encontrados
        </h4> 
    </div>
    <div class="panel-body">
        <table id="resultado" class="display t-responsive" cellspacing="0" width="100%">
         <thead>
            <tr>
                <th>Seleccionar</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Ciclo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Seleccionar</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Ciclo</th>
                <th>Estado</th>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td ><input type="checkbox" name="usu" value="eduardo"></td>
                <td>eduardo@gmail.com</td>
                <td>Eduardo</td>
                <td>Morales Alberti</td>
                <td>DAW</td>
                <td>Pendiente</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="usu" value="antonio"></td>
                <td>antonio@hotmail.com</td>
                <td>Antonio</td>
                <td>Díaz del Valle</td>
                <td>ASIR</td>
                <td>Alta</td>
            </tr>
        </table>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-12 text-right">
                <input type="submit" class="btn btn-danger" name="eliminar" value="Eliminar selección">
                <input type="submit" class="btn btn-green" name="alta" value="Dar de alta">
            </div>
        </div>
    </div>
    <!-- Fin Usuarios encontrados -->

</div>
<?php
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
