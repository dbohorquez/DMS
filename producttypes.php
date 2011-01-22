<?php $section = 'product-types'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addProductType($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editProductType($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Tipos de Productos</h2>
			<ul class="toolbar">
            	<?php 
				$rol=isAnyRol($_SESSION['dms_id']);
				if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
                <li><a href="includes/forms/productTypesAdd.php" class="btn colorbox">Agregar Tipo</a></li>
	            <?php } ?>
    
            </ul>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$producttypes = getTable('producttypes','deletedAt IS NULL','id desc');
					$numRows = mysql_num_rows($producttypes);
					if($numRows > 0){
						while($producttype = mysql_fetch_array($producttypes)){
				?>
                <tr>
                	<td><?php echo $producttype['name']; ?></td>
                    <td><?php echo $producttype['description']; ?></td>
                    <td><?php 
						echo findRow('categories','id',$producttype['categories_id'],'name');							
					?></td>
                    <td>
                    <?php if($rol== 1 || $rol== 3 || $rol== 5 || $rol== 6){?>
	            	<ul class="table-actions">
                        	<li><a href="includes/forms/productTypesEdit.php?e=<?php echo $producttype['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=producttypes&d=<?php echo $producttype['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
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