<div class="narrow">
	<?php 
		$id = $_GET['d'];
		$table = $_GET['t'];
		$action = $table;
		if($table == 'towns' || $table == 'users') $action = 'options';
		if($table == 'distributions') $action = 'distribution';
	?>
	<h3>Eliminar</h3>
    <form action="<?php echo $action; ?>.php" enctype="application/x-www-form-urlencoded" method="post">
    	<input type="hidden" id="table" name="table" value="<?php echo $table; ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <p>¿Desea eliminar el elemento seleccionado?</p>
        <input type="submit" class="btn clear" value="Eliminar" name="bt-delete" /><span class="cancel">o <a href="javascript:void(0);" onClick="$.colorbox.close()">Cancelar</a></span>
    </form>
</div>