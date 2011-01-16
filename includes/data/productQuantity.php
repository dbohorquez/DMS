<?php
	include('../functions.php');
	$productName = $_GET['p'];
	$quantity = getProductQuantity($productName);
	for($i=1;$i<=$quantity;$i++){
	?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	<?php
	}
?>