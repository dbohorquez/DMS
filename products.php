<?php $section = 'products'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addProduct($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editProduct($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Productos</h2>
			<ul class="toolbar">
            <?php if(isAnyRol($_SESSION['dms_id'])== 1 || isAnyRol($_SESSION['dms_id'])== 3){?>
            	<li><a href="includes/forms/productsAdd.php" class="btn colorbox">Agregar Producto</a></li>
            <?php } ?>
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Nombre</th>
                    <th>Tipo</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$products = getTable('products','flagkit=0 and deletedAt IS NULL','id desc');
					$numRows = mysql_num_rows($products);
					if($numRows > 0){
						while($product = mysql_fetch_array($products)){
				?>
                <tr>
                	<td><?php echo $product['name']; ?></td>
                    <td><?php 
						echo findRow('producttypes','id',$product['productTypes_id'],'name');							
					?></td>
                    <td>
                    <?php if(isAnyRol($_SESSION['dms_id'])== 1 || isAnyRol($_SESSION['dms_id'])== 3){?>
	            	<ul class="table-actions">
                        	<li><a href="includes/forms/productsEdit.php?e=<?php echo $product['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=products&d=<?php echo $product['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
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