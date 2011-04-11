<?
require_once 'clasesincluder.php';

if($niveldeacceso!='Admin')
{
	header("Location: ./salir.php");
	die;
}





//<!-- Inicio Puestos RH -->

if($_GET['file'])
{
	//-----------hacer cadenas para consultas sql	
	$where='';
	$campos='';
	foreach ($camposdatosRHpuestos as $campo)
	{
		$where.= " $campo is NULL OR ";
		$campos.= " $campo, ";
	}
	$where=rtrim($where,'OR ');
	$campos=rtrim($campos,', ');
	
	////--------obtien datos para la tabla
	$query="Select count(*) FROM puestos";	
	$totalpuestos=$sql->queryArregloUNI($query);
	$totalpuestos=$totalpuestos[0];
	
	$query="Select count(*) FROM puestos WHERE $where";	
	$puestoscondatosfaltantes=$sql->queryArregloUNI($query);
	$puestoscondatosfaltantes=$puestoscondatosfaltantes[0];



	if($_GET['file']=='datosRHpuestos.xls')
	{
		///-------------genera archivo total
		$query="Select $campos FROM puestos WHERE $where";	
		$data=$sql->queryArreglo($query);
		$tabla= new datatable('datos',null,null,$data);	
		$tabla->sutituyeporllaves('PerfilTipo',$sql,'perfiles','NombrePerfil','NoPerfil');
		$excel= new datosexcel("./exceles/$NoUsuario.xls");
		$excel->guardartabla('datos',$tabla->tabla);	
		
		
		header('Content-disposition: attachment; filename=datosRHpuestos.xls');
		
		header("Content-Type: application/x-msexcel; name=\"datosRHpuestos.xls\"");
		header("Content-Disposition: inline; filename=\"datosRHpuestos.xls\"");
		$fh=fopen("./exceles/$NoUsuario.xls", "rb");
		fpassthru($fh);
		unlink("./exceles/$NoUsuario.xls");		
	}



	if($_GET['file']=='datosRHpuestos.zip')
	{	
		///--------------Genera archivo por unidad operatativa
		unlinkRecursive('./exceles/temp/',FALSE);
		$Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');
	
		foreach ($Unidadesoperativas as $unidadoperativa)
		{
			//chek($unidadoperativa);
			$unidadoperativafile=cadenafilesystem($unidadoperativa);
			$query="Select $campos FROM puestos WHERE ($where) and UnidadOperativa='$unidadoperativa'";
			$data=$sql->queryArreglo($query);
			unlink("./exceles/temp/datosFEMSAempleados-$unidadoperativafile-.xls");
			if(sizeof($data)>=1){
				$tabla= new datatable('datos',null,null,$data);	
				$tabla->sutituyeporllaves('PerfilTipo',$sql,'perfiles','NombrePerfil','NoPerfil');
				$excel= new datosexcel("./exceles/temp/datosRHpuestos-$unidadoperativafile-.xls");
				$excel->guardartabla('datos',$tabla->tabla);
			}
		}
		unlink("./exceles/$NoUsuario.zip");
		$zip=new PclZip("./exceles/$NoUsuario.zip");
		$zip->add("./exceles/temp/");	
		
		unlinkRecursive('./exceles/temp/',FALSE);	
		
		header('Content-disposition: attachment; filename=datosRHpuestos.zip');
		
		header("Content-Disposition: inline; filename=\"datosRHpuestos.zip\"");
		$fh=fopen("./exceles/$NoUsuario.zip", "rb");
		fpassthru($fh);
		
		unlink("./exceles/$NoUsuario.zip");	
		
		
	}
}


	if($_GET['file']=='perfiles.xls')
	{

		//------------imprime la tabla
		$tablaperfiles=new datatable('perfiles',$camposdatosRHperfiles,$camposdatosRHperfiles,$sql);
	
		//------------genera el archivo
		unlink("./exceles/$NoUsuario.xls");
		$tablaperfiles->nombretabla='datos';
		$excel=new datosexcel("./exceles/$NoUsuario.xls",1);
		$tablaperfiles->guardar($excel);
		
		header('Content-disposition: attachment; filename=perfiles.xls');
		
		header("Content-Type: application/x-msexcel; name=\"perfiles.xls\"");
		header("Content-Disposition: inline; filename=\"perfiles.xls\"");
		$fh=fopen("./exceles/$NoUsuario.xls", "rb");
		fpassthru($fh);
		unlink("./exceles/$NoUsuario.xls");	
		
	}

//<!-- Fin Puestos RH -->


//<!-- Inicio Datos FEMSA Empleados  -->

if($_POST['botonFEMSAEmplados']=='Generar Archivos')
{
	$camposparaarchivos=array();
	//chek($_POST['tiposdepuesto']);
	//chek($_POST['pruebas']);
	//chek($_POST['formatodeentrega']);

	foreach($_POST['pruebas'] as $valorpost)
	{
		$camposparaarchivos=array_merge($camposparaarchivos,$camposFEMSAempleadosporconcepto[$valorpost]);
	}
	
	$where='';
	$campos='';
	foreach ($camposparaarchivos as $campo)
	{
		$where.= " $campo is NULL OR ";
		$campos.= " $campo, ";
	}
	$where=rtrim($where,'OR ');
	$campos=rtrim($campos,', ');
	
	$where2='';
	foreach($_POST['tiposdepuesto'] as $tipodepuesto)
	{
		$where2.=" TipodePuesto='$tipodepuesto' OR ";
	}
	$where2=rtrim($where2,'OR ');
	
	unlink('./exceles/datosFEMSAempleados.xls');
	unlink('./exceles/datosFEMSAempleados.zip');
	unlinkRecursive('./exceles/temp/',FALSE);	
	
	
	if($_POST['formatodeentrega']=='total')
	{
		$query="Select NoPersonal, NombreEmpleado, $campos FROM empleadosypuestos WHERE ($where) AND ($where2)";	
		
		//chek($query);
		
		$data=$sql->queryArreglo($query);
		
		if(file_exists("./exceles/$NoUsuario.xls")){unlink("./exceles/$NoUsuario.xls");}
		$excel= new datosexcel("./exceles/$NoUsuario.xls");
		
		//$tabla= new datatable('datos',NULL,NULL,$data);
		//chek($data);
		//$tabla->guardar($excel);
		$excel->guardartabla('datos',$data);
		
		header('Content-disposition: attachment; filename=datosFEMSAempleados.xls');
		
		header("Content-Type: application/x-msexcel; name=\"datosFEMSAempleados.xls\"");
		header("Content-Disposition: inline; filename=\"datosFEMSAempleados.xls\"");
		$fh=fopen("./exceles/$NoUsuario.xls", "rb");
		fpassthru($fh);
		unlink("./exceles/$NoUsuario.xls");			
		
		
		
			
	}else if($_POST['formatodeentrega']=='porUO'){
		
		
		$Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');
		

		foreach ($Unidadesoperativas as $unidadoperativa)
		{
			$unidadoperativafile=cadenafilesystem($unidadoperativa);
			
			$query="Select NoPersonal, NombreEmpleado, $campos FROM empleadosypuestos WHERE UnidadOperativa='$unidadoperativa' AND ($where) AND ($where2)";
			$data=$sql->queryArreglo($query);
			unlink("./exceles/temp/datosFEMSAempleados-$unidadoperativafile-.xls");
			if(sizeof($data)>=1){
				$excel= new datosexcel("./exceles/temp/datosFEMSAempleados-$unidadoperativafile-.xls");
				$excel->guardartabla('datos',$data);
			}
			//$zip->addFile("/exceles/temp/datosFEMSAempleados-$unidadoperativa-.xls","datosFEMSAempleados-$unidadoperativa-.xls");
			
		}
		//$zip=new zip();
		
		//$zip->makeZip("./exceles/temp/",'./exceles/datosFEMSAempleados.zip');
		unlink("./exceles/$NoUsuario.zip");
		$zip=new PclZip("./exceles/$NoUsuario.zip");
		$zip->add("./exceles/temp/");		
		unlinkRecursive('./exceles/temp/',FALSE);

		
		header('Content-disposition: attachment; filename=datosFEMSAempleados.zip');
		
		//header("Content-Type: application/x-msexcel; name=\"datosFEMSAempleados.xls\"");
		header("Content-Disposition: inline; filename=\"datosFEMSAempleados.zip\"");
		$fh=fopen("./exceles/$NoUsuario.zip", "rb");
		fpassthru($fh);
		
		unlink("./exceles/$NoUsuario.zip");			
		

		
		
	}
	
	
}

//<!-- Fin Datos FEMSA Empleados  -->
//<!-- Inicio Datos RH Empleados  -->

if($_POST['botonRHEmplados']=='Generar Archivos')
{
	$camposparaarchivos=array();
	//chek($_POST['tiposdepuesto']);
	//chek($_POST['pruebas']);
	//chek($_POST['formatodeentrega']);

	foreach($_POST['pruebas'] as $valorpost)
	{
		$camposparaarchivos=array_merge($camposparaarchivos,$camposRHempleadosporconcepto[$valorpost]);
	}
	
	$where='';
	$campos='';
	foreach ($camposparaarchivos as $campo)
	{
		$where.= " $campo is NULL OR ";
		$campos.= " $campo, ";
	}
	$where=rtrim($where,'OR ');
	$campos=rtrim($campos,', ');
	
	$where2='';
	foreach($_POST['tiposdepuesto'] as $tipodepuesto)
	{
		$where2.=" TipodePuesto='$tipodepuesto' OR ";
	}
	$where2=rtrim($where2,'OR ');
	
	unlink('./exceles/datosRHempleados.xls');
	unlink('./exceles/datosRHempleados.zip');
	unlinkRecursive('./exceles/temp/',FALSE);	
	
	
	if($_POST['formatodeentrega']=='total')
	{
		$query="Select NoPersonal, NombreEmpleado, $campos FROM empleadosypuestos WHERE ($where) AND ($where2)";	
		
		//chek($query);
		
		$data=$sql->queryArreglo($query);
		$excel= new datosexcel("./exceles/$NoUsuario.xls");
		//$tabla= new datatable('datos',NULL,NULL,$data);
		//chek($data);
		//$tabla->guardar($excel);
		$excel->guardartabla('datos',$data);
		
		header('Content-disposition: attachment; filename=datosRHempleados.xls');
		
		header("Content-Type: application/x-msexcel; name=\"datosRHempleados.xls\"");
		header("Content-Disposition: inline; filename=\"datosRHempleados.xls\"");
		$fh=fopen("./exceles/$NoUsuario.xls", "rb");
		fpassthru($fh);
		unlink("./exceles/$NoUsuario.xls");	
		
		
		
			
	}else if($_POST['formatodeentrega']=='porUO'){
		
		//chek('uo');
		$Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');

		foreach ($Unidadesoperativas as $unidadoperativa)
		{
			//chek($unidadoperativa);
			$unidadoperativafile=cadenafilesystem($unidadoperativa);
			//$unidadoperativafile=utf8_decode($unidadoperativa);
			//chek($unidadoperativa);
			$query="Select NoPersonal, NombreEmpleado, $campos FROM empleadosypuestos WHERE UnidadOperativa='$unidadoperativa' AND ($where) AND ($where2)";
			$data=$sql->queryArreglo($query);
			unlink("./exceles/temp/datosRHempleados-$unidadoperativafile-.xls");
			if(sizeof($data)>=1){
				$excel= new datosexcel("./exceles/temp/datosRHempleados-$unidadoperativafile-.xls");
				$excel->guardartabla('datos',$data);
				//chek("datosRHempleados-$unidadoperativafile-.xls");
			}
			
			//$zip->addFile("/exceles/temp/datosRHempleados-$unidadoperativa-.xls","datosRHempleados-$unidadoperativa-.xls");
			
		}
		//$zip=new zip();
		//chek('uo2');
		//$zip->makeZip("./exceles/temp/",'./exceles/datosRHempleados.zip');
		unlink("./exceles/$NoUsuario.zip");
		$zip=new PclZip("./exceles/$NoUsuario.zip", "rb");
		$zip->add("./exceles/temp/");	
		
		unlinkRecursive('./exceles/temp/',FALSE);
		
		//chek('uo3');
		
		header('Content-disposition: attachment; filename=datosRHempleados.zip');
		
		header("Content-Disposition: inline; filename=\"datosRHempleados.zip\"");
		$fh=fopen("./exceles/$NoUsuario.zip", "rb");
		fpassthru($fh);
		
		unlink("./exceles/$NoUsuario.zip");	
		
	}
}
//<!-- Fin Datos RH Empleados  -->
?>