<?php
	include('../functions.php');
	$userid = $_GET['us']; 
	$id = $_GET['e']; 
	$distribution = getTable('distributions',"id = $id",'',1);
	$query = "SELECT  products.id, products.name, COUNT(products_donations.id)
		FROM products
		INNER JOIN products_donations
		ON products.id=products_donations.products_id
		WHERE products_donations.state=2
		GROUP BY products.id, products.name
		ORDER BY products.name";
	$products = runQuery($query);
	$data = '';
	$warehouse = getTable('warehouses',"id = $distribution[warehouses_id] and deletedAt IS NULL",'','1');
	$company = getTable('companies',"type = 2 and id = $distribution[companies_id] and deletedAt IS NULL",'', '1');
	$shelter = getTable('shelters',"id = $distribution[shelter_id] and deletedAt IS NULL",'', '1');

	while($product = mysql_fetch_array($products)){
		$data .= '"' . $product['name'] . '",';
	}
?>

<div class="medium">
	<h3><?php echo $distribution['state'] == 2 ? "Ver" : "Editar" ?> Distribución</h3>
      <?php if ($distribution['state'] != 2) { ?><p>Los datos marcados con  <span class="required">*</span> son obligatorios</p> <?php } ?>
		<div id="errorMessage" class="error"> </div>

    <form action="distribution.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();">
			<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <div class="column c50p">
          <fieldset>
              <p><strong>Bodega:</strong> <?php echo $warehouse['name']; ?></p>
              <p><strong>Canal de Distribución:</strong> <?php echo $company['name']; ?></p>
              <p><strong>Beneficiarios:</strong> <?php echo $shelter['name']; ?></p>
         		  <p><strong>Fecha de Entrega:</strong> <?php echo formatDate($distribution['deliveryDate']); ?></p>
			    </fieldset>
        </div>
        <div class="column c50p last">
            <fieldset>
							<?php if ($distribution['state'] != 2) { ?>
                <label for="state">Estado: <span class="required">*</span></label>
                <select name="state" id="state">
                    <option value="1"<?php if($distribution['state'] == 1){ ?> selected="selected"<?php } ?>>Programada</option>
                    <option value="2"<?php if($distribution['state'] == 2){ ?> selected="selected"<?php } ?>>Entregada</option>
                    <option value="3"<?php if($distribution['state'] == 3){ ?> selected="selected"<?php } ?>>Pendiente</option>
                </select>
							<?php } else { ?>
								<p><strong>Estado: </strong>Entregado</p>
							<?php } ?>
            </fieldset>
        </div>
				<div class="clear"></div>
				<div class="table_scroll">
					<table cellpadding="0" cellspacing="0" class="clear"><thead>
           	<tr>
               	<th>Nombre</th>
                <th width="100">Fecha de expiración</th>
             </tr></thead><tbody>
				<?php
					$products = getDistributionProducts($id);
					$products_length = mysql_num_rows($products);
				  
					if ($products_length > 0){
            while($product = mysql_fetch_array($products)){
		    	 ?>
					<tr>
   							<td><?php echo $product['name']; ?> </td>
								<td><?php echo $product['expirationDate']; ?> </td>
					</tr>
        <?php
            } 
					}else{
         ?>
						<tr><td colspan="5">No se han encontrado productos.</td></tr>
				<?php
					}
				?>
				 </tbody>
			   </table>
		   </div>		
       <fieldset class="clear">
        <?php
					if ($distribution['state'] != 2) { 
						$rol=isAnyRol($userid);
						if($rol== 1 || $rol== 2){?>
  	    			<input type="submit" class="btn clear" value="Guardar Cambios" name="bt-edit" />
         		<?php } ?>
        		<span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
         <?php } else { ?>
					 	<input type="button" class="btn clear" value="Ok" onClick="$.colorbox.close()" />
	         <?php } ?>
				</fieldset>
    </form>
    <script type="text/javascript">
		$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
			inline: true
		});	
		$('.datepicker').datepicker("option", "dateFormat", 'yy-mm-dd');
		$('.datepicker').datepicker('setDate', '<?php echo $distribution['deliveryDate']; ?>');
		$('#add').hide();
		var data = [<?php echo $data; ?>];
		$('#product').autocomplete({
			source: data,
			mustMatch: true,
			select: function(event, ui){
				$('#add').show();
				updateElm('#quantity','includes/data/productQuantity.php?p=' + ui.item.value);
			}
		});
	</script>
</div>