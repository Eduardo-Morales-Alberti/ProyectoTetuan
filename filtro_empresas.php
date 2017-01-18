<?php
$page["nombrePag"] = "Filtro de empresas";
include_once("funciones/generalF.php");
session_start();
/*$_SESSION["tipo"] = "administrador";*/
if(!isset($_SESSION["usuario"])){
    header("location:login.php");
}else if($_SESSION["usuario"]->tipo != "administrador"){
    header("location:dashboard.php");
}

ob_start();?>
<script type="text/javascript">
filtroem();

</script>
<?php
$page["js"] = ob_get_clean();

ob_start();
?>
<h1 >Filtro de empresas
</h1>

<!--Panel Busqueda -->

<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Buscar empresas</h4> 
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
              <div class="form-group">
               <label>Nombre de la empresa</label>
               <select class="form-control" name="empresa">
                <option value="todo">Todas</option>
                <option value="coritel">Coritel</option>
                <option value="kpmg">Kpmg</option>
                <option value="microsoft">Microsoft</option>
                <option value="apple">Apple</option>
            </select>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="emailEmpresa" name="emailEmpresa" value="" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Introduzca un email valido" />
        </div>
    </div> 
    <div class="col-md-4">
        <div class="form-group">
            <label>Teléfono</label>
            <input type="tel" class="form-control" id="telefonoEmpresa" name="telefonoEmpresa" value="" >
        </div>
    </div> 
    <div class="col-md-4">
        <div class="form-group">
           <label>Población</label>
           <select class="form-control" name="poblacion">
            <!-- Quiza podemos usar datalist en vez de option???-->
            <option value="todo">Todas</option>
            <option value="madrid">Madrid</option>
            <option value="alcobendas">Alcobendas</option>
            <option value="arganda">Arganda</option>
            <option value="tres cantos">Tres Cantos</option>
        </select>
    </div>
</div>  
</div>
<!--<div class="row">-->

<!--<div class="col-md-2">
    <div class="form-group">
        <label>Código Postal</label>
        <input type="direccion" class="form-control" id="direccionEmpresa" name="direccionEmpresa" value="" >
    </div>
</div> -->
<!--</div>-->
<div class="row">
 <div class="col-md-4">
    <div class="form-group">
        <label>Persona de contacto</label>
        <input type="direccion" class="form-control" id="direccionEmpresa" name="direccionEmpresa" value="" >
    </div>
</div>  
</div>
</div>
<div class="panel-footer">
    <div class="row">
       <div class="col-md-12 text-right">
           <input type="button" class="btn btn-warning" name="limpiarfiltros" value="Limpiar filtros">
           <input type="submit" class="btn btn-green" name="buscarpuesto" value="Buscar empresas">
       </div>
   </div>
</div>
</div>

<!-- Fin panel búsqueda empresas-->
<!-- Panel resultados -->

<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Resultados de la búsqueda</h4> 
    </div>
    <div class="panel-body">
        <table id="resempresas" class="display t-responsive" cellspacing="0" width="100%">
         <thead>
            <tr>
                <th>Editar</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Persona de contacto</th>                
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th >Editar</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Persona de contacto</th>                
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>
                    <form action="ficha_empresas.php" method="post">
                        <button type="submit" name="modificaremp" class="btn btn-success">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                    </form><!-- Este botón lleva a ficha_empresas.php donde se cargarán los datos de la empresa para modificarlos-->
                </td>
                <td>KPMG</td>
                <td>rrhh@kpmg.com</td>
                <td>91 666 66 66</td>
                <td>Macarena Marta Bla Bla</td>

            </tr>
            <tr>
                <td>
                    <form action="ficha_empresas.php" method="post">
                        <button type="submit" name="modificar" class="btn btn-success">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                        <!-- Este botón lleva a ficha_empresas.php donde se cargarán los datos de la empresa para modificarlos-->
                    </form>
                </td>
                <td>Informática El Corte Inglés</td>
                <td>rrhh@ieci.com</td>
                <td>91 666 66 33</td>
                <td>Persona de contacto 2</td>

            </tr>
        </table>               
    </div>
</div>   

<!-- Fin Panel resultados -->




<?php
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
