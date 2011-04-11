<?php

require_once ("./jpgraph/jpgraph.php");
require_once ("./jpgraph/jpgraph_line.php");

$urlpagina='simulador';

require_once 'clasesincluder.php';
require_once 'acceso.php';

$idempleado=$_GET['noempleado'];
$tipo=$_GET['tipo'];
$graficaanterior=$_GET['graficaanterior'];

require_once 'arreglosdecampos.php';

$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);

// Create the graph. 
$graph = new Graph(124,300,"auto");	
$graph->SetScale("textlin",0,100);
$graph->img->SetMargin(25,2,65,25);
$graph->SetMarginColor("white"); 
$graph->ygrid->Show(null);
$graph->xgrid->Show(null);
$graph->SetFrame(false);
$graph->xaxis->SetTickLabels(array('D','I','S','C'));
$graph->legend->Pos(0.01,0.01,"top","right");

//EMPLADO - CANDIDATO-  //OJO el empleado debe ir antges del perfil pues el tipode perfil se lee del empleado
$datos=$sql->queryArreglo("SELECT * FROM empleadosypuestos e WHERE NoPersonal=$idempleado");
$datos=$datos[0];
$empdata = array($datos["D$tipo"],$datos["I$tipo"],$datos["S$tipo"],$datos["C$tipo"]);

$emp=new LinePlot($empdata);
$emp->mark->SetType(MARK_STAR);
$emp->mark->SetFillColor("brown");
$emp->mark->SetWidth(4);
$emp->SetLegend("DISC\n".$_GET['tipo']);
$emp->SetColor("brown");
//$emp->SetStyle('dashed');
$emp->SetCenter();
$graph->Add($emp);



if($graficaanterior=='si')
{
	$empantdata = array($datos["D$tipo"."Anterior"],$datos["I$tipo"."Anterior"],$datos["S$tipo"."Anterior"],$datos["C$tipo"."Anterior"]);
	
	$anterior=new LinePlot($empantdata);
	$anterior->mark->SetType(MARK_CIRCLE);
	$anterior->mark->SetFillColor("orange");
	$anterior->mark->SetWidth(4);
	$anterior->SetLegend("Anterior");
	$anterior->SetColor("orange");
	//$anterior->SetStyle('dashed');
	$anterior->SetCenter();
	$graph->Add($anterior);
}


// Perfil
if($tipo=='Observable')
{
	if($_GET['perfil']){ $perfil=$_GET['perfil']; }else{ $perfil=$datos['PerfilTipo']; }
	$datos=$sql->queryArreglo("SELECT * FROM perfiles e WHERE NoPerfil=$perfil");
	$datos=$datos[0];
	$perfildata = array($datos["D$tipo"],$datos["I$tipo"],$datos["S$tipo"],$datos["C$tipo"]);
	
	$perfil=new LinePlot($perfildata);
	$perfil->mark->SetType(MARK_UTRIANGLE);
	$perfil->mark->SetFillColor("blue");
	$perfil->mark->SetWidth(4);
	$perfil->SetLegend("Perfil");
	$perfil->SetColor("blue");
	$perfil->SetStyle('dashed');
	$perfil->SetCenter();
	$graph->Add($perfil);
}



//referencia
//$dataylinea = array(50,50,50,50);
//$ref=new LinePlot($dataylinea);
//$ref->SetColor("gray");
//$ref->SetWeight(3);
//$graph->Add($ref);



// Display the graph
$graph->Stroke();






//EMPLADO - CANDIDATO- anterior
//$empantdata = array(80,20,70,50);
//$empant=new LinePlot($empantdata);
//$empant->mark->SetType(MARK_FILLEDCIRCLE);
//$empant->mark->SetFillColor("red");
//$empant->mark->SetWidth(4);
//$empant->SetLegend('Anterior');
//$empant->SetColor("red");
//$emp->SetStyle('dashed');
//$empant->SetCenter();
//$graph->Add($empant);
?>


