<?php
require_once ("./jpgraph/jpgraph.php");
require_once ("./jpgraph/jpgraph_bar.php");

$urlpagina='simulador';

require_once 'clasesincluder.php';
require_once 'acceso.php';

$idempleado=$_GET['noempleado'];
$tipo=$_GET['tipo'];

require_once 'arreglosdecampos.php';

$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);


// Create the graph and setup the basic parameters 
$graph = new Graph(380,300,'auto');
$graph->SetScale("textlin",50,150);
	
$graph->Set90AndMargin(92,3,20,65);
$graph->SetShadow();
$graph->SetFrame(false); // No border around the graph
$graph->SetBackgroundImage("./pics/EQIBKG.png",BGIMG_FILLFRAME);

// Add some grace to the top so that the scale doesn't
// end exactly at the max value. 



// Setup X-axis labels
$a = $gDateLocale->GetShortMonth();
$graph->xaxis->SetTickLabels(array("IntRApersonal","IntERpersonal","Manejo de\nEstres","Adaptabilidad","Estado\nde Animo","Total"));

$graph->xaxis->SetLabelAngle(0);										
//$graph->xaxis->SetFont(FF_FONT2);

$graph->yaxis->SetPos('max');
//$graph->yaxis->SetTickSide(SIDE_LEFT);

$graph->yaxis->HideLabels();



// Setup graph title ands fonts
$graph->title->Set("EQI");
$graph->title->SetFont(FF_FONT1,FS_BOLD);


// Create a bar pot
//EMPLADO - CANDIDATO-  //OJO el empleado debe ir antges del perfil pues el tipode perfil se lee del empleado
$datos=$sql->queryArreglo("SELECT * FROM empleadosypuestos e WHERE NoPersonal=$idempleado");
$datos=$datos[0];
$empdata = array($datos['EQIntrapersonal'],$datos['EQInterpersonal'],$datos['EQManejodeEstres'],$datos['EQAdaptabilidad'],$datos['EQEstadodeAnimo'],$datos['EQTotal']);

$bplot = new BarPlot($empdata);
$bplot->SetFillColor("gray");
$bplot->SetWidth(0.6);
$bplot->SetShadow();

// Setup the values that are displayed on top of each bar
//$bplot->value->Show();
// Must use TTF fonts if we want text at an arbitrary angle
//$bplot->value->SetFont(FF_ARIAL,FS_BOLD);
//$bplot->value->SetAngle(45);
// Black color for positive values and darkred for negative values
//$bplot->value->SetColor("black","darkred");
$graph->Add($bplot);

// Finally stroke the graph
$graph->Stroke();
?>
