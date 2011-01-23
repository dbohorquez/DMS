<div class="">
	<h3>Editar Producto</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="products.php" enctype="application/x-www-form-urlencoded" method="post">
    	<?php
			include('../functions.php');
			$id = $_GET['e']; 
			$userid = $_GET['us']; 
			$product = getTable('products',"id = $id",'',1);
			$types = getTable('producttypes','deletedAt IS NULL','name asc');
			$data = '';
			while($type = mysql_fetch_array($types)){
				$data .= '"' . $type['name'] . '",';
			}
			
			
		?>
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" value="<?php echo $product['name']; ?>" />
        </fieldset>
        <fieldset>
            <label for="type">Tipo de Producto: <span class="required">*</span></label>
            <input type="text" class="text autocomplete" size="48" name="type" id="type" value="<?php $query = "select * from producttypes where id=$product[productTypes_id]";
						$result = runQuery($query);
						if(mysql_num_rows($result) == 0){
							return false;
						}else{
							$row = mysql_fetch_array($result);
							echo $row['name'];
						}  ?>" />
        </fieldset>
       <fieldset class="clear">
          <?php 
		  $rol=isAnyRol($userid);
		  if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
          	<input type="submit" class="btn clear" value="Guardar Cambios" name="bt-edit" />
          <?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
    <script type="text/javascript">
		var data = [<?php echo $data; ?>];
		$('#type').autocomplete({
			source: data
		});
	</script>
</div>