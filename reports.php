<?php $section = 'inicio'; ?>
<?php include('includes/header.php'); ?>
<?php 
	$company_id = $_POST['compan']; 
	$warehouse_id = $_POST['warehouse']; 
	$product_name = $_POST['product']; 
	$company_warehouse_id = $_POST['compan_ware']; 
	if($product_name!='')
	{
	$product_id = findRow('products','name',"'".$product_name."'",'id');	
	}
	
	$products = getTable('products','','name asc');
	$data = '';
	while($product = mysql_fetch_array($products)){
		$data .= '"' . $product['name'] . '",';
	}
?>
			<h2>Bienvenido</h2>
   			<h2>Puntos de Reorden de atencion Critica</h2>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Producto</th>
                    <th>Bodega</th>
                    <th>Punto de Reorden</th>
                    <th>Cantidad en Bodega</th>
                </tr></thead><tbody>
                <?php

					$query = "SELECT p.id,name,c.quantity FROM products p,products_checkpoint c WHERE p.deletedAt IS NULL AND c.deletedAt IS NULL AND product_id=p.id";
					$checkpoints = runQuery($query);
					

					$numRows = mysql_num_rows($checkpoints);
					if($numRows > 0){
						while($checkpoint = mysql_fetch_array($checkpoints)){
							
							$query = "SELECT COUNT(*) as cont, warehouses_id FROM products_donations WHERE products_id=$checkpoint[id] AND state=1 GROUP BY warehouses_id";
							$count = runQuery($query);
							while($cont = mysql_fetch_array($count)){
							if($cont['cont']<$checkpoint['quantity']){		
				?>
                <tr>
                	<td><?php echo $checkpoint['name']; ?></td>
                    <td><?php 
					$warehouse = getTable('warehouses',"id = $cont[warehouses_id]",'',1);
					echo $warehouse['name']; ?></td>
                    <td><?php echo $checkpoint['quantity']; ?></td>
                    <td><?php echo $cont['cont']; ?></td>
                </tr>
                <?php
							}
							}
						}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
				?>
            </tbody></table>
            
   			<h2>Solicitudes a Operadores Comerciales</h2>
            <form name="datos" action="reports.php" method="post" enctype="application/x-www-form-urlencoded">
					<div class="toolbar">
						
						<div class="input inline alignleft">Seleccione un operador Comercial</div>
						<select name="compan" id="compan">
                        		
							<?php 
							$query = "select * from companies where type=1";
							$companies = runQuery($query);
							$numRows = mysql_num_rows($companies);
							if($numRows > 0){
							while($company = mysql_fetch_array($companies)){
							?>
							<option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
							<?php } 
							}
							?>
						</select>
						<input type="submit" class="btn" value="Consultar" name="bt-consulta" />
					</div>

            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Operador</th>
                    <th>Factura</th>
                    <th>Productos solicitados</th>
                </tr></thead><tbody>
                <?php

					$query = "SELECT DISTINCT(sequence),bill,companies_id FROM products_donations_tranfers, products_donations pd,donations d WHERE pd.id=product_donation_id AND donations_id=sequence";
					
					if($company_id){
					$query.=" AND companies_id=$company_id";	
					}
					$companies = runQuery($query);
					

					$numRows = mysql_num_rows($companies);
					if($numRows > 0){
						while($company = mysql_fetch_array($companies)){
				
				?>
                <tr>
                	<td><?php $company_name = getTable('companies',"id = $company[companies_id]",'',1);
					echo $company_name['name']; ?></td>
                    <td><?php echo $company['bill']; ?></td>
                    <td>
                    <?php
					$query = "SELECT name, COUNT(name) AS quantity FROM products_donations_tranfers, products_donations pd, products p WHERE pd.id=product_donation_id AND donations_id=$company[sequence] AND products_id=p.id GROUP BY p.name";
							$count = runQuery($query);
							echo "<ul>";

							while($row = mysql_fetch_array($count)){
							echo "<li>$row[name]: $row[quantity] unidades</li>";
							}
							echo "</ul>";
					?>
                    </td>
                </tr>
                <?php
							
				
						}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
				?>
            </tbody></table>
            </form>       

   			<h2>Productos en Bodega</h2>
            <form name="datos" action="reports.php" method="post" enctype="application/x-www-form-urlencoded">
					<div class="toolbar">
						
						<div class="input inline alignleft">Digite un Producto</div>
	                    <input type="text" class="text autocomplete" size="20" name="product" id="product" />

						<input type="submit" class="btn" value="Consultar" name="bt-consulta" />
					</div>

            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Producto</th>
                    <th>Cantidad</th>
                </tr></thead><tbody>
                <?php

				
					if($product_id!= ''){
					$query="SELECT COUNT(*) AS cont FROM products_donations WHERE products_id=".$product_id." AND state = 1 ";	
					$conts = runQuery($query);
					$numRows = mysql_num_rows($conts);
					if($numRows > 0){
						while($cont = mysql_fetch_array($conts)){
				
				?>
                <tr>
                	<td><?php echo $product_name;?></td>
                    <td><?php echo $cont['cont']; ?></td>
                </tr>
                <?php
							
				
						}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
				?>
            </tbody></table>
            </form>       
            
   			<h2>Productos por Bodega</h2>
            <form name="datos" action="reports.php" method="post" enctype="application/x-www-form-urlencoded">
					<div class="toolbar">
						
						<div class="input inline alignleft">Seleccione una Bodega</div>
						<select name="warehouse" id="warehouse">
                        		
							<?php 
							$query = "select * from warehouses";
							$warehouses = runQuery($query);
							$numRows = mysql_num_rows($warehouses);
							if($numRows > 0){
							while($warehouse = mysql_fetch_array($warehouses)){
							?>
							<option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['name']; ?></option>
							<?php } 
							}
							?>
						</select>
						<input type="submit" class="btn" value="Consultar" name="bt-consulta" />
					</div>

            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Producto</th>
                    <th>Cantidad</th>
                </tr></thead><tbody>
                <?php

					
					if($warehouse_id){
					$query = "SELECT COUNT(*) AS cont, products_id FROM products_donations WHERE warehouses_id=".$warehouse_id." AND state=1 GROUP BY products_id";
	
	
					$warehouses = runQuery($query);
					

					$numRows = mysql_num_rows($warehouses);
					if($numRows > 0){
						while($warehouse = mysql_fetch_array($warehouses)){
				
				?>
                <tr>
                	<td><?php $product_name = getTable('products',"id = $warehouse[products_id]",'',1);
					echo $product_name['name']; ?></td>
                    <td><?php echo $warehouse['cont']; ?></td>
                </tr>
                <?php
							
				
						}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
	
				?>
            </tbody></table>
            </form>       

   			<h2>Productos por Compañia</h2>
            <form name="datos" action="reports.php" method="post" enctype="application/x-www-form-urlencoded">
					<div class="toolbar">
						<div class="input inline alignleft">Seleccione un operador Comercial</div>
						<select name="compan_ware" id="compan_ware">
                        		
							<?php 
							$query = "select * from companies where type=1";
							$companies = runQuery($query);
							$numRows = mysql_num_rows($companies);
							if($numRows > 0){
							while($company = mysql_fetch_array($companies)){
							?>
							<option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
							<?php } 
							}
							?>
						</select>

						<input type="submit" class="btn" value="Consultar" name="bt-consulta" />
					</div>

            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Producto</th>
                    <th>Cantidad</th>
                    <th>Bodega</th>
                </tr></thead><tbody>
                <?php

					
					if($company_warehouse_id){
					$query = "SELECT COUNT(*) AS cont, products_id,name FROM products_donations,warehouses w WHERE warehouses_id=w.id and companies_id=".$company_warehouse_id." AND state=1 GROUP BY products_id";
	
	
					$warehouses = runQuery($query);
					

					$numRows = mysql_num_rows($warehouses);
					if($numRows > 0){
						while($warehouse = mysql_fetch_array($warehouses)){
				
				?>
                <tr>
                	<td><?php $product_name = getTable('products',"id = $warehouse[products_id]",'',1);
					echo $product_name['name']; ?></td>
                    <td><?php echo $warehouse['cont']; ?></td>
                    <td><?php echo $warehouse['name']; ?></td>
                </tr>
                <?php
							
				
						}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
	
				?>
            </tbody></table>
            </form>       


 
		<script>
		var data = [<?php echo $data; ?>];
		$('#product').autocomplete({
			source: data,
			mustMatch: true,
			select: function(event, ui){
				$('#add').show();
			}
		});
		</script>


<?php include('includes/footer.php'); ?>