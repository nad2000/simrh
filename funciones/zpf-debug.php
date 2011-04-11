<?


function chek($var='chek aqui')
{
	if ( !empty($var) ){
	?><pre><?
	print_r ($var);
	?></pre><?
	}
	else { echo 'vacio<br>'; }
}//function arrchek($arr)

function aqui($var='aqui')
{
	echo '<br>'.$var.'<br>';
}

/*
function arrchek($arr)
{
	if(empty($arr) ) { echo 'vacio<br>'; }
	foreach($arr as $key => $val)
	{
		if( is_array($val) )
		{
			?><blockquote>-><? echo $key; ?><br><?
			arrchek($val);
			?></blockquote><?
		}else{//if( is_array($val) )
			echo $key.'--'.$val.'<br>';
		}//}else{
	}//foreach($arr as $key => $val)
}//function arrchek($arr)
*/

?>