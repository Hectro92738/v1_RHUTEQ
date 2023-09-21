<?php require("SQLquerys/querys.php");
function cabeza(){
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RH UTEQ</title>
    
    <!-- <script src="vendor/jquery/jquery.dataTables.min.js"></script>-->
    
	
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/metisMenu/metisMenu.min.js"></script>
    <script src="dist/js/sb-admin-2.js"></script>
	<script src="js/moment-with-locales.js"></script>
	<script src="js/xlsx.full.min.js"></script>
	<script src="js/FileSaver.min.js"></script>
    <style>
    .invi{
    font-family: Tahoma, Verdana, Arial;
    font-size: 12px;
    color: #707070;
    background-color: #FFFFFF;
    border-width:0;
    }
    </style>';
	if(validarSession()!=1){
		header("Location: login.php");
	}
echo '
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">RH UTEQ</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
                        <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>           
                </li>           
            </ul>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="envioPDF.php"><i class="fa fa-plus-circle fa-fw"></i>SUBIR RECIBOS NOMINA</a>
                        </li>
                         <li>
                            <a href="declaracionPatrimonial.php"><i class="fa fa-plus-circle fa-fw"></i>SUBIR ARCHIVOS DECLARACION PATRIMONIAL</a>
                        </li>
                        <li>
                            <a href="enviarMailNomina.php"><i class="fa fa-plus-circle fa-fw"></i>ENVIAR ARCHIVOS NOMINA</a>
                        </li>
						<li>
                            <a href="enviarMailDP.php"><i class="fa fa-plus-circle fa-fw"></i>ENVIAR ARCHIVOS DECLARACION PATRIMONIAL</a>
                        </li>
                        <li>
                            <a href="modules/estructura/leerEstructura.php"><i class="fa fa-plus-circle fa-fw"></i>MIGRAR ESTRUCTURA</a>
                        </li>
                    </ul>
                </div>           
            </div>           
        </nav>
        <div id="page-wrapper">
           ';

}



function pie() {
    echo '</div>
    </div>
    
</body>
</html>';
}           
       

?>