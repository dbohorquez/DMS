<div class="medium">
	<h3>Agregar Producto</h3>
    <p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>
    <form action="products.php" enctype="application/x-www-form-urlencoded" method="post">
    	<?php
			include('../functions.php');
			$types = getTable('producttypes','deletedAt IS NULL','name asc');
			$data = '';
			$userid = $_GET['us']; 
			while($type = mysql_fetch_array($types)){
				$data .= '"' . $type['name'] . '",';
			}
		?>
        <fieldset>
            <label for="name">Nombre: <span class="required">*</span></label>
            <input type="text" class="text" size="48" name="name" id="name" />
        </fieldset>
        <fieldset>
            <label for="type">Tipo de Producto: <span class="required">*</span></label>
            <input type="text" class="text autocomplete" size="48" name="type" id="type" />
        </fieldset>
        <fieldset class="clear">
         <?php 
		 $rol=isAnyRol($userid);
		 if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
          	<input type="submit" class="btn clear" value="Agregar" name="bt-add" />
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