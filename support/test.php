<?
require_once 'clasesincluder.php';

$excel= new datosexcel2("test.xls",1);

$excel=$excel->excel;

			if($excel->sheets[0]['cells'][2][27]==='0')
			{ echo '0';}
			else
			{chek($excel->sheets[0]['cells'][1][27]);}
			
			//chek($excel);
?>