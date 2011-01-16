<?php
	include('../functions.php');
	$province = $_GET['p'];
	$towns = getTable('towns',"provinces_id = $province",'name asc');
	while($town = mysql_fetch_array($towns)){
	?>
		<option value="<?php echo $town['id']; ?>"><?php echo utf8_encode($town['name']); ?></option>
	<?php
	}
?>