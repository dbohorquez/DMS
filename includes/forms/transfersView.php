<div class="medium">
	<h3>Ver Transferencia</h3>
  <div id="errorMessage" class="error"> </div>
	<?php
		include('../functions.php');
		$id = $_GET['t']; 

		$transfer = getTable('transfers',"deletedAt IS NULL and id = $id",'',1);
		$starting_warehouse = getTable('warehouses', "deletedAt IS NULL and id = $transfer[starting_warehouse]","",1);
		$destination_warehouse = getTable('warehouses', "deletedAt IS NULL and id = $transfer[destination_warehouse]","",1);
		$shelter = getTable('shelters',"deletedAt IS NULL and id = $transfer[shelter_id]","",1);
	?>
    <form action="distribution.php" enctype="application/x-www-form-urlencoded" method="post" onsubmit="return validateColorboxForm();">
			<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <div class="column c50p">
          <fieldset>
              <p><strong>Bodega de Origen:</strong> <?php echo $starting_warehouse['name'] == null ? "Virtual" : $starting_warehouse['name'] ; ?></p>
              <p><strong>Bodega Destino:</strong> <?php echo $destination_warehouse['name']; ?></p>
          </fieldset>
        </div>
        <div class="column c50p last">
            <fieldset>
			        <p><strong>Destino de Despacho:</strong> <?php echo $shelter['name']; ?></p>
			   		  <p><strong>Comentarios:</strong> <?php echo $transfer['notes']; ?></p>
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
					$products = getTransferProducts($id);
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
    			 	<input type="button" class="btn clear" value="Ok" onClick="$.colorbox.close()" />
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