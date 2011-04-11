<?

function enc_filename_esp($filename)
{

//$str='./'.$dir.'/'.$nombre_base_f.'-_-'.$workbook.'.html';

$search=array("á" , "é" , "í" , "ó" , "ú" , "," , " ");
$replace=array("-a" , "-e" , "-i" , "-o" , "-u" , "--" , "_");

$nombre_file=str_replace($search, $replace, $filename);

$nombre_file=htmlentities($nombre_file);

$nombre_file=str_replace('&ntilde;', '-n', $nombre_file);

return $nombre_file;

}

function dec2web_filename_esp($filename)
{

//$str='./'.$dir.'/'.$nombre_base_f.'-_-'.$workbook.'.html';

$replace=array("&aacute;" , "&eacute;" , "&iacute;" , "&oacute;" , "&uacute;" , "&ntilde;", "," , "&nbsp;");
$search=array("-a" , "-e" , "-i" , "-o" , "-u" , "-n", "--" , "_");

$nombre_file=str_replace($search, $replace, $filename);

//$nombre_file=htmlentities($nombre_file);

$nombre_file=str_replace('-&nbsp;-', '-_-', $nombre_file);

return $nombre_file;

}

function decweb2_filename_esp($filename)
{

//$str='./'.$dir.'/'.$nombre_base_f.'-_-'.$workbook.'.html';

$search=array("&aacute;" , "&eacute;" , "&iacute;" , "&oacute;" , "&uacute;" , "&ntilde;", "," , "&nbsp;");
$replace=array("-a" , "-e" , "-i" , "-o" , "-u" , "-n", "--" , "_");

$nombre_file=str_replace($search, $replace, $filename);

//$nombre_file=htmlentities($nombre_file);

//$nombre_file=str_replace('-&nbsp;-', '-_-', $nombre_file);

return $nombre_file;

}



?>