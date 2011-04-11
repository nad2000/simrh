<?php
require_once 'clasesincluder.php';


if($niveldeacceso!='Admin')
{
	header("Location: ./salir.php");
	die;
}

$campossalida[]=new camposalida('No. de Empleado','NoPersonal','12.5%');
$campossalida[]=new camposalida('Password','password','12.5%');
$campossalida[]=new camposalida('Nivel de acceso','niveldeacceso','12.5%');
$campossalida[]=new camposalida('Nombre','NombreEmpleado','12.5%');
$campossalida[]=new camposalida('Puesto','NombrePuesto','12.5%');
$campossalida[]=new camposalida('Divisi&oacute;n','Division','12.5%');
$campossalida[]=new camposalida('&Aacute;rea','Area','12.5%');
$campossalida[]=new camposalida('Unidad operativa','UnidadOperativa','12.5%');

$usuarios=new datatable('consultausuarios',null,$campossalida,$sql);


	if(file_exists("./exceles/$NoUsuario.xls")){unlink("./exceles/$NoUsuario.xls");}
	$excelbusqueda = new datosexcel("./exceles/$NoUsuario.xls");	
	$usuarios->nombretabla='usuarios';
	$usuarios->guardar($excelbusqueda);


header('Content-disposition: attachment; filename=usuarios.xls');

header("Content-Type: application/x-msexcel; name=\"usuarios.xls\"");
header("Content-Disposition: inline; filename=\"usuarios.xls\"");
$fh=fopen("./exceles/$NoUsuario.xls", "rb");
fpassthru($fh);
unlink("./exceles/$NoUsuario.xls");

?>