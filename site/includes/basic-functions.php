<?php
/* Database
============================================================ */

function getTable($table,$condition = '',$order = '',$limit = ''){
	$return = $limit == '1' ? 1 : 0;
	$condition = $condition != '' ? ' where ' . $condition : '';
	$order = $order != '' ? ' order by ' . $order : '';
	$limit = $limit != '' ? ' limit ' . $limit : '';
	$query = "select * from $table $condition $order $limit";
	return ejecutarQuery($query,$return);
}

function dbInsert($tabla,$datos){
	//$datos: Array de campos con sus respectivos valores
	
	$campos  = "";
	$valores = "";

	foreach ($datos as $f => $v){
		$campos  .= "$f,";
		$valores .= (is_numeric($v) && (intval($v) == $v)) ? $v."," : "'$v',";
	}

	//Eliminar las "," sobrantes
	$campos = substr($campos, 0, -1);
	$valores = substr($valores, 0, -1);

	$query = "insert into " . $tabla . "({$campos}) values({$valores})";
	return ejecutarQuery($query,3);
}

function dbDelete($tabla,$condicion,$limite = ''){
	$limite = ($limite == '') ? '' : ' limit ' . $limite;
	$query = "delete from {$tabla} where {$condicion} {$limite}";
	return ejecutarQuery($query);
}

function dbUpdate($tabla,$cambios,$condicion){
	//$cambios: Array de campos con sus respectivos valores
	
	$query = "update " . $tabla . " set ";
	
	foreach($cambios as $campo => $valor){
		$query .= $campo . "='{$valor}',";
	}

	//Eliminar las "," sobrantes
	$query = substr($query, 0, -1);
	
	if($condicion != '') $query .= " where " . $condicion;
	return ejecutarQuery($query);
}

function ejecutarQuery($query,$return = 0){
	/*$return: 
		0 => Devuelve el resultado de la query
		1 => Devuelve la primera fila del resultado
		2 => Devuelve el número de filas del resultado
		3 => Devuelve el ID insertado
	*/
	include('settings.php');
	$connection = mysql_connect($dbHost,$dbUsername,$dbPassword);
	mysql_select_db($dbDatabase);
	$result = mysql_query($query,$connection);
	if($result){
		if($return == 1){
			$row = mysql_fetch_array($result);
			return $row;
		}elseif($return == 2){
			$num = mysql_num_rows($result);
			return $num;
		}elseif($return == 3){
			$id = mysql_insert_id($connection);
			return $id;
		}else{
			return $result;
		}
	}else{
		return false;
	}
	mysql_close($connection);
}

function existe($tabla,$condicion){
	$query = "select * from " . $tabla . " where " . $condicion;
	$result = ejecutarQuery($query);
	if(mysql_num_rows($result) == 0){
		return false;
	}else{
		$row = mysql_fetch_array($result);
		return $row['id'];
	}
}

/* Forms
============================================================ */

function fInput($type,$name,$label = '',$value = '',$required = 0,$size = '',$parameters = ''){
	if($required != 0) $required = ' required="required"'; else $required = '';
	if($size != '') $size = ' size="' . $size . '"';
	if($label != '') echo '<label for="' . $name . '">' . $label . '</label>';
	echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" value="' . $value . '"' . $required . $size . ' ' . $parameters . ' />';
}

function fTextarea($name,$label = '',$value = '',$cols = '',$rows = '',$required = 0,$parameters = ''){
	if($required != 0) $required = ' required="required"'; else $required = '';
	$cols = ($cols == '') ? '' : ' cols="' . $cols . '"';
	$rows = ($rows == '') ? '' : ' rows="' . $rows . '"';
	if($label != '') echo '<label for="' . $name . '">' . $label . '</label>';
	echo '<textarea name="' . $name . '" id="' . $name . '"' . $size . $rows . $cols . $required . ' ' . $parameters . '>' . $value . '</textarea>';
}

function fCheckbox($name,$value,$label = '',$checked = 0,$onclick = '',$class = ''){
	if($checked != 0) $checked = ' checked="checked"';
	if($onclick != '') $onclick = ' onclick="' . $onclick . '"';
	if($class != '') $class = ' class="' . $class . '"';
	echo '<input type="checkbox" name="' . $name . '" id="' . $name . '" value="' . $value . '"' . $class . $checked . $onclick . ' />';
	if($label != '') echo '<label for="' . $name . '">' . $label . '</label>';
}

function fDate($nameD,$nameM,$nameY,$label = '',$valueD = '',$valueM = '',$valueY = '',$nameH = '',$nameI = '', $nameS = '', $valueH = '', $valueI = '', $valueS = ''){
	if($label != '') echo '<label for="' . $nameD . '">' . $label . '</label>';
	echo '<select name="' . $nameD . '" id="' . $nameD . '">';
	for($i=1;$i<=31;$i++){
		$sel = '';
		if($i<10){
			if($valueD == '0' . $i) { $sel = ' selected="selected"'; }
			echo '<option value="0' . $i . '"' . $sel . '>0' . $i . '</option>';
		}else{
			if($valueD == $i) { $sel = ' selected="selected"'; }
			echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
		}
	}
	echo '</select>';
	echo '<select name="' . $nameM . '" id="' . $nameM . '">';
	$opt = array('01','02','03','04','05','06','07','08','09','10','11','12');
	$lbl = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	for($i=0;$i<count($opt);$i++){
		$sel = '';
		if($valueM == $opt[$i]) { $sel = ' selected="selected"'; }
		echo '<option value="' . $opt[$i] . '"'. $sel . '>' . $lbl[$i] . '</option>';
	}
	echo '</select>';
	echo '<select name="' . $nameY . '" id="' . $nameY . '">';
	for($i=date('Y');$i>=1910;$i--){
		$sel = '';
		if($valueY == $i){ $sel = ' selected="selected"'; }
		echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
	}
	echo '</select>';
	if($nameH != '' && $nameI != ''){ fTime($nameH,$nameI,$nameS,'',$valueH,$valueI,$valueS); }
}

function fTime($nameH,$nameM,$nameS,$label = '',$valueH = '',$valueM = '',$valueS = ''){
	if($label != '') echo '<label for="' . $nameH . '">' . $label . '</label>';
	echo '<select name="' . $nameH . '" id="' . $nameH . '">';
	for($i=0;$i<=23;$i++){
		$sel = '';
		if($i<10){
			if($valueH == '0' . $i) { $sel = ' selected="selected"'; }
			echo '<option value="0' . $i . '"' . $sel . '>0' . $i . '</option>';
		}else{
			if($valueH == $i) { $sel = ' selected="selected"'; }
			echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
		}
	}
	echo '</select>';
	
	if($nameM != ''){
		echo ' :<select name="' . $nameM . '" id="' . $nameM . '">';
		for($i=0;$i<=59;$i++){
			$sel = '';
			if($i<10){
				if($valueM == '0' . $i) { $sel = ' selected="selected"'; }
				echo '<option value="0' . $i . '"' . $sel . '>0' . $i . '</option>';
			}else{
				if($valueM == $i) { $sel = ' selected="selected"'; }
				echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
			}
		}
		echo '</select>';
	}
	
	if($nameS != ''){
		echo ' :<select name="' . $nameS . '" id="' . $nameS . '">';
		for($i=0;$i<=59;$i++){
			$sel = '';
			if($i<10){
				if($valueS == '0' . $i) { $sel = ' selected="selected"'; }
				echo '<option value="0' . $i . '"' . $sel . '>0' . $i . '</option>';
			}else{
				if($valueS == $i) { $sel = ' selected="selected"'; }
				echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
			}
		}
		echo '</select>';
	}
}

/* Misc
============================================================ */
function makeAlias($name){
	$alias = utf8_encode(strtolower(utf8_decode($name)));
	$alias = str_replace(' - ','-',$alias);	
	$alias = str_replace(' ','-',$alias);
	$alias = str_replace('&nbsp;','-',$alias);
	$accent = array('á','é','í','ó','ú','ñ');
	$accent_rep = array('a','e','i','o','u','n');
	$alias = str_replace($accent,$accent_rep,$alias);		
	$alias = preg_replace('/[^a-z0-9._-]/','',$alias);
	return $alias;
}

function formatDate($date,$format = 0){
	$y = substr($date,0,4);
	$m = substr($date,5,2);
	$d = substr($date,8,2);
	if($format == 0){
		$mes = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	}else{
		$mes = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	}
	$nmes = array('01','02','03','04','05','06','07','08','09','10','11','12');
	$m = str_replace($nmes,$mes,$m);
	
	$fecha = $m.' '.$d;
	if($format == 0 || $format == 2){ $fecha = $m.' '.$d.' de '.$y; }
	
	if(substr($date,11,8)!=''){
		$h = substr($date,11,2);
		$i = substr($date,14,2);
		$a = 'pm';
		if($h < 12){ $a = 'am'; }
		if($h == 0){ $h = 12; }
		if($h > 12){ $h -= 12; }		
		$fecha .= ', '.$h.':'.$i.' '.$a;
	}
	
	return $fecha;
}//End Function formatDate

function getMonth($month,$format = 0){
	if($format == 0){
		$mes = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	}else{
		$mes = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	}
	$nmes = array('01','02','03','04','05','06','07','08','09','10','11','12');
	return str_replace($nmes,$mes,$month);
}

function getWeekDay($day,$format = 0){
	if($format == 0){
		$weekday = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
	}else{
		$weekday = array('Dom','Lun','Mar','Mié','Jue','Vie','Sáb');
	}
	return $weekday[$day];
}

function getAge($birthdate,$date = ''){
	if($date == ''){ $date = date('Y-m-d'); }
	$date = mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
	$birthdate = mktime(0,0,0,substr($birthdate,5,2),substr($birthdate,8,2),substr($birthdate,0,4));
	return intval(($date-$birthdate)/(60*60*24*365));
}
?>