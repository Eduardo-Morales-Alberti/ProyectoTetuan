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

/** Agregar tag **/

function agregarTag(selctid,divid,elementos,col){
  /** Obtengo el select con las etiquetas**/
  var x = document.getElementById(selctid);

  /** Compruebo que el opction seleccionado es correcto**/
  if(x.value != "nada"){
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
    '<input type="text" class="form-control" value="'+x.value+'" disabled="disabled">'+
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
  var selectTipo = document.getElementById("tipo");
  selectTipo.addEventListener("change", 
    function(){
      var elEmpresa = document.getElementsByClassName("elEmp");
      var elEst = document.getElementsByClassName("elEst");
      if(selectTipo.value =="empresa"){
        for (var i = 0; i < elEmpresa.length; i++) {
          elEmpresa[i].style.display = "block";
        };
        for (var i = 0; i < elEst.length; i++) {
          elEst[i].style.display = "none";
        };
      }else{
        for (var i = 0; i < elEmpresa.length; i++) {
         elEmpresa[i].style.display = "none";
       };
       for (var i = 0; i < elEst.length; i++) {
        elEst[i].style.display = "block";
      };
    }

  });
}

/**Fin Login**/
/**Perfil**/
var check;
function perfil(){
  /** Opcion fechas actualmente **/
  check = document.getElementsByClassName("actualmente");

  for (var i = 0; i < check.length; i++) {
    check[i].addEventListener("click",function(){

     var actSpans = document.getElementsByClassName("actSpan");
     var actDivs = document.getElementsByClassName("actDiv");
     var actInputs = document.getElementsByClassName("actInput");
     if(this.checked){
      for (var i = 0; i < actDivs.length; i++) {
        actDivs[i].style.display = "none";
        actSpans[i].style.display = "inline";   
      };
      actInput.value = "actualmente";

    }else{
      for (var i = 0; i < actDivs.length; i++) {
        actDivs[i].style.display = "inline";
        actSpans[i].style.display = "none";   
      };
      actInput.value = "";
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
  
  
}
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