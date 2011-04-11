<?
require_once 'clasesincluder.php';

if($niveldeacceso!='Admin' AND $niveldeacceso!='Editor' AND !$idjunta)
{
  header("Location: ./salir.php");
  die;
}

if($idjunta AND $_POST['boton']=='Cerrar Junta')
{

  $sql->actualizaregistroporID('juntas',array('comentarios'=>$_POST['comentarios']),'id',$idjunta); 
  $_SESSION['idjunta'] = NULL;
  unset($_SESSION['idjunta']);
  $editable=0;
  header("Location: ./simulador.php");
  die;
  
}

if($_GET['idjunta'])
{
  $idjunta=$_GET['idjunta'];
  $editar=0;
}else if($idjunta){
  $editar=1;
}

$data=new datatable('justasconresponsable',null,$campossalidalistadodejuntas,$sql,' id=id Order by fecha DESC, id DESC');



//--------limpieza para lectores y editores

if($niveldeacceso!='Admin')
{
  foreach($data->tabla as $key=>$renglon)
  {   

    if(!in_array($renglon["unidadoperativa"],$unidadesvisibles))
    {
      unset($data->tabla[$key]);
    } 
  } 
}
//---------------




$mensajeJuntas='';




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" style="overflow:auto;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrador de Datos</title>
  <script language="JavaScript" type="text/javascript" src="/js/jquery-1.3.1.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/jTPS.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/FuncionesJavaScript.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/jTPS.css" />
  <link href="/css/estilos.css" rel="stylesheet" type="text/css" />
  <link href="/css/juntas.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" type="text/javascript">
  $(document).ready(function() 
  { 
    establecefuncionalidaddetabs();   
  }); 
  </script>
  <!-- menu-->
  <link href="css/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
  <link href="css/dropdown/themes/mtv.com/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />
  <!--[if lt IE 7]>
  <script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
  <![endif]-->
</head>

<body class="verdana09em">

<? include('partials/carga.php'); ?>
<? include('partials/menu.php'); ?>

<div class="paddingbody">
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
<h1>Listado de juntas</h1>
<? $data->imprimeHTMLGrid('listadodejuntas','100%','450'); ?>
</form>
</div>
<?  include('partials/footer.php'); ?>
</body>
</html>
