<?
function array_unshift_assoc(&$arr, $key, $val)
{
   $arr = array_reverse($arr, true);
   $arr[$key] = $val;
   $arr = array_reverse($arr, true);
   return count($arr);
} 

function insert_in_array_pos($array, $pos, $value)
{
  if(!is_array($value) ) { $value=array($value); }
  if(!is_array($array) ) { $array=array($array); }
  $result = array_merge(array_slice($array, 0 , $pos), $value, array_slice($array,  $pos));
  return $result;
}

/**
 * Imprime un select a partir de un arreglo de arreglos [0]valor [1]texto
 *
 * @param array $lista
 * @param string $nombre
 * @param string $valor
 * @param string $atrribs
 */
function htmlselect ($lista, $nombre, $valor, $atrribs='')//lista tiene un arreglo de arreglos con valor en el 0 y texto en el 1
{
?> 

<select name="<? printf($nombre); ?>" <? echo $atrribs ?> >
<?php for ($ren=0;  $ren< sizeof($lista); $ren++){?>
<option <? if($valor === $lista[$ren][0]) {?> selected="selected" <? } ?>value="<? Printf($lista[$ren][0]); ?>"><? Printf ($lista[$ren][1]); ?></option>				 
<?php } ?>
</select>

<?
}

/**
 * Imprime un select a partir de un arreglo unidimencional poene valor y texto iguales
 *
 * @param array $lista
 * @param string $nombre
 * @param string $valor
 * @param string $atrribs
 */
function htmlselectuni ($lista, $nombre, $valor, $atrribs='')//lista tiene es un arreglounidimesional y pone el vlaor y el nombre iguales
{
?> 

<select name="<? printf($nombre); ?>" <? echo $atrribs ?> >
<?php foreach($lista as $item){?>
<option <? if($valor === $item) {?> selected="selected" <? } ?>value="<? Printf($item); ?>"><? Printf ($item); ?></option>				 
<?php } ?>
</select>

<?
}

/**
 * Imprime un select a partir de un arreglo unidimencional 'valor'=>'texto'
 *
 * @param array $lista
 * @param string $nombre
 * @param string $valor
 * @param string $atrribs
 */
function htmlselectuni2 ($lista, $nombre, $valor, $atrribs='')//lista tiene es un arreglounidimesional y pone el con la llave numerica y el nombre iguales
{
?> 

<select name="<? printf($nombre); ?>" <? echo $atrribs ?> >
<?php foreach($lista as $key=>$item){?>
<option <? if($valor == $key) {?> selected="selected" <? } ?>value="<? Printf($key); ?>"><? Printf ($item); ?></option>				 
<?php } ?>
</select>

<?
}

function &array_reverse_ref(&$a) {
   $r = array();
   for($i=0, $j=count($a); $i<count($a); $i++, $j--) 
   {
       $r[$i] =& $a[$j-1];
   }
   return $r;
}


function array2table2($array)
{
?><table><?
	foreach($array as $key=>$subarray)
	{
	?><tr><td><b><? echo $key ?></b></td><?
		foreach($subarray as $elem)
		{
			?><td><? echo $elem ?></td><?
		}
	?></tr><?
	}
?></table><?
}



/**
 * Translate a result array into a HTML table
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.3.1
 * @link        http://aidanlister.com/repos/v/function.array2table.php
 * @param       array  $array      The result (numericaly keyed, associative inner) array.
 * @param       bool   $recursive  Recursively generate tables for multi-dimensional arrays
 * @param       bool   $return     return or echo the data
 * @param       string $null       String to output for blank cells
 */
function array2table($array, $recursive = false, $return = false, $null = '&nbsp;')
{
  
	
	// Sanity check
	if (empty($array) || !is_array($array)) {
		return false;
    }

    if (!isset($array[0]) || !is_array($array[0])) {
        $array = array($array);
    }

    // Start the table
    $table = "<table>\n";

    // The header
    $table .= "\t<tr>";
    // Take the keys from the first row as the headings
	foreach (array_keys($array[0]) as $heading) {
		$table .= '<th>' . $heading . '</th>';
	}
    $table .= "</tr>\n";

    // The body
	foreach ($array as $row) {
        $table .= "\t<tr>" ;
		foreach ($row as $cell) {
			$table .= '<td>';

            // Cast objects
            if (is_object($cell)) { $cell = (array) $cell; }
            
            if ($recursive === true && is_array($cell) && !empty($cell)) {
                // Recursive mode
                $table .= "\n" . array2table($cell, true, true) . "\n";
            } else {
		/*
		 $meses=array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
   $mesestmp=array_flip($meses);
				$tmpxxx=array();
				$tmpxxx=explode('de',$cell);

				if( sizeof($tmpxxx)<2)
				{
					$table.='Sin fecha';		
				} else {
					$tmpxxx[0]=trim($tmpxxx[0]);
					$tmpxxx[1]=trim($tmpxxx[1]);
					$tmpxxx[0]=sprintf ("%'02.2s\n",  $mesestmp[$tmpxxx[0]]); 
					$table.=$tmpxxx[1].$tmpxxx[0];
				}
		*/	
                $table .= (strlen($cell) > 0) ?
                    htmlspecialchars((string) $cell) :
                    $null;
					
            }

            $table .= '</td>';
		}

        $table .= "</tr>\n";
	}

    // End the table
    $table .= '</table>';

    // Method of output
    if ($return === false) {
        echo $table;
    } else {
        return $table;
    }
}



?>