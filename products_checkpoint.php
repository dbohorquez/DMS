<?php $section = 'warehouses'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addCheckpoint($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editCheckpoint($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Puntos de Reorden</h2>
			<ul class="toolbar">
                 <?php 
				 $rol=isAnyRol($_SESSION['dms_id']);
				 if($rol== 1){?>
            	<li><a href="includes/forms/checkpointsAdd.php?us=<?php echo $_SESSION['dms_id']?>" class="btn colorbox">Agregar Punto de Reorden</a></li>
          		<?php } ?>
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Producto</th>
                    <th>Cantidad</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$checkpoints = getTable('products_checkpoint','deletedAt IS NULL','id desc');
					$numRows = mysql_num_rows($checkpoints);
					if($numRows > 0){
						while($checkpoint = mysql_fetch_array($checkpoints)){
				?>
                <tr>
                	<td><?php 
					echo findRow("products","id",$checkpoint['product_id'],"name");
					 ?></td>
                    <td><?php echo $checkpoint['quantity']; ?></td>
                    <td>
                    <?php if($rol== 1){?>
		        	<ul class="table-actions">
                        	<li><a href="includes/forms/checkpointsEdit.php?e=<?php echo $checkpoint['id']; ?>&us=<?php echo $_SESSION['dms_id']?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=products_checkpoint&d=<?php echo $checkpoint['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
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