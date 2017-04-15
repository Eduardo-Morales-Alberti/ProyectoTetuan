/** Datatable **/

function cargarTabla(idtabla){
  return $(idtabla).DataTable( {   
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
}

/** Fin datatable **/

/** Poner 0 a la izquierda **/

function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}

/** Fin Poner 0 a la izquierda **/

/** Modal mensaje **/

function mensajeModal(mensaje){
  $(document).ready(function(){
    $("#mensajeserv").html(mensaje);
    $("#modalmensaje").modal("show");
    var a = window.setTimeout(function(){
      $("#modalmensaje").modal("hide");
    },4000);
  });

}

/** Fin Modal mensaje **/

/* Validar email */

function validarEmail(email) {
  var re = /^[A-Z0-9._-]+@[A-Z0-9.-]+\.[A-Z0-9.-]+$/i;
  return re.test(email);
}
/* Validar email */

/* validar texto */
function validarTexto(texto){
  var re = /^[\w]+$/i;
  return re.test(texto);
}

/* fin validar texto */

/* validar texto espacios*/
function validarTextoEspacios(texto){
  var re = /^[\w áéíóúÁÉÍÓÚ]+$/i;
  return re.test(texto);
}

/* fin validar texto espacios*/

/* validar nombres propios */

function validarNombres(nombre){
  var re = /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/;
  return re.test(nombre);
}
/* fin validar nombres propios */

/* validar web */
function validarWeb(web){
  var re = /^((http\:\/\/)|(https\:\/\/))?([wW]{3})?[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}$/i;
  return re.test(web);
}

/* fin validar web */

/* validar teléfono */

function validarTelefono(telefono){
  var re = /^\d{9}$/i;
  return re.test(telefono);
}

/* fin validar teléfono */




/** crear id **/
function crearId(cadena){
  // Quito los espacios extras y lo dejo a uno
  cadena = cadena.trim();
  cadena = cadena.replace(/\s+/gi,' ');
   // Definimos los caracteres que queremos eliminar
   //var specialChars = "\'\"!@#$^&%*()+=-[]\/{}|:<>?,.";


   // Los eliminamos todos
   /*for (var i = 0; i < specialChars.length; i++) {
     cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
   }   */
   

   // Lo queremos devolver limpio en minusculas
   cadena = cadena.toLowerCase();

   // Quitamos espacios y los sustituimos por _ porque nos gusta mas asi
   cadena = cadena.replace(/ /g,"_");

   // Quitamos acentos y "ñ". Fijate en que va sin comillas el primer parametro
   cadena = cadena.replace(/á/gi,"a");
   cadena = cadena.replace(/é/gi,"e");
   cadena = cadena.replace(/í/gi,"i");
   cadena = cadena.replace(/ó/gi,"o");
   cadena = cadena.replace(/ú/gi,"u");
   cadena = cadena.replace(/ñ/gi,"n");
   cadena = cadena.replace(/\W/g,'');
   return cadena.substring(0,5);
 }
 /** fin crear id**/

 /** limpiar cadena **/
 function limpiarCadena(cadena){
  // Quitamos caracteres raros
  var specialChars = "\'\"¿¡!@#$^&%*()+=-[]\/{}|:<>?,.";


   // Los eliminamos todos
   for (var i = 0; i < specialChars.length; i++) {
     cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
   }   
  // Quito los espacios extras y lo dejo a uno

  cadena = cadena.trim();
  cadena = cadena.replace(/\s+/gi,' ');

   // Lo queremos devolver limpio en minusculas
   //cadena = cadena.substring(0,1).toUpperCase()+cadena.substring(1,cadena.length).toLowerCase();
   
   return cadena;
 }
 /** fin limpiar cadena**/

 /** Next sibling **/
 function siguienteHermano(x){
  if(x.nextElementSibling){
    var e = x.nextElementSibling;
    while(e.nodeName == "#text"){
      e = e.nextElementSibling;
    };
    return e;
  }

}
/** Fin Next sibling **/
function anteriorHermano(x){
  if(x.previousElementSibling){
    var e = x.previousElementSibling;
    while(e.nodeName == "#text"){
      e = e.previousElementSibling;
    };
    return e;
  }

}
/** Previous sibling **/



/** Fin Previous sibling **/

/** Agregar tag **/


var elementosreq = new Array();
var n = 0;

/** Agregar skills para borrarlas **/
function agregarEtiquetas(etq,elementos){ 
  for (var i = 0; i < etq.length; i++) {
    var elment = etq[i].nombre.trim();
    //var id = elment;

    var id = crearId(elment).substring(0,5)+n;
    n++;

    elementos[id] = elment; 
    
  }
}


function agregarTag(selctid,divid,elementos,col,name){
  /** Obtengo el select con las etiquetas**/
  var x = document.getElementById(selctid);
  //x.value = getCleanedString(x.value);
  var id = crearId(x.value).substring(0,5)+n;
  n++;
  /** Compruebo que la etiqueta no existe **/
  var existe = false;
  var etiqueta = limpiarCadena(x.value);
  for (v in elementos) {
    if(elementos[v].trim() == etiqueta){
      existe = true;
    }
  };

  //var existe = elementos.indexOf(x.value.trim());

  

  /** Compruebo que el option seleccionado es correcto**/
  if(x.value != "nada"  && x.value.length >2 && !existe){
    /** Obtengo el div donde voy a agregar la etiqueta**/
    var ele = document.getElementById(divid);
    /** Creo un div **/
    var divele = document.createElement("div");
    divele.setAttribute("class",col+" form-group");
    /** El id del div va a ser el de la etiqueta mas elemento**/
    divele.setAttribute("id",id+"elemento");
    var html = '<div class="input-group">'+
    '<span class="input-group-addon">'+
    '<input type="checkbox" id="check'+id+'"  value="'+id+'">'+
    '</span>'+
    '<input type="text" id="input'+id+'" name="'+name+'[]" class="form-control" value="'+etiqueta+'" readonly>'+
    '</div>';
    divele.innerHTML = html;
    /** Agrego a elementos los id de los checkbox que he ido añadiendo al div**/

    //elementos.push(x.value);
    elementos[id] = x.value.trim();
    /** Agrego al div seleccionado, el div que acabo de crear**/
    ele.appendChild(divele);
    /** Elimino el option que acabo agregar a las etiquetas**/
    if(x.type == "select-one"){
      x.remove(x.selectedIndex);
    }else if(x.nodeName == "INPUT"){
     /** Si es un input lo dejo vacío**/ 
     x.value = "";
   }

 }else{
  mensajeModal("No se ha podido añadir la etiqueta");
  if(x.nodeName == "INPUT"){
   /** Si es un input lo dejo vacío**/ 
   x.value = "";
 }
}
/** Retorno el array de elementos **/
return elementos;
}

/** Fin agregar tag**/

/** Eliminar tag **/
function eliminarTag(selctid,divid,elementos){
  /** Obtengo el select con las etiquetas**/
  var x = document.getElementById(selctid); 
  /** Obtengo el div donde voy a eliminar la etiqueta**/
  var ele = document.getElementById(divid);
  /** Recorro elementos con los check que he agregado anteriormente**/
  
  //var longi = elementos.length;
  for (v in elementos) {
    /** Obtengo los elemento checkbox a partir de su id**/

    var checkel = document.getElementById("check"+v);
    //console.log("check"+v+"|"+checkel);
    /** Si el checkbox está seleccionado**/
    if(checkel.checked){
      /**A partir del value del checkbox obtengo el div que lo contiene**/
      var divelim = document.getElementById(checkel.value+"elemento");

      if(x.type = "select-one"){
        /** Creo un option**/
        var opt = document.createElement("option");
        /** Le pongo el valor del input eliminado**/
        var text = document.getElementById("input"+checkel.value).value;
        opt.value = text;        
        opt.innerHTML = text;
        /** Agrego el option a mi select **/
        x.appendChild(opt);
      }  
      /** Elimino el div de la etiqueta**/
      ele.removeChild(divelim);
      /** Elimino el elemento del array **/
      /*elementos.splice(i,1);  
      i = i-1;*/
      delete elementos[v];
    }  

    
  };
  return elementos;
}
/** Fin tag **/

/**Login**/
function login(){
  /* Validaciones */

  /* Validacion del login */

  $("#acceder").on("click",function(){
    var mensaje = "";
    var valido = true;
    if(!validarEmail($("#mail").val())){
      mensaje += "El email no es válido.<br>";
      valido = false;
    }
    if(!validarTexto($("#contrlog").val())){
      mensaje += "La contraseña no está bien escrita.<br>";
      valido = false;
    }


    if(!valido){
      mensajeModal(mensaje);
    }

    return valido;

  });

  /* Validacion del login */

  /* Validación de enviar email */

  $("#recordar").on("click",function(){
    var mensaje = "";
    var valido = true;
    if(!validarEmail($("#recontr").val())){
      mensaje += "El email no es válido.<br>";
      valido = false;
    }

    if(!valido){
      mensajeModal(mensaje);
    }

    return valido;

  });



  /* Fin validación de enviar email */

  /* validación registrarse */
  $("#registrar").on("click",function(){
    var mensaje = "";
    var valido = true;
    if(!validarEmail($("#resemail").val())){
      mensaje += "El email no es válido.<br>";
      valido = false;
    }

    if(!validarNombres($("#nombre").val())){
      mensaje += "Escriba correctamente su nombre.<br>";
      valido = false;
    }

    if(!validarNombres($("#apellidos").val())){
      mensaje += "Escriba correctamente sus apellidos.<br>";
      valido = false;
    }

    if(!validarTextoEspacios($("#empresa").val()) && $('.elEmp').is(":visible")){
      mensaje += "Escriba correctamente su empresa sin caracteres especiales.<br>";
      valido = false;
    }

    if(!validarTexto($("#contres").val())||!validarTexto($("#contres2").val())){
      mensaje += "La contraseña no está bien escrita.<br>";
      valido = false;
    }else if($("#contres").val()!=$("#contres2").val()){
      mensaje += "Las contraseñas no coinciden.<br>";
      valido = false;
    }

    if(!validarWeb($("#webempresa").val())&& $('.elEmp').is(":visible")){
      mensaje += "Escriba correctamente la web de su empresa.<br>";
      valido = false;
    }



    if(!valido){
      mensajeModal(mensaje);
    }

    return valido;

  });

/* fin validación registrarse */

/* Fin validaciones */

$(document).ready(function(){
  setTimeout(function() { $("#mail").focus() }, 500);

});

$("#tipo").change( function(){

  if($(this).val() == "empresa"){
    $(".elEmp").show();
    $(".inputEmp").attr("required","required");
    $(".elEst").hide();
    $(".inputEst").removeAttr("required");
  }else{
    $(".elEst").show();
    $(".inputEst").attr("required","required");
    $(".elEmp").hide();
    $(".inputEmp").removeAttr("required");
  }

});
}

/**Fin Login**/

/* Restablecer contraseña*/

function restablecer(){
  /* validar formulario */
  $("#restcontr").on("click",function(){
    var mensaje = "";
    var valido = true;

    if(!validarTexto($("#ncontr").val())||!validarTexto($("#ccontr").val())){
      mensaje += "La contraseña no está bien escrita.<br>";
      valido = false;
    }else if($("#ncontr").val()!=$("#ccontr").val()){
      mensaje += "Las contraseñas no coinciden.<br>";
      valido = false;
    }

    



    if(!valido){
      mensajeModal(mensaje);
    }

    return valido;

  });

  /* fin validar formulario */
}

/* fin restablecer contraseña*/


/**Perfil Estudiante **/



function perfilEstudiante(){
  /** Opcion fechas actualmente **/

  var selact = document.getElementsByClassName("selact");
  for (var i = 0; i < selact.length; i++) {
    selact[i].addEventListener("change", function(x){
      if(x.target.value == 0){
        siguienteHermano(x.target).style.display = "none";
      }else{
        siguienteHermano(x.target).style.display = "inline";
      }
    });
  };

  /** Fin Opcion fechas actualmente **/

  /* validar formulario contraseña */

  $("#modcontr").on("click",function(){
    var mensaje = "";
    var valido = true;

    if(!validarTexto($("#contr").val())){
      mensaje += "La contraseña no está bien escrita.<br>";
      valido = false;
    }
    
    if(!validarTexto($("#ncontr").val())||!validarTexto($("#ccontr").val())){
      mensaje += "La contraseña no está bien escrita.<br>";
      valido = false;
    }else if($("#ncontr").val()!=$("#ccontr").val()){
      mensaje += "Las contraseñas no coinciden.<br>";
      valido = false;
    }

    



    if(!valido){
      mensajeModal(mensaje);
    }

    return valido;

  });

  /* fin validar formulario contraseña */

  /** Agregar etiquetas **/


  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3",'etiquetas')
  });

  var btnet2 = document.getElementById("ageet");
  btnet2.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetasinput", "divetiquetas",elementosreq,"col-md-4 col-lg-3",'etiquetas')
  });

  var btnelimex = document.getElementById("eliminarskills");
  btnelimex.addEventListener("click", function(){
    elementosreq = eliminarTag("etiquetas", "divetiquetas",elementosreq)
  });

  /** Fin agregar etiquetas **/

  /** Modificar valores experiencia, educación e idiomas**/
  var spns = document.getElementsByClassName("spn");
  var npts = document.getElementsByClassName("npt");
  for (var i = 0; i < spns.length; i++) {
    spns[i].addEventListener("click",function(x){
      /*if(x.target.nextElementSibling.nodeName == "INPUT"
        || x.target.nextElementSibling.nodeName == "TEXTAREA"){*/
      siguienteHermano(x.target).value = x.target.innerHTML;
      /*}*/        
      siguienteHermano(x.target).style.display = "initial";
      siguienteHermano(x.target).focus();
      siguienteHermano(x.target).addEventListener("focusout", function(y){
        anteriorHermano(y.target).innerHTML = y.target.value;
        anteriorHermano(y.target).style.display = "initial";
        y.target.style.display = "none";
      });
      x.target.style.display = "none";

    });
  };

  /** Fin Modificar valores experiencia, educación e idiomas**/

  /** Modificar actualmente **/
  var divactual = document.getElementsByClassName("mod1");

  for (var i = 0; i < divactual.length; i++) {
    divactual[i].addEventListener("click", function(x){      
      var mes = x.target.firstChild.innerHTML;
      var anio =  x.target.lastChild.innerHTML;
      x.target.style.display = "none";
      var mod2 = siguienteHermano(x.target);
      mod2.style.display = "initial";
      mod2.firstChild.value = mes;
      mod2.lastChild.value = anio;
      mod2.addEventListener("focusout", function(y){
        siguienteHermano(x.target).style.display = "none";
        var html = "<span class='oculto'>"+mod2.firstChild.value+"</span>"+mod2.firstChild.value+", "+mod2.lastChild.value+"<span class='oculto'>"+mod2.lastChild.value+"</span>";
        x.target.innerHTML = html;
        x.target.style.display = "initial";
      });
    });
  };
  /** fin Modificar actualmente**/

  /** Ayuda código postal **/

  $("#provincias").change(function(){
    $("#cpostal").val(pad($(this).val(),2));
  });

  /** Fin Ayuda código postal **/

  /** Función eliminar cuenta **/

  $("#eliminarcuenta").click(function(event){
    var eliminar = confirm("¿Seguro que desea eliminar la cuenta?");
    if(!eliminar){
      event.preventDefault();
    }
  });

  /** Fin Función eliminar cuenta **/

  /** función mostrar foto **/

  $("#mostrarf").click(function(){   
    var html = "<p><b>Imagen del perfil</b></p><img src='./subidas/"+$("#dirfotop").val()+"' alt='foto del perfil'/>";
    mensajeModal(html);

  });

  /** fin función mostrar foto**/

  /** función mostrar cv **/

  $("#mostrarcv").click(function(){   
    //var html = "<p><b>Curriculum Vitae</b></p><embed src='./subidas/"+$("#dircv").val()+"#toolbar=0' />";
    var url = "./subidas/"+$("#dircv").val();
    var win = window.open(url, '_blank');
    win.focus();

  });

  /** fin función mostrar cv**/

}



/** Modificar modal **/

function modificarModal(){
  $(document).ready(function(){
    $("#modificarmodal").modal("show");  
  });

}

/** Modificar modal**/


/**Fin Perfil **/

/** Búsqueda de ofertas **/
function busquedaofer(){
  /** Opcion requisitos **/
  //var elementosreq = new Array();

  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3",'etiquetas')
  });

  var btnelimex = document.getElementById("elimrequisito");
  btnelimex.addEventListener("click", function(){
    elementosreq = eliminarTag("etiquetas", "divetiquetas",elementosreq)
  });
  /** Fin Opcion requisitos **/

  /* Eliminar elementos repetidos del select de etiquetas*/
  
  for (v in elementosreq ) {     
    $("#etiquetas option[value='"+elementosreq[v]+"']").remove();
  };  

  /* fin Eliminar elementos repetidos del select de etiquetas*/


  /* Aplicar a un puesto */
  $(".aplicarform").each(function(){
    /*console.log($(this));*/
    $(this).submit(function() {
      event.preventDefault();
      var input = $(this).children("input[name='aplicar']");
      input.prop( "disabled", true );
      
      var xhr = $.post( "ajax.php", 
        { aplicar: $(this).children("input[name='aplicar']").eq(0).val(), 
        idpuesto:  $(this).children("input[name='idpuesto']").eq(0).val(),
        token:  $(this).children("input[name='token']").eq(0).val()} );

      xhr.done(function( data ) {
        //alert(data);
        if(data == "correcto"){
          input.prop( "value", "Se ha aplicado correctamente" );
          mensajeModal("Ha seleccionado el puesto correctamente");
        }else{
          input.removeAttr( "disabled");
          /*mensajeModal("No ha podido aplicar al puesto");*/
          mensajeModal(data);
        }

      }).fail(function() {
        input.removeAttr("disabled");
        mensajeModal("Error: No ha podido aplicar al puesto");
      });

      
    });

  }); 



  /* Fin Aplicar a un puesto */

}



/**Fin Búsqueda de ofertas **/
/**Filtro de usuarios**/

function filtrous(){
  var table = cargarTabla('#resultado');

  /* Agregar una etiqueta */
  $("#agreet").click(function(){
    $(this).prop( "disabled", true );
    var etiqueta = $("#inputetiq").val();
    var valtoken = $("#tokenetq").val();
    $("#inputetiq").val("");

    var xhr = $.post( "ajax.php", 
      { agreet: "agregar", 
      inputetiq:  etiqueta,
      token: valtoken } );

    xhr.done(function( data ) {
        //alert(data);
        $("#agreet").removeAttr("disabled");
        //console.log(data);
        var obj = JSON.parse(data);
        //console.log(obj);
        mensajeModal(obj.mensaje);

        if(obj.resultado){

          $("#divetiquetas").append(
            '<div class="col-md-4 col-lg-3 form-group" ><div class="input-group"><span class="input-group-addon">'
            +'<input type="checkbox" name="etiquetasel[]" value="'+etiqueta+'">'
            +'</span><input type="text" class="form-control" value="'+etiqueta+'" readonly></div></div>'
            );
        }


      }).fail(function() {
        $("#inputetiq").removeAttr("disabled");
        mensajeModal("Error: No ha podido agregar la etiqueta "+etiqueta);
      });

    });

/* fin Agregar una etiqueta */

/* Agregar un idioma */
$("#agreidm").click(function(){
  $(this).prop( "disabled", true );
  var idioma = $("#inputidm").val();
  var valtoken = $("#tokenidm").val();
  $("#inputidm").val("");

  var xhr = $.post( "ajax.php", 
    { agreidm: "agregar", 
    inputidm:  idioma,
    token:valtoken } );

  xhr.done(function( data ) {
        //alert(data);
        $("#agreidm").removeAttr("disabled");
        //console.log(data);
        var obj = JSON.parse(data);
        //console.log(obj);
        mensajeModal(obj.mensaje);

        if(obj.resultado){

          $("#dividiomas").append(
            '<div class="col-md-4 col-lg-3 form-group" ><div class="input-group"><span class="input-group-addon">'
            +'<input type="checkbox" name="idiomasel[]" value="'+idioma+'">'
            +'</span><input type="text" class="form-control" value="'+idioma+'" readonly></div></div>'
            );
        }


      }).fail(function() {
        $("#inputetiq").removeAttr("disabled");
        mensajeModal("Error: No ha podido agregar el idioma "+idioma);
      });

    });

/* fin Agregar un idioma */
}

/**Filtro de usuarios**/

/* etiquetas idiomas */

function etiquetasIdiomas(){
  
  /* Agregar una etiqueta */
  $("#agreet").click(function(){
    $(this).prop( "disabled", true );
    var etiqueta = $("#inputetiq").val();
    var valtoken = $("#tokenetq").val();
    $("#inputetiq").val("");

    var xhr = $.post( "ajax.php", 
      { agreet: "agregar", 
      inputetiq:  etiqueta,
      token: valtoken } );

    xhr.done(function( data ) {
        //alert(data);
        $("#agreet").removeAttr("disabled");
        //console.log(data);
        var obj = JSON.parse(data);
        //console.log(obj);
        mensajeModal(obj.mensaje);

        if(obj.resultado){

          $("#divetiquetas").append(
            '<div class="col-md-4 col-lg-3 form-group" ><div class="input-group"><span class="input-group-addon">'
            +'<input type="checkbox" name="etiquetasel[]" value="'+etiqueta+'">'
            +'</span><input type="text" class="form-control" value="'+etiqueta+'" readonly></div></div>'
            );
        }


      }).fail(function() {
        $("#inputetiq").removeAttr("disabled");
        mensajeModal("Error: No ha podido agregar la etiqueta "+etiqueta);
      });

    });

/* fin Agregar una etiqueta */

/* Agregar un idioma */
$("#agreidm").click(function(){
  $(this).prop( "disabled", true );
  var idioma = $("#inputidm").val();
  var valtoken = $("#tokenidm").val();
  $("#inputidm").val("");

  var xhr = $.post( "ajax.php", 
    { agreidm: "agregar", 
    inputidm:  idioma,
    token:valtoken } );

  xhr.done(function( data ) {
        //alert(data);
        $("#agreidm").removeAttr("disabled");
        //console.log(data);
        var obj = JSON.parse(data);
        //console.log(obj);
        mensajeModal(obj.mensaje);

        if(obj.resultado){

          $("#dividiomas").append(
            '<div class="col-md-4 col-lg-3 form-group" ><div class="input-group"><span class="input-group-addon">'
            +'<input type="checkbox" name="idiomasel[]" value="'+idioma+'">'
            +'</span><input type="text" class="form-control" value="'+idioma+'" readonly></div></div>'
            );
        }


      }).fail(function() {
        $("#inputetiq").removeAttr("disabled");
        mensajeModal("Error: No ha podido agregar el idioma "+idioma);
      });

    });

/* fin Agregar un idioma */
}
/* fin etiquetas e idiomas*/

/* perfil empresa */

function perfilempresa(){
  /** Función eliminar cuenta **/

  $("#eliminarcuenta").click(function(event){
    var eliminar = confirm("¿Seguro que desea eliminar la cuenta?");
    if(!eliminar){
      event.preventDefault();
    }
  });

  /** Fin Función eliminar cuenta **/

  /* Validación de formulario */

  $("#guardar").on("click",function(){
    var mensaje = "";
    var valido = true;

    if(!validarTextoEspacios($("#nombre").val())){
      mensaje += "Escriba correctamente su empresa sin caracteres especiales.<br>";
      valido = false;
    }


    if(!validarEmail($("#mail").val())){
      mensaje += "El email no es válido.<br>";
      valido = false;
    }

    if(!validarTelefono($("#telefono").val())){
      mensaje += "El teléfono no es válido.<br>";
      valido = false;
    }

    if(!validarNombres($("#nombre").val())){
      mensaje += "Escriba correctamente su nombre.<br>";
      valido = false;
    }

    if(!validarWeb($("#web").val())){
      mensaje += "Escriba correctamente la web de su empresa.<br>";
      valido = false;
    }

    if(!valido){
      mensajeModal(mensaje);
    }

    return valido;

  });

  $("#modcontr").on("click",function(){
    var mensaje = "";
    var valido = true;


    if(!validarTexto($("#contr").val())||!validarTexto($("#ncontr").val())||!validarTexto($("#ccontr").val())){
      mensaje += "La contraseña no está bien escrita.<br>";
      valido = false;
    }else if($("#ncontr").val()!=$("#ccontr").val()){
      mensaje += "Las contraseñas no coinciden.<br>";
      valido = false;
    }

    if(!valido){
      mensajeModal(mensaje);
    }

    return valido;

  });

  

  /* fin validación de formulario */
}

/* fin perfil empresa */

/** Filtro Puestos**/
function filtropuestos(){
  /** Opcion requisitos **/
  /*var elementosreq = new Array();

  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3",'etiquetas')
  });

  var btnelimex = document.getElementById("elimrequisito");
  btnelimex.addEventListener("click", function(){
    elementosreq = eliminarTag("etiquetas", "divetiquetas",elementosreq)
  });*/
/** Fin Opcion requisitos **/
/* Cargar tabla*/
var table = cargarTabla('#respuestos');
}

/** Fin Filtro Puestos**/

/** Ficha Puestos **/

var elementosidm = new Array();
var elementosfunc = new Array();
function fichapuestos(){

  /* validar formularios */
  $("#guardarpuesto").on("click",function(){
    var mensaje = "";
    var valido = true;


    if(!validarTextoEspacios($("#titpuesto").val())){
      mensaje += "El título del puesto no está bien escrito.<br>";
      valido = false;
    }

    

    if(!valido){
      mensajeModal(mensaje);
    }

    return valido;

  });


  /* fin validar formularios */

  /** Opcion requisitos **/
  //elementosreq = new Array();

  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3","etiquetas");
    //console.log(ele);
  });

  var btnet2 = document.getElementById("ageet");
  btnet2.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetasinput", "divetiquetas",elementosreq,"col-md-4 col-lg-3",'etiquetas')
  });

  var btnelimex = document.getElementById("elimrequisito");
  btnelimex.addEventListener("click", function(){
    elementosreq = eliminarTag("etiquetas", "divetiquetas",elementosreq)
  });
  /** Fin Opcion requisitos **/
  /** Opción idiomas **/
  //var elementosidm = new Array();

  var btnaidm = document.getElementById("ageidi");
  btnaidm.addEventListener("click", function(){
    elementosidm = agregarTag("idiomas", "dividiomas",elementosidm,"col-md-4 col-lg-3","idiomas")
  });

  var btnelimidm = document.getElementById("elimidi");
  btnelimidm.addEventListener("click", function(){
    elementosidm = eliminarTag("idiomas", "dividiomas",elementosidm)
  });
  /** Fin Opción idiomas **/
  /** Opción funciones **/
  //var elementosfunc = new Array();

  var btnfunc = document.getElementById("afuncion");
  btnfunc.addEventListener("click", function(){
    elementosfunc = agregarTag("funciones", "divfunciones",elementosfunc,"col-md-6","funciones")
  });

  var btnelimfunc = document.getElementById("elimfunc");
  btnelimfunc.addEventListener("click", function(){
    elementosfunc = eliminarTag("funciones", "divfunciones",elementosfunc)
  });
  /** Fin opción funciones**/

  
}


/** Fin Ficha Puestos**/

/**Filtro de empresas**/

function filtroem(){
  var table = cargarTabla('#resempresas');
}

/**Fin filtro de empresas**/

/** Ficha Empresa**/
function fichaem(){

}
/** Fin Ficha Empresa**/

/* interesados */
function interesados(){
  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3","etiquetas");
    //console.log(ele);
  });
  var btnelimex = document.getElementById("elimrequisito");
  btnelimex.addEventListener("click", function(){
    elementosreq = eliminarTag("etiquetas", "divetiquetas",elementosreq)
  });

  /* Eliminar elementos repetidos del select de etiquetas*/
  /*console.log(elementosreq);*/
  for (v in elementosreq ) {     
    $("#etiquetas option[value='"+elementosreq[v]+"']").remove();
  };  

  /* fin Eliminar elementos repetidos del select de etiquetas*/

}

/* fin interesados */

