<?php

abstract class almacendedatos {

	public function  __construct()
	{
		chek('Falta implementar -__construct- en:'.get_class($this));
	}
	
//-------funciones de tablas		
	public function leertabla($nombretabla, $campos, $filtros=null) 
	{
		chek('Falta implementar -leertabla- en:'.get_class($this));
	}
	
	/**
	 * Crea, llena y guarda una tabla o vacia y luego inserta datos en una tabla
	 *
	 * @param string $nombretabla
	 * @param array[string[]] $data
	 */
	public function guardartabla($nombretabla, $data) //reemplaza lo que hay y si no hay crea una nueva tabla
	{
		if($this->existetabla($nombretabla)){$this->vaciatabla($nombretabla);}
		else{$this->creartabla($nombretabla,$data[0]);}//hay que enviarle solo un registro no toda la tabla
		
		foreach($data as $row)
		{
			$this->agregarregistro($nombretabla, $row);	
		}
		
		//chek($this);
	}
	
	public function vaciatabla	($nombretabla)//Deja la tabla con su estructura pero vacia
	{
		chek('Falta implementar -vaciatabla- en:'.get_class($this));
	}
	
	public function creartabla	($nombretabla,$camposenkeys)//Deja la tabla con su estructura pero vacia
	{
		chek('Falta implementar -creartabla- en:'.get_class($this));
	}
	
	public function existetabla	($nombretabla)//responde true si existe una tabla con el nombre proporcionado
	{
		chek('Falta implementar -existetabla- en:'.get_class($this));
	}

	
//-------funciones de registros	
	public function leeregistro()
	{
		chek('Falta implementar -leeregistro- en:'.get_class($this));
	}
	
	public function agregarregistro($nombretabla, $data)//agrega un registro al final de la tabla
	{
		chek('Falta implementar -agregarregistro- en:'.get_class($this));
	}	
	
	public function actualizaregistro($nombretabla, $data, $filtros=null)
	{
		chek('Falta implementar -actualizaregistro- en:'.get_class($this));
	}	
	
}

class datossql extends almacendedatos  
{
	var $db;
	var $conexion;
	var $tablecolumstypes;

//----
	function getlastupdatedate($tabla,$campo,$campoid,$valorid)
	{
		$ret=$this->queryArregloUNI("SELECT fecha FROM historicoconfechas h where Campo='$campo' and Tabla='$tabla' and CampoId='$campoid' and ValorId='$valorid' order by fecha DESC limit 1");
		if($ret)
		{ 
			$ret=split('-',$ret[0]);
			return $ret[2].'/'.$ret[1].'/'.$ret[0]; 
		}
		else
		{ return 'NA'; }
	}
	
//----
	
	function __construct($db, $usr, $pwd='', $host='localhost')
	{			
		$this->db=$db;
		
		$this->conexion=mysql_connect($host,$usr,$pwd)		or die("No pudo conectarse : " . mysql_error());
		mysql_select_db($db,$this->conexion) 		or die("No pudo seleccionarse la BD $db");
	}
	
//-------funciones de tablas	
	function leertabla($nombretabla, $campos='*', $filtros=null)
	{
		if(!$campos){$campos='*';}
		if(is_array($campos)){$campos=$this->generacampos($campos);}
		 
		$query='select '.$campos.' from '.$nombretabla;
		 
		if($filtros){ $query.=$this->traducefiltros($filtros); }

		$tabla = $this->queryArreglo($query);
		return $tabla;//---Regresa un arreglo de arreglos NO un objeto datatable
	}	
	
	public function actualizatablaconID	($nombretabla,$data,$campoID,$add=true)//Guarda o actualiza un atabla con los registros de un arreglo de arreglos
	{
		$ids=$this->GetColumn($nombretabla,$campoID);
		//chek($data);
		//chek($ids);
		//die;
		foreach($data as $row)
		{
//			chek( $campoID );
//			die;
			if($row[$campoID])
			{
				if( in_array($row[$campoID],$ids) )
				{
					$this->actualizaregistroporID($nombretabla,$row,$campoID,$row[$campoID]);
				}else if($add){
					$this->agregarregistro($nombretabla,$row);				
				}
			}
		}
	}	
	
/*	
	public function guardartabla($nombretabla, $data) //reemplaza lo que hay y si no hay crea una nueva tabla
				//data es un arreglo de arreglos NO un objeto datatable
	{
		//chek($nombretabla);
		//chek($this->existetabla($nombretabla));
		if($this->existetabla($nombretabla)){$this->vaciatabla($nombretabla);}
		else{$this->creatabla($nombretabla);}
		
		foreach($data as $row)
		{
			$this->agregarregistro($nombretabla, $row);//$row es un arreglo no un objeto datarow
		}
	}
*/	
	public function vaciatabla ($nombretabla)//Deja la tabla con su estructura pero vacia
	{
		$this->query("TRUNCATE $nombretabla");
	}
	
//	public function creartabla ($nombretabla,$camposenkeys)//Deja la tabla con su estructura pero vacia
//	{
//		chek('Falta implementar -creartabla- en:'.get_class($this));
//	}

	public function existetabla	($nombretabla)//responde true si existe una tabla con el nombre proporcionado
	{
 		if(    mysql_num_rows( $this->query("SHOW TABLES LIKE '".$nombretabla."'") )    )
 		{ return true;	}
 		else
 		{ return false; }		
	}
	
//-------funciones de registros	
	public function leeregistro()//??fala definir como seleccionar el registro
	{
		chek('Falta implementar -leeregistro- en:'.get_class($this));
	}
	
	public function leeregistroporID($nombretabla,$id,$nombredelcampoID)//??fala definir como seleccionar el registro
	{
		$ret=$this->queryArreglo("Select * from $nombretabla WHERE $nombredelcampoID=$id");
		return $ret[0];	
	}	
	
	public function agregarregistro($nombretabla, $data)//agrega un registro al final de la tabla
	{
		$campos=$this->generacampos($data);
		$values=$this->generavalues($nombretabla, $data);
		$query="INSERT INTO $nombretabla ($campos) VALUES ($values)";
		$this->query($query);
	}		
		
	public function actualizaregistro($nombretabla, $data, $filtros=null)//??fala definir como seleccionar el registro
	{
		chek('Falta implementar -actualizaregistro- en:'.get_class($this));
	}
	
	
	
	public function actualizaregistroporID($nombretabla, $data, $campoID, $valorID)//una vez hecho actualizaregistro esta se peude hacer utilizasndo esa funcion
	{
		
		
		
		$camposvalues=$this->generacamposvalues($nombretabla,$data);
		$query="UPDATE $nombretabla SET ".$camposvalues." WHERE ".$campoID.'='.$valorID;
		//chek($query);
		$this->query($query);

		//UPDATE persondata SET age=age+1
	}

	public function borraregistroporID($nombretabla, $campoID, $valorID)//una vez hecho actualizaregistro esta se peude hacer utilizasndo esa funcion
	{
		$camposvalues=$this->generacamposvalues($nombretabla,$data);
		$query="DELETE FROM $nombretabla WHERE ".$campoID.'='.$valorID;
		$this->query($query);

		//UPDATE persondata SET age=age+1
	}
//-------funciones de columnas
	public function leeColumna($nombretabla, $nombrecampo)
	{
		$query="SELECT $nombrecampo  FROM $nombretabla";
		return $this->queryArregloUNI($query);
	}

	public function leeColumnaUnicos($nombretabla, $nombrecampo)
	{
		$query="SELECT DISTINCT $nombrecampo  FROM $nombretabla";
		//chek($query);
		return $this->queryArregloUNI($query);
	}
	
	 
//-----funciuones exclusivas de datossql

	public function cuentadiferentesdeuncampo($nombretabla, $campo, $where)
	{
		if(is_string($campo))
		{
			$query="SELECT $campo, COUNT(*) as cuenta FROM $nombretabla $where GROUP BY $campo ORDER BY $campo";
			return $this->queryArregloKeyUNI($query);
		}else if(is_array($campo)){
			$campos=implode(',',$campo);
			$query="SELECT $campos, COUNT(*) as cuenta FROM $nombretabla $where GROUP BY $campos ORDER BY $campos";
			return $this->queryArreglo($query);			
		}		
	}	
	
	
	public function obtenRelacionvaloresLlaves($nombretabla, $nombreID, $nombrevalor)
	{
		$query="SELECT DISTINCT $nombrevalor, $nombreID  FROM $nombretabla";
		return $this->queryArregloKeyUNI($query);		
	}
	
	private function traducefiltros($filtros)//pasa del arreglo de filtros "aun por definir" a uan frase Where 
	{
		//chek('Falta implementar -traducefiltros- en:'.get_class($this));
		//return 'WHERE '.$where;
		return ' WHERE '.$filtros;
	}
	
	private function generacampos($campos)//puede recibir un arreglo camposdeentrda o con datos $llave=>$valor y da un string para
	{
		//chek($campos);
		if(is_a($campos[0],'campoentrada'))
		{
			$camposSQL=array_shift($campos)->nombre;
			foreach($campos as $campo)
			{
				/* @var campoentrada $campo  */
				$camposSQL.=', '.$campo->nombre;
			}
		}
		else if( is_string(key($campos) ) )
		{
			
			foreach($campos as $key=>$value)
			{
				if($value){ $camposSQL.=', '.$key; }
			}			
		}
		$camposSQL=ltrim($camposSQL,', ');
		
		return $camposSQL;
	}
	
	private function generavalues($nombretabla,$data)//recibe un arreglo de datos y el nombre de una tabla los imprime par aun insert de acuerdo al tipo de datos de cada columna en la tabla
	{
		$tipostabla=$this->gettipostabla($nombretabla);
		foreach($data as $key=>$value)
		{	
			if($value)
			{
				if($tipostabla[$key]=='int')
				{
					if($value==='0')
					{
						$valuesSQL.='0, ';
					}else{
						$valuesSQL.=$value.', ';
					}
					
				}
				//else if($tipostabla[$key]=='string')
				else
				{
					
					if($value==='0')
					{
						$valuesSQL.="0, ";
					}else{
						$valuesSQL.="'$value', ";
					}
				}
			}
		}
		$valuesSQL=rtrim($valuesSQL,', ');
		return $valuesSQL;
	}
	
	private function generacamposvalues($nombretabla,$data)//recibe un arreglo de datos y el nombre de una tabla los imprime par aun insert de acuerdo al tipo de datos de cada columna en la tabla
	{
		$tipostabla=$this->gettipostabla($nombretabla);
		foreach($data as $key=>$value)
		{	
			if($value){
				if($tipostabla[$key]=='int')
				{
					
					if($value===0)
					{
						$valuesSQL.=$key.'=0, ';
					}else{
						$valuesSQL.=$key.'='.$value.', ';
					}				
				}
				//else if($tipostabla[$key]=='string')
				else
				{
					 $valuesSQL.=$key.'='."'$value', ";
				}
			}else
			{$valuesSQL.=$key.'=NULL, ';}
		}
		$valuesSQL=rtrim($valuesSQL,', ');
		return $valuesSQL;
	}
	
	function queryArreglo($query)
	{
		$rowtotal = array();
		$resultado = $this->query($query);
		while ($row = mysql_fetch_assoc($resultado))
		{
			//foreach($row as &$cell)
			//{$cell=utf8_decode($cell);}
			array_push ($rowtotal,$row);
		}
		return ($rowtotal);
	}	

	/**
	 * Recibe un query que devuelve dos parametros por registro devuelve un arreglo llave=>valor donde el la lalve es el primer dato del regitro y el valor el segundo
	 *
	 * @param string $query
	 * @return string[]
	 */
	function queryArregloKeyUNI($query)
	{
		$rowtotal = array();
		$resultado = mysql_query ($query) or die("no se pudo ejecutar la consulta:<br>$query<br>". mysql_error());
		$ret=array();
		
		while ($row = mysql_fetch_row($resultado))	
		{
			$ret[$row[0]]=$row[1];
		}
		Return $ret;	//regresa el arreglo
	}

	function queryArregloUNI($query)
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
	}	

	function GetColumn($nombretabla,$campo)
	{
		$rowtotal = array();
		$ret = $this->queryArregloUNI("SELECT $campo FROM $nombretabla");
		return ($ret);
	}	
	
	function query($query)
	{
		$result = mysql_query($query,$this->conexion) or die("No se pudo ejecutar la consulta:<br>$query<br>". mysql_error());
		return $result;	
	}

	private function gettipostabla($nombretabla)
	{
		if(!$this->tablecolumstypes[$nombretabla])
		{	
			$query = "SELECT * FROM $nombretabla LIMIT 1";
			//$result = mysql_query($query,$this->conexion);
			
			//chek($this->db);
			//chek($nombretabla);
			$fields = mysql_list_fields($this->db,$nombretabla,$this->conexion);

			for($i=0;$i<mysql_num_fields($fields);$i++) 
			{
				$temp[mysql_field_name($fields,$i)]=mysql_field_type($fields,$i);
				//echo mysql_field_name($fields,$i)." (".mysql_field_len($fields,$i).") - ".mysql_field_type($fields,$i)."<br>";
			}
			//chek($temp);
			$this->tablecolumstypes[$nombretabla]=$temp;
		}
		
		$ret=$this->tablecolumstypes[$nombretabla];
		
		return $ret;
	}
}



/*


class datossql 
{

	function leerregistro($nombretabla,$campos,$campollave='id', $valorllave, $filtros=null)
	{
		if(!$campos){$campos='*';}
		if(is_array($campos)){$campos=$this->generacampos($campos);}
		 
		$query='select '.$campos.' from '.$nombretabla;
		 
		
		if($valorllave)
		{
			$valorllave=$this->stringonum($valorllave);
			$query.=' WHERE '.$campollave.'='.$valorllave;
		} else if($filtros)
		{
			$query.=$this->generawhere($filtros);
		}
		//chek($query); 
		$tabla = $this->queryArreglo($query);
		return $tabla[0];
	}	
   
	function updateregistro($nombretabla,$registro,$campollave='id')
	{
		//chek($nombretabla);
		if(!$this->tablecolumstypes[$nombretabla]){$this->gettipostabla($nombretabla);}		
		//chek($this->tablecolumstypes[$nombretabla]);
		
		$temp=$this->generalistaupdate($registro,$nombretabla);
		$query="UPDATE $nombretabla SET $temp WHERE $campollave=".$registro[$campollave]." LIMIT 1";
		
		chek($query); 
		mysql_query ($query,$this->conexion) or die("no se pudo ejecutar la consulta:<br>$query<br>". mysql_error());
	}	

	private function generalistaupdate($registro,$nombretabla)
	{
		foreach($registro as $key=>$value)
		{
			if($this->tablecolumstypes[$nombretabla][$key]=='int')
			{
				$ret.=$key.'='.$value.', ';
			}
			else if($this->tablecolumstypes[$nombretabla][$key]=='string')
			{
				$ret.="$key='$value', ";
			}	
		}
		$ret=rtrim($ret);

		$ret=rtrim($ret,',');

		return $ret;
	}

	
	function generawhere($filtros)
	{
		/* @var $filtros dataregistry 
		
		if($filtros)
		{
			$where=' WHERE '.$this->concatenaarreglo($filtros->data,' AND ',' OR ');
		}

		return $where;
	}
	
	private function concatenaarreglo($array,$operadorparaarreglo,$operadorparasubarreglos=null)
	{
		chek($array);
		
		$var=array_kshift($array);
		
		//chek(key($var));
		//chek(current($var));
		
		if(!is_array(current($var))){ $cadena='('.key($var).'='.current($var); } 
		else { $cadena='('.$this->concatenasubarreglo(current($var),key($var),$operadorparasubarreglos); }
		
		//chek($cadena);
		
		foreach ($array as $key=>$value)
		{
			if(!is_array($value)){$cadena.=' '.$operadorparaarreglo.' '.$key.'='.$value;}
			else {$cadena.=' '.$operadorparaarreglo.' '.$this->concatenasubarreglo($value,$key,$operadorparasubarreglos);}	
		}
		$cadena.=')';
		//chek($cadena);
		return $cadena;
	}

	private function concatenasubarreglo($array,$key,$operadorparasubarreglos)
	{
		$value=array_shift($array);
		
		$cadena='('.$key.'='.$value;
		
		foreach ($array as $value)
		{
			$cadena=$operadorparasubarreglos.' '.$key.'='.$value.' ';
		}
		$cadena.=')';
		return $cadena;
	}	

} 
*/
class datosexcel extends almacendedatos  
{
	var $path;
	var $excel;
	var $encabezadosRow;
	var $coordendascols;
	var $versiondeexcel;
	
	function __construct($path,$encabezadosRow=1,$sololectura=false)
	{		
		$this->path=$path;
		$this->encabezadosRow=$encabezadosRow;
		if(stripos($path,'xlsx')){$this->versiondeexcel='Excel2007';}
		else if(stripos($path,'xls')){$this->versiondeexcel='Excel5';}
		else if(stripos($path,'csv')){$this->versiondeexcel='CSV';}
			
		
		if(file_exists($path))
		{
			
			$objReader = PHPExcel_IOFactory::createReader($this->versiondeexcel,$sololectura);
			$this->excel = $objReader->load($path);
			$this->encabezadosRow=$encabezadosRow;
		}
		else
		{
			$this->excel = new PHPExcel();
			$excel=&$this->excel;
			/* @var $excel PHPExcel */	
			$excel->removeSheetByIndex(0);
		}
	}
	
//-------funciones de tablas		
	public function leertabla($nombrehoja, $campos=null, $filtros=null) 
	{
		
		if($campos){$campos=$this->generacampos($campos);}
		//chek($campos);
		
		
		$excel=&$this->excel;
		/* @var $excel PHPExcel */

		if(!$nombrehoja)
		{
			$hoja=$excel->getActiveSheet();
		}else{
			$hoja=$excel->getSheetByName($nombrehoja);
		}
		/* @var $hoja PHPExcel_Worksheet */
		
		$maxcol=$hoja->getHighestColumn();
		$maxcol++;
		for($tempcol='A';$tempcol!=$maxcol;$tempcol++)
		{
			if(!$campos && $hoja->getCell($tempcol.$this->encabezadosRow)->getValue() )
			{
				$camposcols[$hoja->getCell($tempcol.$this->encabezadosRow)->getValue()]=$tempcol;
			
			}else{
				if(in_array($hoja->getCell($tempcol.$this->encabezadosRow)->getValue(),$campos) )
				{ $camposcols[$hoja->getCell($tempcol.$this->encabezadosRow)->getValue()]=$tempcol; }
			}
		}
		
		//chek($camposcols);
		
		
		$maxrow=$hoja->getHighestRow();
		for($temprow=$this->encabezadosRow+1;$temprow<=$maxrow;$temprow++)
		{
			$tabla[]=$this->leerregistroporrenglon($hoja,$camposcols,$temprow);
		}
		//$tabla = $this->queryArreglo($query);
		
		//chek ($tabla);

		return $tabla;
	}

	public function guardartabla($nombrehoja, $data, $titulo=null) //reemplaza lo que hay y si no hay crea una nueva tabla
	{
		parent::guardartabla($nombrehoja, $data);
		
		if($titulo)
		{
			$excel=&$this->excel;
			/* @var $excel PHPExcel */
			$hoja=$excel->getSheetByName($nombrehoja);
			//$hoja->setCellValueExplicit('A1',$titulo);
		}
		$this->save();
	}
	
	public function vaciatabla($nombrehoja)//Deja la tabla con su estructura pero vacia
	{
		//$campos=$this->generacampos($campos);
		
		
		$excel=&$this->excel;/* @var $excel PHPExcel */
		
		if(!$nombrehoja)
		{
			return false;
		}else{
			$hoja=&$excel->getSheetByName($nombrehoja);		
			$camposencabsado=$this->respaldacamposencabesado($hoja);
			$excel->removeSheetByIndex($excel->getIndex($hoja));
			unset($hoja);

			$hoja2=new PHPExcel_Worksheet(&$this->excel,$nombrehoja);
			$this->restauracamposencabesado($hoja2,$camposencabsado);			
			$excel->addSheet($hoja2);
			
			

			return true;
		}
	}
	
	public function creartabla	($nombretabla,$camposenkeys)//Deja la tabla con su estructura pero vacia
	{
	
		$hoja=new PHPExcel_Worksheet(&$this->excel,$nombretabla);
		$excel=&$this->excel;
		/* @var $excel PHPExcel */
		$col='A';
		//chek($camposenkeys);
		foreach($camposenkeys as $key=>$value)
		{
			$hoja->setCellValue($col.$this->encabezadosRow,$key);
			//chek($col.$this->encabezadosRow);
			//chek($hoja->getCell($col.$this->encabezadosRow)->getValue());
			$col++;
		}
		$excel->addSheet($hoja);
		
	}
	
	public function existetabla	($nombrehoja)//responde true si existe una tabla con el nombre proporcionado
	{
		$excel=&$this->excel;/* @var $excel PHPExcel */
		if(     in_array( $nombrehoja,$excel->getSheetNames() )    )
		{  return true; }else{  return false;}
	}
	
//-------funciones de registros	
	public function leeregistro()
	{
		chek('Falta implementar -leeregistro- en:'.get_class($this));
	}
	
	public function agregarregistro($nombrehoja, $data)//agrega un registro al final de la tabla
	{
		$excel=&$this->excel;
		/* @var $excel PHPExcel */
		$hoja=$excel->getSheetByName($nombrehoja);
		/* @var $hoja PHPExcel_Worksheet */
		//chek($hoja->getCell('A2')->getValue());
		
		$currentrow=$hoja->getHighestRow()+1;
		if(!$this->coordendascols[$nombrehoja])
		{ 
			$this->coordendascols[$nombrehoja]=$this->getcoordendascols($hoja,$data);
		}
		$coordendascols=&$this->coordendascols[$nombrehoja];
		
		foreach($coordendascols as $key=>$value)
		{
			$hoja->setCellValue($coordendascols[$key].$currentrow,$data[$key]);
		}		
	}	
	
	public  function actualizaregistro($nombretabla, $data, $filtros=null)
	{
		chek('Falta implementar -actualizaregistro- en:'.get_class($this));
	}

	
	
	
//--------funcionesexclusivas de datosexcel	

	function getencabezados($nombrehoja)//lee un registro pero no con filtros sino por el numero de renglon
	{//--------igual y sirve en todos los objetos da datos
		
		$excel=&$this->excel;/* @var $excel PHPExcel */
		
		if(!$nombrehoja)
		{
			$hoja=$excel->getActiveSheet();
		}else{
			$hoja=$excel->getSheetByName($nombrehoja);
		}	
		
		$maxcol=$hoja->getHighestColumn();
		$maxcol++;
		for($tempcol='A';$tempcol!=$maxcol;$tempcol++)
		{
			$campos[]=$hoja->getCell($tempcol.$this->encabezadosRow)->getValue();	
		}
		
		return $campos;
		
	}		
	
	
	
	
	private function revisayobjtenobjetohoja(&$hoja)
	{
		if(is_string($hoja))
		{
			$nombrehoja=$hoja;
			$excel=&$this->excel;/* @var $excel PHPExcel */
			$hoja=&$excel->getSheetByName($nombrehoja);
			if(!$hoja)
			{
				$hoja=new PHPExcel_Worksheet(&$this->excel,$nombrehoja);			
				$excel->addSheet($hoja);
				$hoja=&$excel->getSheetByName($nombrehoja);
			}
		}
		return $hoja;
	}
	
	function fijahojacatlogacelda($nombrehoja,$coordendascelda,$hojacatalogo)
	{	
		$excel=&$this->excel;/* @var $excel PHPExcel */
		//$excel = new PHPExcel;
		$excel->
		//$hoja=$this->revisayobjtenobjetohoja($hoja);
		$excel->setActiveSheetIndex(0);
		chek($excel);
		
		$objValidation = $excel->getActiveSheet()->getCell($coordendascelda)->getDataValidation();
		$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_WHOLE );
		$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
		$objValidation->setAllowBlank(true);
		$objValidation->setShowInputMessage(true);
		$objValidation->setShowErrorMessage(true); 
		$objValidation->setErrorTitle('Valor no permitido'); 
		$objValidation->setError('Valor no permitido');
		$objValidation->setPromptTitle('Valor no permitido');
		$objValidation->setPrompt('Solo valores de en la columna b de la hoja:'.$hojacatalogo.' estan permitidos');
		//$objValidation->setFormula1('='.$hojacatalogo.'!$B$1:$B$900'); //=perfiles!$B$1:$B$33   =perfiles!$B$1:$B$24
		$objValidation= new PHPExcel_Cell_DataValidation;
		chek($objValidation->getFormula1());
		//$objValidation->setFormula1(10);
		//$objValidation->setFormula2(20);
		//$excel->getActiveSheet()->getCell($coordendascelda)->setDataValidation($objValidation);	
		
	}
	
	
	function setCellValue($coordenadas,$valor,&$hoja)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);

		$hoja->setCellValue($coordenadas,$valor);	
	}
	
	function renombrahoja($nombreviejo,$nombrenuevo)
	{
		$excel=&$this->excel;/* @var $excel PHPExcel */
		
		chek($excel->getSheetNames() );
		
		
		$hoja=&$excel->getSheetByName($nombreviejo);
		if(!is_a($hoja,'PHPExcel_Worksheet')){$hoja=$this->revisayobjtenobjetohoja($nombreviejo);}
		$hoja->setTitle($nombrenuevo);
		
		//chek($excel->getSheetNames() );
	}	
	
	private function respaldacamposencabesado(&$hoja)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);
		
		$maxcol=$hoja->getHighestColumn();
		for($row=1;$row<=$this->encabezadosRow;$row++)
		{
			for($col='A';$col<=$maxcol;$col++)
			{
				//chek($col.$row);
				$camposencabsado[$col.$row]=$hoja->getCell($col.$row)->getValue();
			}
		}
		return	$camposencabsado;
	}
	
	private function restauracamposencabesado(&$hoja,$camposencabsado)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);
		
		foreach($camposencabsado as $key=>$value)
		{
			$hoja->setCellValue($key,$value);
		}
	}


	
	
	function leerregistroporrenglon($hoja,$camposcols,$row)//lee un registro pero no con filtros sino por el numero de renglon
	{
		$excel=&$this->excel;
		/* @var $excel PHPExcel */
		
		$hoja=$this->revisayobjtenobjetohoja($hoja);
//		if(!is_class('PHPExcel_Worksheet',$hoja))
//		{
//			$hoja=$excel->getSheetByName($hoja);
//		}
		/* @var $hoja PHPExcel_Worksheet */
		
		foreach($camposcols as $key=>$value)
		{
			$ret[$key]=$hoja->getCell($value.$row)->getValue();
		}
		return $ret;
		
	}
	
	private function getcoordendascols(&$hoja,$data)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);
		/* @var $hoja PHPExcel_Worksheet */
		foreach($data as $key=>$value)
		{
			$columna=$this->encuentracolumna($hoja,$key);
			$ret[$key]=$columna;
		}
		return $ret;
	}

	private function encuentracolumna(&$hoja,$key)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);
		/* @var $hoja PHPExcel_Worksheet */
		
		$maxcol=$hoja->getHighestColumn();
		$maxcol++;
		for($tempcol='A';$tempcol!=$maxcol;$tempcol++)
		{
			//chek('key- '.$key);
			//chek('col- '.$hoja->getCell($tempcol.$this->encabezadosRow)->getValue());
			if($hoja->getCell($tempcol.$this->encabezadosRow)->getValue()==$key)
			{ return $tempcol; }
		}
	}
	
	function save()
	{
		//chek($this->excel);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, $this->versiondeexcel);
		$objWriter->save($this->path);	
	}
	
	private function generacampos($campos)
	{
		foreach($campos as $campo)
		{
			/* @var $campo campoentrada */
			if(is_a($campo,'campoentrada'))
			{ 
				$camposarray[]=$campo->nombre; 
			}
			else if(is_string($campo))
			{
				$camposarray[]=$campo;
			}
		}
		//chek($camposarray);
		return $camposarray;
	}	
	
}





class datosexcel2 extends almacendedatos  
{
	var $path;
	var $excel;
	var $encabezadosRow;
	var $coordendascols;
//	var $versiondeexcel;
	
	
	function __construct($path,$encabezadosRow=1,$sololectura=false)
	{		
		$this->path=$path;
		$this->encabezadosRow=$encabezadosRow;
		
		
//		if(stripos($path,'xlsx')){$this->versiondeexcel='Excel2007';}
//		else if(stripos($path,'xls')){$this->versiondeexcel='Excel5';}
//		else if(stripos($path,'csv')){$this->versiondeexcel='CSV';}

		if(!stripos($path,'xls')){chek('El archivo no es de excel 97-2003');}
		
		if(file_exists($path))
		{
			
		//	$objReader = PHPExcel_IOFactory::createReader($this->versiondeexcel,$sololectura);
		//	$this->excel = $objReader->load($path);
			
			$data = new Spreadsheet_Excel_Reader_phpexcelinterface();
			$data->setOutputEncoding('UTF-8');
			$data->read($path);

			$this->excel=$data;
			
			//chek($this->excel->sheets);
			
		}
		else
		{
	//		$this->excel = new PHPExcel();
	//		$excel=&$this->excel;
	//		/* @var $excel PHPExcel */	
	//		$excel->removeSheetByIndex(0);
		}
		
		
		

		
		
	}

///-------euxiliares en excel2	
	function getSheetNumberByName($name,&$excel)
	{
		/* @var $excel Spreadsheet_Excel_Reader */
		
		
		foreach($excel->boundsheets as $key=>$val)
		{
			if($val['name']==$name)
			{ 
				return (string) $key; 
			}
		}
		return false;
		
	}
	
	
//-------funciones de tablas		
	public function leertabla($nombrehoja, $campos=null, $filtros=null) 
	{
		$excel=&$this->excel;
		/* @var $excel Spreadsheet_Excel_Reader */
		
		//chek($excel->sheets['0']);
		
		$numerohoja=$this->getSheetNumberByName($nombrehoja,$excel);
		//$numerohoja=false;
		//chek($numerohoja);
		//die;
		
		if($campos){$campos=$this->generacampos($campos);}
		//chek($campos);
		//die;
		
		//chek($excel->sheets[$numerohoja]);

		
		$maxcol=$excel->sheets[$numerohoja]['numCols'];
		//$maxcol++;
		//chek($maxcol);
		//die;
	/*	
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
				echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
			}
	*/				
			for($tempcol=1;$tempcol<=$maxcol;$tempcol++)
			{
				//chek("sheets[$numerohoja]['cells'][$this->encabezadosRow][$tempcol]");
				//chek($excel->sheets[$numerohoja]['cells'][$this->encabezadosRow][$tempcol]);
				if(in_array($excel->sheets[$numerohoja]['cells'][$this->encabezadosRow][$tempcol],$campos) )
				{ $camposcols[$excel->sheets[$numerohoja]['cells'][$this->encabezadosRow][$tempcol]]=$tempcol; }
				
			}
			//chek($camposcols);
			//die;
		
			
			$maxrow=$excel->sheets[$numerohoja]['numRows'];
			for($temprow=$this->encabezadosRow+1;$temprow<=$maxrow;$temprow++)
			{
				$tabla[]=$this->leerregistroporrenglon($nombrehoja,$camposcols,$temprow);
			}
			//$tabla = $this->queryArreglo($query);
			return $tabla;
	}
	
	public function guardartabla($nombrehoja, $data, $titulo=null) //reemplaza lo que hay y si no hay crea una nueva tabla
	{
		parent::guardartabla($nombrehoja, $data);
		
		if($titulo)
		{
			$excel=&$this->excel;
			/* @var $excel PHPExcel */
			$hoja=$excel->getSheetByName($nombrehoja);
			$hoja->setCellValueExplicit('A1',$titulo);
		}
		$this->save();
	}
	
	public function vaciatabla($nombrehoja)//Deja la tabla con su estructura pero vacia
	{
		//$campos=$this->generacampos($campos);
		
		
		$excel=&$this->excel;/* @var $excel PHPExcel */
		
		if(!$nombrehoja)
		{
			return false;
		}else{
			$hoja=&$excel->getSheetByName($nombrehoja);		
			$camposencabsado=$this->respaldacamposencabesado($hoja);
			$excel->removeSheetByIndex($excel->getIndex($hoja));
			unset($hoja);

			$hoja2=new PHPExcel_Worksheet(&$this->excel,$nombrehoja);
			$this->restauracamposencabesado($hoja2,$camposencabsado);			
			$excel->addSheet($hoja2);
			
			

			return true;
		}
	}
	
	public function creartabla	($nombretabla,$camposenkeys)//Deja la tabla con su estructura pero vacia
	{
	
		$hoja=new PHPExcel_Worksheet(&$this->excel,$nombretabla);
		$excel=&$this->excel;
		/* @var $excel PHPExcel */
		$col='A';
		//chek($camposenkeys);
		foreach($camposenkeys as $key=>$value)
		{
			$hoja->setCellValue($col.$this->encabezadosRow,$key);
			//chek($col.$this->encabezadosRow);
			//chek($hoja->getCell($col.$this->encabezadosRow)->getValue());
			$col++;
		}
		$excel->addSheet($hoja);
		
	}
	
	public function existetabla	($nombrehoja)//responde true si existe una tabla con el nombre proporcionado
	{
		$excel=&$this->excel;
		/* @var $excel Spreadsheet_Excel_Reader */
		
		foreach($excel->boundsheets as $key=>$val)
		{
			if($val['name']==$nombrehoja)
			{ 
				return true; 
			}
		}
		return false; 
		
	}
	
//-------funciones de registros	
	public function leeregistro()
	{
		chek('Falta implementar -leeregistro- en:'.get_class($this));
	}
	
	public function agregarregistro($nombrehoja, $data)//agrega un registro al final de la tabla
	{
		$excel=&$this->excel;
		/* @var $excel PHPExcel */
		$hoja=$excel->getSheetByName($nombrehoja);
		/* @var $hoja PHPExcel_Worksheet */
		//chek($hoja->getCell('A2')->getValue());
		
		$currentrow=$hoja->getHighestRow()+1;
		if(!$this->coordendascols[$nombrehoja])
		{ 
			$this->coordendascols[$nombrehoja]=$this->getcoordendascols($hoja,$data);
		}
		$coordendascols=&$this->coordendascols[$nombrehoja];
		
		foreach($coordendascols as $key=>$value)
		{
			$hoja->setCellValue($coordendascols[$key].$currentrow,$data[$key]);
		}		
	}	
	
	public  function actualizaregistro($nombretabla, $data, $filtros=null)
	{
		chek('Falta implementar -actualizaregistro- en:'.get_class($this));
	}

	
	
	
//--------funcionesexclusivas de datosexcel	

	function getencabezados($nombrehoja)//lee un registro pero no con filtros sino por el numero de renglon
	{//--------igual y sirve en todos los objetos da datos
				
		$excel=&$this->excel;
		/* @var $excel Spreadsheet_Excel_Reader */
		$numerohoja=$this->getSheetNumberByName($nombrehoja,$excel);
		
		
		$maxcol=$excel->sheets[$numerohoja]['numCols'];
		
		for($tempcol=1;$tempcol<=$maxcol;$tempcol++)
		{
			//chek("sheets[$numerohoja]['cells'][$this->encabezadosRow][$tempcol]");
			//chek($excel->sheets[$numerohoja]['cells'][$this->encabezadosRow][$tempcol]);
			
			$campos[]=$excel->sheets[$numerohoja]['cells'][$this->encabezadosRow][$tempcol];
		}
		
		//die;
		
		return $campos;
		
	}		
	
	
	
	
	private function revisayobjtenobjetohoja(&$hoja)
	{
		if(is_string($hoja))
		{
			$nombrehoja=$hoja;
			$excel=&$this->excel;/* @var $excel PHPExcel */
			$hoja=&$excel->getSheetByName($nombrehoja);
			if(!$hoja)
			{
				$hoja=new PHPExcel_Worksheet(&$this->excel,$nombrehoja);			
				$excel->addSheet($hoja);
				$hoja=&$excel->getSheetByName($nombrehoja);
			}
		}
		return $hoja;
	}
	
	function fijahojacatlogacelda($nombrehoja,$coordendascelda,$hojacatalogo)
	{	
		$excel=&$this->excel;/* @var $excel PHPExcel */
		//$excel = new PHPExcel;
		$excel->
		//$hoja=$this->revisayobjtenobjetohoja($hoja);
		$excel->setActiveSheetIndex(0);
		chek($excel);
		
		$objValidation = $excel->getActiveSheet()->getCell($coordendascelda)->getDataValidation();
		$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_WHOLE );
		$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP );
		$objValidation->setAllowBlank(true);
		$objValidation->setShowInputMessage(true);
		$objValidation->setShowErrorMessage(true); 
		$objValidation->setErrorTitle('Valor no permitido'); 
		$objValidation->setError('Valor no permitido');
		$objValidation->setPromptTitle('Valor no permitido');
		$objValidation->setPrompt('Solo valores de en la columna b de la hoja:'.$hojacatalogo.' estan permitidos');
		//$objValidation->setFormula1('='.$hojacatalogo.'!$B$1:$B$900'); //=perfiles!$B$1:$B$33   =perfiles!$B$1:$B$24
		$objValidation= new PHPExcel_Cell_DataValidation;
		chek($objValidation->getFormula1());
		//$objValidation->setFormula1(10);
		//$objValidation->setFormula2(20);
		//$excel->getActiveSheet()->getCell($coordendascelda)->setDataValidation($objValidation);	
		
	}
	
	
	function setCellValue($coordenadas,$valor,&$hoja)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);

		$hoja->setCellValue($coordenadas,$valor);	
	}
	
	function renombrahoja($nombreviejo,$nombrenuevo)
	{
		$excel=&$this->excel;/* @var $excel PHPExcel */
		
		chek($excel->getSheetNames() );
		
		
		$hoja=&$excel->getSheetByName($nombreviejo);
		if(!is_a($hoja,'PHPExcel_Worksheet')){$hoja=$this->revisayobjtenobjetohoja($nombreviejo);}
		$hoja->setTitle($nombrenuevo);
		
		//chek($excel->getSheetNames() );
	}	
	
	private function respaldacamposencabesado(&$hoja)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);
		
		$maxcol=$hoja->getHighestColumn();
		for($row=1;$row<=$this->encabezadosRow;$row++)
		{
			for($col='A';$col<=$maxcol;$col++)
			{
				//chek($col.$row);
				$camposencabsado[$col.$row]=$hoja->getCell($col.$row)->getValue();
			}
		}
		return	$camposencabsado;
	}
	
	private function restauracamposencabesado(&$hoja,$camposencabsado)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);
		
		foreach($camposencabsado as $key=>$value)
		{
			$hoja->setCellValue($key,$value);
		}
	}


	
	
	function leerregistroporrenglon($hoja,$camposcols,$row)//lee un registro pero no con filtros sino por el numero de renglon
	{
		$excel=&$this->excel;
		
		if(is_string($hoja))
		{
			$numerohoja=$this->getSheetNumberByName($hoja,$excel);
		}

		
		foreach($camposcols as $key=>$value)
		{
			//$ret[$key]=$hoja->getCell($value.$row)->getValue();
			if($excel->sheets[$numerohoja]['cells'][$row][$value]==='0')
			{$val='0';}
			else
			{$val=$excel->sheets[$numerohoja]['cells'][$row][$value];}
			$ret[$key]=utf8_encode($val);
			
		}
		return $ret;
		
	}
	
	private function getcoordendascols(&$hoja,$data)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);
		/* @var $hoja PHPExcel_Worksheet */
		foreach($data as $key=>$value)
		{
			$columna=$this->encuentracolumna($hoja,$key);
			$ret[$key]=$columna;
		}
		return $ret;
	}

	private function encuentracolumna(&$hoja,$key)
	{
		$hoja=$this->revisayobjtenobjetohoja($hoja);
		/* @var $hoja PHPExcel_Worksheet */
		
		$maxcol=$hoja->getHighestColumn();
		$maxcol++;
		for($tempcol='A';$tempcol!=$maxcol;$tempcol++)
		{
			//chek('key- '.$key);
			//chek('col- '.$hoja->getCell($tempcol.$this->encabezadosRow)->getValue());
			if($hoja->getCell($tempcol.$this->encabezadosRow)->getValue()==$key)
			{ return $tempcol; }
		}
	}
	
	function save()
	{
		//chek($this->excel);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, $this->versiondeexcel);
		$objWriter->save($this->path);	
	}
	
	private function generacampos($campos)
	{
		foreach($campos as $campo)
		{
			/* @var $campo campoentrada */
			if(is_a($campo,'campoentrada'))
			{ 
				$camposarray[]=$campo->nombre; 
			}
			else if(is_string($campo))
			{
				$camposarray[]=$campo;
			}
		}
		//chek($camposarray);
		return $camposarray;
	}	
	
}




?>