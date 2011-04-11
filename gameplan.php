<?
session_start();

$urlpagina='gameplan';
require_once 'clasesincluder.php';
//
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
<title>Game Plan</title>
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

if($_GET['perfillink'])
{
  $PerfilTipo=utf8_decode($_GET['perfillink']);
  $_SESSION['Perfil']=$PerfilTipo;
}

//FIXME: Query
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
  //chek($query);
  foreach($data as $renglon)
  {
    if(!$renglon["9BXS$anio"]){$renglon["9BXS$anio"]='Sin asignar';}
    if(!$renglon["EdoPromocional20$anio"] AND !$renglon["EdoPromocional20$anioant"]){$renglon["EdoPromocional20$anio"]='Sin asignar';}

    if($renglon["EdoPromocional20$anio"])
      {$ep=$renglon["EdoPromocional20$anio"];}
    else if($renglon["EdoPromocional20$anioant"])
      {$ep=$renglon["EdoPromocional20$anioant"];}

    if(!$renglon["Temporalidad20$anio"] AND !$renglon["Temporalidad20$anioant"]){$renglon["Temporalidad20$anio"]='Sin asignar';}      

    if($renglon["Temporalidad20$anio"])
      {$tempo=$renglon["Temporalidad20$anio"];}
    else if($renglon["Temporalidad20$anioant"])
      {$tempo=$renglon["Temporalidad20$anioant"];}

    $dataorganizado[$renglon["9BXS$anio"]][]=$renglon['NombreEmpleado'].' ('.$renglon['NoPersonal'].') EP:'.$ep;
    $dataorganizadoporperfil[$renglon['NombrePerfil']][$tempo][]=$renglon['PerfilTipo'];
  }

  //chek($dataorganizado);
}else{$muestrabuscador=1;}

?>

<div class="tab t1gp">
    <div class="tabsProm">
      <span class="tablink trActive">Game Plan</span>
        <span class="tablink trUp">Entradas</span>
        <span class="tablink trUp">Salidas</span>
        <span class="tablink trUp">Por Perfil</span>
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
    <td width="13%" >Corto Plazo</td>
    <td width="13%">Mediano Plazo</td>
    <td width="13%">Largo Plazo</td>

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
    $numerospersonales.=$idempleado.', ';
    $datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');

    //$puesto=$sql->queryArregloUNI("Select NoPuesto, PerfilTipo from empleadosypuestos where NoPersonal=$idempleado");
    $perfil=$datos['PerfilTipo'];
    $puesto=$datos['NoPuesto'];

    //FIXME: Query
    $campossalida=array();
    $campossalida[]=new camposalidaLinkPopUp('Nombre','NombreEmpleado','cedula.php','idempleado','NoPersonal','Cedula');
    //-------------Tabla de remplazo
    $datos2=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trcorto where NoPuesto=$puesto");
    $trcorto=new datatable('trcorto',null,$campossalida,$datos2);

    $datos2=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trmediano where NoPuesto=$puesto");
    $trmediano=new datatable('trmediano',null,$campossalida,$datos2);

    $datos2=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trmediano where NoPuesto=$puesto");
    $trlargo=new datatable('trmediano',null,$campossalida,$datos2);

    //-------------Story board
    $datos2=array(array('NombreEmpleado'=>$nombre,'NoPersonal'=>$idempleado));
    $sbself=new datatable('sbself',null,$campossalida,$datos2);

    $focorojo=new focorojo();
    $pendiente=new pendiente();

    if($datos["Temporalidad20$anio"]=='0 - 12 meses')
    {
      $SBcorto=&$sbself;
      if( sizeof($trcorto->tabla)>=1 ){$SBmediano=&$trmediano;}else{$SBmediano=&$focorojo;}
      if( sizeof($trcorto->tabla)>=1 ){$SBlargo=&$trlargo;}else{$SBlargo=&$focorojo;}
    }else if($datos["Temporalidad20$anio"]=='13 - 24 meses'){
      $SBcorto=&$sbself;
      $SBmediano=&$sbself;
      if( sizeof($trcorto)>=1 ){$SBlargo=&$trlargo;}else{$SBlargo=&$focorojo;}
    }else if($datos["Temporalidad20$anio"]=='25 - 36 meses'){
      $SBcorto=&$sbself;
      $SBmediano=&$sbself;
      $SBlargo=&$sbself;
    }else{
      $SBcorto=&$pendiente;
      $SBmediano=&$pendiente;
      $SBlargo=&$pendiente;
    }

    ?>
    <tr>
      <td width="20px"><a href="simulador.php?idempleado=<?= $idempleado ?>" target="_self"><img src="./imagenes/bonton_sim.jpg"></a></td>
      <td width="15%" class="left"><?= $datos['NombrePuesto'] ?></td>
      <td width="15%" class="left"><? echo '<a href="javascript:popUpCedula(\'cedula.php?idempleado='.$idempleado.'\')">'.$datos['NombreEmpleado'].'</a>'; ?></td>
      <td  width="51px"><?=  getAge(strtotime( $datos['FechadeAlta'] )) ?></td>
      <td class="<?= str_replace(' ', '', $datos["EdoPromocional20$anio"]);  ?>"><?= $datos["EdoPromocional20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td><?= $datos["Temporalidad20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"Temporalidad20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td width="8%"><?= $datos["9BXS$anio"]; ?></td>
      <td width="13%"><? $SBcorto->imprimeHTML('gridmm6','100%','220'); ?></td>
      <td width="13%"><? $SBmediano->imprimeHTML('gridmm76','100%','220'); ?></td>
      <td width="13%"><? $SBlargo->imprimeHTML('gridmmm86','100%','220'); ?></td>
    </tr>
        <tr>
        <td colspan="10"><div id="gp_separador"> &nbsp;</div></td>
        </tr>
  <?
  }
  ?>
  </table>
  </div>
</div>

<div class="tab t1gp">
    <div class="tabsProm">
      <span class="tablink trUp">Game Plan</span>
        <span class="tablink trActive">Entradas</span>
        <span class="tablink trUp">Salidas</span>
        <span class="tablink trUp">Por Perfil</span>
     </div>
  <table id="gp_header">
  <tr>  
    <td width="20px">&nbsp;</td>
    <td width="15%">Puesto</td>
    <td width="15%">Empleado</td>
    <td width="51px">Antig.</td>
    <td width="100px">EP&nbsp;<?= "$anio"; ?></td>
    <td width="100px">Temp &nbsp;<?= "$anio"; ?></td>
    <td width="13%">TR corto</td>
    <td width="13%">TR mediano</td>
    <td width="13%">TR largo</td>

  </tr>
  </table>
  
  <div id="tabla_gp">
    
    <table cellpadding="0" cellspacing="0" width="97%"> 
  <?
  
  
  //chek($data);
  //$data=$sql->queryArreglo($query);
  
  foreach($data as $renglon)
  {   
    $idempleado=$renglon['NoPersonal'];
    $nombre=$renglon['NombreEmpleado'];

    $datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
    
    //$puesto=$sql->queryArregloUNI("Select NoPuesto, PerfilTipo from empleadosypuestos where NoPersonal=$idempleado");
    $perfil=$datos['PerfilTipo'];
    $puesto=$datos['NoPuesto']; 
  
    $campossalida=array();
    $campossalida[]=new camposalidaLinkPopUp('Nombre','NombreEmpleado','cedula.php','idempleado','NoPersonal','Cedula');
      
    //-------------Tabla de remplazo
    $datos=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trcorto where NoPuesto=$puesto");
    $trcorto=new datatable('trcorto',null,$campossalida,$datos);
      
    $datos=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trmediano where NoPuesto=$puesto");
    $trmediano=new datatable('trmediano',null,$campossalida,$datos);  
  
    $datos=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trmediano where NoPuesto=$puesto");
    $trlargo=new datatable('trmediano',null,$campossalida,$datos);  
      
    ?>
    <tr>  
      <td width="20px"><a href="simulador.php?idempleado=<?= $idempleado ?>" target="_self"><img src="./imagenes/bonton_sim.jpg"></a></td>
      <td width="15%" class="left"><?= $renglon['NombrePuesto'] ?></td>
      <td width="15%" class="left"><? echo '<a href="javascript:popUpCedula(\'cedula.php?idempleado='.$idempleado.'\')">'.$renglon['NombreEmpleado'].'</a>'; ?></td>
      <td  width="51px"><?=  getAge(strtotime( $renglon['FechadeAlta'] )) ?></td>
      <td  width="100px" class="<?= str_replace(' ', '', $renglon["EdoPromocional20$anio"]);  ?>"><?= $renglon["EdoPromocional20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anio",'NoPersonal',$idempleado); ?></div></td>
      <td width="100px"><?= $renglon["Temporalidad20$anio"]; ?><div class="fechas"><?= $sql->getlastupdatedate('empleados',"Temporalidad20$anio",'NoPersonal',$idempleado); ?></div></td>
      
      <td width="13%"><? $trcorto->imprimeHTML('gridmm6','100%','220'); ?></td>
      <td width="13%"><? $trmediano->imprimeHTML('gridmm76','100%','220'); ?></td>
      <td width="13%"><? $trlargo->imprimeHTML('gridmmm86','100%','220'); ?></td>
  
    </tr>
        
                <tr>
        <td colspan="9"><div id="gp_separador"> &nbsp;</div></td>
        </tr>
  <?
  } 
  ?>
  
  </table>
  </div>
</div>

<div class="tab t1gp">
    <div class="tabsProm">
      <span class="tablink trUp">Game Plan</span>
        <span class="tablink trUp">Entradas</span>
        <span class="tablink trActive">Salidas</span>
        <span class="tablink trUp">Por Perfil</span>
     </div>
  <table id="gp_header">
  <tr>  
    <td width="20px">&nbsp;</td>
    <td>Puesto</td>
    <td>Empleado</td>
    <td  width="210px">EP&nbsp;<?= "$anio"; ?></td>
    <td  width="210px">EP&nbsp;<?= "$anioant"; ?></td>
  </tr>
  </table>

  <div id="tabla_gp">
  <table cellpadding="0" cellspacing="0" width="97%"> 
  <?
  foreach($data as $renglon)
  {   
    
    
    $idempleado=$renglon['NoPersonal'];
    $nombre=$renglon['NombreEmpleado'];

    $numerospersonales.=$idempleado.', ';
    
    $renglon=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
  
//    if( 
//      ($renglon["EdoPromocional20$anio"]=='FOCO ROJO' OR $renglon["EdoPromocional20$anio"]=='Por jubilarse' OR ($renglon["EdoPromocional20$anio"]=='MO' AND $renglon["Salidaencontroplazo"]=='Si')   ) OR
//      (($renglon["EdoPromocional20$anioant"]=='FOCO ROJO' OR $renglon["EdoPromocional20$anioant"]=='Por jubilarse' OR ($renglon["EdoPromocional20$anioant"]=='MO' AND $renglon["Salidaencontroplazo"]=='Si') AND !$renglon["EdoPromocional20$anio"]))
//      )

    //$renglones=array();
    if($renglon["Salidaencontroplazo"]=='Si')
    { 
      $renglones[1][]=$renglon;
      ////chek($renglon['NombreEmpleado']);
    }

    if(($renglon["EdoPromocional20$anio"]=='Por jubilarse' OR ( !$renglon["EdoPromocional20$anio"] AND  $renglon["EdoPromocional20$anioant"]=='Por jubilarse') ) AND $renglon["Salidaencontroplazo"]!='Si'   )
    { 
      $renglones[2][]=$renglon;
      //chek($renglon['NombreEmpleado']);
    }
    if(($renglon["EdoPromocional20$anio"]=='MO' OR ( !$renglon["EdoPromocional20$anio"] AND   $renglon["EdoPromocional20$anioant"]=='MO')) AND $renglon["Salidaencontroplazo"]!='Si'   )
    { 
      $renglones[3][]=$renglon;
      //chek($renglon['NombreEmpleado']);
    }
    if(($renglon["EdoPromocional20$anio"]=='FOCO ROJO' OR ( !$renglon["EdoPromocional20$anio"] AND   $renglon["EdoPromocional20$anioant"]=='FOCO ROJO')) AND $renglon["Salidaencontroplazo"]!='Si'   )
    { 
      $renglones[4][]=$renglon;
      //chek($renglon['NombreEmpleado']);
    }
  }
  //chek($renglones[1]);
  $renglones=array_merge($renglones[1],$renglones[2],$renglones[3],$renglones[4]);
  foreach($renglones as $renglon)
  { 
  ?>
      <tr>  
        <td width="20px"><a href="simulador.php?idempleado=<?= $idempleado ?>" target="_self"><img src="./imagenes/bonton_sim.jpg"></a></td>
        <td class="left">
          <?= $renglon['NombrePuesto'] ?>
          <?
            if($renglon["Salidaencontroplazo"]=='Si')
            {?><span title="Salida en corto plazo">*</span><?}
          ?>
        </td>
        <td class="left"><? echo '<a href="javascript:popUpCedula(\'cedula.php?idempleado='.$idempleado.'\')">'.$renglon['NombreEmpleado'].'</a>'; ?></td>
        <td width="200px" class="<?= str_replace(' ', '', $renglon["EdoPromocional20$anio"]);  ?>"><?= $renglon["EdoPromocional20$anio"]; ?><br /><?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anio",'NoPersonal',$idempleado); ?></td>
        <td width="200px" class="<?= str_replace(' ', '', $renglon["EdoPromocional20$anioant"]);  ?>"><?= $renglon["EdoPromocional20$anioant"]; ?><br /><?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anioant",'NoPersonal',$idempleado); ?></td>
      </tr>
                        <tr>
        <td colspan="5"><div id="gp_separador"> &nbsp;</div></td>
        </tr>
  <?      
  }
  
  ?>
  </table>
  </div>
</div>

<div class="tab t1gp">
    <div class="tabsProm">
      <span class="tablink trUp">Game Plan</span>
        <span class="tablink trUp">Entradas</span>
        <span class="tablink trUp">Salidas</span>
        <span class="tablink trActive">Por Perfil</span>
     </div>
  <table id="gp_header">
  <tr>  
    <td>Perfil</td>
    <td>Puestos</td>


  </tr>
  </table>

  <div id="tabla_gp">
  <table cellpadding="0" cellspacing="0" width="97%">
  <?
  ksort($dataorganizadoporperfil);
  foreach($dataorganizadoporperfil as $perfil=>$datosperfiles)
  {   
    ksort($datosperfiles);
    ?>
      <tr>  
        <td class="left">
          <?
            $perfilnum=array_flatten($datosperfiles);
            $perfilnum=$perfilnum[0];
          ?>
          <a href="<? $_SERVER['PHP_SELF'] ?>?perfillink=<?= $perfilnum ?>"><?= $perfil ?></a><br />
          Total: <?= sizeof(array_flatten($datosperfiles)) ?>
          <? 
            //chek($datosperfiles); 
          ?>
        </td>
        <td class="left">
          <table class="por_perfil" cellpadding="0" cellspacing="0">
          <tr>
          <?
            foreach($datosperfiles as $temporalidad=>$empleadostemp)
            {
              ?><td colspan="2" class="temporalidad"><?= $temporalidad ?></td><?  
            }
          ?>
          </tr>
          <tr>
          <?
          
            foreach($datosperfiles as $temporalidad=>$empleadostemp)
            {
              ?><td>Salidas:<br />  <?= sizeof($empleadostemp); ?></td><? 
              ?><td>
              TRs.<br />  
              <?

                $plazo='';
                $numtrperfil=0;   
                if($temporalidad=='0 - 12 meses'){ $plazo=" AND plazo='corto'"; } 
                else if($temporalidad=='13 - 24 meses'){ $plazo=" AND plazo='mediano'"; }
                else if($temporalidad=='25 - 36 meses'){ $plazo=" AND plazo='largo'"; }
                

                  foreach($empleadostemp as $idpuesto)
                  {
                    $querytrperfil="Select * from tablasderemplaso where NoPuesto=$idpuesto $plazo";
                    $datostrperfil=$sql->queryArreglo($querytrperfil);
                    //chek($querytrperfil);
                    $numtrperfil+=sizeof($datostrperfil);
                  }
                
                ?><?= sprintf("%d",$numtrperfil) ?><? 
              ?>
              </td><? 
            }
          ?>
          </tr>
          </table>
        </td>
      </tr>
                                    <tr>
        <td colspan="2"><div id="gp_separador"> &nbsp;</div></td>
        </tr>
    <?
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
<?  include('footer.php'); ?>
</div>
<?
    include('buscador.php'); 
?>

</body>
</html>
