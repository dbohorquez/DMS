<?php
 session_start(); 
if($section != 'login' && !isset($_SESSION['dms_authorized'])){ header('Location: login.php'); } 
 	include('../functions.php');
	
	$currentdate = date("Y-m-d H:i");										
	$datos = array(deletedAt=> $currentdate);
	if(dbUpdate("products_donations",$datos,"id= $_POST[product_id]")){	
	    addStatesChanges ($_POST['product_id'],6,$_SESSION['dms_id'],$reason = 'Eliminado por el usuario $_SESSION[dms_id]');
		$quantity=getProductQuantity($_POST['product_name'],$_POST['donation_id'],1);
		if($quantity>0){
			$query = "SELECT id FROM products_donations WHERE deletedAt is null and products_id IN (SELECT products_id FROM products_donations WHERE id=".$_POST['product_id'].")";
			$row=runQuery($query,1);
			echo "ok_".$quantity."_".$row['id'];

		}else{
			echo "ok_".$quantity;
		}
	}else{
		echo "error";
	}

?>