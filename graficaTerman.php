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
//$graph->SetScale("textlin",0,150);
$graph->SetScale("textlin",90,126);	
	
/*
90-95 inferior
96-100 Inferior al termino medio
101-105 termino medio bajo
106-110 medio 
111-115 termino medio alto
116-120 superior al termino medio
121-125

*/	
	
$graph->Set90AndMargin(92,3,20,65);
$graph->SetShadow();

$graph->SetFrame(false); // No border around the graph
$graph->SetBackgroundImage("./pics/TermanBKG.png",BGIMG_FILLFRAME);
// Add some grace to the top so that the scale doesn't
// end exactly at the max value. 



// Setup X-axis labels
$a = $gDateLocale->GetShortMonth();
$graph->xaxis->SetTickLabels(array(              'Información', 
              'Juicio', 
              'Vocabulario', 
              'Síntesis',   
              'Concentración', 
              'Análisis', 
              'Abstracción',  
              'Planeación', 
              'Organización', 
              'Atención', 
              'Terman CI'));

$graph->xaxis->SetLabelAngle(0);
$graph->ygrid->Show(null);
$graph->xgrid->Show(null);	

//$graph->xaxis->SetFont(FF_FONT2);

$graph->yaxis->SetPos('max');
//$graph->yaxis->SetTickSide(SIDE_LEFT);

$graph->yaxis->HideLabels();



// Setup graph title ands fonts
$graph->title->Set("Terman");
$graph->title->SetFont(FF_FONT1,FS_BOLD);


// Create a bar pot
//EMPLADO - CANDIDATO-  //OJO el empleado debe ir antges del perfil pues el tipode perfil se lee del empleado
$datos=$sql->queryArreglo("SELECT * FROM empleadosypuestos e WHERE NoPersonal=$idempleado");
$datos=$datos[0];
$empdata = array($datos["Informacion"], $datos["Juicio"], $datos["Vocabulario"], $datos["Sintesis"], $datos["Concentracion"], $datos["Analsis"], $datos["Abstraccion"], $datos["Planeacion"], $datos["Organizacion"], $datos["Atencion"], $datos["TermanCI"]);


$bplot = new BarPlot($empdata);
$bplot->SetFillColor("gray");
$bplot->SetWidth(0.6);
//$bplot->SetStepStyle();
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





