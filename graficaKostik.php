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
$empdata2008 = array(
$datos["GKostik"],$datos["NKostik"],$datos["WKostik"],$datos["FKostik"],9-$datos["KKostik"],
$datos["EKostik"],9-$datos["ZKostik"],$datos["CKostik"],$datos["DKostik"],$datos["RKostik"],
$datos["OKostik"],$datos["BKostik"],$datos["SKostik"],$datos["XKostik"],$datos["VKostik"],
$datos["TKostik"],$datos["IKostik"],$datos["PKostik"],$datos["LKostik"],$datos["AKostik"]);

//$perfil=$datos['PerfilTipo'];
//$datos=$sql->queryArreglo("SELECT * FROM perfiles e WHERE NoPerfil=$perfil");
//$datos=$datos[0];
$perfildata = array(
$datos["pGKostik"],$datos["pNKostik"],$datos["pWKostik"],$datos["pFKostik"],9-$datos["pKKostik"],
$datos["pEKostik"],9-$datos["pZKostik"],$datos["pCKostik"],$datos["pDKostik"],$datos["pRKostik"],
$datos["pOKostik"],$datos["pBKostik"],$datos["pSKostik"],$datos["pXKostik"],$datos["pVKostik"],
$datos["pTKostik"],$datos["pIKostik"],$datos["pPKostik"],$datos["pLKostik"],$datos["pAKostik"]);

// Create the graph and the plot
$graph = new RadarGraph(380,300,"auto");
$graph->SetScale('lin',0,9); 
$graph->SetPos(0.42,0.5); 
$graph->SetBackgroundImage("./pics/KostikBKG.png",BGIMG_FILLFRAME);
$graph->legend->Pos(0.02,0.02,"top","right");
$graph->SetFrame(false);

// Create the titles for the axis
$graph->SetTitles(array('G','N','W','F','K','E','Z','C','D','R','O','B','S','X','V','T','I','P','L','A'));





// Add grid lines
$graph->grid->Show();
$graph->grid->SetColor('lightgray');
//$graph->grid->SetLineStyle('dotted');

// Perfil
$perfil = new RadarPlot($perfildata);
$perfil->SetColor('blue');
$perfil->SetLineStyle('dashed');

$perfil->SetLegend('Perfil');



//// 2008

$emp = new RadarPlot($empdata2008);
$emp->SetColor('brown');

$emp->SetLegend('Kostik');


//// Add the plot and display the graph
$graph->Add($perfil);
//$graph->Add($empant);
$graph->Add($emp);

$graph->Stroke();
?>