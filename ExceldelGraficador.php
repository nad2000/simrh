<?php
session_start();

require_once 'clasesincluder.php';
require_once 'acceso.php';
require_once 'arreglosdecampos.php';


require_once 'criteriosgraficador.php';

$tipodegrafica=$_GET['tipo'];
$criterio1=$_GET['criterio1'];
$criterio2=$_GET['criterio2'];









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
	

	$c1=$Criterios[$criterio1]['campo'];
	$c2=$Criterios[$criterio2]['campo'];
	
	
	$query.=" order by  $c1 DESC,  $c2 DESC";
	//$desplazamiento=$Pagina*$itemsporpagina;
	//$query.=" limit $desplazamiento, $itemsporpagina";
	
	$data=$sql->queryArreglo($query);
	
	if($tipodegrafica=='Pay' OR $tipodegrafica=='Barras sencillas' ){ $criterio2=null; }
	$datosgrafica=obtendatosgrafica($criterio1,$criterio2,$data,$Criterios);
	
	//$data=$datosgrafica;
	
foreach($datosgrafica as $keyr=>$row)
{
	foreach($row as $keyc=>$cell)
	{ 
		$a[$keyr][$keyc] = utf8_encode(html_entity_decode($cell));
	}

}
	
//	array_walk_recursive(&$datosgrafica, 'arreglaparaexcel');
	
	//chek($datosgrafica);
	
	$tabla=new datatable('resultados',$camposentrada,$camposentrada,$a);
	
	if(file_exists("./exceles/$NoUsuario.xls")){unlink("./exceles/$NoUsuario.xls");}
	$excelbusqueda = new datosexcel("./exceles/$NoUsuario.xls");
	$tabla->guardar($excelbusqueda);
}
}


header('Content-disposition: attachment; filename=DatosGrafica.xls');

header("Content-Type: application/x-msexcel; name=\"DatosGrafica.xls\"");
header("Content-Disposition: inline; filename=\"DatosGrafica.xls\"");
$fh=fopen("./exceles/$NoUsuario.xls", "rb");
fpassthru($fh);
unlink("./exceles/$NoUsuario.xls");

?>