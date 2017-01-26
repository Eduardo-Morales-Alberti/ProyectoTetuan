/** FILTRO DE USUARIOS **/

/** VISTA LISTAR USUARIOS **/

CREATE OR REPLACE VIEW tetuanjobs.listarUsuarios as 
	select us.id_usuario as identificador,email, nombre, apellidos, ciclo,
             CASE 
                  WHEN activo = 1 
                  THEN "Activo" 
                  ELSE "Pendiente" 
             END as estado
             from tetuanjobs.usuarios as us join tetuanjobs.estudiantes as est 
             on us.id_usuario = est.id_usuario 
             where tipo_usuario = "estudiante";

GRANT select on tetuanjobs.listarUsuarios To 'usertetuan'@'localhost';

/** VISTA LISTAR USUARIOS**/


/** VISTA LISTAR empresas **/

CREATE OR REPLACE VIEW tetuanjobs.listarEmpresas as 
	select id_empresa as identificador, nombre_empresa as nombre, emp_web as web, email as correo, 
      telefono, persona_contacto as contacto
             from tetuanjobs.empresas;

GRANT select on tetuanjobs.listarEmpresas To 'usertetuan'@'localhost';

/** VISTA LISTAR empresas**/

/** FIN FILTRO DE USUARIOS**/
