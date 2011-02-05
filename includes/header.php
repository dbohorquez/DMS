<?php session_start(); 
if($section != 'login' && !isset($_SESSION['dms_authorized'])){ header('Location: login.php'); } ?>
<?php require_once('includes/functions.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!--[if IE]><![endif]-->
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title></title>
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
    <link type="text/css" rel="stylesheet" href="css/reset.css?v=1" />
    <link type="text/css" rel="stylesheet" href="css/jquery-ui/jquery-ui-1.8.7.custom.css" />
    <link type="text/css" rel="stylesheet" href="css/colorbox/colorbox.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css?v=1" />
    <link type="text/css" rel="stylesheet" href="css/devices.css?v=1" />
    <script type="text/javascript" src="js/modernizr-1.6.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.7.custom.min.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>

</head>
<body>
<!--[if lt IE 7 ]> <div id="wrapper" class="ie6 ie7 ie8 ie9"> <![endif]-->
<!--[if IE 7 ]>    <div id="wrapper" class="ie7 ie8 ie9"> <![endif]-->
<!--[if IE 8 ]>    <div id="wrapper" class="ie8 ie9"> <![endif]-->
<!--[if IE 9 ]>    <div id="wrapper" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <div id="wrapper"> <!--<![endif]-->
		<div id="header">
			<h1 id="logo"><a href="index.php"><img src="images/logo.png" alt="" /></a></h1>
            <?php if($section != 'login'){ 
			$rol=isAnyRol($_SESSION['dms_id']);
			?>
            <ul id="nav">
                <li<?php if($section == 'home'){ ?> class="active"<?php } ?>><a href="index.php">Inicio</a></li>
                <?php if($rol== 1 || $rol== 2){?>
                <li<?php if($section == 'warehouses'){ ?> class="active"<?php } ?>><?php if($rol== 1){?><a href="warehouses.php">Bodegas</a><?php }?>
	                <ul>
                    <li><a href="transfers.php">Transferencias</a></li>
                    <li><a href="products_checkpoint.php">Puntos de Reorden</a></li>
                  </ul>
                </li>
                <?php }?>
                <li<?php if($section == 'products'){ ?> class="active"<?php } ?>><a href="products.php">Productos</a>
                	<ul>
                    <li><a href="categories.php">Categorías</a></li>
                    <li><a href="producttypes.php">Tipos</a></li>
                    <li><a href="kits.php">Kits</a></li>
                    <li><a href="goals.php">Metas</a></li>
                  </ul>
                </li>
                <li<?php if($section == 'companies'){ ?> class="active"<?php } ?>><a href="companies.php">Operadores</a></li>
                <li<?php if($section == 'donations'){ ?> class="active"<?php } ?>><a <?php if($rol== 5 || $rol== 1){?>href="donations.php"<?php }?>>Donaciones</a>
                	<ul>
										 <?php if($rol== 6 || $rol== 1){?><li><a href="virtual-receptions.php">Donación Virtual</a></li><?php }?>
                    <li><a href="donation-checkin.php">Comprobantes DV</a></li>
                    <li><a href="donations-promises.php">Promesas de Donación</a></li>
                    <li><a href="donors.php">Donantes</a></li>
                  </ul>
                </li>
                <li<?php if($section == 'distribution'){ ?> class="active"<?php } ?>><a href="distribution.php">Distribución</a>
                	<ul>
                    	<li><a href="beneficiaries.php">Beneficiarios</a></li>
                    </ul>
                </li>
                <li<?php if($section == 'reports'){ ?> class="active"<?php } ?>><a href="reports.php">Reportes y Consultas</a>
                	<ul class="large">
                    <li><a href="reports.php?r=1">Puntos de Reorden de Atención Crítica</a></li>
                    <li><a href="reports.php?r=2">Solicitudes a Operadores Comerciales</a></li>
                    <li><a href="reports.php?r=3">Productos en Bodega</a></li>
                    <li><a href="reports.php?r=4">Productos por Bodega</a></li>
                    <li><a href="reports.php?r=5">Productos por Compañía</a></li>
                    <li><a href="reports.php?r=6">Información de Donantes</a></li>
                  </ul>
                </li>
            </ul>
            <ul id="options">
            	<li><a href="options.php">Opciones</a></li>
                <li><a href="help.php">Ayuda</a></li>
                <li><a href="login.php">Salir</a></li>
            </ul>
            <?php } ?>
		</div>
		
		<div id="content">