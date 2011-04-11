<?php
require_once 'clasesincluder.php';


if($niveldeacceso!='Admin')
{
	header("Location: ./salir.php");
	die;
}

$campossalida[]=new camposalida('No. de Empleado','NoPersonal','11.5%');
$campossalida[]=new camposalida('Password','password','11.5%');
$campossalida[]=new camposalida('Nivel de acceso','niveldeacceso','11.5%');

$campossalida[]=new camposalida('Nombre','NombreEmpleado','11.5%');
$campossalida[]=new camposalida('Puesto','NombrePuesto','11.5%');
$campossalida[]=new camposalida('Divisi&oacute;n','Division','11.5%');

$campossalida[]=new camposalida('&Aacute;rea','Area','11.5%');
$campossalida[]=new camposalida('Unidad operativa','UnidadOperativa','11.5%');
$campossalida[]=new camposalida('Unidades operativas','unidadesoperativas','11.5%');

unlink('./exceles/usuarios.xls');
//$excel= new datosexcel('./exceles/usuarios.xls',1);


if($_FILES['archivo'])
{
	if(stripos($_FILES['archivo']['name'], 'usuarios.xls')!== false)
	{
		$newfile=dirname($_FILES['archivo']['tmp_name']).'\\'.$_FILES['archivo']['name'];
		if(file_exists($newfile)){unlink($newfile);}
		rename($_FILES['archivo']['tmp_name'],$newfile);
		//chek($newfile);
		$excelrecibido= new datosexcel2($newfile,1);
	//chek($excelrecibido);
	
		$camposentrada=array();
		$camposentrada[]='NoPersonal';
		$camposentrada[]='password';
		$camposentrada[]='niveldeacceso';
		$camposentrada[]='unidadesoperativas';
			
			
//		$camposentrada[]=new camposalida('NoPersonal','NoPersonal');
//		$camposentrada[]=new camposalida('password','password');
//		$camposentrada[]=new camposalida('niveldeacceso','niveldeacceso');			
	//chek($excelrecibido->leertabla('usuarios',$camposentrada));
		//$usuarios=new datatable('usuarios',$camposentrada,null,$excelrecibido);
	//chek($usuarios->tabla);
	//	$usuarios->imprimeHTML();
		
		//die;
		
		//$usuarios->guardar($sql);
		//$camposainsertar=$excel->getencabezados('datos');	

			
		$usuarios=$excelrecibido->leertabla('datos',$camposentrada);
		$sql->guardartabla('usuarios',$usuarios);
			
			
		
		unlink($newfile);
	}else{
		unlink($_FILES['archivo']['tmp_name']);
		chek('El archivo debe llamarse usuarios.xls');
	}
}


$usuarios=new datatable('consultausuarios',null,$campossalida,$sql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="overflow:auto">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SimRH:: Administraci&oacute;n de usuarios</title>
	<script language="JavaScript" type="text/javascript" src="/js/jquery-1.3.1.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="/js/jTPS.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/jTPS.css" />
  <link href="/css/estilos.css" rel="stylesheet" type="text/css" />
  <link href="/css/adminus.css" rel="stylesheet" type="text/css" />
  <!-- menu-->
  <link href="css/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
  <link href="css/dropdown/themes/mtv.com/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />
  <!--[if lt IE 7]>
  <script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
  <![endif]-->
</head>
<body class="verdana09em">
<? include('partials/menu.php'); ?>
<div class="paddingbody">
<h1>Usuarios registrados</h1>
<?

$usuarios->imprimeHTMLGrid('usuariosregistrados','97%',350);

?>
<p class="info">Para modificar la lista de usuarios, descarga el siguiente archivo.</p>
<a href="./Excelusuarios.php"  >usuarios.xls</a>
<form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
<p class="info">Para actualizar la lista de usuarios, subir el archivo 'usuarios.xls':</p>

<input type="file" name="archivo" /><input type="submit" value="Enviar" /><br />
</form>
</div>
<? 	include('partials/footer.php'); ?>
</body>
</html>
