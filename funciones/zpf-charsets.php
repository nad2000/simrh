<?
/*
falta cometar qeu hace cada funcion o al menos listarlas

*/



//------------------
//-------------------
function asciiandhtml2utf8($string)
{
	//$string = html_entity_decode( $string );//lo que hay html lo pasa a ascii
	
	//echo '<br>string: '.$string."\n";
	$string = ascii2UTF8($string); //todo a utf-8
	//echo '<br>stringhtmlentitites: '.$string."\n";
	

	$trans_array['&#38;lt;'] = '&#60;';
	$trans_array['&#60;'] = '<';
	$trans_array['&#62;'] = '>';
	$trans_array['&#34;'] = '"';
	$trans_array['\\&#34;'] = '"';
	$trans_array['\\&#39;'] = '&#39;';

	$trans_array['&#38;amp;'] = '&#38;';
	$trans_array['&#38;nbsp;'] = '&#160;';

		
	$string = strtr($string, $trans_array); //vuleve a hacer los tags
	//echo '<br>stringtrans: '.$string."\n";
	
	// fix for extended characters
	//$string = preg_replace("/&amp;#([0-9]+);/", "&#$1;", $string);*/
	return $string;		
}

function htmlentities2unicodeentities($input) {
  $htmlEntities = array_values (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $entitiesDecoded = array_keys  (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $num = count ($entitiesDecoded);
  for ($u = 0; $u < $num; $u++) {
   $utf8Entities[$u] = '&#'.ord($entitiesDecoded[$u]).';';
  }
  return str_replace ($htmlEntities, $utf8Entities, $input);
}

function unicodeentities2htmlentities($input) {
  $htmlEntities = array_values (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $entitiesDecoded = array_keys  (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $num = count ($entitiesDecoded);
  for ($u = 0; $u < $num; $u++) {
   $utf8Entities[$u] = '&#x'.strtoupper( dechex( ord($entitiesDecoded[$u]) ) ).';';
  }
  return str_replace ($utf8Entities, $htmlEntities, $input);
}

function unicodeentities162unicodeentities8($input) {
  $entitiesDecoded = array_keys  (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $num = count ($entitiesDecoded);
  for ($u = 0; $u < $num; $u++) {
   $utf16Entities[$u] = '&#x'.strtoupper( dechex( ord($entitiesDecoded[$u]) ) ).';';

   $utf8Entities[$u] = '&#'.ord($entitiesDecoded[$u]).';';
   
  }
  return str_replace ($utf16Entities, $utf8Entities, $input);
}


function ascii2UTF8($input) {
  $ascii = array_keys  (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $num = count ($ascii);
  for ($u = 0; $u < $num; $u++) 
  {
   $utf8Entities[$u] = '&#'.ord($ascii[$u]).';'; 
  }
  array_pop($ascii);
  array_pop($utf8Entities);
  $ascii[0]='&';
  $utf8Entities[0]='&#38;';
  return str_replace ($ascii, $utf8Entities, $input);
}

//------------------ChafCode-- el PHP me falla (leee yescribe mal los UTF-8 del XML) por primera vez por lo que hice un hechizo
function ascii2ChafCode($input) {
  $ascii = array_keys  (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $num = count ($ascii);
  for ($u = 0; $u < $num; $u++) {
   $ChafCodeEntities[$u] = '-#'.ord($ascii[$u]).';';
  }
  return str_replace ($ascii, $ChafCodeEntities, $input);
}

function UTF82ChafCode($input) {
  $ascii = array_keys  (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $num = count ($ascii);
  for ($u = 0; $u < $num; $u++) {
   $ChafCodeEntities[$u] = '-#'.ord($ascii[$u]).';';
   $utf8Entities[$u] = '&#'.ord($ascii[$u]).';';
  }
  return str_replace ($utf8Entities, $ChafCodeEntities, $input);
}

function ChafCode2ascii($input) {
  $ascii = array_keys  (get_html_translation_table (HTML_ENTITIES, ENT_QUOTES));
  $num = count ($ascii);
  for ($u = 0; $u < $num; $u++) {
   $ChafCodeEntities[$u] = '-#'.ord($ascii[$u]).';';
  }
  return str_replace ($ChafCodeEntities, $ascii, $input);
}
//------------------
//-------------------


?>