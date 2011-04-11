<?
session_start();

$urlpagina='gameplan';

require_once 'clasesincluder.php';
require_once 'acceso.php';
require_once 'arreglosdecampos.php';

//$camposentrada=array('NoPersonal', 'NombreEmpleado' ,'NombrePuesto', 'NombrePerfil', 'PerfilTipo', 'TipodePuesto', 'Division', 'Area', 'Zona', 'UnidadOperativa');

//	$NombreEmpleado=$_SESSION['NombreEmpleado'];
//	$estudios=$_SESSION['estudios'];
//	
//	$NombrePuesto=$_SESSION['NombrePuesto'];
//	$OtrasPosiciones=$_SESSION['OtrasPosiciones'];
//	$Division=$_SESSION['Division'];
//	$TipodePuesto=$_SESSION['TipodePuesto'];
//	$Area=$_SESSION['Area'];
//	$UnidadOperativa=$_SESSION['UnidadOperativa'];
//	$Zona=$_SESSION['Zona'];
//	$PerfilTipo=$_SESSION['Perfil'];
//	$Experiencia=$_SESSION['Experiencia'];
//	$EstadoPromocional=$_SESSION['EstadoPromocional'];	
//	$Temporalidad=$_SESSION['Temporalidad'];
//
//	if($_GET['paggp']=='siguiente'){$Pagina++;}
//	if($_GET['paggp']=='aterior' AND $Pagina>=1 ){$Pagina--;}
//	
//	$_SESSION['Pagina']=$Pagina;
	

$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);

	$NombreEmpleado=$_SESSION['NombreEmpleado'];
	$estudios=$_SESSION['estudios'];
	
	$NombrePuesto=$_SESSION['NombrePuesto'];
	$OtrasPosiciones=$_SESSION['OtrasPosiciones'];
	$Division=$_SESSION['Division'];
	$TipodePuesto=$_SESSION['TipodePuesto'];
	$Area=$_SESSION['Area'];
	$UnidadOperativa=$_SESSION['UnidadOperativa'];
	$Zona=$_SESSION['Zona'];
	$PerfilTipo=$_SESSION['Perfil'];
	$Experiencia=$_SESSION['Experiencia'];
	$EstadoPromocional=$_SESSION['EstadoPromocional'];	
	$Temporalidad=$_SESSION['Temporalidad'];	

	$Pagina=$_SESSION['Pagina'];

if($NombreEmpleado OR $estudios OR $NombrePuesto OR $OtrasPosiciones OR $Division OR $TipodePuesto OR $Area OR $UnidadOperativa OR $Zona OR $PerfilTipo OR $Experiencia OR $EstadoPromocional OR $Temporalidad)
{

	///-------------------------Query
	$query="Select NoPersonal, NoPuesto, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos";
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
	
	$data=$sql->queryArreglo($query);
	$total=sizeof($data);
	//------------------------------------fin de consulta
	
	
	
	//--------limpieza para lectores y editores
	
	if($niveldeacceso!='Admin')
	{
		foreach($data as $key=>$renglon)
		{		
	
			if(!in_array($renglon["UnidadOperativa"],$unidadesvisibles))
			{
				unset($data[$key]);
			}	
		}	
	}
	
	//------------------------------

	//chek($dataorganizado);

	foreach($data as $renglon)
	{		
		
		
		$idempleado=$renglon['NoPersonal'];
		$nombre=$renglon['NombreEmpleado'];
		
		$trs=$sql->queryArregloUNI("Select NoPersonal from trcorto where NoPuesto=".$renglon['NoPuesto']);
		
		if(sizeof($trs)==0)
		{
		
			$datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
			
			$datostrcorto[]=$renglon;
		}
	}	

	foreach($data as $renglon)
	{		
		
		
		$idempleado=$renglon['NoPersonal'];
		$nombre=$renglon['NombreEmpleado'];
		
		$trs=$sql->queryArregloUNI("Select NoPersonal from trmediano where NoPuesto=".$renglon['NoPuesto']);
		
		if(sizeof($trs)==0)
		{
		
			$datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
			
			$datostrmediano[]=$renglon;
		}
	}	
	
	foreach($data as $renglon)
	{		
		
		
		$idempleado=$renglon['NoPersonal'];
		$nombre=$renglon['NombreEmpleado'];
		
		$trs=$sql->queryArregloUNI("Select NoPersonal from trlargo where NoPuesto=".$renglon['NoPuesto']);
		
		if(sizeof($trs)==0)
		{
		
			$datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
			
			$datostrlargo[]=$renglon;
		}
	}
	
	foreach($data as $renglon)
	{		
		
		
		$idempleado=$renglon['NoPersonal'];
		$nombre=$renglon['NombreEmpleado'];
		
		$trs=$sql->queryArregloUNI("Select NoPersonal from trlargo where NoPuesto=".$renglon['NoPuesto']);
		
		if(sizeof($trs)==0)
		{
		
			$datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
			
			$datostrcml[]=$renglon;
		}
	}

	
	$tablacorto=new datatable('Op Corto',$campossalidagrid,$campossalidagrid,$datostrcorto);
	$tablamediano=new datatable('Op Mediano',$campossalidagrid,$campossalidagrid,$datostrmediano);
	$tablalargo=new datatable('Op Largo',$campossalidagrid,$campossalidagrid,$datostrlargo);
	$tablacml=new datatable('Op CML',$campossalidagrid,$campossalidagrid,$datostrcml);
	
	if(file_exists("./exceles/$NoUsuario.xls")){unlink("./exceles/$NoUsuario.xls");}
	$excelbusqueda = new datosexcel("./exceles/$NoUsuario.xls");
		
//	chek($tablacorto->tabla);
//	$tablacorto->imprimeHTML();
	
	$tablacorto->guardar($excelbusqueda);	
	$tablamediano->guardar($excelbusqueda);
	$tablalargo->guardar($excelbusqueda);
	$tablacml->guardar($excelbusqueda);
	
header('Content-disposition: attachment; filename=DatosOportunidades.xls');

header("Content-Type: application/x-msexcel; name=\"DatosOportunidades.xls\"");
header("Content-Disposition: inline; filename=\"DatosOportunidades.xls\"");
$fh=fopen("./exceles/$NoUsuario.xls", "rb");
fpassthru($fh);
unlink("./exceles/$NoUsuario.xls");
	
}	
	