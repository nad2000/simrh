<?php


class Spreadsheet_Excel_Reader_phpexcelinterface extends Spreadsheet_Excel_Reader
{
//nota se debe modificar el constructor de la clase reader a __construct

	
	var $hojaactiva;
	
	
	function __construct()
	{
		parent::__construct();
		$this->hojaactiva=0;
		
	} 

	function getSheetByName($name)
	{
		
		foreach($this->boundsheets as $key=>$val)
		{
			if($val['name']==$name)
			{ 
				$hoja=new PHPExcel_Worksheet_alike( $this->sheets[$key] );
			
				return $hoja; 
			}
		}
		
	}

	function getActiveSheet()
	{
		$hoja=new PHPExcel_Worksheet_alike( $this->sheets[$this->hojaactiva] );
		
		return  $hoja;
		
	}	
	
	
}

class PHPExcel_Worksheet_alike
{
	var $data;
	
	function __construct($hoja)
	{
		$this->data=$hoja;
	} 	
	
	function getHighestColumn()
	{
		$ret='A';
		for($i=1;$i<=$this->data['numCols'];$i++)
		{
			$ret++;
		}
		
		
		return $ret;
	}
	
	function getHighestRow()
	{
		return $this->data['numRows'];
	}
	
	
	
	function getCell($texcoordiantes)
	{
		$col=0;
		$row='';
		
		$valoresletras=array('A'=>1,'B'=>2,'C'=>3,'D'=>4,'E'=>5,'F'=>6,'G'=>7,'H'=>8,'I'=>9,'J'=>10,'K'=>11,'L'=>12,'M'=>13,'N'=>14,'O'=>15,'P'=>16,'Q'=>17,'R'=>18,'S'=>19,'T'=>20,'U'=>21,'V'=>22,'W'=>23,'X'=>24,'Y'=>25,'Z'=>26);
		
		//chek($texcoordiantes);
		$texcoordiantes='CA9944';
		
		$max = mb_strlen($texcoordiantes);
		for ($i = 0; $i < $max; $i++) 
		{
			$char = $texcoordiantes[$i];
			
			if(!is_numeric($char)){$col=$col*26+$valoresletras[$char];}
			else { $row=$row.$char; }
		
		}	
		
		$row=(int)$row;
		
		
		
		//--------------------------------------------------------------
		
		
		return new PHPExcel_Cell_alike($this->data[$row][$col]);
	}
}

class PHPExcel_Cell_alike
{
	var $valor;
	
	function __construct($valor)
	{
		$this->valor=$valor;
	} 

	function getValue()
	{
		return $this->valor;
	}
}


?>