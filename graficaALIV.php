<?php
require_once ("./jpgraph/jpgraph.php");
require_once ("./jpgraph/jpgraph_radar.php");

$urlpagina='simulador';

require_once 'clasesincluder.php';
require_once 'acceso.php';

$idempleado=$_GET['noempleado'];

require_once 'arreglosdecampos.php';

$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);

$datos=$sql->queryArreglo("SELECT * FROM empleadosypuestos e WHERE NoPersonal=$idempleado");
$datos=$datos[0];
$empdata = array($datos["Analitico"],$datos["Logico"],$datos["Intuitivo"],$datos["Visionario"]);
$empdataAnterior = array($datos["AnaliticoAnterior"],$datos["LogicoAnterior"],$datos["IntuitivoAnterior"],$datos["VisionarioAnterior"]);

$perfil=$datos['PerfilTipo'];
$datos=$sql->queryArreglo("SELECT * FROM perfiles e WHERE NoPerfil=$perfil");
$datos=$datos[0];
$perfildata = array($datos["Analitico"],$datos["Logico"],$datos["Intuitivo"],$datos["Visionario"]);


// Create the graph and the plot
$graph = new RadarGraph(380,300,"auto");
$graph->SetScale('lin',0,100); 
$graph->SetPos(0.45,0.5); 
$graph->legend->Pos(0.02,0.02,"top","right");
$graph->SetFrame(false);

// Create the titles for the axis
$graph->SetTitles(array('A','L','I','V'));

// Add grid lines
$graph->grid->Show();
$graph->grid->SetColor('lightgray');
//$graph->grid->SetLineStyle('dotted');

// Perfil
$perfil = new RadarPlot($perfildata);
$perfil->SetColor('blue');
$perfil->SetLineStyle('dashed');

$perfil->SetLegend('Perfil');

// anterior
$empant = new RadarPlot($empdataAnterior);
$empant->SetColor('orange');

$empant->SetLegend('Anterior');

//// 2008

$emp = new RadarPlot($empdata);
$emp->SetColor('brown');

$emp->SetLegend('ALIV');


//// Add the plot and display the graph
$graph->Add($perfil);
$graph->Add($empant);
$graph->Add($emp);

$graph->Stroke();
?>