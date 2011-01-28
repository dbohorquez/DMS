<?php
session_start(); 
if($section != 'login' && !isset($_SESSION['dms_authorized'])){ header('Location: login.php'); } 

	include('../functions.php');
	$query = "SELECT u.name unit_name FROM units u, producttypes p, categories c WHERE p.name= '$_POST[type_name]' AND p.categories_id=c.id AND c.unit_id=u.id";
	$result= runQuery($query);
	
	if($result){
		$row = mysql_fetch_array($result);
		echo $row['unit_name'];
	}else{
		echo "error";
	}

?>