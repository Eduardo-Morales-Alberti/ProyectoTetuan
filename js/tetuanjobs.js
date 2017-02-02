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

/** limpiar cadena **/
function getCleanedString(cadena){
   // Definimos los caracteres que queremos eliminar
   var specialChars = "\'\"!@#$^&%*()+=-[]\/{}|:<>?,.";

   // Los eliminamos todos
   for (var i = 0; i < specialChars.length; i++) {
     cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
   }   

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

function agregarTag(selctid,divid,elementos,col){
  /** Obtengo el select con las etiquetas**/
  var x = document.getElementById(selctid);
  x.value = getCleanedString(x.value);
  /** Compruebo que el option seleccionado es correcto**/
  if(x.value != "nada"  && x.value.length >2){
    /** Obtengo el div donde voy a agregar la etiqueta**/
    var ele = document.getElementById(divid);
    /** Creo un div **/
    var divele = document.createElement("div");
    divele.setAttribute("class",col+" form-group");
    /** El id del div va a ser el de la etiqueta mas elemento**/
    divele.setAttribute("id",x.value+"elemento");
    var html = '<div class="input-group">'+
    '<span class="input-group-addon">'+
    '<input type="checkbox" id="check'+x.value+'" name="'+x.value+'" value="'+x.value+'">'+
    '</span>'+
    '<input type="text" name="etiquetas[]" class="form-control" value="'+x.value+'" disabled="disabled">'+
    '</div>';
    divele.innerHTML = html;
    /** Agrego a elementos los id de los checkbox que he ido añadiendo al div**/
    elementos.push("check"+x.value);
    /** Agrego al div seleccionado, el div que acabo de crear**/
    ele.appendChild(divele);
    /** Elimino el option que acabo agregar a las etiquetas**/
    if(x.type == "select-one"){
      x.remove(x.selectedIndex);
    }else if(x.nodeName == "INPUT"){
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
  for (var i = 0; i < elementos.length; i++) {
    /** Obtengo los elemento checkbox a partir de su id**/
    var checkel = document.getElementById(elementos[i]);
    /** Si el checkbox está seleccionado**/
    if(checkel.checked){
      /**A partir del value del checkbox obtengo el div que lo contiene**/
      var divelim = document.getElementById(checkel.value+"elemento");

      if(x.type = "select-one"){
        /** Creo un option**/
        var opt = document.createElement("option");
        /** Le pongo el valor del checkbox eliminado**/
        opt.value = checkel.value;        
        opt.innerHTML = checkel.value;
        /** Agrego el option a mi select **/
        x.appendChild(opt);
      }  
      /** Elimino el div de la etiqueta**/
      ele.removeChild(divelim);
      /** Elimino el elemento del array **/
      elementos.splice(i,1);  
      i = i-1;
    }  

    
  };
  return elementos;
}
/** Fin tag **/

/**Login**/
function login(){

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
/**Perfil**/

function perfil(){
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

  /** Agregar etiquetas **/
  var elementosreq = new Array();

  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3")
  });

  var btnet2 = document.getElementById("ageet");
  btnet2.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetasinput", "divetiquetas",elementosreq,"col-md-4 col-lg-3")
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
  var elementosreq = new Array();

  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3")
  });

  var btnelimex = document.getElementById("elimrequisito");
  btnelimex.addEventListener("click", function(){
    elementosreq = eliminarTag("etiquetas", "divetiquetas",elementosreq)
  });
  /** Fin Opcion requisitos **/

}

/**Fin Búsqueda de ofertas **/
/**Filtro de usuarios**/

function filtrous(){
  var table = cargarTabla('#resultado');
}

/**Filtro de usuarios**/

/** Filtro Puestos**/
function filtropuestos(){
  /** Opcion requisitos **/
  var elementosreq = new Array();

  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3")
  });

  var btnelimex = document.getElementById("elimrequisito");
  btnelimex.addEventListener("click", function(){
    elementosreq = eliminarTag("etiquetas", "divetiquetas",elementosreq)
  });
  /** Fin Opcion requisitos **/
}

/** Fin Filtro Puestos**/

/** Ficha Puestos **/
function fichapuestos(){

  /** Opcion requisitos **/
  var elementosreq = new Array();

  var btnex = document.getElementById("ageex");
  btnex.addEventListener("click", function(){
    elementosreq = agregarTag("etiquetas", "divetiquetas",elementosreq,"col-md-4 col-lg-3")
  });

  var btnelimex = document.getElementById("elimrequisito");
  btnelimex.addEventListener("click", function(){
    elementosreq = eliminarTag("etiquetas", "divetiquetas",elementosreq)
  });
  /** Fin Opcion requisitos **/
  /** Opción idiomas **/
  var elementosidm = new Array();

  var btnaidm = document.getElementById("ageidi");
  btnaidm.addEventListener("click", function(){
    elementosidm = agregarTag("idiomas", "dividiomas",elementosidm,"col-md-4 col-lg-3")
  });

  var btnelimidm = document.getElementById("elimidi");
  btnelimidm.addEventListener("click", function(){
    elementosidm = eliminarTag("idiomas", "dividiomas",elementosidm)
  });
  /** Fin Opción idiomas **/
  /** Opción funciones **/
  var elementosfunc = new Array();

  var btnfunc = document.getElementById("afuncion");
  btnfunc.addEventListener("click", function(){
    elementosfunc = agregarTag("funciones", "divfunciones",elementosfunc,"col-md-6")
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