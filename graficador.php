<?php
session_start();

require_once 'clasesincluder.php';
require_once 'acceso.php';
require_once 'arreglosdecampos.php';

//$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);

require_once 'criteriosgraficador.php';

$tipodegrafica=$_GET['tipo'];
$criterio1=$_GET['criterio1'];
$criterio2=$_GET['criterio2'];


//  $NombreEmpleado=$_GET['NombreEmpleado'];
//  $estudios=$_GET['estudios'];
//  
//  $NombrePuesto=$_GET['NombrePuesto'];
//  $OtrasPosiciones=$_GET['OtrasPosiciones'];
//  $Division=$_GET['Division'];
//  $TipodePuesto=$_GET['TipodePuesto'];
//  $Area=$_GET['Area'];
//  $PerfilTipo=$_GET['Perfil'];
//  
//  $_SESSION['NombreEmpleado']=$NombreEmpleado;
//  $_SESSION['estudios']=$estudios;
//  
//  $_SESSION['NombrePuesto']=$NombrePuesto;
//  $_SESSION['OtrasPosiciones']=$OtrasPosiciones;
//  $_SESSION['Division']=$Division;
//  $_SESSION['TipodePuesto']=$TipodePuesto;
//  $_SESSION['Area']=$Area;
//  $_SESSION['Perfil']=$PerfilTipo;
  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gr&aacute;ficas y Reportes</title>
  <script language="JavaScript" type="text/javascript" src="/js/jquery-1.3.1.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/jTPS.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/FuncionesJavaScript.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/jTPS.css" />
    <link href="/css/estilos.css" rel="stylesheet" type="text/css" />
    <link href="/css/graficas.css" rel="stylesheet" type="text/css" />
    
  <script language="JavaScript" type="text/javascript">
    
  $(document).ready(function() 
  { 
    establecefuncionalidaddetabs();   
    $("#newbody").css("height",($(window).height()-63)+'px');
    $("#newbody").css("width",($(window).width())+'px');
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
<div id="newbody">
<? 
//chek($Criterios);
?>

<div id="graficador">
<div class="caja">
<h1>Gr&aacute;ficas y Reportes<br />
</h1>
<form name="busqueda" action="<?= $_SERVER['PHP_SELF']; ?>" method="get">

<p class="info"><b>1.&nbsp;</b>Utiliza la '<b>B&uacute;squeda</b>' para seleccionar la '<b>muestra de empleados</b>'. No olvides dar click en. <span id='buscadorlink2' style="text-decoration:underline">aqui (Buscar)</span></p>

<p class="info"><b>2.&nbsp;</b>Elige el tipo de gr&aacute;fica:&nbsp;<? htmlselectuni(array('Pay','Barras sencillas','Barras dobles','Barras acumuladas'),'tipo',$_GET['tipo'],'name="grafica"');?></p>


<p class="info"><b>3.&nbsp;</b>Elige el '<b>criterio</b>' que desees graficar. </p>




  <table class="margin">
    <tr>
      <td align="right">Criterio 1:</td>
      <td><? htmlselectuni2($criteriosgraficador,'criterio1',$_GET['criterio1'],'name="grafica"');?>
      </td>
    </tr>
    <tr>
      <td align="right" class="red">*Criterio 2:</td>
      <td><? htmlselectuni2($criteriosgraficador,'criterio2',$_GET['criterio2'],'name="grafica"'); ?></td>
    </tr>
    <tr>
    
    <td>&nbsp;</td>
    
    <td class="red">*S&oacute;lo para gr&aacute;ficas de barras dobles y acumuladas.</td>
     
     
     
     <tr>

  </table>
  
  <p class="info"><b>4.&nbsp;</b><input name="botonbuscador" type="submit" value="Graficar" /> </p>
</form>
</div>



<div class="caja">
<h1>Resultados</h1>


<?
if($tipodegrafica AND $criterio1  ) 
{
  ?><img src="graficagraficador.php?tipo=<?= $_GET['tipo'] ?>&criterio1=<?= $_GET['criterio1'] ?>&criterio2=<?= $_GET['criterio2'] ?>"  /><?
}
?>
<?
if($tipodegrafica AND $criterio1  AND 0) 
{
  ?><br /><iframe width="900" height="7777" src="graficagraficador.php?tipo=<?= $_GET['tipo'] ?>&criterio1=<?= $_GET['criterio1'] ?>&criterio2=<?= $_GET['criterio2'] ?>"  /><?
  die;
}

?>

<?
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

  $criterio2link=$criterio2;
  
  if($tipodegrafica=='Pay' OR $tipodegrafica=='Barras sencillas' ){ $criterio2=null; }
  $datosgrafica=obtendatosgrafica($criterio1,$criterio2,$data,$Criterios);
  //chek($criterio1);
  //chek($datosgrafica);

  
  $tabla=new datatable('resultados',null,null,$datosgrafica);
  $tabla->imprimeHTML('tabla','30%'); 
  
?><a href="ExceldelGraficador.php?tipo=<?= $tipodegrafica ?>&criterio1=<?= $criterio1 ?>&criterio2=<?= $criterio2link ?>&botonbuscador=Graficar">Exportar a Excel...</a> 



<?      

}
  
}

?>
</div></div>
<?  include('partials/footer.php'); ?>
</div>
<?
    include('partials/buscador.php'); 
?>
</body>
</html>
