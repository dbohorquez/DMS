<?php $section = 'distribution'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addDistribution($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editDistribution($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Distribución</h2>
    
			<ul class="toolbar">
	            <?php if(isAnyRol($_SESSION['dms_id'])== 1 || isAnyRol($_SESSION['dms_id'])== 2){?>
                <li><a href="includes/forms/distributionsAdd.php" class="btn colorbox">Nueva Distribución</a></li>
				<?php } ?>
            </ul>			
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Canal</th>
                    <th>Bodega</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$distributions = getTable('distributions','deletedAt IS NULL','id desc');
					$numRows = mysql_num_rows($distributions);
					if($numRows > 0){
						while($distribution = mysql_fetch_array($distributions)){
							$company = getTable('companies',"id = $distribution[companies_id]",'',1);
							$warehouse = getTable('warehouses',"id = $distribution[warehouses_id]",'',1);
				?>
                <tr>
                	<td><?php echo $company['name']; ?></td>
                    <td><?php echo $warehouse['name']; ?></td>
                    <td><?php echo formatDate($distribution['deliveryDate']); ?></td>
                    <td><ul class="kit-product-list">
						<?php
							$products = getDistributionProducts($distribution['id']);
							while($product = mysql_fetch_array($products)){
								echo  '<li>' . $product['name'] . ' <strong>(x' . $product['quantity'] . ')</strong></li>';
							}
						?>
                    </ul></td>
                    <td>
                    <?php if(isAnyRol($_SESSION['dms_id'])== 1 || isAnyRol($_SESSION['dms_id'])== 2){?>
                    	<ul class="table-actions">
                        	<li><a href="includes/forms/distributionsEdit.php?e=<?php echo $distribution['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=distributions&d=<?php echo $distribution['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
                        </ul>

					<?php } ?>
                    </td>
                </tr>
                <?php
						}
					}else{
						echo '<tr><td colspan="5">No hay datos para mostrar</td></tr>';
					}
				?>
            </tbody></table>
            <ul id="pagination">
                <li class="prev"><a href="javascript:void(0);">&laquo;</a></li>
                <li class="next"><a href="javascript:void(0);">&raquo;</a></li>
                <li class="floatright">Mostrar: 
                    <select class="pagesize">
                        <option selected="selected" value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </li>
            </ul>
<?php include('includes/footer.php'); ?>