<?
/*
Hay muchas cosas que deben ir aqui en zpf-funciones.php

CREATE TABLE `encuesta`.`datos` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `a3` VARCHAR(45),
  `a2` INTEGER UNSIGNED,
  PRIMARY KEY(`id`)
)

*/
function conexionBD($base)
         {				 
          mysql_connect('localhost','root','manager123') ///----xxx	mysql_connect('localhost','','')			 
          or die("No pudo conectarse : " . mysql_error());
          mysql_select_db($base) or die("No pudo seleccionarse la BD.");
         }//function conexionBD ------------------------------------------------------------------
		 
		 
//------------------------------------- queryArreglo() --------------------------------------	 
function queryArreglo($query)
         {				 
		  $rowtotal = array();
		  $resultado = mysql_query ($query) or die("no se pudo ejecutar la consulta:<br>$query<br>". mysql_error());
             while ($row = mysql_fetch_row($resultado))
          	        {
		  	              array_push ($rowtotal,$row);
           			}
          return ($rowtotal);				
         }//function selectarreglo 
//------------------------------------- queryArreglo() --------------------------------------
	 
//------------------------------------- queryArreglouni() --------------------------------------
function queryArreglouni($query)
{				 
/* Esta funcion regresa un arreglo unidimencional a partir de un querry que debe regresar unicamente 
   una columna  o un renglon(Nota: la funcion no validad que el query sea asi)	*/	 
		  $rowtotal = array();
		  //echo $query;
			//ejecuta el query y lo guarda en result
		  $resultado = mysql_query ($query) or die("no se pudo ejecutar la consulta:<br>$query<br>". mysql_error());
		  
		  if(1==mysql_num_rows($resultado))//si silo hay un renglon se devuelve este como arreglo
		   { //da el renglobn de mysql ya en forma de arreglo
       	return (mysql_fetch_row($resultado));				
		    } 
		  else 
			  { // Si hay mas de un registro el arreglo que se devuelve debe tener los valores de la primer columna del query(que normalmente es la unica)
		    $ret=array();//creo un arreglo
		      while ($row = mysql_fetch_row($resultado))
					/*ciclo que recorre cada registro leyendo el valor de la primer columna e 
					  insertandolo en el registro (Nogta: esto tal vez se puede cambiar por un 
						transpose y fetch_row)
					*/	
          	{//pone al final del arreglo $ret el valor del la primer columna del registro en turno del resultado de mysql
		 		  		array_push ($ret,$row[0]);
          	}//while ($row = 
			return $ret;	//regresa el arreglo
		  }//} else { // Si h
}//function ueryArreglouni
//------------------------------------- queryArreglouni() --------------------------------------


function insert_array($array,$tabla)
{

	
	foreach($array as $key => $value)
	{
		$nombres.= ", $key";
		
		if(!ctype_digit($value) )
		{$columnas.= ", '$value'";}
		
		elseif(ctype_digit($value) )
		
		{$columnas.= ", $value";}		
		
		
		
	}

	$nombres=ltrim($nombres, ',');
	$columnas=ltrim($columnas, ',');
	
	//chek("INSERT INTO $tabla ( $nombres ) VALUES ( $columnas )");
	mysql_query("INSERT INTO $tabla ( $nombres ) VALUES ( $columnas )");

}

//---INCOMPLETA
function update_array($array,$tabla,$where)
{

	
	foreach($array as $key => $value)
	{	
		if($value)
		{
			
			if(!ctype_digit($value) )
			{ $set.= " $key='$value',"; }
			
			elseif(ctype_digit($value) )
			{ $set.= " $key=$value,"; }			
		}
	}

	$set=rtrim($set, ',');
	chek("Update $tabla set $set where $where");
	//mysql_query("Update $tabla set $set where $where");	

}

function createtable_array($array,$tabla)
{
	$query='CREATE TABLE $tabla ( id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, ';
	
	foreach($array as $key => $value)
	{
		if(!ctype_digit($value) )
		{$query.="$key VARCHAR(255), ";}
		
		elseif(ctype_digit($value) )
		
		{$query.="$key INTEGER UNSIGNED, ";}
				
		
		
		
	}
	$query.="PRIMARY KEY(id))";
	
	chek($query);
}

?>