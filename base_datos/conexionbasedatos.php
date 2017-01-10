<html>
<head> <title>PHP: Recuperación de Datos de MySQL</title></head>
<body bgcolor='white' text='navy'>
	<?php
 // conectamos con el servidor (con usuario= root y password = clave ) y elegimos la BD
	$idDB = @mysql_connect('127.0.0.1','usertetuan','tetuanjobs') or die("No puedo conectar con el gestor");
	$ok=@mysql_select_db('tetuanjobs') or die("No puedo seleccionar BD");
 // enviamos consulta
 $consulta = 'SELECT * FROM ADMINISTRADORES'; // formamos la consulta
 $resultado = mysql_query($consulta); // realizamos la consulta
 // recuperamos y mostramos el resultado
 echo "<h2 align='center'>Contenido de la tabla ADMINISTRADORES</h2>\n";
 echo "<table border='1' align='center'>\n";
 echo "<tr><td colspan='3'>Nº de filas: ", mysql_num_rows($resultado), "</td></tr>\n" ;
 echo "<tr><th> DNI </th><th> Nombre </th><th> email </th></tr>\n";
 $fila = mysql_fetch_array($resultado); // Guarda en array $fila la primera fila de $resultado
 while ( $fila ) // Mientras haya contenido en $fila
 { echo "<tr><td>", $fila['id_usuario'], "</td>"; // muestro valores de sus campos
 echo " <td>", $fila['nombre'], "</td>";
 echo " <td>", $fila['email'], "</td></tr>";
 $fila = mysql_fetch_array($resultado); // Guarda en array $fila la siguiente fila de $resultado
}
echo "</table>";
 // liberamos recursos y cerramos la conexión
mysql_free_result($resultado);
mysql_close($idDB);
?>
</body>
</html>