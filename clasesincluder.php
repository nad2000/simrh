<?php 
ini_set('memory_limit', '2048M');
set_time_limit(0);

//error_reporting(E_ERROR);
//error_reporting(E_ERROR | E_PARSE);
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(0);

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . './clases/phpexcel/Classes/');
set_include_path(get_include_path() . PATH_SEPARATOR . './clases/Excel/');
set_include_path(get_include_path() . PATH_SEPARATOR . './clases/excel-2.0/');
set_include_path(get_include_path() . PATH_SEPARATOR . './clases/');


$datos=array();



require_once 'funciones.php';
require_once 'almacendedatos.php';
require_once 'datatable.php';
require_once 'campos.php';
require_once 'dataregistry.php';
require_once 'formelement.php';
require_once 'objetosSIMRH.php';
require_once 'ZIPClass.php';
require_once 'reader.php';
require_once 'excelrederint.php';
require_once 'arreglosdecampos.php';
require_once 'buscadorvars.php';

$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);

require_once 'acceso.php';



///------------------
$anio=$sql->queryArregloUNI("SELECT fecha FROM simrh.juntas j order by fecha DESC limit 1");
$anio=$anio[0];
$anio=explode('-',$anio);
$anio=$anio[0];

$anio=ltrim("$anio",'20');
$anio= sprintf("%02s", $anio);
$anioant= sprintf("%02s", $anio-1);
$anioantant= sprintf("%02s", $anio-2);


/** PHPExcel */
require_once 'PHPExcel.php';

/** PHPExcel_IOFactory */
require_once 'PHPExcel/IOFactory.php';


ae_nocache();
// disable caching 
?>
