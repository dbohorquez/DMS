<?php
	include('../functions.php');
	if($_POST['warehouse'] == "-1"){
		$query = "SELECT  products.id, products.name, COUNT(products_donations.id)
			FROM products
			INNER JOIN products_donations
			ON products.id=products_donations.products_id
			WHERE products_donations.state=2 AND products_donations.deletedAt IS NULL
			GROUP BY products.id, products.name
			ORDER BY products.name";
	}else{
		$query = "SELECT  products.id, products.name, COUNT(products_donations.id)
			FROM products
			INNER JOIN products_donations
			ON products.id=products_donations.products_id
			WHERE products_donations.state=1 AND products_donations.warehouses_id = $_POST[warehouse] AND products_donations.deletedAt IS NULL
			GROUP BY products.id, products.name
			ORDER BY products.name";
	}	
	$products = runQuery($query);
	$data = '';
	while($product = mysql_fetch_array($products)){
		$data .= $product['name'].',';
	}
	echo $data;
?>