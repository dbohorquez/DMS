<?php $section = 'kits'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addKit($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editKit($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Kits</h2>
			<ul class="toolbar">
                 <?php 
				 $rol=isAnyRol($_SESSION['dms_id']);
				 if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
            	<li><a href="includes/forms/kitsAdd.php" class="btn colorbox">Agregar Kit</a></li>
          		<?php } ?>
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Nombre</th>
                    <th>Productos</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$kits = getTable('kits','deletedAt IS NULL','id desc');
					$numRows = mysql_num_rows($kits);
					if($numRows > 0){
						while($kit = mysql_fetch_array($kits)){
				?>
                <tr>
                	<td><?php echo $kit['name']; ?></td>
                    <td><ul class="kit-product-list">
						<?php
							$products = getKitProducts($kit['id']);
							while($product = mysql_fetch_array($products)){
								echo  '<li>' . $product['name'] . ' <strong>(x' . $product['quantity'] . ')</strong></li>';
							}
						?>
                    </ul></td>
                    <td>
                    <?php if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
		        	<ul class="table-actions">
                        	<li><a href="includes/forms/kitsEdit.php?e=<?php echo $kit['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=kits&d=<?php echo $kit['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
                        </ul>
	          		<?php } ?>
            
                    </td>
                </tr>
                <?php
						}
					}else{
						echo '<tr><td colspan="3">No hay datos para mostrar</td></tr>';
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