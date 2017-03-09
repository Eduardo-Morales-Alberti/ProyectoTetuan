<?php 
include_once('funciones/loginF.php');

session_start();

$logincl = new loginBBDD;
$modal = $logincl->restContr();

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<meta name="description" content="Programa bolsa de empleo." />
	<meta name="author" content="Eduardo Morales" />
	<meta name="copyright" content="" />
	<meta name="producto" content="TetuanJobs" />
	<meta name="version" content="V1.0" />
	<link rel="icon"  type="image/png"  href="images/favicon.png"/>

	<title>TetuanJobs | Restablecer Contraseña </title>

	<!-- Bootstrap CSS-->
	<link href="css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/bootstrap-toggle.min.css" rel="stylesheet" />
	<!-- Plugins CSS-->
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="plugins/animo/animateanimo.css" rel="stylesheet" />
	<link href="plugins/csspinner/csspinner.min.css" rel="stylesheet" />
	<link href="plugins/Notific/jquery.notific8.min.css" rel="stylesheet" />
	<!-- DataTables CSS -->

	<link href="css/dataTables.bootstrap.min.css" rel="stylesheet" />
	<link href="css/dataTables.responsive.bootstrap.min.css" rel="stylesheet" />


	<!-- Web CSS-->
	<link href="css/app.css" rel="stylesheet" />

	<!-- Aplicación CSS-->
	<link href="css/tetuanjobs.css" rel="stylesheet" />

    <style type="text/css">
    @media only screen and (min-width: 768px){
        .main-content{
            margin-top: 60px;
        }
    }
    </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Modernizr JS Script-->
        <script src="plugins/modernizr/modernizr.js"></script>
        <!-- FastClick for mobiles-->
        <script src="plugins/fastclick/fastclick.js"></script>


    </head>
    <body>

    	<div class="wrapper">

    		<!--<app:navigation ID="navigation" runat="server" />-->
    		<!-- Barra Navegacion -->
    		<nav role="navigation" class="navbar navbar-default navbar-top navbar-fixed-top">
    			<!--Logo-->
    			<div class="navbar-header">
    				<a href="#" class="navbar-brand">
    					<div class="brand-logo">
    						<img src="images/logo.png" alt="App Logo" class="img-responsive" />
    					</div>
    					<div class="brand-logo-collapsed">
    						<img src="images/logo-single.png" alt="App Logo" class="img-responsive" />
    					</div>
    				</a>
    			</div>
    			<!---->
    			

    		</nav>
    		<!-- Fin Barra Navegacion -->       
    		<!-- CONTENIDO INICIO -->


    		<!-- START Page content-->
    		<div class="main-content">

    			<h1>Restablecer Contraseña</h1>
    			<!--panel cambiar contraseña -->

    			<div class="row">
    				<div class="col-md-offset-2 col-md-8">
    					<form method="post">
    						<div class="panel panel-default">
    							<div class="panel-heading">
    								<h4>Formulario</h4> 
    							</div>
    							<div class="panel-body">
    								<div class="row">
    									<div class="col-md-6 col-lg-4">
    										<div class="form-group">
    											<label>Nueva contraseña</label>
    											<input type="password" class="form-control" name="ncontr" value="" required="required">
    										</div>
    									</div>
    									<div class="col-md-6 col-lg-4">
    										<div class="form-group">
    											<label>Confirma la contraseña</label>
    											<input type="password" class="form-control" name="ccontr" value="" required="required">
    										</div>
    									</div>
    								</div>
    							</div>
    							<div class="panel-footer">
    								<div class="row">
    									<div class="col-md-12 text-right">
    										<input type="reset" class="btn btn-warning" name="limpiar" value="Limpiar">
    										<input type="submit" name="restcontr" value="Restablecer" class="btn btn-green">
    									</div>
    								</div>
    							</div>
    						</div>
    					</form>
    				</div>
    			</div>
    			<!-- Fin panel cambiar contraseña -->
    		</div>
    		<!-- END Page content-->

    		<!--<app:footer ID="footer" runat="server" />-->
    		<footer class="text-center">&copy; 2018 - Copyright - Desarrollado por: Eduardo Morales<br /></footer>
    	</div>
    	<!-- CONTENIDO FIN -->
    </div>



    <!-- Modal mensaje del servidor -->
    <div class="modal fade" id="modalmensaje" >
    	<div class="modal-dialog modal-lg">

    		<!-- Contenido del modal // Un modal es una ventana que se muestra encima del contenido -->
    		<div class="modal-content">
    			<div class="modal-header">
    				<!-- Este boton sirve para cerrar el modal -->
    				<button type="button" class="close" data-dismiss="modal">&times;</button>
    				<!-- Este es el título de la cabecera del modal -->
    				<h4 class="modal-title"><span id="titexp">Aviso</span></h4>
    			</div>

    			<!-- Este es el cuerpo del modal -->
    			<div class="modal-body">
    				<p><?php //echo $_REQUEST["mensaje"]; ?>
    					<span id="mensajeserv"></span></p>
    				</div>
    				<!-- Este es el pie del modal -->
    				<div class="modal-footer"> 
    					<input type="button" class="btn btn-info" data-dismiss="modal" value="Salir">
    					<!-- Para cerrar todos los modales con data-dismiss-->
    				</div>

    			</div>
    		</div>
    	</div>                        

    	<!-- Fin Modal -->

    	<!-- jQuery Scripts-->
    	<script src="js/jquery-2.1.4.min.js"></script>
    	<!-- Bootstrap Scripts-->
    	<script src="js/bootstrap.min.js"></script>
    	<script src="js/bootstrap-toggle.min.js"></script>
    	<!-- Plugins Scripts-->
    	<script src="plugins/jquery.json-2.4.js"></script>
    	<script src="plugins/animo/animo.min.js"></script>
    	<script src="plugins/chosen/chosen.jquery.min.js"></script>
    	<script src="plugins/filestyle/bootstrap-filestyle.min.js"></script>
    	<script src="plugins/slider/js/bootstrap-slider.js"></script>
    	<script src="plugins/sparklines/jquery.sparkline.min.js"></script>
    	<script src="plugins/slimscroll/jquery.slimscroll.min.js"></script>
    	<script src="plugins/classyloader/js/jquery.classyloader.min.js"></script>
    	<script src="plugins/store/storejson2.min.js"></script>
    	<script src="plugins/Notific/jquery.notific8.min.js"></script>
    	<!-- Data Table Scripts-->
    	<script src="js/jquery.dataTables.min.js"></script>
    	<script src="js/dataTables.bootstrap.min.js"></script>

    	<!-- Tabla responsive -->
    	<script src="js/dataTables.responsive.min.js"></script>


    	<script src="js/app.js"></script> 

    	<!-- Aplicación Scripts-->
    	<script src="js/tetuanjobs.js"></script>

    	<?php

    	/*if(isset($_SESSION["mensajeServidor"])){
    		echo '<script type="text/javascript">
    		mensajeModal("'.$_SESSION["mensajeServidor"].'"");
    		</script>';
    		unset($_SESSION["mensajeServidor"]);
    	}*/

    	if(isset($modal)){
    		echo $modal;
    	}
    	?>   

    </body>
    </html>

