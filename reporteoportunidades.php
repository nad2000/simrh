<?
session_start();

$urlpagina='gameplan';

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
<title>Reporte Oportunidades</title>
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


<!-- INICIO de gameplan -->
<div class="margin_20px">
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
    alert('Los resultados fueron reducidos únicamente al personal de tu Unidad Operativa.');
    </script>
    <?
    $total=sizeof($data);
  }
  if($total==0)
  {
    ?>
    <script language="JavaScript" type="text/javascript">
    alert('Búsqueda sin resultados. Intenta nuevamente por favor.');
    </script>
    <?
    $muestrabuscador=1;
  }
  //------------------------------

  //chek($dataorganizado);
}else{$muestrabuscador=1;}

?>

<div class="tab t1gp">
    <div class="tabsProm">
      <span class="tablink trActive">Sin TR Corto</span>
        <span class="tablink trUp">Sin TR Mediano</span>
        <span class="tablink trUp">Sin TR Largo</span>
        <span class="tablink trUp">Sin TR C M y L</span>
     </div>
     
     
  <table id="gp_header">
  <tr>  
    <td width="20px">&nbsp;</td>
    <td width="15%" >Puesto</td>
    <td width="15%">Empleado</td>
    <td width="52px">Antig.</td>
    <td>EP&nbsp;<?= "$anio"; ?></td>
    <td>Temp&nbsp;<?= "$anio"; ?></td>
    <td width="8%">9BXs</td>
  </tr> 
  </table>
  
  <div id="tabla_gp">
  <table cellpadding="0" cellspacing="0">
  <?
  $numerospersonales='';
  foreach($data as $renglon)
  {   
    
    
    $idempleado=$renglon['NoPersonal'];
    $nombre=$renglon['NombreEmpleado'];
    
    $trs=$sql->queryArregloUNI("Select NoPersonal from trcorto where NoPuesto=".$renglon['NoPuesto']);
    
    if(sizeof($trs)==0)
    {
    
    $datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
    
    ?>
    <tr>  
      <td width="20px"><a href="simulador.php?idempleado=<?= $idempleado ?>" target="_self"><img src="./imagenes/bonton_sim.jpg"></a></td>
      <td width="15%" class="left"><?= $datos['NombrePuesto'] ?></td>
      <td width="15%" class="left"><? echo '<a href="javascript:popUpCedula(\'cedula.php?idempleado='.$idempleado.'\')">'.$datos['NombreEmpleado'].'</a>'; ?></td>
      <td  width="51px"><?=  getAge(strtotime( $datos['FechadeAlta'] )) ?></td>
      <td class="<?= str_replace(' ', '', $datos["EdoPromocional20$anio"]);  ?>"><?= $datos["EdoPromocional20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td><?= $datos["Temporalidad20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"Temporalidad20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td width="8%"><?= $datos["9BXS"]; ?></td>
    </tr>
        <tr>
        <td colspan="10"><div id="gp_separador"> &nbsp;</div></td>
        </tr>
    <?
    }
  } 
  ?>
  </table>
    
    
    
  </div>  
</div>

<div class="tab t1gp">
    <div class="tabsProm">
      <span class="tablink trUp">Sin TR Corto</span>
        <span class="tablink trActive">Sin TR Mediano</span>
        <span class="tablink trUp">Sin TR Largo</span>
        <span class="tablink trUp">Sin TR C M y L</span>
     </div>
  <table id="gp_header">
  <tr>  
    <td width="20px">&nbsp;</td>
    <td width="15%" >Puesto</td>
    <td width="15%">Empleado</td>
    <td width="52px">Antig.</td>
    <td>EP&nbsp;<?= "$anio"; ?></td>
    <td>Temp&nbsp;<?= "$anio"; ?></td>
    <td width="8%">9BXs</td>
  </tr> 
  </table>
  
  <div id="tabla_gp">
    
  <table cellpadding="0" cellspacing="0">
  <?
  $numerospersonales='';
  foreach($data as $renglon)
  {   
    
    
    $idempleado=$renglon['NoPersonal'];
    $nombre=$renglon['NombreEmpleado'];
    
    $trs=$sql->queryArregloUNI("Select NoPersonal from trmediano where NoPuesto=".$renglon['NoPuesto']);
    
    if(sizeof($trs)==0)
    {
    
    $datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
    
    ?>
    <tr>  
      <td width="20px"><a href="simulador.php?idempleado=<?= $idempleado ?>" target="_self"><img src="./imagenes/bonton_sim.jpg"></a></td>
      <td width="15%" class="left"><?= $datos['NombrePuesto'] ?></td>
      <td width="15%" class="left"><? echo '<a href="javascript:popUpCedula(\'cedula.php?idempleado='.$idempleado.'\')">'.$datos['NombreEmpleado'].'</a>'; ?></td>
      <td  width="51px"><?=  getAge(strtotime( $datos['FechadeAlta'] )) ?></td>
      <td class="<?= str_replace(' ', '', $datos["EdoPromocional20$anio"]);  ?>"><?= $datos["EdoPromocional20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td><?= $datos["Temporalidad20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"Temporalidad20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td width="8%"><?= $datos["9BXS"]; ?></td>
    </tr>
        <tr>
        <td colspan="10"><div id="gp_separador"> &nbsp;</div></td>
        </tr>
    <?
    }
  } 
  ?>
  </table>
  </div>
</div>

<div class="tab t1gp">
    <div class="tabsProm">
      <span class="tablink trUp">Sin TR Corto</span>
        <span class="tablink trUp">Sin TR Mediano</span>
        <span class="tablink trActive">Sin TR Largo</span>
        <span class="tablink trUp">Sin TR C M y L</span>
     </div>
  <table id="gp_header">
  <tr>  
    <td width="20px">&nbsp;</td>
    <td width="15%" >Puesto</td>
    <td width="15%">Empleado</td>
    <td width="52px">Antig.</td>
    <td>EP&nbsp;<?= "$anio"; ?></td>
    <td>Temp&nbsp;<?= "$anio"; ?></td>
    <td width="8%">9BXs</td>
  </tr> 
  </table>

  <div id="tabla_gp">
  <table cellpadding="0" cellspacing="0">
  <?
  $numerospersonales='';
  foreach($data as $renglon)
  {   
    
    
    $idempleado=$renglon['NoPersonal'];
    $nombre=$renglon['NombreEmpleado'];
    
    $trs=$sql->queryArregloUNI("Select NoPersonal from trlargo where NoPuesto=".$renglon['NoPuesto']);
    
    if(sizeof($trs)==0)
    {
    
    $datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
    
    ?>
    <tr>  
      <td width="20px"><a href="simulador.php?idempleado=<?= $idempleado ?>" target="_self"><img src="./imagenes/bonton_sim.jpg"></a></td>
      <td width="15%" class="left"><?= $datos['NombrePuesto'] ?></td>
      <td width="15%" class="left"><? echo '<a href="javascript:popUpCedula(\'cedula.php?idempleado='.$idempleado.'\')">'.$datos['NombreEmpleado'].'</a>'; ?></td>
      <td  width="51px"><?=  getAge(strtotime( $datos['FechadeAlta'] )) ?></td>
      <td class="<?= str_replace(' ', '', $datos["EdoPromocional20$anio"]);  ?>"><?= $datos["EdoPromocional20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td><?= $datos["Temporalidad20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"Temporalidad20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td width="8%"><?= $datos["9BXS"]; ?></td>
    </tr>
        <tr>
        <td colspan="10"><div id="gp_separador"> &nbsp;</div></td>
        </tr>
    <?
    }
  } 
  ?>
  </table>
  </div>
</div>

<div class="tab t1gp">
    <div class="tabsProm">
      <span class="tablink trUp">Sin TR Corto</span>
        <span class="tablink trUp">Sin TR Mediano</span>
        <span class="tablink trUp">Sin TR Largo</span>
        <span class="tablink trActive">Sin TR C M y L</span>
     </div>
  <table id="gp_header">
  <tr>  
    <td width="20px">&nbsp;</td>
    <td width="15%" >Puesto</td>
    <td width="15%">Empleado</td>
    <td width="52px">Antig.</td>
    <td>EP&nbsp;<?= "$anio"; ?></td>
    <td>Temp&nbsp;<?= "$anio"; ?></td>
    <td width="8%">9BXs</td>
  </tr> 
  </table>

  <div id="tabla_gp">
  <table cellpadding="0" cellspacing="0">
  <?
  $numerospersonales='';
  foreach($data as $renglon)
  {   
    
    
    $idempleado=$renglon['NoPersonal'];
    $nombre=$renglon['NombreEmpleado'];
    
    $trs=$sql->queryArregloUNI("Select NoPersonal from tablasderemplaso where NoPuesto=".$renglon['NoPuesto']);
    
    if(sizeof($trs)==0)
    {
    
    $datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
    
    ?>
    <tr>  
      <td width="20px"><a href="simulador.php?idempleado=<?= $idempleado ?>" target="_self"><img src="./imagenes/bonton_sim.jpg"></a></td>
      <td width="15%" class="left"><?= $datos['NombrePuesto'] ?></td>
      <td width="15%" class="left"><? echo '<a href="javascript:popUpCedula(\'cedula.php?idempleado='.$idempleado.'\')">'.$datos['NombreEmpleado'].'</a>'; ?></td>
      <td  width="51px"><?=  getAge(strtotime( $datos['FechadeAlta'] )) ?></td>
      <td class="<?= str_replace(' ', '', $datos["EdoPromocional20$anio"]);  ?>"><?= $datos["EdoPromocional20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td><?= $datos["Temporalidad20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"Temporalidad20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td width="8%"><?= $datos["9BXS"]; ?></td>
    </tr>
        <tr>
        <td colspan="10"><div id="gp_separador"> &nbsp;</div></td>
        </tr>
    <?
    }
  } 
  ?>
  </table>
  <? 
  //chek( $data ) 
  ?>

  </div>
</div>

<!-- Fin de gameplan -->
</div>
  <div class="excel">
    <a href="reporteoportunidadesExcel.php">Exportar a EXCEL</a>
    </div>
<?  include('partials/footer.php'); ?>
</div>
<?
    include('partials/buscador.php'); 
?>

</body>
</html>
