/** VISTAS GENERALES **/

/** VISTA LISTAR PROVINCIAS **/

CREATE OR REPLACE VIEW tetuanjobs.listarProvincias as 
     select id_provincia as identificador, nombre_provincia as nombre from tetuanjobs.provincias order by nombre;

GRANT select on tetuanjobs.listarProvincias To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR PROVINCIAS **/

/** VISTA LISTAR ETIQUETAS **/

CREATE OR REPLACE VIEW tetuanjobs.listarEtiquetas as 
     select id_etiqueta as identificador, nombre_etiqueta as nombre from tetuanjobs.etiquetas order by nombre;

GRANT select on tetuanjobs.listarEtiquetas To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR ETIQUETAS **/

/** VISTA LISTAR Idiomas **/

CREATE OR REPLACE VIEW tetuanjobs.listarIdiomas as 
     select id_idioma as identificador, nombre_idioma as nombre from tetuanjobs.idiomas order by nombre;

GRANT select on tetuanjobs.listarIdiomas To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR Idiomas **/

/** VISTA LISTAR EMPRESAS **/

CREATE OR REPLACE VIEW tetuanjobs.listarEmpresasSelect as 
     select id_empresa as identificador, nombre_empresa as nombre from tetuanjobs.empresas order by nombre;

GRANT select on tetuanjobs.listarEmpresasSelect To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR EMPRESAS **/

/** VISTAS GENERALES **/

/** FILTRO DE USUARIOS **/

/** VISTA LISTAR USUARIOS **/

CREATE OR REPLACE VIEW tetuanjobs.listarUsuarios as 
	select us.id_usuario as identificador,email, nombre, apellidos, ciclo, cv, carnet,
      descripcion, foto,
             CASE 
                  WHEN activo = 1 
                  THEN "Activo" 
                  ELSE "Pendiente" 
             END as estado, id_estudiante as idestudiante, telefono, nombre_provincia as provincia, prov.id_provincia as idprovincia
             from tetuanjobs.usuarios as us join tetuanjobs.estudiantes as est 
             on us.id_usuario = est.id_usuario  
             left join tetuanjobs.provincias prov on est.id_provincia = prov.id_provincia
             where tipo_usuario = "estudiante";

GRANT select on tetuanjobs.listarUsuarios To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR USUARIOS**/
/** FIN FILTRO DE USUARIOS**/

/** FILTRO DE empresas**/

/** VISTA LISTAR empresas **/

CREATE OR REPLACE VIEW tetuanjobs.listarEmpresas as 
	select nombre_empresa as nombre, id_empresa as identificador, emp_web as web, emp.email as correo, 
      telefono, persona_contacto as contacto, CASE 
                  WHEN activo = 1 
                  THEN "Activo" 
                  ELSE "Pendiente" 
             END as estado
             from tetuanjobs.empresas emp join tetuanjobs.usuarios us on emp.id_usuario = us.id_usuario;

GRANT select on tetuanjobs.listarEmpresas To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR empresas**/

/** FIN FILTRO DE empresas**/

/** Perfil estudiante **/

/** VISTA LISTAR EXPERIENCIA **/

CREATE OR REPLACE VIEW tetuanjobs.listarExperiencia as 
  select id_experiencia as identificador, titulo_puesto as titulo, nombre_empresa as empresa, f_inicio as fecha_ini, 
  if(actualmente,"actualmente",f_fin) as fecha_fin, experiencia_desc as descripcion,id_usuario as estudiante      
             from tetuanjobs.experiencia ex join tetuanjobs.estudiantes e on
             ex.id_estudiante = e.id_estudiante order by fecha_ini desc;

GRANT select on tetuanjobs.listarExperiencia To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR EXPERIENCIA **/

/** VISTA LISTAR EDUCACION **/

CREATE OR REPLACE VIEW tetuanjobs.listarEducacion as 
  select id_formacion as identificador, titulo_formacion as titulo, institucion, formacion_clasificacion as grado,
  f_inicio as fecha_ini,  if(actualmente,"actualmente",f_fin) as fecha_fin, 
  formacion_desc as descripcion, id_usuario as estudiante
             from tetuanjobs.formacion f  join tetuanjobs.estudiantes e on
             f.id_estudiante = e.id_estudiante order by fecha_ini desc;

GRANT select on tetuanjobs.listarEducacion To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR EDUCACION **/

/** VISTA LISTAR Idiomas **/

CREATE OR REPLACE VIEW tetuanjobs.listarIdiomasEst as 
  select id.id_idioma as identificador,nombre_idioma as nombre, hablado, escrito, id_usuario as estudiante
             from tetuanjobs.idiomas id join tetuanjobs.estudiantes_idiomas est_id on
             id.id_idioma = est_id.id_idioma
              join tetuanjobs.estudiantes e on
             est_id.id_estudiante = e.id_estudiante;

GRANT select on tetuanjobs.listarIdiomasEst To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR Idiomas **/

/** vista listar skills **/

CREATE OR REPLACE VIEW tetuanjobs.listarSkills as 
     select etq.id_etiqueta as identificador, nombre_etiqueta as nombre, usu.id_usuario usuario 
     from tetuanjobs.etiquetas etq left join 
     tetuanjobs.estudiantes_etiquetas estetq on etq.id_etiqueta = estetq.id_etiqueta left join tetuanjobs.estudiantes est
     on estetq.id_estudiante = est.id_estudiante left join tetuanjobs.usuarios usu on est.id_usuario = usu.id_usuario 
      order by etq.id_etiqueta;

GRANT select on tetuanjobs.listarSkills To 'usertetuan'@'localhost';

/** fin vista listar skills **/

/** fin Perfil estudiante **/

/* BUSQUEDA ESTUDIANTE */

/* VISTA ETIQUETAS Y COMPROBAR SI SE HA APLICADO AL PUESTO*/

CREATE OR REPLACE VIEW tetuanjobs.listarPstEtqEst as 
  select  pst.id_puesto as identificador, nombre_etiqueta, est.nombre as estudiante, pstest.id_estudiante as idestudiante,
  id_usuario as idusuario   
     from tetuanjobs.puestos pst 
     left join tetuanjobs.puestos_etiquetas pstetq on pst.id_puesto = pstetq.id_puesto
     left join tetuanjobs.etiquetas etq on pstetq.id_etiqueta = etq.id_etiqueta
     left join tetuanjobs.puestos_estudiantes pstest on pstest.id_puesto = pst.id_puesto
     left join tetuanjobs.estudiantes est on est.id_estudiante = pstest.id_estudiante;
GRANT select on tetuanjobs.listarPstEtqEst To 'usertetuan'@'localhost';

/* FIN VISTA ETIQUETAS Y COMPROBAR SI SE HA APLICADO AL PUESTO*/

/* FIN BUSQUEDA ESTUDIANTE */


/** filtro puestos **/

/** VISTA LISTAR puesto  **/

CREATE OR REPLACE VIEW tetuanjobs.listarPuestos as 
  select  puesto_nombre as nombre, pst.id_puesto as identificador, nombre_empresa as empresa, nombre_provincia as provincia, 
      puesto_desc as descripcion, f_publicacion as publicacion, emp.id_empresa as idempresa,emp.id_usuario as idusuario, prv.id_provincia as idprovincia, 
      puesto_carnet as carnet, emp.email, persona_contacto as contacto,tipo_contrato as contrato, 
      cast(tipo_contrato as unsigned) idcontrato, experiencia, cast(experiencia as unsigned) idexperiencia, 
      jornada, cast(jornada as unsigned) idjornada, count(pstest.id_estudiante) as interesados/*,
      nombre_etiqueta , est.nombre as estudiante, pstest.id_estudiante as idestudiante */  
     from tetuanjobs.puestos pst join tetuanjobs.empresas emp on pst.id_empresa = emp.id_empresa
     left join tetuanjobs.provincias prv on prv.id_provincia = pst.id_provincia
     join tetuanjobs.usuarios usr on emp.id_usuario = usr.id_usuario
     /*left join tetuanjobs.puestos_etiquetas pstetq on pst.id_puesto = pstetq.id_puesto
     left join etiquetas etq on pstetq.id_etiqueta = etq.id_etiqueta;*/
     left join tetuanjobs.puestos_estudiantes pstest on pstest.id_puesto = pst.id_puesto
     where activo = 1
     group by pst.id_puesto;
     /*left join tetuanjobs.estudiantes est on est.id_estudiante = pstest.id_estudiante;*/
GRANT select on tetuanjobs.listarPuestos To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR puesto **/



/** fin filtro puestos **/

/** ficha puestos **/

/*CREATE OR REPLACE VIEW tetuanjobs.listarPuestoId as 
  select puesto_nombre as nombre, id_puesto as identificador, emp.id_empresa as id_emp,  nombre_empresa as empresa, 
  pst.id_provincia as idprov, nombre_provincia as provincia, puesto_desc as descripcion,puesto_carnet, experiencia, 
  tipo_contrato, jornada, titulacion_minima 
  from tetuanjobs.puestos pst join empresas emp on pst.id_empresa = emp.id_empresa
             join provincias prv on prv.id_provincia = pst.id_provincia;

GRANT select on tetuanjobs.listarPuestoId To 'usertetuan'@'localhost';*/

/** vista listar skills puesto **/

CREATE OR REPLACE VIEW tetuanjobs.listarSkillsPuesto as 
     select etq.id_etiqueta as identificador, nombre_etiqueta as nombre, pst.id_puesto puesto 
     from tetuanjobs.etiquetas etq left join tetuanjobs.puestos_etiquetas pstetq on etq.id_etiqueta = pstetq.id_etiqueta
     left join tetuanjobs.puestos pst on pstetq.id_puesto = pst.id_puesto
      order by etq.id_etiqueta;

GRANT select on tetuanjobs.listarSkillsPuesto To 'usertetuan'@'localhost';

/** fin vista listar skills puesto **/

/** vista listar idiomas puesto **/

CREATE OR REPLACE VIEW tetuanjobs.listarIdiomasPuesto as 
     select idm.id_idioma as identificador, nombre_idioma as nombre, pst.id_puesto puesto 
     from tetuanjobs.idiomas idm left join tetuanjobs.puestos_idiomas pstidm on idm.id_idioma = pstidm.id_idioma
     left join tetuanjobs.puestos pst on pstidm.id_puesto = pst.id_puesto
      order by idm.id_idioma;

GRANT select on tetuanjobs.listarIdiomasPuesto To 'usertetuan'@'localhost';

/** fin vista listar idiomas puesto **/

/** fin ficha puestos **/

/* listar interesador */
CREATE OR REPLACE VIEW tetuanjobs.listarInteresados as 
  select idestudiante, nombre, lus.email, lus.telefono, identificador, provincia, foto, ciclo, cv, f_seleccion,
  puesto_nombre as nombrepuesto, idprovincia, pst.id_puesto as idpuesto, emp.id_usuario as idempusuario,
  formacion_clasificacion as titulacion,  cast(formacion_clasificacion as unsigned) as idtitulacion
   from tetuanjobs.puestos_estudiantes pstest join tetuanjobs.listarUsuarios lus
  on pstest.id_estudiante = lus.idestudiante
  join tetuanjobs.puestos pst on pstest.id_puesto = pst.id_puesto
  join tetuanjobs.empresas emp on pst.id_empresa = emp.id_empresa
  left join tetuanjobs.formacion form on form.id_estudiante = lus.idestudiante;

GRANT select on tetuanjobs.listarInteresados To 'usertetuan'@'localhost';

/* fin listar interesador */







