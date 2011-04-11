<?
session_start();

$urlpagina='reporte9bxs';

require_once 'clasesincluder.php';


//  $NombreEmpleado=$_SESSION['NombreEmpleado'];
//  $estudios=$_SESSION['estudios'];
//  
//  $NombrePuesto=$_SESSION['NombrePuesto'];
//  $OtrasPosiciones=$_SESSION['OtrasPosiciones'];
//  $Division=$_SESSION['Division'];
//  $TipodePuesto=$_SESSION['TipodePuesto'];
//  $Area=$_SESSION['Area'];
//  $UnidadOperativa=$_SESSION['UnidadOperativa'];
//  $Zona=$_SESSION['Zona'];
//  $PerfilTipo=$_SESSION['Perfil'];
//  $Experiencia=$_SESSION['Experiencia'];
//  $EstadoPromocional=$_SESSION['EstadoPromocional'];  
//  $Temporalidad=$_SESSION['Temporalidad'];
//
//  if($_GET['paggp']=='siguiente'){$Pagina++;}
//  if($_GET['paggp']=='aterior' AND $Pagina>=1 ){$Pagina--;}
//  
//  $_SESSION['Pagina']=$Pagina;
  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte 9BXs</title>
  <script language="JavaScript" type="text/javascript" src="/js/jquery-1.3.1.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/jTPS.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/FuncionesJavaScript.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/jTPS.css" />
  <link href="/css/estilos.css" rel="stylesheet" type="text/css" />

  <script language="JavaScript" type="text/javascript">
    $(document).ready(function() 
    { 
      establecefuncionalidaddetabs();   
      $("#newbody").css("height",($(window).height()-43)+'px');
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

<div style="padding-left: 20px; padding-top:20px;">

<?

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

  if($total!=sizeof($data))
  {
    ?>
    <script language="JavaScript" type="text/javascript">
    alert('Los resultados fueron reducidos unicamente a personal de tu Unidades Operativas');
    </script>
    <?
    $total=sizeof($data);
  }
  if($total==0)
  {
    ?>
    <script language="JavaScript" type="text/javascript">
    alert('Busqueda sin resultados intenta nuevamente por favor');
    </script>
    <?
    $muestrabuscador=1;
  }
  //------------------------------
  
  $total=sizeof($data);
  
  
  
  
  foreach($data as $renglon)
  {   
    if(!$renglon["9BXS$anio"]){$renglon["9BXS$anio"]='Sin asignar';}
    if(!$renglon["EdoPromocional20$anio"] AND !$renglon["EdoPromocional20$anioant"]){$renglon["EdoPromocional20$anio"]='Sin asignar';}
    
    if($renglon["EdoPromocional20$anio"])
      {$ep=$renglon["EdoPromocional20$anio"];}
    else if($renglon["EdoPromocional20$anioant"])
      {$ep=$renglon["EdoPromocional20$anioant"];}
    
    $dataorganizado[$renglon["9BXS$anio"]][]=
    '<a href="simulador.php?idempleado='.$renglon['NoPersonal'].'" target="_self"><img src="./imagenes/bonton_sim.jpg" height="10px" width="10px"></a>&nbsp;&nbsp;'.
    '<a href="javascript:popUpCedula(\'cedula.php?idempleado='.$renglon['NoPersonal'].'\')" target="">'.$renglon['NombreEmpleado'].'</a> EP:'.$ep;
  }

  //chek($dataorganizado);
}else{$muestrabuscador=1;}
?>

<!--<table id="nineboxes">-->

<table width="960" >
  <tr>
    <td class="ninebxsfree"  width="320"><h3>
    <? 
      $var9BXs='TALENTO COLUMNA'; 
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>
    <td class="AP"  width="320"><h3 style="color:inherit">
    <? 
      $var9BXs='TALENTO PROMOVIBLE POTENCIAL'; 
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>
    <td  class="AP"  width="320"><h3>
    <? 
      $var9BXs='TALENTO TOP'; 
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>       
  </tr>
  <tr>
    <td  class="EST"><h3>
    <? 
      $var9BXs='COLUMNA EN CONSOLIDACION'; 
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>
    <td  class="PROM"><h3>
    <? 
      $var9BXs='TALENTO EN CONSOLIDACION'; 
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>
    <td class="AP"><h3>
    <? 
      $var9BXs='TALENTO PROMOVIBLE'; 
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>
  </tr>
  <tr>
    <td  class="FOCOROJO"><h3>
    <?
      $var9BXs='CASO CRITICO';
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>
    <td class="EST"><h3>
    <? 
      $var9BXs='SEGUIMIENTO'; 
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>
    <td class="EST"><h3>
    <? 
      $var9BXs='TALENTO POR PROBAR'; 
      $tamano=sizeof($dataorganizado[$var9BXs]);
      $porcentaje=sprintf("%.2f",($tamano*100)/$total);
    ?>
    <?= $var9BXs; ?></h3>
    <?= $tamano; ?> Personas -----  <?= $porcentaje; ?>% 
    <div class='BXsList'>
    <?
      foreach($dataorganizado[$var9BXs] as $renglon)
      {
        ?><?= $renglon ?><br /><?
      }
    ?>
    </div>
    </td>
  </tr>

</table><br />
<span class="resumen">Total:&nbsp;&nbsp;<strong><?= $total ?></strong></span><br />
<span class="resumen">Resolver:&nbsp;&nbsp;<strong><? $resolver=sizeof($dataorganizado['COLUMNA EN CONSOLIDACION'])+sizeof($dataorganizado['CASO CRITICO'])+sizeof($dataorganizado['SEGUIMIENTO']); echo  $resolver ?></strong>&nbsp;&nbsp; %<?= sprintf("%.2f",($resolver*100)/$total); ?></span>
<span class="resumen">Retener:&nbsp;&nbsp;<strong><? $resolver=sizeof($dataorganizado['TALENTO COLUMNA'])+sizeof($dataorganizado['TALENTO EN CONSOLIDACION'])+sizeof($dataorganizado['TALENTO POR PROBAR']); echo  $resolver ?></strong>&nbsp;&nbsp; %<?= sprintf("%.2f",($resolver*100)/$total); ?></span>
<span class="resumen">Crecer:&nbsp;&nbsp;<strong><? $resolver=sizeof($dataorganizado['TALENTO PROMOVIBLE POTENCIAL'])+sizeof($dataorganizado['TALENTO TOP'])+sizeof($dataorganizado['TALENTO PROMOVIBLE']); echo  $resolver ?></strong>&nbsp;&nbsp;%<?= sprintf("%.2f",($resolver*100)/$total); ?></span>
</div>

<?  include('partials/footer.php'); ?>
</div>
<?  include('partials/buscador.php'); ?>
</body>
</html>
