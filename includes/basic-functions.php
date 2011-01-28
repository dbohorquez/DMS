<?php
/* Database
============================================================ */

function getTable($table,$condition = '',$order = '',$limit = ''){
	$return = $limit == '1' ? 1 : 0;
	$condition = $condition != '' ? ' where ' . $condition : '';
	$order = $order != '' ? ' order by ' . $order : '';
	$limit = $limit != '' ? ' limit ' . $limit : '';
	$query = "select * from $table $condition $order $limit";
	return runQuery($query,$return);
}

function dbInsert($table,$data){
	//$data: Array de campos con sus respectivos valores
	
	$fields  = "";
	$values = "";

	foreach ($data as $f => $v){
		$fields  .= "$f,";
		$values .= (is_numeric($v) && (intval($v) == $v)) ? $v."," : "'$v',";
	}

	//Eliminar las "," sobrantes
	$fields = substr($fields, 0, -1);
	$values = substr($values, 0, -1);

	$query = "insert into " . $table . "({$fields}) values({$values})";
	echo $query;
	return runQuery($query,3);
}

function dbDelete($table,$condition,$limit = ''){
	$limit = ($limit == '') ? '' : ' limit ' . $limit;
	$query = "delete from {$table} where {$condition} {$limit}";
	return runQuery($query);
}

function dbUpdate($table,$changes,$condition){
	//$changes: Array de campos con sus respectivos valores
	
	$query = "update " . $table . " set ";
	
	foreach($changes as $field => $value){
		$query .= $field . "='{$value}',";
	}

	//Eliminar las "," sobrantes
	$query = substr($query, 0, -1);
	if($condition != '') $query .= " where " . $condition;
	return runQuery($query);
}

function runQuery($query,$return = 0){
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

function exists($table,$condition){
	$query = "select * from " . $table . " where " . $condition;
	$result = runQuery($query);
	if(mysql_num_rows($result) == 0){
		return false;
	}else{
		$row = mysql_fetch_array($result);
		return $row['id'];
	}
}

/* Various
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