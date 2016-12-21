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
  
}
/**Fin Perfil **/

/** Prueba **/
function prueba(){



  var table = $('#example').DataTable( {
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

/** **/