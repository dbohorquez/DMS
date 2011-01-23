<?php $section = 'donations'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addvirtualDonation($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editvirtualDonation($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>
			<h2>Donaciones Virtuales</h2>
            <div class="column c50p">
                <ul class="toolbar">
                <?php 
				$rol=isAnyRol($_SESSION['dms_id']);
				if($rol== 1){?>
                <li><a href="includes/forms/virtualreceptionAdd.php" class="btn colorbox">Nueva donación virtual</a></li>    
				<?php } ?>

                </ul>
            </div>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Consecutivo</th>
                	<th>Donante</th>
                    <th>Bodega</th>
                    <th>Detalles</th>
                    <th width="50">&nbsp;</th>
                </tr></thead><tbody>
                <?php
					$donations = getTable('donations d,warehouses w','d.deletedAt IS NULL and w.type=2 and w.id=warehouses_id','sequence asc');
					$numRows = mysql_num_rows($donations);
					$ddata = '';
					if($numRows > 0){
						while($donation = mysql_fetch_array($donations)){
							$ddata .= '"' . $donation['sequence'] . '",';
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
                    <td><?php echo $donation['bill'] != '' ? '<strong>Factura:</strong> ' . $donation['bill'] . '<br />' : ''; ?><?php echo $donation['detail']; ?></td>
                    <td>
                    	<ul class="table-actions">
                        	<li><a href="includes/forms/donationsEdit.php?e=<?php echo $donation['sequence']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=donations&d=<?php echo $donation['sequence']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
                        </ul>
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
			<?php
                $donors = getTable('donors','','id asc');
                $data = '';
                while($donor = mysql_fetch_array($donors)){
                    $data .= '"' . $donor['id'] . '",';
				}
            ?>
            <script type="text/javascript">
				var data = [<?php echo $data; ?>];
				var ddata = [<?php echo $ddata; ?>];
				$('#donorId').autocomplete({
					source: data
				});
				$('#sequence').autocomplete({
					source: ddata
				});
			</script>
<?php include('includes/footer.php'); ?>