<?php
session_start(); 
if($section != 'login' && !isset($_SESSION['dms_authorized'])){ header('Location: login.php'); } 
	
 	include('../functions.php');
	$sw=false;
	for($i = 1 ; $i <= $_POST['product_quantity'] ; $i ++){
		$idp = findRow('products', 'name', "'".$_POST['product_name']."'", 'id');
		
		$datos = array(donations_id => $_POST['donation_id'], products_id =>$idp, expirationDate => $_POST['product_date'], warehouses_id => $_POST['warehouse_id']);
		
		$idp=dbInsert("products_donations",$datos);
		if($idp){	
			addStatesChanges ($idp,1,$_SESSION['dms_id'],$reason = 'Ingreso a la bodega '.$_POST['warehouse_id']);
			$sw=true;	
		}
	}
	if ($sw)
		echo $idp;
	else
		echo "error";
?>