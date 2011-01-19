<?php
require_once('basic-functions.php');

/* General 
============================================================ */
function delete($data){
	//if(dbDelete($data['table'],"id = $data[id]")){
	$currentdate = date("Y-m-d H:i");										
	$datos = array(deletedAt=> $currentdate);
	if(dbUpdate($data['table'],$datos,"id= $data[id]")){	
		$success = "El elemento fue eliminado.";
	}else{
		$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
	}
	return array($warning, $success);
}
function checkMail($mail){ 
	if($mail !== ""){ 
		if(ereg("^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}([\;][-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5})*$", $mail)) {
			return true; 
		}else{ 
			return false; 
		}
	}else{ 
		return false; 
	}
}
function getDonationProducts($id){
	$query = "select p.*, pd.*, d.* from donations d, products_donations pd, products p where d.sequence = pd.donations_id and pd.products_id = p.id and d.sequence = $id group by p.id order by p.name asc";
	$products = runQuery($query);
	return $products;
}

function getDistributionProducts($id){
	$query = "select p.*, pd.*, pdd.*, d.*, count(p.id) quantity from distributions d, products_donations_distributions pdd, products_donations pd, products p where d.id = pdd.distributions_id and pdd.products_donations_id = pd.id and pd.products_id = p.id and d.id = $id group by p.id order by p.name asc";
	$products = runQuery($query);
	return $products;
}


function findRow($table,$identifier,$id,$field){
	$query = "select * from $table where $identifier=$id";
	$result = runQuery($query);
	if(mysql_num_rows($result) == 0){
		return false;
	}else{
		$row = mysql_fetch_array($result);
		return $row[$field];
	}
}

function getItemLocation($table,$id){
	$query = "select i.towns_id, t.name town, p.name province, p.id provinces_id from $table i join towns t on i.towns_id = t.id join provinces p on t.provinces_id = p.id where i.id = $id limit 1";
	$row = runQuery($query,1);
	return $row;
}

function importTowns($data,$file){

						if(is_uploaded_file($file['datos']['tmp_name'])){
							$archivo = $file['datos']['name'];
							$filetype = $file['datos']['type'];
							$filesize = $file['datos']['size'];
							if(!(($filetype == 'application/vnd.ms-excel' || $filetype == 'application/force-download') and ($filesize < 500000))){
								$warning = "El archivo debe ser .csv y debe tener un tamaño menor a 500 KB";
							}else{
								if(move_uploaded_file($file['datos']['tmp_name'], 'upload/' . $archivo)){
									chmod( 'upload/' . $archivo , 0777 ); 
								
								}
								
								$fp=fopen('upload/' .$archivo,"r") or die("Error al abrir el fichero");
								$line = fgets( $fp, 2024 );
								
								
								
								while(!feof($fp))
								{
								$datos = array(name => $line, provinces_id =>$data['province']);
								$line = fgets( $fp, 2024 );
								$id = dbInsert("towns",$datos);
								}
								fclose($fp);
							}
						}
						else
						{
							$warning = "No ha subido ningún archivo. Debe subir un archivo a importar.";
							}
	return array($warning, $success);
}
function isAdmin($user){
	$query = "select * from users where id=$user and profile='Administrador'";
	$nums_row=runQuery($query,2);
	
	if($nums_row>0)
		return true;
	else
		return false;
}

function isSupervisor($user){
	$query = "select * from users where id=$user and profile='Supervisor'";
	$nums_row=runQuery($query,2);
	
	if($nums_row>0)
		return true;
	else
		return false;
}

function isGestor($user){
	$query = "select * from users where id=$user and profile='Gestor'";
	$nums_row=runQuery($query,2);
	
	if($nums_row>0)
		return true;
	else
		return false;
}


/* Warehouses 
============================================================ */
function addWarehouse($data){	
	if($data['name'] != ""){
		if(checkmail($data['email']) or $data['email']==''){
		//if(is_numeric($data['phonenumber']) and is_numeric($data['cellphone']) and is_numeric($data['fax'])){
			if(is_numeric($data['occupation'])){ 
				if($data['occupation'] <= 100 and $data['occupation']>=0){ 	
					if(!exists("warehouses","name='$data[name]'")){
															
						$datos = array(name => $data['name'], type => $data['type'], description => $data['description'], address => $data['address'],occupation => $data['occupation'], contactName => $data['contactname'], phoneNumber => $data['phonenumber'], faxNumber => $data['fax'],cellphone => $data['cellphone'], towns_id =>$data['town'],email => $data['email']);
						if(dbInsert("warehouses",$datos)){
							$success = "La bodega fue agregada exitosamente.";
						}else{
							$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
						}
					}else{
						$warning = "Ya existe una bodega registrada con el nombre '$data[name]'.";
					}
				}else{
					$warning = "El porcentaje de ocupación de la bodega debe ubicarse entre los valores 0 y 100";
				}														
			}else{
				$warning = "El porcentaje de ocupación de la bodega debe ser numérico";
			}
		}else{
			$warning = "La dirección de correo electrónico no es válida.";
		}			
		/*}else{
			$warning = "Los números telefónicos no pueden contener letras o símbolos";
		}*/											
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

function editWarehouse($data){	
	if($data['name'] != ""){
		if(checkmail($data['email']) or $data['email']==''){
	//	if(is_numeric($data['phonenumber']) and is_numeric($data['cellphone']) and is_numeric($data['fax'])){
			if(is_numeric($data['occupation'])){ 
				if($data['occupation'] <= 100 and $data['occupation']>=0){ 	
					if((!exists("warehouses","name='$data[name]' ")) or (exists("warehouses","name='$data[name]'")==$data[id])){										
						$datos = array(name => $data['name'], type => $data['type'], description => $data['description'], address => $data['address'],occupation => $data['occupation'], contactname => $data['contactname'], phonenumber => $data['phonenumber'], faxnumber => $data['fax'],cellphone => $data['cellphone'], towns_id =>$data['town'],email => $data['email']);
						if(dbUpdate("warehouses",$datos,"id= $data[id]")){
							$success = "La bodega fue editada exitosamente.";
						}else{
							$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
						}
					}else{
						$warning = "Ya existe una bodega registrada con el nombre '$data[name]'.";
					}
				}else{
					$warning = "El porcentaje de ocupación de la bodega debe ubicarse entre los valores 0 y 100";
				}														
			}else{
				$warning = "El porcentaje de ocupación de la bodega debe ser numérico";
			}
		}else{
			$warning = "La dirección de correo electrónico no es válida.";
		}
		/*}else{
			$warning = "Los números telefónicos no pueden contener letras o símbolos";
		}	*/										
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

/* Companies 
============================================================ */
function addCompany($data){	
	if($data['name'] != "" and $data['nit'] != ""){
		if(checkmail($data['email']) or $data['email']==''){
		//if(is_numeric($data['phonenumber']) and is_numeric($data['fax'])){
			if(!exists("companies","name='$data[name]'")){
				$datos = array(id => $data['nit'], name => $data['name'], type => $data['type'], address => $data['address'], contactname => $data['contactname'], phonenumber => $data['phonenumber'], faxnumber => $data['fax'], email => $data['email'], towns_id =>$data['town']);
				$fields  = "";
				$values = "";
			
				foreach ($datos as $f => $v){
					$fields  .= "$f,";
					$values .= (is_numeric($v) && (intval($v) == $v)) ? $v."," : "'$v',";
				}
			
				$fields = substr($fields, 0, -1);
				$values = substr($values, 0, -1);
			
				$query = "insert into companies ({$fields}) values({$values})";
				$value = runQuery($query,4);
				if($value!=''){
					$success = "La entidad fue agregada exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning = "Ya existe una entidad registrada con el nombre '$data[name]'.";
			}
		}else{
			$warning = "La dirección de correo electrónico no es válida.";
		}
	/*	}else{
			$warning = "Los números telefónicos no pueden contener letras o símbolos";
		}		*/									
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

function editCompany($data){	
	if($data['name'] != "" and $data['nit'] != ""){
		if(checkmail($data['email']) or $data['email']==''){
	//	if(is_numeric($data['phonenumber']) and is_numeric($data['fax'])){
			if((!exists("companies","name='$data[name]' ")) or (exists("companies","name='$data[name]'")==$data[id])){										
				$datos = array(id=> $data['nit'],name => $data['name'], type => $data['type'], address => $data['address'], contactname => $data['contactname'], phonenumber => $data['phonenumber'], faxnumber => $data['fax'],email => $data['email'], towns_id =>$data['town']);
				if(dbUpdate("companies",$datos,"id= $data[id]")){
					$success = "La Entidad fue editada exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning = "Ya existe una entidad registrada con el nombre '$data[name]'.";
			}
		}else{
			$warning = "La dirección de correo electrónico no es válida.";
		}
		/*}else{
			$warning = "Los números telefónicos no pueden contener letras o símbolos";
		}*/											
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

/* Product Types 
============================================================ */
function addProductType($data){	
	if($data['name'] != ""){
		if(!exists("producttypes","name='$data[name]'")){
			
			if(exists("categories","name='$data[category]'"))
			{
					$category = exists("categories","name='$data[category]'");
					$datos = array(name => $data['name'],description => $data['description'], categories_id =>$category);
					if(dbInsert("producttypes",$datos)){
						$success = "El tipo de producto fue agregado exitosamente.";
					}else{
						$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
					}
			}else{
			$warning = "La categoría digitada no existe. Por favor intentelo nuevamente.";
			}
		}else{
			$warning = "Ya existe un tipo de producto registrado con el nombre '$data[name]'.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

function editProductType($data){	
	if($data['name'] != ""){
		if((!exists("producttypes","name='$data[name]' ")) or (exists("producttypes","name='$data[name]'")==$data[id])){										
			
			if(exists("categories","name='$data[category]'"))
			{
					$category = exists("categories","name='$data[category]'");
					$datos = array(name => $data['name'],description => $data['description'], categories_id =>$category);
					if(dbUpdate("producttypes",$datos,"id= $data[id]")){
						$success = "El tipo de producto fue editado exitosamente.";
					}else{
						$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
					}
			}else{
			$warning = "La categoría digitada no existe. Por favor intentelo nuevamente.";
			}
			
		}else{
			$warning = "Ya existe un tipo de producto registrado con el nombre '$data[name]'.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

/* Products 
============================================================ */
function addProduct($data){	
	if($data['name'] != ""){
		if(!exists("products","name='$data[name]'")){
			
			if(exists("producttypes","name='$data[type]'"))
			{
				$type = exists("producttypes","name='$data[type]'");									
				$datos = array(name => $data['name'], productTypes_id => $type, description => $data['description'],state => 1,flagkit => 0);
				if(dbInsert("products",$datos)){
					$success = "El Producto fue agregado exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}

			}else{
			$warning = "El tipo de producto digitado no existe. Por favor intentelo nuevamente.";
			}

		}else{
			$warning = "Ya existe una bodega registrada con el nombre '$data[name]'.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

function editProduct($data){	
	if($data['name'] != ""){
		if((!exists("products","name='$data[name]' ")) or (exists("products","name='$data[name]'")==$data[id])){										

			if(exists("producttypes","name='$data[type]'"))
			{
				$type = exists("producttypes","name='$data[type]'");
				$datos = array(name => $data['name'], productTypes_id => $type,description => $data['description'],state => 1,flagkit => 0);
				if(dbUpdate("products",$datos,"id= $data[id]")){
					$success = "El Producto fue editado exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
			$warning = "El tipo de producto digitado no existe. Por favor intentelo nuevamente.";
			}
			
		}else{
			$warning = "Ya existe un producto registrado con el nombre '$data[name]'.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
}

function transferProducts ($data){
	if($data['warehouse'] != "" ){
		$warehouse = exists("warehouses","id='$data[warehouse]'");	
		if($warehouse){
			$sw=false;
			foreach($data as $key => $value){
				if(substr($key,0,5) == 'hitem'){
					$sw=true;
					$qtyname = 'citem' . substr($key,-7);
					$qty = $data[$qtyname];
					$idp = findRow('products','name',"'".$value."'",'id');
					$query = "select * from products_donations where products_id=$idp and state in (1) order by expirationDate limit $qty";
					$result= runQuery($query);
					while($row = mysql_fetch_array($result)){
						$update=dbUpdate(products_donations,array(state => 2, warehouses_id => $warehouse),"id=$row[id]");
					}	
				}
			}
			if($sw){
				$success = "La traferencia fue  exitosa.";
			}else{
				$warning = "No agregó ningun producto para tranferir. Por favor inténtelo nuevamente.";
			}
		}else{
			$warning = "Hay datos que no existen, por favor verifique.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
}

/* Kits 
============================================================ */
function addKit($data){	
	if($data['name'] != ""){
		if(!exists("kits","name='$data[name]'")){
				if(validateExistenceKitProducts($data)){
				$datos = array(name => $data['name']);
				$id = dbInsert("kits",$datos);
				if($id != ''){
					foreach($data as $key => $value){
						if(substr($key,0,5) == 'hitem'){
							$qtyname = 'citem' . substr($key,-7);
							$qty = $data[$qtyname];
							$idp = findRow('products','name',"'".$value."'",'id');
							$datos = array(kits_id => $id, products_id =>$idp,quantity => $qty);
							$idlist = dbInsert("kits_products",$datos);
						}
					}
					$success = "El kit fue agregado exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning ="Un kit debe tener por lo menos dos productos, por favor verifique."; 
			}
		}else{
			$warning = "Ya existe un tipo de producto registrado con el nombre '$data[name]'.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

function editKit($data){	
	if($data['name'] != ""){
		if((!exists("kits","name='$data[name]' ")) or (exists("kits","name='$data[name]'")==$data['id'])){
			if(validateExistenceKitProducts($data)){
				$datos = array(name => $data['name']);
				$id = dbUpdate("kits",$datos,"id= $data[id]");
				if($id!=''){
					$query = "delete from kits_products where kits_id=$data[id]";
					$result = runQuery($query);	
					foreach($data as $key => $value){
						if(substr($key,0,5) == 'hitem'){
							$qtyname = 'citem' . substr($key,-7);
							$qty = $data[$qtyname];
							$idp = findRow('products','name',"'".$value."'",'id');
							$datos = array(kits_id => $data['id'], products_id =>$idp,quantity => $qty);
							$idlist = dbInsert("kits_products",$datos);
						}
					}
					$success = "El kit fue editado exitosamente.";
				
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning ="Un kit debe tener por lo menos dos productos, por favor verifique."; 
			}
		}else{
			$warning = "Ya existe un tipo de producto registrado con el nombre '$data[name]'.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

function getKitProducts($kit){
	$query = "select p.*, pk.*, k.name kitName from kits k, kits_products pk, products p where k.id = pk.kits_id and pk.products_id = p.id and k.id = $kit group by p.id order by p.name asc";
	$products = runQuery($query);
	return $products;
}
function validateExistenceKitProducts($data){
	$sw=0;
	foreach($data as $key => $value){
		if(substr($key,0,5) == 'hitem'){
			$sw++;
			$qtyname = 'citem' . substr($key,-7);
			$qty = $data[$qtyname];
			echo $qty;
			if($qty>1){
				$sw++;
			}	
		}
		if($sw>1){
			return true;
		}
	}
	return false;	
}

/* Donors
============================================================ */
function addDonor($data){	
	if($data['name'] != "" and $data['identification'] != ""){
		if(checkmail($data['email']) or $data['email']==''){
		//if(is_numeric($data['phonenumber']) and is_numeric($data['fax'])){
			if(!exists("donors","id='$data[identification]'")){
				$currentdate = date("Y-m-d");									
				$datos = array(id => $data['identification'], name => $data['name'], type => $data['type'], address => $data['address'], phonenumber => $data['phonenumber'], faxnumber => $data['fax'], email => $data['email'], towns_id =>$data['town'], creationDate => $currentdate);
				$fields  = "";
				$values = "";
			
				foreach ($datos as $f => $v){
					$fields  .= "$f,";
					$values .= (is_numeric($v) && (intval($v) == $v)) ? $v."," : "'$v',";
				}
			
				//Eliminar las "," sobrantes
				$fields = substr($fields, 0, -1);
				$values = substr($values, 0, -1);
			
				$query = "insert into donors ({$fields}) values({$values})";
				$value = runQuery($query,4);
				if($value != ''){
					$success = "El donante fue agregado exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning = "Ya existe un donante registrado con el id '$data[identification]'.";
			}
		}else{
			$warning = "La dirección de correo electrónico no es válida.";
		}
		/*}else{
			$warning = "Los números telefónicos no pueden contener letras o símbolos";
		}*/											
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
	
} 

function editDonor($data){	
	if($data['name'] != "" and $data['identification'] != ""){
		if(checkmail($data['email']) or $data['email']==''){
	//	if(is_numeric($data['phonenumber']) and is_numeric($data['fax'])){
			if((!exists("donors","name='$data[name]' ")) or (exists("donors","name='$data[name]'")==$data['id'])){										
				$datos = array(id => $data['identification'], name => $data['name'], type => $data['type'], address => $data['address'], phonenumber => $data['phonenumber'], faxnumber => $data['fax'], email => $data['email'], towns_id =>$data['town']);
				if(dbUpdate("donors",$datos,"id= $data[id]")){
					$success = "El donante fue editado exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning = "Ya existe un donante registrado con el id '$data[identification]'.";
			}
		}else{
			$warning = "La dirección de correo electrónico no es válida.";
		}
		/*}else{
			$warning = "Los números telefónicos no pueden contener letras o símbolos";
		}*/											
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

/* Donations
============================================================ */
function addDonation($data){	
	if($data['exists']=='false'){
		if($data['name'] != "" and $data['identification'] != ""){
		//	if(is_numeric($data['phonenumber']) and is_numeric($data['fax'])){
				if(!exists("donors","id='$data[identification]'")){
					if(validateExistenceProduct($data)){
						$currentdate = date("Y-m-d");									
						$datos = array(id => $data['identification'], name => $data['name'], type => $data['type'], address => $data['address'], phonenumber => $data['phonenumber'], faxnumber => $data['fax'], email => $data['email'], towns_id =>$data['town'], creationDate => $currentdate);
						$fields  = "";
						$values = "";
					
						foreach ($datos as $f => $v){
							$fields  .= "$f,";
							$values .= (is_numeric($v) && (intval($v) == $v)) ? $v."," : "'$v',";
						}
					
						//Eliminar las "," sobrantes
						$fields = substr($fields, 0, -1);
						$values = substr($values, 0, -1);
					
						$query = "insert into donors ({$fields}) values({$values})";
						
						$value = runQuery($query,4);
						if($value != ''){
							$success = "El donante fue agregado exitosamente. <br />";
						}else{
							$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
						}
					}else{
						$warning ="Se debe elegir por lo menos un producto, por favor verifique."; 
					}
				}else{
					$warning = "Ya existe un donante registrado con el id '$data[identification]'.";
				}
			/*}else{
				$warning = "Los números telefónicos no pueden contener letras o símbolos";
			}	*/										
		}else{
			$warning = "Por favor digite todos los datos obligatorios.";
		}
	}
	$currentdate = date("Y-m-d");
	$datos = array(donors_id =>$data['identification'],users_id => 1,warehouses_id => $data['warehouse'], date => $currentdate);
	$id = dbInsert("donations",$datos);
	if($id != ''){
		$success = $success."La donación fue ingresada exitosamente. El consecutivo asignado es ".$id;
	}else{
		$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
	}
	return array($warning, $success);
} 

function editDonation($data){
	if(validateExistenceProduct($data)){
		$datos = array(detail =>$data['detail'],warehouses_id => $data['warehouse'], bill => $data['bill']);
		if(dbUpdate("donations",$datos,"sequence= $data[id]")){
			$success = "La donación fue editada exitosamente.";
		}else{
			$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
		}
			foreach($data as $key => $value){
				if(substr($key,0,5) == 'hitem'){
					$qtyname = 'citem' . substr($key,-7);
					$edname = 'ditem' . substr($key,-7);
					$qty = $data[$qtyname];
					$expd = $data[$edname];
					$idp = findRow('products','name',"'".$value."'",'id');
					$query = "delete from products_donations where products_id=$idp";
					$result = runQuery($query);	
					
					for ($init = 0; $init <$qty ; $init++){
						$datos = array(donations_id => $data['id'], products_id =>$idp, state => 1, expirationDate => $expd,warehouses_id => $data['warehouse']);
						$idlist = dbInsert("products_donations",$datos);
					}
				}
			}
		}else{
			$warning ="Se debe elegir por lo menos un producto, por favor verifique."; 
		}
			
	return array($warning, $success);
}

function deleteDonation($data){	
	$query = "delete from donations where sequence = $data[id]";
	$result = runQuery($query);
	if($result){
		$success = "El elemento fue eliminado.";
	}else{
		$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
	}
	return array($warning, $success);
	
}

function getProductQuantity($product,$donation = '',$state=''){

	if ($state!='')
		$state= ' and state = '.$state;
	
	if($donation != ''){
		$idp = findRow('products','name',"'".$product."'",'id');
		$query = "SELECT COUNT(*) AS cont FROM products_donations WHERE donations_id=$donation AND products_id=$idp".$state;	
		$row = runQuery($query,1);
		return $row['cont'];
	}else{
		$idp = findRow('products','name',"'".$product."'",'id');
		$query = "SELECT COUNT(*) AS cont FROM products_donations WHERE products_id=$idp".$state;	
		$row = runQuery($query,1);
		return $row['cont'];
	}
}

function addStatesChanges ($products_donations,$newState,$user,$reason = '' ,$note = ''){
	if(exists("products_donations","id=$products_donations") and exists("users","id=$user")){
		$currentState=getCurrentState ($products_donations);
		$datos = array(products_donations_id => $products_donations, previousState => $currentState, currentState => $newState,users_id => $user,reason => $reason);
		if(dbInsert("products",$datos)){
			$datos = array(state => $newState);
			if(dbUpdate("id",$datos,"id = $products_donations")){
				return 0;
			}else{
				return "Error en el cambio de estado del producto $products_donations. Por favor verifique.";
			}			
		}else{
			return "Error en el cambio de estado del producto $products_donations. Por favor verifique.";
		}
	}else{
		return "Hay datos que no existen para el cambio de estado del producto $products_donations, por favor verifique.";
	}
}

function getCurrentState ($products_donations){
		$query="Select state from products_donations where id=$products_donations";
		$result= runQuery($query);
		if($row = mysql_fetch_array($result)){
			return $row['state'];
		}else{
			return 0;
		}
	return array($warning, $success);	

}

/* Users
============================================================ */
function addUser($data){
	if($data['name'] != "" && $data['email'] != ''){
		if(checkmail($data['email']) or $data['email']==''){
			if(!exists("users","email='$data[email]'")){
				$pass = substr(md5(rand(),0,8));
				$encodedPass = md5($pass);
				$date = date('Y-m-d');
				$datos = array(name => $data['name'], password => $encodedPass, phoneNumber => $data['phonenumber'], email => $data['email'], profile => $data['profile']);
				if(dbInsert("users",$datos)){
					$to      = $data['email'];
					$subject    = 'Bienvenido a Sahana Caribe';
					$message   = 'Su cuenta ha sido creada. Ingrese a http://www.sahanacaribe.org/ para iniciar sesión. Su contraseña provisional es ' . $pass;
					$headers = 'From: Sahana Caribe <admin@sahanacaribe.com>' . "\r\n" .'Fecha: '.$date. "\r\n";
					if(mail($to, $subject, $message, $headers)){
						$success = "El usuario ha sido agregado exitosamente.";
					}else{
						$warning = "El usuario ha sido creado pero no se ha podido enviar el correo activación. Por favor elimine al usuario e inténtelo nuevamente.";
					}
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning = "Ya existe un usuario registrado con el email '$data[email]'.";
			}
		}else{
			$warning = "La dirección de correo electrónico no es válida.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
}

function editUser($data){
	if($data['name'] != ""){
		$datos = array(name => $data['name'], phoneNumber => $data['phonenumber'], profile => $data['profile']);
		if(dbUpdate("users",$datos,"id = $data[id]")){
			$success = "El usuario ha sido agregado exitosamente.";
		}else{
			$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
}

function validateLogin($data){

	if(checkmail($data['email']) or $data['email']==''){
		if($data['email']!='' && $data['password']!=''){
			$password = md5($data['password']);
			$query = "select * from users where email='$data[email]' and password='$password'";
			if($result = runQuery($query)){
				if(mysql_num_rows($result) == 1){
					$row = mysql_fetch_array($result);
					$_SESSION['dms_authorized'] = true;
					$_SESSION['dms_id'] = $row['id'];
					
					header('Location: index.php');
				}else{
					$warning = "Nombre de usuario o contraseña incorrectos.";
				}
			}else{
				$warning = "Nombre de usuario o contraseña incorrectos.";
			}
		}else{
			$warning = "Por favor digite todos los datos.";
		}
	}else{
		$warning = "La dirección de correo electrónico no es válida.";
	}
	return $warning;
}

function changePassword($data){
	if($data['current']!='' and $data['password']!='' and $data['password-confirm']!=''){
		if($data['password']== $data['password-confirm']){
			$password = md5($data['current']);
			if(exists("users","id=$data[user_id] and password='$password'")){
				$password = md5($data['password']);
				$query = "update users set password='$password' where id=$data[user_id]";
				if(runQuery($query,4) == 1){
					$success = "La contraseña fue cambiada exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";		
				}
			}else{
				$warning = "La contraseña actual no es válida. Por favor verifique los datos e inténtelo nuevamente";
			}
		}else{
			$warning = "Las contraseñas no coinciden. Por favor verifique los datos e inténtelo nuevamente.";
		}
	}else{
		$warning = "Por favor digite todos los datos.";
	}
	return array($warning, $success);
}

function resetPassword($data){
	if(checkmail($data['email']) or $data['email']==''){
		if($id = exists("users","email='$data[email]'")){
			$pass = substr(md5(rand(),0,8));
			$encodedPass = md5($pass);
			$query = "update users set password = '$encodedPass' where id = '$id'";
			if(runQuery($query)){
				$date = date('Y-m-d');
				$to      = $data['email'];
				$subject    = 'Reestablecimiento de contraseña';
				$message   = "Su contraseña ha sido restablecida.\r\n\r\nSu nueva contraseña es $pass. Puede cambiar su contraseña en el panel de Opciones una vez haya iniciado sesión.\r\n\r\nPuede iniciar sesión en http://www.sahanacaribe.org";
				$headers = 'From: Sahana Caribe <admin@sahanacaribe.com>' . "\r\n" .'Fecha: '.$date. "\r\n";
				if(mail($to, $subject, $message, $headers)){
					$success = "Su nueva contraseña ha sido enviada a su dirección de correo electrónico.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor comuníquese con el administrador del sitio.";	
				}
			}else{
				$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";	
			}
		}else{
			$warning = "La dirección de correo electrónico no está registrada. Por favor verifique los datos.";
		}
	}else{
		$warning = "La dirección de correo electrónico no es válida.";
	}
	return array($warning, $success);
}
/* Distributions
============================================================ */
function addDistribution($data){	
	if($data['warehouse'] != "" and $data['company'] != "" and $data['deliveryDate'] != ""){
		if(validateExistenceProduct($data)){
			$warehouse = exists("warehouses","id='$data[warehouse]'");	
			$company = exists("companies","id='$data[company]'");	
			if($warehouse and $company ){
				$datos = array(warehouses_id => $warehouse, companies_id  => $company , deliveryDate => $data['deliveryDate'],state => $data['state']);
				$id = dbInsert("distributions",$datos);
				if($id != ''){
					foreach($data as $key => $value){
						if(substr($key,0,5) == 'hitem'){
							$qtyname = 'citem' . substr($key,-7);
							$qty = $data[$qtyname];
							$idp = findRow('products','name',"'".$value."'",'id');
							$query = "select * from products_donations where products_id=$idp and state in (2) order by expirationDate limit $qty";
							$result= runQuery($query);
							while($result and $row = mysql_fetch_array($result)){
								$datos = array(products_donations_id => $row['id'], distributions_id =>$id);
								$idlist = dbInsert("products_donations_distributions",$datos);
								$update=dbUpdate(products_donations,array(state => 4),"id=$row[id]");
							}	
						}
					}
					$success = "La distribución fue agregada exitosamente.";
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning = "Hay datos que no existen, por favor verifique.";
			}
		}else{
			$warning ="Se debe elegir por lo menos un producto, por favor verifique."; 
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

function validateExistenceProduct($data){
	foreach($data as $key => $value){
		if(substr($key,0,5) == 'hitem'){
			return true;
		}
	}
	return false;	
}
function editDistribution($data){
if($data['warehouse'] != "" and $data['company'] != "" and $data['deliveryDate'] != ""){
		if(validateExistenceProduct($data)){
			$warehouse = exists("warehouses","id='$data[warehouse]'");	
			$company = exists("companies","id='$data[company]'");	
			if($warehouse and $company ){
				if(dbUpdate("products_donations",array(state => 2),"id in (select products_donations_id from products_donations_distributions where distributions_id=$data[id])")){
					if(dbDelete("products_donations_distributions","distributions_id=$data[id]")){
						$datos = array(warehouses_id => $warehouse, companies_id  => $company , deliveryDate => $data['deliveryDate'],state => $data['state']);
						if(dbUpdate("distributions",$datos,"id=$data[id]")){
							foreach($data as $key => $value){
								if(substr($key,0,5) == 'hitem'){
									$qtyname = 'citem' . substr($key,-7);
									$qty = $data[$qtyname];
									$idp = findRow('products','name',"'".$value."'",'id');
									$query = "select * from products_donations where products_id=$idp and state in (2) order by expirationDate limit $qty";
									$result= runQuery($query);
									while($result and $row = mysql_fetch_array($result)){
										$datos = array(products_donations_id => $row['id'], distributions_id =>$data[id]);
										$idlist = dbInsert("products_donations_distributions",$datos);
										$update=dbUpdate(products_donations,array(state => 4),"id=$row[id]");
									}	
								}
							}
							$success = "La distribución fue agregada exitosamente.";
						}else{
							$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
						}
					}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
					}
				}else{
					$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
				}
			}else{
				$warning = "Hay datos que no existen, por favor verifique.";
			}
		}else{
			$warning ="Se debe elegir por lo menos un producto, por favor verifique."; 
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);

}

/* Notifications
============================================================ */

function sendNotification($data){
	
   
   ini_set(sendmail_from,"example@gobernacion.com");
   
	if(mail("example@gobernacion.com",$data['subject'],$data['body'])){
      $success = "Mensaje Enviado con exito.";
	  
	  $datos = array(subject => $data['subject'], from  => $data['from'] , to => $data['to'],body => $data['body'], type => $data['type'], users_id => $data['user']);
		if(dbInsert("notifications",$datos)){
			
		}
		else
		{
			$warning = "El mensaje ha sido enviado, pero no ha podido guardarse en la base de datos. Por favor consulte al Administrador.";
			}
   }else{
      $warning = "El mensaje no ha podido ser enviado";
   }
	
	
	return array($warning, $success);
}

/* Categories
============================================================ */
function addCategory($data){	
	if($data['name'] != ""){
		if(!exists("categories","name='$data[name]'")){
			$datos = array(name => $data['name'],description => $data['description']);
			if(dbInsert("categories",$datos)){
				$success = "La categoría fue agregada exitosamente.";
			}else{
				$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
			}
		}else{
			$warning = "Ya existe una categoría registrada con el nombre '$data[name]'.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 

function editCategory($data){	
	if($data['name'] != ""){
		if((!exists("categories","name='$data[name]' ")) or (exists("categories","name='$data[name]'")==$data[id])){										
			$datos = array(name => $data['name'],description => $data['description']);
			if(dbUpdate("categories",$datos,"id= $data[id]")){
				$success = "La categoría fue editada exitosamente.";
			}else{
				$warning = "Ha ocurrido un error de conexión con el servidor. Por favor inténtelo nuevamente.";
			}
		}else{
			$warning = "Ya existe una categoría registrada con el nombre '$data[name]'.";
		}
	}else{
		$warning = "Por favor digite todos los datos obligatorios.";
	}
	return array($warning, $success);
} 


?>