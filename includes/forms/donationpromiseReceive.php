<div class="medium">
	<?php
		include('../functions.php');
		$id = $_GET['r']; 
		if($id !=''){
			$userid = $_GET['us']; 
			$donation = getTable('donations',"sequence = $id",'',1);
			$donor = getTable('donors',"id = $donation[donors_id]",'',1);
			$query = "select * from products_donations where donations_id=$id and deletedAt IS NULL";
			if (runQuery($query,2) > 0)	{
	?>
	<h3>Recibir Promesa de Donación #<?php echo $donation['sequence']; ?></h3>
    <p>Por favor, ingrese los siguientes elementos para dar por cumplida la promesa.</p>
		<p>Los datos marcados con  <span class="required">*</span> son obligatorios</p>

    <form action="donations-promises.php" enctype="application/x-www-form-urlencoded" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
					
      	<div class="column c50p">	
          <p><strong>Fecha:</strong> <?php echo formatDate($donation['date']); ?></p>
					<h4>Donante</h4>
          <p><strong>Identificación:</strong> <?php echo $types[$donor['type']] . ': ' . $donor['id']; ?></p>
          <p><strong>Nombre:</strong> <?php echo $donor['name']; ?></p>
        </div> 
				<div class="column c50p last">
						<fieldset>
	              <label for="warehouse">Bodega:<span class="required">*</span></label>
	              <select name="warehouse" id="warehouse">
	              <?php
	                  $warehouses = getTable('warehouses','','name asc');
	                  while($warehouse = mysql_fetch_array($warehouses)){
	              ?>
	                  <option value="<?php echo $warehouse['id']; ?>"<?php if($donation['warehouses_id'] == $warehouse['id']){ ?> selected="selected"<?php } ?>><?php echo $warehouse['name']; ?></option>
	              <?php } ?>
	              </select>
        	  </fieldset>
						<fieldset>
		           	<label for="company">Operador:</label>
	                <select name="company" id="company">
									 <option value="">Ninguno</option>
	                <?php
						$companies = getTable('companies','','name asc');
						while($company = mysql_fetch_array($companies)){
					?>
	                	<option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
	                <?php } ?>
	                </select>
	        	 </fieldset>
						<fieldset>
              <label for="bill">Número de Factura:</label>
              <input type="text" class="text" size="48" name="bill" id="bill" value="<?php echo $donation['bill']; ?>" />
          	</fieldset>
				</div>
				<div class="table_scroll">
					<table cellpadding="0" cellspacing="0" class="clear"><thead>
           	<tr>
               	<th>Nombre</th>
               	<th width="40">Cantidad <span class="required">*</span></th>
                <th width="100">Fecha de expiración <span class="required">*</span></th>
             </tr></thead><tbody>
				<?php
            $products = getDonationProducts($id);
            while($product = mysql_fetch_array($products)){
							    $rand = rand(1,10000000);
									$quantity = getProductQuantity($product['name'],$id);
        ?>
					<tr>
   							<td>
										<?php echo $product['name']; ?> 
										<input type="hidden" id="hitem<?php echo $rand ; ?>" name="hitem<?php echo $rand ; ?>" value="<?php echo $product['name'] ; ?>" />
								</td>
								<td><input type="text" style="width:50px" value="<?php echo $quantity; ?>" id="citem<?php echo $rand ; ?>" name="citem<?php echo $rand ; ?>" class="text"></td>
								<td><input type="text" id="ditem<?php echo $rand ; ?>" name="ditem<?php echo $rand ; ?>" class="text datepicker"></td>
					</tr>
        <?php
            }
        ?>
				 </tbody>
				</table>
				
			</div>	
				
    <fieldset class="clear">
   	        <?php 
			$rol=isAnyRol($userid);
			if($rol== 1 ||  $rol== 3){?>
            <input type="submit" class="btn" value="Guardar Cambios" name="bt-receive" />
			<?php } ?>
	        <span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
        </fieldset>
    </form>
   <script type="text/javascript">
			$('.datepicker').datepicker($.datepicker.regional[ "es" ],{
				inline: true
			});	
			$('.datepicker').datepicker("option", "dateFormat", 'yy-mm-dd');
		</script>
  <?php 
				}else{ ?>
				<div class="error">Debe de elegir algún producto en la donación.</div>
		  	<p><a href="javascript:void(0);" class="btn" onClick="$.colorbox.close()">Volver</a></p>
		<?php
		 		}
			}else{ ?>
  	<div class="error">Debe escribir un número de consecutivo.</div>
  	<p><a href="javascript:void(0);" class="btn" onClick="$.colorbox.close()">Volver</a></p>
  <?php } ?>
</div>