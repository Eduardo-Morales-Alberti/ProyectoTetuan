<?php 

include_once('funciones/loginF.php');

session_start();

$logincl = loginBBDD::singleton();
$logincl->entrar();
$logincl->nvContrEmail();
$logincl->nvEstudiante();
$logincl->nvEmpresa();

?>

<!DOCTYPE html>

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

    <title>TetuanJobs | Login</title>


    <!-- Bootstrap CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/bootstrap-toggle.min.css" rel="stylesheet" />

    <!-- Plugins CSS-->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="plugins/animo/animateanimo.css" rel="stylesheet" />
    <link href="plugins/csspinner/csspinner.min.css" rel="stylesheet" />
    <link href="plugins/Notific/jquery.notific8.min.css" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link href="plugins/datatables-1.10.9/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <!-- DataTables Responsive CSS -->
    <link href="plugins/datatables-1.10.9/extensions/Responsive/css/responsive.dataTables.min.css" rel="stylesheet" />

    <!-- Web CSS-->
    <link href="css/app.css" rel="stylesheet" />
    <link href="css/tetuanjobs.css" rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" />
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

        <!-- START wrapper-->
        <div class="row row-table page-wrapper">
            <div class="col-lg-3 col-md-6 col-sm-8 col-xs-12 ">
                <div data-toggle="play-animation" data-play="fadeIn" data-offset="0" class="panel panel-dark b0">
                    <div class="panel-heading text-center p-lg">
                        <a href="#">
                            <img src="images/logo.png" alt="Image" class="block-center img-rounded" />
                        </a>
                    </div>
                    <div id="accordion" data-toggle="collapse-autoactive" class="panel-group">
                        <!-- COMIENZO panel Entrar-->
                        <div class="panel radius-clear b0 shadow-clear">
                            <div class="panel-heading radius-clear panel-heading-active panel-heading-green">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="text-muted btn-block text-center">INICIAR SESIÓN</a>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <form class="mb-lg" method="post">
                                        <div class="form-group has-feedback">
                                            <label for="mail">Email</label>
                                            <input id="mail" name="mail" type="email" placeholder="Email" class="form-control" required="required"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Introduzca un email valido" />
                                            <span class="fa fa-envelope form-control-feedback text-muted"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="contrlog">Contraseña</label>
                                            <input id="contrlog" name="contrlog" type="password" placeholder="Contraseña" class="form-control" required="required"/>
                                            <span class="fa fa-lock form-control-feedback text-muted"></span>
                                        </div>      
                                        <input type="submit" name="entrar" value="Entrar" class="btn btn-block btn-success"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- FINAL panel Entrar-->
                        <!-- COMIENZO panel Recuperar contraseña--> 
                        <div class="panel radius-clear b0 shadow-clear">
                            <div class="panel-heading radius-clear">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="text-muted btn-block text-center">¿Ha olvidado la contraseña?</a>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form method="post">
                                        <p class="text-center"><i>Escriba su email para establecer una nueva contraseña.</i></p>
                                        <div class="form-group has-feedback">
                                            <label for="mail">Email</label>
                                            <input  name="mail" type="email" placeholder="Email" class="form-control" required="required"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Introduzca un email valido"/>
                                            <span class="fa fa-envelope form-control-feedback text-muted"></span>
                                        </div>
                                        <input type="submit" name="recordar" value="Enviar" class="btn btn-danger btn-block">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- FINAL panel Recuperar contraseña-->
                        <!-- COMIENZO panel Registro-->
                        <div class="panel radius-clear b0 shadow-clear">

                            <div class="panel-heading  radius-clear panel-heading-active panel-heading-blue ">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="text-muted btn-block text-center">REGISTRARSE</a>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form id="registro" method="post">
                                        <div class="form-group ">
                                            <label for="tipo">Tipo de usuario</label><br>
                                            <select id="tipo" name="tipo" class="form-control">
                                                <option value="estudiante">Estudiante</option>
                                                <option value="empresa">Empresa</option>
                                            </select>                                        
                                        </div>
                                        <div class="form-group has-feedback elEmp" >
                                            <label for="empresa">Empresa</label>
                                            <input id="empresa" name="empresa" type="text" placeholder="Nombre de la empresa" class="form-control inputEmp"  title="Introduzca un Nombre valido" required="required"/>                                       
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="nombre">Nombre</label>
                                            <input id="nombre" name="nombre" type="text" placeholder="Escriba su nombre" class="form-control" required="required" title="Introduzca un Nombre valido"/>

                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="apellidos">Apellidos</label>
                                            <input id="apellidos" name="apellidos" type="text" placeholder="Escriba sus apellidos" class="form-control" required="required"   title="Introduzca un Apellido valido"/>

                                        </div>
                                        <div class="form-group has-feedback elEmp" >
                                            <label for="webempresa">Web de la Empresa</label>
                                            <input id="webempresa" name="webempresa" type="text" placeholder="Escriba la web de la empresa" class="form-control" title="Introduzca un Apellido valido"/>

                                        </div>
                                        <div class="form-group has-feedback elEst">
                                            <label for="modulo">Módulo</label><br>
                                            <select name="modulo" class="form-control inputEst" required="required">
                                                <option value="DAW">DAW</option>
                                                <option value="ASIR">ASIR</option>
                                                <option value="TURISMO">TURISMO</option>
                                            </select>  
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label for="mail">Email</label>
                                            <input name="mail" type="email" placeholder="Correo electrónico" class="form-control" required="required"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Introduzca un email valido"/>
                                            <span class="fa fa-envelope form-control-feedback text-muted"></span>
                                        </div>                                                                       
                                        <input type="submit" name="registrar" class="btn btn-block btn-success" value="Registrar">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- FINAL panel Registro-->

                    </div>

                </div>

            </div> 

        </div>

        
        <!-- END wrapper-->

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
                        <p><?php //echo $_SESSION["mensajeServidor"];?>
                            <span id="mensajeserv"></span>
                        </p>
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
        <script src="plugins/datatables-1.10.9/media/js/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables-1.10.9/media/js/dataTables.bootstrap.min.js"></script>
        <script src="js/app.js"></script>
        <script src="js/tetuanjobs.js"></script>
        <script type="text/javascript">
        login();

        </script>
        <?php
        if(isset($_SESSION["mensajeServidor"])){
            echo '<script type="text/javascript">
            mensajeModal("'.$_SESSION["mensajeServidor"].'");
            </script>';
            unset($_SESSION["mensajeServidor"]);
        }
        
        ?> 
    </body>
    </html>
