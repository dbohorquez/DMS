<?php $section = 'inicio'; ?>
<?php include('includes/header.php'); ?>
			<h2>Bienvenido</h2>
   			<h2>Puntos de Reorden</h2>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Producto</th>
                    <th>Bodega</th>
                    <th>Punto de Reorden</th>
                    <th>Cantidad en Bodega</th>
                </tr></thead><tbody>
                <?php

					$query = "SELECT p.id,name,quantity FROM products p,products_checkpoint c WHERE p.deletedAt IS NULL AND c.deletedAt IS NULL AND product_id=p.id";
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
<?php include('includes/footer.php'); ?>