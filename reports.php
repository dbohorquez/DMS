<?php $section = 'inicio'; ?>
<?php include('includes/header.php'); ?>
<?php 
	$company_id = $_POST['compan']; 
	$warehouse_id = $_POST['warehouse']; 
	$product_name = $_POST['product']; 
	$company_warehouse_id = $_POST['compan_ware']; 
	$donor_id = $_POST['donorId']; 
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
			<h2>Reportes y Consultas</h2>
      <?php if(!isset($_GET['r'])){ ?>
      <ul>
        <li><a href="reports.php?r=1">Puntos de Reorden de Atención Crítica</a></li>
        <li><a href="reports.php?r=2">Solicitudes a Operadores Comerciales</a></li>
        <li><a href="reports.php?r=3">Productos en Bodega</a></li>
        <li><a href="reports.php?r=4">Productos por Bodega</a></li>
        <li><a href="reports.php?r=5">Productos por Compañía</a></li>
        <li><a href="reports.php?r=6">Información de Donantes</a></li>
      </ul>
      <?php }else{ ?>
      <?php if($_GET['r'] == 1){ ?>
   		<h3>Puntos de Reorden de Atención Crítica</h3>
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
        <?php }elseif($_GET['r'] == 2){ ?> 
   			<h3>Solicitudes a Operadores Comerciales</h3>
            <form name="datos" action="reports.php?r=2" method="post" enctype="application/x-www-form-urlencoded">
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
				<?php }elseif($_GET['r'] == 3){ ?> 
   			<h3>Productos en Bodega</h3>
            <form name="datos" action="reports.php?r=3" method="post" enctype="application/x-www-form-urlencoded">
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
        <?php }elseif($_GET['r'] == 4){ ?>   
   			<h3>Productos por Bodega</h3>
            <form name="datos" action="reports.php?r=4" method="post" enctype="application/x-www-form-urlencoded">
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
				<?php }elseif($_GET['r'] == 5){ ?> 
   			<h3>Productos por Compañía</h3>
            <form name="datos" action="reports.php?r=5" method="post" enctype="application/x-www-form-urlencoded">
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
				<?php }elseif($_GET['r'] == 6){ ?> 
        <h3>Información de Donantes</h3>
            <form name="datos" action="reports.php?r=6" method="post" enctype="application/x-www-form-urlencoded">
					<div class="toolbar">
						
						<label for="donorId">Número de Identificación:</label><input type="text" class="text autocomplete" id="donorId" name="donorId" />
						<input type="submit" class="btn" value="Consultar" name="bt-consulta" />
					</div>

            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Consecutivo</th>
                	<th>Donante</th>
                    <th>Bodega</th>
                    <th>Detalles</th>
                </tr></thead><tbody>
                <?php

				
					if($donor_id!= ''){
						$query="SELECT * FROM donations WHERE donors_id=".$donor_id;
						$donations = runQuery($query);
						$numRows = mysql_num_rows($donations);
						if($numRows > 0){
							while($donation = mysql_fetch_array($donations)){
								$donor = getTable('donors',"id = $donation[donors_id]",'',1);
								$location = getItemLocation('donors',$donor['id']);
								$types = array("","C.C.","C.E.","NIT");
								$warehouse = getTable('warehouses',"id = $donation[warehouses_id]",'',1);
				?>
                <tr>
                	<td><?php echo $donation['sequence']; ?></td>
                    <td><?php echo $donor['name']; ?> (<?php echo $types[$donor['type']] . ': ' . $donor['id']; ?>)</td>
                    <td><?php echo $warehouse['name']; ?><br />
					<?php echo formatDate($donation['date']); ?></td>
                    <td><?php echo $donation['bill'] != '' ? '<strong>Factura:</strong> ' . $donation['bill'] . '<br />' : ''; ?><?php echo $donation['detail']; ?>                </tr>
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
            <?php } ?>
            <?php } ?>   
		<?php
                $donors = getTable('donors','','id asc');
                $ddata = '';
                while($donor = mysql_fetch_array($donors)){
                    $ddata .= '"' . $donor['id'] . '",';
				}
        ?>
		<script>
		var data = [<?php echo $data; ?>];
		var ddata = [<?php echo $ddata; ?>];
				$('#donorId').autocomplete({
					source: ddata
				});
		$('#product').autocomplete({
			source: data,
			mustMatch: true,
			select: function(event, ui){
				$('#add').show();
			}
		});
		</script>


<?php include('includes/footer.php'); ?>