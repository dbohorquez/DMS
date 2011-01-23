<?php
session_start(); 
if($section != 'login' && !isset($_SESSION['dms_authorized'])){ header('Location: login.php'); } 
	
 	include('../functions.php');
	$sw=false;
	for($i = 1 ; $i <= $_POST['product_quantity'] ; $i ++){
		$idp = findRow('products', 'name', "'".$_POST['product_name']."'", 'id');
		if(isset($_POST['warehouse_id'])){
			if($_POST['product_date']!=''){
				$datos = array(donations_id => $_POST['donation_id'], products_id =>$idp, expirationDate => $_POST['product_date'], warehouses_id => $_POST['warehouse_id']);
				$warehouse=$_POST['warehouse_id'];
			}else{     
				$sw=false;
			}
			$idp=dbInsert("products_donations",$datos);
			if($idp){	
				addStatesChanges ($idp,1,$_SESSION['dms_id'],$reason = 'Ingreso a la bodega '.$_POST['warehouse_id']);
				$sw=true;	
			}
		}else{
			if($_POST['donation_type']==2){
				$datos = array(donations_id => $_POST['donation_id'], products_id =>$idp, expirationDate => $_POST['product_date']);
				$idp=dbInsert("products_donations",$datos);
				if($idp){	
					addStatesChanges ($idp,2,$_SESSION['dms_id'],$reason = 'Ingreso a la bodega virtual');
					$sw=true;	
				}
			}else{
				$datos = array(donations_id => $_POST['donation_id'], products_id =>$idp);
				$idp=dbInsert("products_donations",$datos);
				if($idp){	
					addStatesChanges ($idp,3,$_SESSION['dms_id'],$reason = 'Ingreso a la bodega de promesas');
					$sw=true;	
				}
			}
		}
	}
	if ($sw)
		echo $idp;
	else
		echo "error";
?>