<?php $section = 'donations'; ?>
<?php include('includes/header.php'); ?>

<?php if(isset($_POST['bt-add'])) list($warning, $success) = addDonationCheckin($_POST);?>
<?php if(isset($_POST['bt-edit'])) list($warning, $success) = editDonationCheckin($_POST);?>
<?php if(isset($_POST['bt-verify'])) list($warning, $success) = verifyDonationPromise($_POST);?>
<?php if(isset($_POST['bt-delete'])) list($warning, $success) = delete($_POST);?>

			<h2>Comprobante de Donación Virtual</h2>
			
			  <div class="column c50p">
            <ul class="toolbar">
            	<?php 
			$rol=isAnyRol($_SESSION['dms_id']);
			if($rol== 1){?>
            <li><label for="donorId">Número de Identificación:</label><input type="text" class="text autocomplete" id="donorId" />
                <a href="javascript:void(0);" class="btn" onclick="var href = 'includes/forms/donationCheckinAdd.php?d=' + $('#donorId').attr('value'); $.colorbox({href:href});">Agregar Comprobante</a></li>
			<?php } ?>
            </ul>
        </div>
        <div class="column c50p last">
            <ul class="toolbar">
                <?php if($rol== 1){?>
                <li><label for="sequence">Número de Consecutivo:</label><input type="text" class="text autocomplete" id="sequence" />
                <a href="javascript:void(0);" class="btn" onclick="var href = 'includes/forms/donationCheckinEdit.php?e=' + $('#sequence').attr('value'); $.colorbox({href:href});">Editar Comprobante</a></li>
			<?php } ?>
            </ul>
        </div>
            <?php if($success != ''){ echo '<div class="success">' . $success . '</div>'; } ?>
			<?php if($warning != ''){ echo '<div class="error">' . $warning . '</div>'; } ?>
            <table cellpadding="0" cellspacing="0"><thead>
            	<tr>
                	<th>Consecutivo</th>
                	<th>Donante</th>
                  <th>Factura</th>
                  <th>Operadores</th>
									<th>Fecha Recibo</th>
									<th>Detalles</th>
                  <th width="60">&nbsp;</th>
                </tr></thead><tbody>
                <?php
									$donations = getTable('vouchers','deletedAt IS NULL and state=0','id asc');
									$numRows = mysql_num_rows($donations);
									$ddata = '';
									if($numRows > 0){
										while($voucher = mysql_fetch_array($donations)){
											$ddata .= '"' . $voucher['id'] . '",';
											$donor = getTable('donors',"id = $voucher[donors_id]",'',1);
											$location = getItemLocation('donors',$donor['id']);
											$types = array("","C.C.","C.E.","NIT");
											$company = getTable('companies',"id = $voucher[company_id]",'',1);
								?>
                <tr>
                		<td><?php echo $voucher['id']; ?></td>
                    <td><?php echo $donor['name']; ?> (<?php echo $types[$donor['type']] . ': ' . $donor['id']; ?>)</td>
                    <td><?php echo $voucher['bill']; ?></td>
										<td><?php echo $company['name']; ?></td>
										<td><?php echo formatDate($voucher['date']); ?></td>
										<td><?php echo $voucher['detail']; ?></td>
                    <td>
                    	<ul class="table-actions">
	                        <li><a href="includes/forms/donationCheckinReceive.php?r=<?php echo $voucher['id']; ?>" class="icon check colorbox" title="Recibir"><span>Recibir</span></a></li>
                        	<li><a href="includes/forms/donationCheckinEdit.php?e=<?php echo $voucher['id']; ?>" class="icon edit colorbox" title="Editar"><span>Editar</span></a></li>
                            <li><a href="includes/forms/delete.php?t=donation-checkin&d=<?php echo $voucher['id']; ?>" class="icon delete colorbox" title="Eliminar"><span>Eliminar</span></a></li>
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