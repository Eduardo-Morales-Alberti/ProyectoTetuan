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
var table = $('#ejemplo').DataTable( {
    responsive: true,
    "language": {
      "decimal":        "",
      "emptyTable":     "No hay datos disponibles",
      "info":           "Mostrando de _START_ a _END_ de _TOTAL_ entradas",
      "infoEmpty":      "Mostrando de 0 a 0 de 0 entradas",
      "infoFiltered":   "(filtrado de _MAX_ total entradas)",
      "infoPostFix":    "",
      "thousands":      ",",
      "lengthMenu":     "Mostrar &nbsp; _MENU_ entradas",
      "loadingRecords": "Cargando...",
      "processing":     "Procesando...",
      "search":         "Buscar:",
      "zeroRecords":    "No encontrado",
      "paginate": {
        "first":      "Primero",
        "last":       "Último",
        "next":       "Siguiente",
        "previous":   "Anterior"
    }
}
}); 
</script>
<?php
$page["js"] = ob_get_clean();


ob_start();
?>

<h1>Data Table</h1>
<div class="panel sinborde">    
    <!--<input type="hidden" name="key" value="<%=usuario.Key%>" />-->
    <input type="hidden" id="idtokken" name="idtokken" value="numero tokken" >    
    <!--  -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Otra información</h4> 
        </div>
        <div class="panel-body">

            <table id="ejemplo" class="display t-responsive" cellspacing="0" width="100%">
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
    <!-- Fin de datatable -->
</div>

<?php 
/** Guardamos el buffer del cuerpo **/
$page["cuerpo"] = ob_get_clean();
/** Incluimos el fichero cuerpo **/
include_once("cuerpo.php");
?>
