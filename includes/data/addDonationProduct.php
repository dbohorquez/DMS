<?php
session_start(); 
if($section != 'login' && !isset($_SESSION['dms_authorized'])){ header('Location: login.php'); } 
	include('../functions.php');
	$sw=false;
	$idp = findRow('products', 'name', "'".$_POST['product_name']."'", 'id');
	if(exists("products","id=$idp")){
		for($i = 1 ; $i <= $_POST['product_quantity'] ; $i ++){
			if(isset($_POST['warehouse_id'])){// si es una donacion fisica
				if($_POST['product_date']!=''){
					$datos = array(donations_id => $_POST['donation_id'], products_id =>$idp, expirationDate => $_POST['product_date'], warehouses_id => $_POST['warehouse_id']);
					$warehouse=$_POST['warehouse_id'];
				}else{     
					$sw=false;
				}
				$idpd=dbInsert("products_donations",$datos);
				if($idpd){	
					addStatesChanges ($idpd,1,$_SESSION['dms_id'],$reason = 'Ingreso a la bodega '.$_POST['warehouse_id']);
					$sw=true;	
				}
			}else{
				if($_POST['donation_type']==2){//si es una donacion virtual
					$datos = array(donations_id => $_POST['donation_id'], products_id =>$idp, expirationDate => $_POST['product_date']);
					$idpd=dbInsert("products_donations",$datos);
					if($idpd){	
						addStatesChanges ($idpd,2,$_SESSION['dms_id'],$reason = 'Ingreso a la bodega virtual');
						$sw=true;	
					}
				}else{// si es una promesa
					$datos = array(donations_id => $_POST['donation_id'], products_id =>$idp);
					$idpd=dbInsert("products_donations",$datos);
					if($idpd){	
						addStatesChanges ($idpd,3,$_SESSION['dms_id'],$reason = 'Ingreso a la bodega de promesas');
						$sw=true;	
					}
				}
			}
		}
	}
	if ($sw)
		echo $idpd;
	else
		echo "error";
?>