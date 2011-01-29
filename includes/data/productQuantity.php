<?php
	include('../functions.php');
	$productName = $_GET['p'];
	if ( isset($_GET['w']) && $_GET['w'] != "-1"){
		$quantity = getProductQuantity($productName,'', 1, $_GET['w']);
	}else{
		$quantity = getProductQuantity($productName,'', 2 );
	}
	for($i=1;$i<=$quantity;$i++){
	?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	<?php
	}
?>