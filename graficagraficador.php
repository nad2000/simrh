<?php
session_start();

require_once ("./jpgraph/jpgraph.php");
require_once 'clasesincluder.php';
require_once 'acceso.php';
require_once 'arreglosdecampos.php';

//$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);

require_once 'criteriosgraficador.php';

$tipodegrafica=$_GET['tipo'];
$criterio1=$_GET['criterio1'];
$criterio2=$_GET['criterio2'];

$substring1 = substr($criterio1,0,18);
$substring2 = substr($criterio2,0,18);

//chek($substring1.' '.$criterio1);    //#CCC
//chek($substring2.' '.$criterio2);
$colores=array('lightgray','green','blue','red','orange','yellow','gray','pink','black','brown');

$titulo='';
$where='';
if($criterio1)
{
	

if($NombreEmpleado OR $estudios OR $NombrePuesto OR $OtrasPosiciones OR $Division OR $TipodePuesto OR $Area OR $UnidadOperativa OR $Zona OR $PerfilTipo OR $Experiencia OR $EstadoPromocional OR $Temporalidad)
{

	///-------------------------Query
	$query="Select * from empleadosypuestos";
	$query.=" where ";
	
	if($NombreEmpleado){$query.=" NombreEmpleado like '%$NombreEmpleado%' AND ";}
	if($NombrePuesto){$query.=" NombrePuesto like '%$NombrePuesto%' AND ";}
	if($Experiencia)
	{
		$query.="( NombrePuesto like '%$Experiencia%' OR ";
		$query.=" Puesto1 like '%$Experiencia%' OR ";
		$query.=" Puesto2 like '%$Experiencia%' OR ";
		$query.=" Puesto3 like '%$Experiencia%' OR ";
		$query.=" Puesto4 like '%$Experiencia%' ) AND ";
	}
	if($OtrasPosiciones){$query.=" OtrasPosiciones like '%$OtrasPosiciones%' AND ";}
	if($estudios){$query.=" Escolaridad1 like '%$estudios%' AND ";}	
	if($estudios){$query.=" Escolaridad2 like '%$estudios%' AND ";}	
	if($estudios){$query.=" Escolaridad3 like '%$estudios%' AND ";}	
	if($estudios){$query.=" Escolaridad4 like '%$estudios%' AND ";}	
	if($Division){$query.="Division='$Division' AND ";}
	if($TipodePuesto)
	{
		$query.="(";
		foreach($TipodePuesto as $TipodePuestoSeleccionado)
		{
			$query.="TipodePuesto='$TipodePuestoSeleccionado' OR ";
		}
		$query=trim($query,'OR ');
		$query.=") AND ";
	}
	if($Area){$query.="Area='$Area' AND ";}
	if($PerfilTipo){$query.="PerfilTipo=$PerfilTipo AND ";}
	
	if($EstadoPromocional)
	{
		$query.="(EdoPromocional20$anio='$EstadoPromocional' OR (EdoPromocional20$anio IS NULL AND EdoPromocional20$anioant='$EstadoPromocional') ) AND ";
	}

	if($Temporalidad)
	{
		$query.="(Temporalidad20$anio='$Temporalidad' OR (Temporalidad20$anio IS NULL AND Temporalidad20$anioant='$Temporalidad') ) AND ";
	}	
	if($UnidadOperativa){$query.="UnidadOperativa='$UnidadOperativa' AND ";}
	if($Zona){$query.="Zona='$Zona' AND ";}

	
	$query=trim($query,'AND ');
	
	//$desplazamiento=$Pagina*$itemsporpagina;
	//$query.=" limit $desplazamiento, $itemsporpagina";
	
	$data1=$sql->queryArreglo($query);

	
	if($tipodegrafica=='Pay' OR $tipodegrafica=='Barras sencillas' ){ $criterio2=null; }
	$data=obtendatosgrafica($criterio1,$criterio2,$data1,$Criterios);

	
//	chek($data);
//---------Porcentajes
	$cienporciento=0;
	if($tipodegrafica=='Barras sencillas' )
	{
		$cienporciento=array_sum(array_flatten($data));
		foreach($data as &$subdata)
		{
			foreach($subdata as &$val)
			{
				$val=$val*100/$cienporciento;
			}
		}
	
	}else if($tipodegrafica!='Pay'){
		
		foreach($data as $subdata)
		{
			$cienporciento=$cienporciento+$subdata['Cuenta'];	
		}
		foreach($data as &$subdata)
		{
			$subdata['Cuenta']=$subdata['Cuenta']*100/$cienporciento;	
		}
		
	}
//	chek($data);

//	chek($cienporciento);

	
	

}
	
}



//|| $substring2=="Estado Promocional"




if($tipo=='Pay')
{
	require_once ("./jpgraph/jpgraph_pie.php");
	require_once ("./jpgraph/jpgraph_pie3d.php");
	
	// Some data
	
	//$data=$sql->cuentadiferentesdeuncampo('empleadospuestosyrangos',$criterio1,$where);
	//$data =& $criteriosgraficador[$criterio1];
	$data = $data[0];
	
//patch para colores de edos pormocionales -- est amas abajo tambien	
if( $substring1=="Estado Promocional"  )
{
	$coloresEDOS=array('FOCO ROJO'=>'red','AP'=>'green','EST'=>'blue',''=>'lightgray','MO'=>'gray','Porjubilarse'=>'gray','PROM'=>'yellow');
	$colores=array();
	foreach($data as $key=>$datox)
	{
		$colores[]=$coloresEDOS[$key];
		//chek($key.' '.$coloresEDOS[$key]);
	}
	
	//chek($colores);
}	
	
	
	
	//chek($data);	
	// Create the Pie Graph.
	$graph = new PieGraph(500,300,"auto");
	$graph->SetShadow();
	
	// Set A title for the plot
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_VERDANA,FS_BOLD,9); 
	$graph->title->SetColor("darkblue");
	$graph->legend->Pos(0.1,0.2);
	
	// Create 3D pie plot
	$p1 = new PiePlot3d(array_values($data));
	$p1->SetTheme("sand");
	$p1->SetCenter(0.5);
	$p1->SetSize(0.4);
	$p1->SetHeight(5);
	$p1->SetSliceCOlors($colores);

	// Adjust projection angle
	$p1->SetAngle(60);
	
	// You can explode several slices by specifying the explode
	// distance for some slices in an array}
	$distancia=array();
	foreach($data as $x){$distancia[]=7;}
	$p1->Explode($distancia);
	
	// As a shortcut you can easily explode one numbered slice with
	// $p1->ExplodeSlice(3);
	
	$p1->value->SetFont(FF_ARIAL,FS_NORMAL,10);
	//$p1->SetLegends(array_keys($data));
	
	///-----------------------------------------------------
	$lbl=array();
	foreach(array_keys($data) as $label){$lbl[]=html_entity_decode($label)." %.1f%%";}
	
	$p1->SetLabels($lbl);
	$p1->SetLabelPos(1);
	
	
	$graph->Add($p1);
	$graph->Stroke();
}


if($tipo=='Barras sencillas')
{
	// $Id: barintex1.php,v 1.3 2002/07/11 23:27:28 aditus Exp $

	require_once ("./jpgraph/jpgraph_bar.php");
	
	// Some data
	//$data=$sql->cuentadiferentesdeuncampo('empleadospuestosyrangos',$criterio1,$where);
	$data = $data[0];


	$temp=array();
	$opcionescriterio1=array_keys($Criterios[$criterio1]['rangos']);
	foreach($opcionescriterio1 as $opc1)
	{
		$temp[$opc1]=$data[$opc1];
	}
	$data=$temp;
	
//patch para colores de edos pormocionales -- est amas abajo tambien	
if( $substring1=="Estado Promocional" )
{
	$coloresEDOS=array('FOCO ROJO'=>'red','AP'=>'green','EST'=>'blue',''=>'lightgray','MO'=>'gray','Porjubilarse'=>'gray','PROM'=>'yellow');
	$colores=array();
	foreach($data as $key=>$datox)
	{
		$colores[]=$coloresEDOS[$key];

	}
	//chek($coloresEDOS);
	//chek($colores);
}	


	//sort($data);	
	
	// Create the graph and setup the basic parameters 
	$graph = new Graph(660,600,'auto');	
	$graph->img->SetMargin(30,30,30,200);
	$graph->SetScale("textint");
	$graph->SetShadow();
	$graph->SetFrame(false); // No border around the graph
	
	// Add some grace to the top so that the scale doesn't
	// end exactly at the max value. 
	$graph->yaxis->scale->SetGrace(20);
	
	// Setup X-axis labels
	$graph->xaxis->SetTickLabels(array_map("html_entity_decode", array_keys($data)));
	$graph->xaxis->SetFont(FF_FONT2);
	$graph->xaxis->SetLabelAngle(90);
	
	// Setup graph title ands fonts
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_FONT2,FS_BOLD);
	                              
	// Create a bar pot
	$bplot = new BarPlot(array_values($data));
	$bplot->SetFillColor($colores);
	$bplot->SetWidth(0.5);
	$bplot->SetShadow();
	$bplot->value->SetFormat('%01.0f%%');
	
	// Setup the values that are displayed on top of each bar
	$bplot->value->Show();
	// Must use TTF fonts if we want text at an arbitrary angle
	$bplot->value->SetFont(FF_ARIAL,FS_BOLD);
	$bplot->value->SetAngle(45);
	// Black color for positive values and darkred for negative values
	$bplot->value->SetColor("black","darkred");
	$graph->Add($bplot);
	
	// Finally stroke the graph
	$graph->Stroke();
}





if($tipo=='Barras dobles')
{
	



	require_once ("./jpgraph/jpgraph_bar.php");
	
	// Some data
	//$data=$sql->cuentadiferentesdeuncampo('empleadospuestosyrangos',array($criterio1,$criterio2),$where);
	
	//chek($data);
	//chek($criterio2);
	
	//$opcionescriterio1=$sql->queryArregloUNI("Select distinct $criterio1 from empleadospuestosyrangos order by $criterio1");//labels
	//$opcionescriterio2=$sql->queryArregloUNI("Select distinct $criterio2 from empleadospuestosyrangos order by $criterio2");//labels

	$opcionescriterio1=array_keys($Criterios[$criterio1]['rangos']);
	$opcionescriterio2=array_keys($Criterios[$criterio2]['rangos']);	

	//sort($opcionescriterio1);	
	//sort($opcionescriterio2);	
	   
	//$opcionescriterio2=$fuente->queryArregloUNI("Select distinct $criterio2 from 'empleadospuestosyrangos' ");//legends
	foreach($data as $row)
	{
		$plostsdata[$row[$criterio2]][$row[$criterio1]]=$row['Cuenta'];
	}
	
	if($plostsdata['']>0){ array_unshift($opcionescriterio2,''); }
	foreach($plostsdata as $key=>$dataarray)
	{
		if($dataarray[''] AND !in_array('',$opcionescriterio1))
		{
			array_unshift($opcionescriterio1,''); 
			//chek($dataarray['']);
		}
		
	}

//chek($opcionescriterio1);
//chek($opcionescriterio2);	
	
	
	
foreach($opcionescriterio2 as $criterio2)	
{

			foreach($opcionescriterio1 as $criterio1)	
			{
				if(!$plostsdata[$criterio2][$criterio1]){$plostsdata[$criterio2][$criterio1]=0;}
			}
		
		ksort($plostsdata[$criterio2]);
	
	ksort($plostsdata);
}	

//chek($data);
//chek($plostsdata);	
//die;

	$opcionescriterio1 = array_map("html_entity_decode", $opcionescriterio1);
	$opcionescriterio2 = array_map("html_entity_decode", $opcionescriterio2);
	
	
	
//chek($plostsdata);
	
	foreach($plostsdata as $legend=>$plotdata)
	{
		//chek($legend);
		//chek($plotdata);
		
		
		//ksort($arregloplot);
		//$legend=array_keys($arregloplot); 
		//$plotdata=array_values($arregloplot);
			
		$bplot1 = new BarPlot(array_values($plotdata));
		$bplot1->SetFillColor(current($colores));
			if(!next($colores)){reset($colores);}
		
		if($legend==''){$legend='-';}
		$bplot1->SetLegend(html_entity_decode($legend));
		$bplot1->SetWidth(0.5);
		$bplot1->SetShadow();
		//$bplot1->se  SetFormt('%01.0f%%'); 
		
		
		// Setup the values that are displayed on top of each bar
		$bplot1->value->Show();
		// Must use TTF fonts if we want text at an arbitrary angle
		$bplot1->value->SetFont(FF_ARIAL,FS_BOLD);
		$bplot1->value->SetAngle(45);
		// Black color for positive values and darkred for negative values
		$bplot1->value->SetColor("black","darkred");
		$bplot1->value->SetFormat('%01.0f%%');
		$plots[]=$bplot1;
	}
	
	
	// Create the graph and setup the basic parameters 
	$graph = new Graph(890,600,'auto');	
	$graph->img->SetMargin(30,200,30,200);
	$graph->SetScale("textint");
	$graph->SetShadow();
	$graph->SetFrame(false); // No border around the graph
	
	// Setup graph title ands fonts
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_FONT2,FS_BOLD);	
	
	// Add some grace to the top so that the scale doesn't
	// end exactly at the max value. 
	$graph->yaxis->scale->SetGrace(20);
	
	// Setup X-axis labels
	$graph->xaxis->SetTickLabels($opcionescriterio1);
	$graph->xaxis->SetFont(FF_FONT2);
	$graph->xaxis->SetLabelAngle(90);
	
	$gbarplot = new GroupBarPlot($plots);
	$gbarplot->SetWidth(0.6);
	$graph->Add($gbarplot);
	$graph->legend->Pos(-0.00,0.35,"right","center");
	$graph->Stroke();	
		
}

if($tipo=='Barras acumuladas')
{



	require_once ("./jpgraph/jpgraph_bar.php");
	
	// Some data
	//$data=$sql->cuentadiferentesdeuncampo('empleadospuestosyrangos',array($criterio1,$criterio2),$where);
	
	//chek($data);
	//chek($criterio2);
	
	//$opcionescriterio1=$sql->queryArregloUNI("Select distinct $criterio1 from empleadospuestosyrangos order by $criterio1");//labels
	//$opcionescriterio2=$sql->queryArregloUNI("Select distinct $criterio2 from empleadospuestosyrangos order by $criterio2");//labels

	$opcionescriterio1=array_keys($Criterios[$criterio1]['rangos']);
	$opcionescriterio2=array_keys($Criterios[$criterio2]['rangos']);	

	sort($opcionescriterio1);	
	sort($opcionescriterio2);	
	   
	//$opcionescriterio2=$fuente->queryArregloUNI("Select distinct $criterio2 from 'empleadospuestosyrangos' ");//legends
	foreach($data as $row)
	{
		$plostsdata[$row[$criterio2]][$row[$criterio1]]=$row['Cuenta'];
	}
	
	if($plostsdata['']>0){ array_unshift($opcionescriterio2,''); }
	foreach($plostsdata as $key=>$dataarray)
	{
		if($dataarray[''] AND !in_array('',$opcionescriterio1))
		{
			array_unshift($opcionescriterio1,''); 
			//chek($dataarray['']);
		}
		
	}

//chek($opcionescriterio1);
//chek($opcionescriterio2);	
	
	
	
foreach($opcionescriterio2 as $criterio2)	
{

			foreach($opcionescriterio1 as $criterio1)	
			{
				if(!$plostsdata[$criterio2][$criterio1]){$plostsdata[$criterio2][$criterio1]=0;}
			}
		
		ksort($plostsdata[$criterio2]);
	
	ksort($plostsdata);
}	

//chek($data);
//chek($plostsdata);	
//die;

	$opcionescriterio1 = array_map("html_entity_decode", $opcionescriterio1);
	$opcionescriterio2 = array_map("html_entity_decode", $opcionescriterio2);
	
	
	
//chek($plostsdata);	
	
	foreach($plostsdata as $legend=>$plotdata)
	{
		
		$bplot1 = new BarPlot(array_values($plotdata));
		$bplot1->SetFillColor(current($colores));
			if(!next($colores)){reset($colores);}
		
		if($legend==''){$legend='-';}
		$bplot1->SetLegend(html_entity_decode($legend));
		$bplot1->SetWidth(0.5);
		$bplot1->SetShadow();
	
		
		// Setup the values that are displayed on top of each bar
		//$bplot1->value->Show();
		// Must use TTF fonts if we want text at an arbitrary angle
		//$bplot1->value->SetFont(FF_ARIAL,FS_BOLD);
		//$bplot1->value->SetAngle(45);
		// Black color for positive values and darkred for negative values
		//$bplot1->value->SetColor("black","darkred");
		$plots[]=$bplot1;
	}
	
	
	// Create the graph and setup the basic parameters 
	$graph = new Graph(890,580,'auto');	
	
	//$graph->img->SetMargin(30,30,30,30);
	
	$graph->SetScale("textint");
	$graph->SetShadow();
	$graph->SetFrame(false); // No border around the graph
	
	// Add some grace to the top so that the scale doesn't
	// end exactly at the max value. 
	$graph->yaxis->scale->SetGrace(20);
	
	// Setup X-axis labels
	$graph->xaxis->SetTickLabels($opcionescriterio1);
	$graph->xaxis->SetFont(FF_FONT2);
	//$graph->xaxis->SetLabelAngle(90);

	// Setup graph title ands fonts
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_FONT2,FS_BOLD);
	
	
	$gbarplot = new AccBarPlot($plots);
	$gbarplot->SetWidth(0.6);
	$graph->Add($gbarplot);
	$graph->legend->Pos(-0.00,0.35,"right","center");
	
	$graph->Set90AndMargin(200,100,60,10);
	
	$graph->Stroke();	
		
}

?>