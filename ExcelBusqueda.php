<?php
session_start();
require_once 'clasesincluder.php';
require_once 'acceso.php';
require_once 'arreglosdecampos.php';


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


if($Experiencia OR $Zona OR $UnidadOperativa OR $Temporalidad OR $NombreEmpleado OR $EstadoPromocional OR $estudios OR $NombrePuesto OR $OtrasPosiciones OR $Division OR $TipodePuesto OR $Area OR $PerfilTipo)
{
	
	///-------------------------Query
	$query='Select NoPersonal, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos';
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
	
	$desplazamiento=$Pagina*$itemsporpagina;
	//$query.=" limit $desplazamiento, $itemsporpagina";
	

	$data=$sql->queryArreglo($query);
	$tabla=new datatable('resultados',$camposentrada,$camposentrada,$data);
	
	if(file_exists("./exceles/$NoUsuario.xls")){unlink("./exceles/$NoUsuario.xls");}
	$excelbusqueda = new datosexcel("./exceles/$NoUsuario.xls");	
	$tabla->guardar($excelbusqueda);
}


header('Content-disposition: attachment; filename=DatosBusqueda.xls');

header("Content-Type: application/x-msexcel; name=\"DatosBusqueda.xls\"");
header("Content-Disposition: inline; filename=\"DatosBusqueda.xls\"");
$fh=fopen("./exceles/$NoUsuario.xls", "rb");
fpassthru($fh);
unlink("./exceles/$NoUsuario.xls");

?>