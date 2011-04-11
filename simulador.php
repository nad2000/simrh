<?
session_start();

$tiposdepuestopermitidos=array('Director', 'Gerente', 'Grouper');
$urlpagina='simulador';

require_once 'clasesincluder.php';

if($_GET['idempleado'])
{
  $datostemporalesempleado=$sql->leeregistroporID('empleadosypuestos',$_GET['idempleado'],'NoPersonal');
  if( $niveldeacceso=='Admin' OR in_array($datostemporalesempleado['UnidadOperativa'],$unidadesvisibles))
  {
    $idempleado=$_GET['idempleado'];
    $_SESSION['idempleado']=$idempleado;
  }else if($_SESSION['idempleado']){
    $idempleado=$_SESSION['idempleado'];
  }else{
    $muestrabuscador=1;
  }
}else if($_SESSION['idempleado']){
  $idempleado=$_SESSION['idempleado'];
}else{
  $muestrabuscador=1;
}

if($editable==1){$_SESSION['editandoempleado']=$idempleado;}else{unset($_SESSION['editandoempleado']);}

if($_GET['idcandidato'])
{
  $idcandidato=$_GET['idcandidato'];
  $_SESSION['idcandidato']=$idcandidato;
}else if($_SESSION['idcandidato']){
  $idcandidato=$_SESSION['idcandidato'];
}

//$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);

if($idempleado)
{
  $puesto=$sql->queryArregloUNI("Select NoPuesto, PerfilTipo from empleadosypuestos where NoPersonal=$idempleado");
  $perfil=$puesto[1];
  $puesto=$puesto[0];
  if($editable==1){$_SESSION['editandopuesto']=$puesto;}else{unset($_SESSION['editandopuesto']);}
}

if($idcandidato)
{
  $datoscandidato=$sql->leeregistroporID('empleadosypuestos',$idcandidato,'NoPersonal');
}
//-----------------------agrega a tablas de remplazo
//FIXME: Queries
if($_GET['trcorto']&&$idempleado&&$editable==1)
{
  $temp=$sql->queryArreglo("Select NoPuesto from trcorto where NoPuesto=$puesto AND NoPersonal=".$_GET['trcorto']);
  if(sizeof($temp)==0){ 
    $sql->agregarregistro('tablasderemplaso',array('NoPuesto'=>$puesto,'plazo'=>'corto','NoPersonal'=>$_GET['trcorto']));
    $sql->agregarregistro('historico',array('idJunta'=>$idjunta,'Tabla'=>'Tablas de remplazo','CampoId'=>'NoPersonal','ValorId'=>$idempleado,'Campo'=>'TR Corto Agreg&oacute;','NuevoValor'=>$datoscandidato['NombreEmpleado'].' ('.$_GET['trlargo'].')'));
  }
}else if($_GET['trmediano']&&$idempleado&&$editable==1){
  $temp=$sql->queryArreglo("Select NoPuesto from trmediano where NoPuesto=$puesto AND NoPersonal=".$_GET['trmediano']);
  if(sizeof($temp)==0){ 
    $sql->agregarregistro('tablasderemplaso',array('NoPuesto'=>$puesto,'plazo'=>'mediano','NoPersonal'=>$_GET['trmediano']));
    $sql->agregarregistro('historico',array('idJunta'=>$idjunta,'Tabla'=>'Tablas de remplazo','CampoId'=>'NoPersonal','ValorId'=>$idempleado,'Campo'=>'TR Mediano Agreg&oacute;','NuevoValor'=>$datoscandidato['NombreEmpleado'].' ('.$_GET['trlargo'].')'));
  }
}else if($_GET['trlargo']&&$idempleado&&$editable==1){
  $temp=$sql->queryArreglo("Select NoPuesto from trlargo where NoPuesto=$puesto AND NoPersonal=".$_GET['trlargo']);
  if(sizeof($temp)==0){ 
    $sql->agregarregistro('tablasderemplaso',array('NoPuesto'=>$puesto,'plazo'=>'largo','NoPersonal'=>$_GET['trlargo']));
    $sql->agregarregistro('historico',array('idJunta'=>$idjunta,'Tabla'=>'Tablas de remplazo','CampoId'=>'NoPersonal','ValorId'=>$idempleado,'Campo'=>'TR Largo Agreg&oacute;','NuevoValor'=>$datoscandidato['NombreEmpleado'].' ('.$_GET['trlargo'].')'));
  }
}

//----quita de tablas de remplazo
//FIXME: Queries
if($_GET['rtrcorto']&&$idcandidato&&$puesto&&$editable==1)
{
  $sql->queryArreglo("Delete from tablasderemplaso where NoPuesto=$puesto AND plazo='corto' AND NoPersonal=".$idcandidato);
  $sql->agregarregistro('historico',array('idJunta'=>$idjunta,'Tabla'=>'Tablas de remplazo','CampoId'=>'NoPersonal','ValorId'=>$idempleado,'Campo'=>'TR Corto Quit&oacute;','NuevoValor'=>$datoscandidato['NombreEmpleado'].' ('.$idcandidato.')'));
}else if($_GET['rtrmediano']&&$idcandidato&&$editable==1){
  $sql->queryArreglo("Delete from tablasderemplaso where NoPuesto=$puesto AND plazo='mediano' AND NoPersonal=".$idcandidato);
  $sql->agregarregistro('historico',array('idJunta'=>$idjunta,'Tabla'=>'Tablas de remplazo','CampoId'=>'NoPersonal','ValorId'=>$idempleado,'Campo'=>'TR Mediano Quit&oacute;','NuevoValor'=>$datoscandidato['NombreEmpleado'].' ('.$idcandidato.')'));
}else if($_GET['rtrlargo']&&$idcandidato&&$editable==1){
  $sql->queryArreglo("Delete from tablasderemplaso where NoPuesto=$puesto AND plazo='largo' AND NoPersonal=".$idcandidato);
  $sql->agregarregistro('historico',array('idJunta'=>$idjunta,'Tabla'=>'Tablas de remplazo','CampoId'=>'NoPersonal','ValorId'=>$idempleado,'Campo'=>'TR Largo Quit&oacute;','NuevoValor'=>$datoscandidato['NombreEmpleado'].' ('.$idcandidato.')'));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Simulador</title>
  <script language="JavaScript" type="text/javascript" src="/js/jquery-1.3.1.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/jTPS.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js//FuncionesJavaScript.js"></script>
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
  <link href="/css/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
  <link href="/css/dropdown/themes/mtv.com/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />
  <!--[if lt IE 7]>
  <script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
  <![endif]-->
</head>
<body class="verdana09em">
  <? include('partials/carga.php'); ?>
  <? include('partials/menu.php'); ?>
  <div id="newbody">
<!-- INICIO de sim -->
<?  //chek($unidadesvisibles); ?>
<div id="caja"> <h4>EMPLEADO ACTUAL</h4>
  <?
if($idempleado)
{
  $datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
  //chek($datos);
?>
<div id="container_foto">
    <div class="foto">
      <? if(file_exists("./fotos/$idempleado.jpg")){$foto="./fotos/$idempleado.jpg";}else{$foto="./fotos/sinfoto.jpg";} ?>
      <img src="<?= $foto ?>" width="87px" height="87px" />
        </div>
      
        <div class="datos">
      <a class="nombre" href="javascript:popUpCedula('cedula.php?idempleado=<?= $idempleado ?>')" target=""><?= $datos['NombreEmpleado'] ?></a>
        <h4> <?= $datos['NombrePuesto'] ?> </h4>
  
      <span id="antig">
<!--      <span><h4>Edad</h4> getAge(strtotime( $datos['FechadeAlta'] )) <!--</span>-->
<!--            <span><h4>Antig&uuml;edad</h4>  getAge(strtotime( $datos["FechadeIngresoaPuestoActual"])) <!--</span>-->
      <span><h4>Edad</h4><?= getAge(strtotime( $datos['FechadeNacimiento'] )) ?></span>
            <span><h4>Antig&uuml;edad</h4><?= getAge(strtotime( $datos["FechadeAlta"])) ?></span>

            </span>
        </div>  
      
        <div class="boton">
        <a href="javascript:popUp('graficaDISCtriple.php?noempleado=<?= $idempleado ?>')">
        <img src="pics/bioBtn.jpg" name="Image82" border="0" id="Image82" /></a>
        </div>   
  
 </div>  

<table border="0" cellpadding="0" cellspacing="0" id="tabla2">
    <th>Desempe&ntilde;o 20<?= $anio ?></th>
    <th>EP 20<? printf("%02s\n",$anio-1);?></th>
    <th>EP 20<?= $anio ?></th>
    <tr>
    <td><?= $datos["ED$anio"] ?></td>
    <td><span class="<?= str_replace(' ', '', $datos["EdoPromocional20$anioant"]);  ?>"><?= $datos["EdoPromocional20$anioant"]; ?></span></td>
    <td><span class="<?= str_replace(' ', '', $datos["EdoPromocional20$anio"]);  ?>"><?= $datos["EdoPromocional20$anio"]; ?></span></td>
    </tr> 
</table>

  
<table border="0" cellpadding="0" cellspacing="0" id="tabla">
    <th>Posiciones Anteriores</th>
    <th>Tiempo</th>
  <tr><td><?= $datos['Puesto1'] ?></td><td><?= printdate($datos['FechadeIngresoaPuesto1']) ?></td></tr> 
    <tr><td><?= $datos['Puesto2'] ?> </td><td><?= printdate($datos['FechadeIngresoaPuesto2']) ?></td></tr>    
  <tr><td><?= $datos['Puesto3'] ?></td><td><?= printdate($datos['FechadeIngresoaPuesto3']) ?></td></tr>    
  <tr><td><?= $datos['Puesto4'] ?></td><td><?= printdate($datos['FechadeIngresoaPuesto4']) ?></td></tr> 
</table>


<table border="0" cellpadding="0" cellspacing="0" id="tabla">
  <th>Otras Posiciones</th>
    <tr><td>
      <div style="width:100%; overflow:auto; height:50px"><?= $datos['OtrasPosiciones'] ?></div>
      </td></tr>
  </table>
 


<div id="tabla_reemp">
  <?
  //------------para todos las tr
  $campossalida=array();
  $campossalida[]=new camposalidaLink('','<img src="./imagenes/bonton_simcandidato.jpg" />','simulador.php','idcandidato','NoPersonal');
  $campossalida[]=new camposalidaLink('Nombre','NombreEmpleado','cedula.php','idempleado','NoPersonal','_blank');
  ?>
  
  <div style="height:138px; overflow:auto; overflow-x:hidden"><h5>TR Corto</h5>
    <?
    $data=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trcorto where NoPuesto=$puesto");
    $tabla=new datatable('trcorto',null,$campossalida,$data);
    $tabla->imprimeHTML('grid1','100%','220');
  ?>
    </div>
      
    
    <div style="height:138px; overflow:auto; overflow-x:hidden"><h5>TR Mediano</h5>
    <?
    $data=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trmediano where NoPuesto=$puesto");
    $tabla=new datatable('trmediano',null,$campossalida,$data);
    $tabla->imprimeHTML('grid2','100%','220');
  ?>
      </div>
  
   
    <div style="height:138px; overflow:auto; overflow-x:hidden"><h5>TR Largo</h5>
    <?
    $data=$sql->queryArreglo("Select NombreEmpleado, NoPersonal from trlargo where NoPuesto=$puesto");
    $tabla=new datatable('trlargo',null,$campossalida,$data);
    $tabla->imprimeHTML('grid3','100%','220');
  ?>
      </div>
  
</div>    
  
<? 
  unset($datos);
} 
?>
</div>




<div id="caja">


<h4>CANDIDATO</h4>


<?
if($idcandidato AND ($idempleado!=$idcandidato) )
{
  $datos=$sql->leeregistroporID('empleadosypuestos',$idcandidato,'NoPersonal');
  //chek($datos);
?>

<div id="container_foto">
    
        <div class="foto">

    <? if(file_exists("./fotos/$idcandidato.jpg")){$foto="./fotos/$idcandidato.jpg";}else{$foto="./fotos/sinfoto.jpg";} ?>
    <img src="<?= $foto ?>" width="87px" height="87px" />
    
      </div>
    
        <div class="datos">
 
    <?
    if( $niveldeacceso=='Admin' OR in_array($datos['UnidadOperativa'],$unidadesvisibles))
    {
      ?><a href="simulador.php?idempleado=<?= $idcandidato ?>" target="_self"><img src="./imagenes/bonton_sim.jpg"></a><?
    } 
    ?>
    <?
    if( $niveldeacceso=='Admin' OR in_array($datos['UnidadOperativa'],$unidadesvisibles))
    {
      
      ?><a class="nombre" href="javascript:popUpCedula('cedula.php?idempleado=<?= $idcandidato ?>')" target=""><?= $datos['NombreEmpleado'] ?></a><? 
    }else{
      //chek($unidadesvisibles);
      echo $datos['NombreEmpleado'];
    }       
        ?>
    
      <h4><?= $datos['NombrePuesto'] ?></h4>
        
        <span id="antig">
    <span><h4>Edad</h4><?= getAge(strtotime($datos['FechadeNacimiento'])) ?></span>
        <span><h4>Antig&uuml;edad</h4><?= getAge(strtotime($datos['FechadeAlta'])) ?></span>
        </span>
       
        </div>
      
        <div class="boton">
    
      <a href="javascript:popUp('graficaDISCtriple.php?noempleado=<?= $idcandidato ?>')">
    <img src="pics/bioBtn.jpg" class="botonBio" name="Image82" border="0" id="Image82" /></a>
      
        </div>
</div>   
    
 <table border="0" cellpadding="0" cellspacing="0" id="tabla2">
      <th>Desempe&ntilde;o 20<?= $anio ?></th>
      <th>EP 20<? printf("%02s\n",$anio-1);?></th>
      <th>EP 20<?= $anio ?></th>
      <tr>
      <td>
        <?
      if( $niveldeacceso=='Admin' OR in_array($datos['UnidadOperativa'],$unidadesvisibles))
      {
        ?><?= $datos["ED$anio"] ?><?
      }else{
        echo '<span title="solicitalo a nivel central">--</span>';
      } 
      ?>
        </td>
      
        <?
      if( $niveldeacceso=='Admin' OR in_array($datos['UnidadOperativa'],$unidadesvisibles))
      { 
        ?>
        <td>
        <span class="<?= str_replace(' ', '', $datos["EdoPromocional20$anioant"]);  ?>"><?= $datos["EdoPromocional20$anioant"]; ?></span>
        </td>
        <?
      }else{
        echo '<td><span title="solicitalo a nivel central">--</span></td>';
      } 
      ?>    

        <?
      if( $niveldeacceso=='Admin' OR in_array($datos['UnidadOperativa'],$unidadesvisibles))
      { 
        ?>
        <td>
        <span class="<?= str_replace(' ', '', $datos["EdoPromocional20$anio"]);  ?>"><?= $datos["EdoPromocional20$anio"]; ?></span>
        </td>
        <?
      }else{
        echo '<td><span title="solicitalo a nivel central">--</span></td>';
      } 
      ?>        
      
      
      
      
      </tr> 
</table>    
 
 
<table border="0" cellpadding="0" cellspacing="0" id="tabla">
    <th>Posiciones Anteriores</th>
    <th>Tiempo</th>
  <tr><td><?= $datos['Puesto1'] ?></td><td><?= printdate($datos['FechadeIngresoaPuesto1']) ?></td></tr> 
    <tr><td><?= $datos['Puesto2'] ?> </td><td><?= printdate($datos['FechadeIngresoaPuesto2']) ?></td></tr>    
  <tr><td><?= $datos['Puesto3'] ?></td><td><?= printdate($datos['FechadeIngresoaPuesto3']) ?></td></tr>    
  <tr><td><?= $datos['Puesto4'] ?></td><td><?= printdate($datos['FechadeIngresoaPuesto4']) ?></td></tr> 
</table> 
 
 
<table border="0" cellpadding="0" cellspacing="0" id="tabla">
  <th>Otras Posiciones</th>
    <tr><td>
      <? 
    if( $niveldeacceso=='Admin' OR in_array($datos['UnidadOperativa'],$unidadesvisibles))
    { 
      ?>
      <div style="width:100%; overflow:auto; height:50px"><?= $datos['OtrasPosiciones'] ?></div>
      <?
    }else{
      echo '<span title="solicitalo a nivel central">--</span>';
    }
    ?>    
      </td></tr>
  </table> 
  
  
  
  
  
<? 
if( $niveldeacceso=='Admin' OR in_array($datos['UnidadOperativa'],$unidadesvisibles))
{ 
  ?>
  <table border="0" cellpadding="0" cellspacing="0" id="tabla3">
  <th colspan="3">Agregar a TR de Empleado Actual</th>
  <tr>
    <?
    $temp=$sql->queryArreglo("Select NoPuesto from trcorto where NoPuesto=$puesto AND NoPersonal=".$idcandidato);
    if($editable==1)
    {
      if(sizeof($temp)>0){  
        ?><td><a href="<?= $_SERVER['PHP_SELF'] ?>?rtrcorto=<?=$idcandidato ?>" ><img src="imagenes/quita_corto.jpg" /></a></td><?
      }else{
        ?><td><a href="<?= $_SERVER['PHP_SELF'] ?>?trcorto=<?=$idcandidato ?>" ><img src="imagenes/agrega_corto.jpg" /></a></td><?
      }
      ?>
      <?
      $temp=$sql->queryArreglo("Select NoPuesto from trmediano where NoPuesto=$puesto AND NoPersonal=".$idcandidato);
      if(sizeof($temp)>0){  
        ?><td><a href="<?= $_SERVER['PHP_SELF'] ?>?rtrmediano=<?=$idcandidato ?>" ><img src="imagenes/quita_mediano.jpg" /></a></td><?
      }else{
        ?><td><a href="<?= $_SERVER['PHP_SELF'] ?>?trmediano=<?=$idcandidato ?>" ><img src="imagenes/agrega_mediano.jpg" /></a></td><?
      }
      ?>
    
      <?
      $temp=$sql->queryArreglo("Select NoPuesto from trlargo where NoPuesto=$puesto AND NoPersonal=".$idcandidato);
      if(sizeof($temp)>0){  
        ?><td><a href="<?= $_SERVER['PHP_SELF'] ?>?rtrlargo=<?=$idcandidato ?>" ><img src="imagenes/quita_largo.jpg" /></a></td><?
      }else{
        ?><td><a href="<?= $_SERVER['PHP_SELF'] ?>?trlargo=<?=$idcandidato ?>" ><img src="imagenes/agrega_largo.jpg" /></a></td><?
      }
      ?>       
  <?  } ?>   
  </tr>
  </table>
  <?
}else{
  ?>
  <table border="0" cellpadding="0" cellspacing="0" id="tabla3">
  <th colspan="3">Agregar a TR de Empleado Actual</th>
  <tr>
    <td colspan="3">Para agregar a esta persona como tabla de remplazo o ver su cedula solicitalo a nivel central. <br /> Su numero personal es:<?= $datos['NoPersonal'] ?><br />El del empleado con quien comparas es: <?= $idempleado ?> </td>   
  </tr>
  </table>    
  <?
}
?>

    



<? 
  unset($datos);
} 
?>
</div>


<div class="tab t2sim" style="margin-left:13px;">
    
        <div class="tabsProm">
    <span class="tablink trActive">Promovibles</span>
        <span class="tablink trUp">Altos potenciales</span>
        <span class="tablink trUp">Ranking Cleaver</span>
        <span class="tablink trUp">TRcorto de perfil</span>
        <span class="tablink trUp">TRmediano de perfil</span>
        <span class="tablink trUp">TRlargo de perfil</span>
        </div>

  <div style="border: #666666 solid 1px; width:930px">
<?

  //$query="SELECT `cveempleado`  FROM `empleados` WHERE edoprom$anio='PROM'";
  $query='Select NoPersonal, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos';
  $query.=" where EdoPromocional20$anio='PROM'";

//  chek($query);
//die;
  $data=$sql->queryArreglo($query);
  
  
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
  
  
  
  $tabla=new datatable('resultados',$camposentrada,$campossalidagrid,$data);
  $tamano=sizeof($tabla->tabla);
  $tabla->imprimeHTMLGrid('grid1','930px','220');

?>
  </div>
    
</div>


<div class="tab t2sim" style="margin-left:13px;">
        <div class="tabsProm">
        <span class="tablink trUp">Promovibles</span>
        <span class="tablink trActive">Altos potenciales</span>
        <span class="tablink trUp">Ranking Cleaver</span>
        <span class="tablink trUp">TRcorto de perfil</span>
        <span class="tablink trUp">TRmediano de perfil</span>
        <span class="tablink trUp">TRlargo de perfil</span>
        </div>
  <div style="border: #666666 solid 1px; width:930px">
<?

  //$query="SELECT `cveempleado`  FROM `empleados` WHERE edoprom$anio='AP'";
  $query='Select NoPersonal, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos';
  $query.=" where EdoPromocional20$anio='AP'";
  $data=$sql->queryArreglo($query);
  
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

  $tabla=new datatable('resultados',$camposentrada,$campossalidagrid,$data);
  $tamano=sizeof($tabla->tabla);
  $tabla->imprimeHTMLGrid('grid2','930px','220');

?>
  </div>
</div>

<div class="tab t2sim" style="margin-left:13px;">
<div class="tabsProm">
<span class="tablink trUp">Promovibles</span>
<span class="tablink trUp">Altos potenciales</span>
<span class="tablink trActive">Ranking Cleaver</span>
<span class="tablink trUp">TRcorto de perfil</span>
<span class="tablink trUp">TRmediano de perfil</span>
<span class="tablink trUp">TRlargo de perfil</span>
</div>
<div style="border: #666666 solid 1px; width:930px">
<?

if($perfil)
{
//  "SELECT e.cveempleado , (ABS((p.cleaverd-e.cleaverd)) + ABS((p.cleaveri-e.cleaveri)) + ABS((p.cleavers-e.cleavers)) + ABS((p.cleaverc-e.cleaverc)) ) AS a FROM plazas as p,empleados as e WHERE p.cveplaza=".$plaza->datos['cveplaza']." ORDER BY a LIMIT 30 "
  
  $query="SELECT NoPersonal, NombreEmpleado ,NombrePuesto, p.NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa, (ABS((p.DObservable-e.DObservable)) + ABS((p.IObservable-e.IObservable)) + ABS((p.SObservable-e.SObservable)) + ABS((p.CObservable-e.CObservable)) ) AS a FROM perfiles p, empleadosypuestos e Where p.`NoPerfil`=$perfil AND e.DObservable IS NOT NULL AND e.IObservable IS NOT NULL AND e.SObservable IS NOT NULL AND e.CObservable IS NOT NULL AND p.DObservable IS NOT NULL AND p.IObservable IS NOT NULL AND p.SObservable IS NOT NULL AND p.CObservable IS NOT NULL ORDER BY a limit 30";
  //$query='Select NoPersonal, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos';
  //$query.=" where EdoPromocional20$anio='AP'";

  $data=$sql->queryArreglo($query);
  
  
  //--------limpieza para lectores y editores    Director, Gerente, Grouper
  
  if($niveldeacceso!='Admin')
  {
    foreach($data as $key=>$renglon)
    {   
      if(in_array($renglon["TipodePuesto"],$tiposdepuestopermitidos))
      {
        unset($data[$key]);
      } 
    } 
  }
  //------------------------------  
  
  
  
  $tabla=new datatable('resultados',$camposentrada,$campossalidagrid,$data);
  $tamano=sizeof($tabla->tabla);
  $tabla->imprimeHTMLGrid('grid3','930px','220');
}
?>
</div>
</div>

<div class="tab t2sim" style="margin-left:13px;">
<div class="tabsProm">
<span class="tablink trUp">Promovibles</span>
<span class="tablink trUp">Altos potenciales</span>
<span class="tablink trUp">Ranking Cleaver</span>
<span class="tablink trActive">TRcorto de perfil</span>
<span class="tablink trUp">TRmediano de perfil</span>
<span class="tablink trUp">TRlargo de perfil</span>
</div>
<div style="border: #666666 solid 1px; width:930px">
<?

if($perfil)
{

  //$query="SELECT `cveempleado`  FROM `empleados` WHERE edoprom$anio='PROM'";
  $query='Select NoPersonal, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos';
  $query.=" where NoPersonal IN(SELECT NoPersonal FROM simrh.trcorto WHERE PerfilTipo=$perfil)";
  $data=$sql->queryArreglo($query);
  
  //--------limpieza para lectores y editores    Director, Gerente, Grouper
  
  if($niveldeacceso!='Admin')
  {
    foreach($data as $key=>$renglon)
    {   
      if(in_array($renglon["TipodePuesto"],$tiposdepuestopermitidos))
      {
        unset($data[$key]);
      } 
    } 
  }
  //------------------------------    
  
  
  $tabla=new datatable('resultados',$camposentrada,$campossalidagrid,$data);
  $tamano=sizeof($tabla->tabla);
  $tabla->imprimeHTMLGrid('grid4','930px','220');
  
}
?>
</div>
</div>

<div class="tab t2sim" style="margin-left:13px;">
<div class="tabsProm">
<span class="tablink trUp">Promovibles</span>
<span class="tablink trUp">Altos potenciales</span>
<span class="tablink trUp">Ranking Cleaver</span>
<span class="tablink trUp">TRcorto de perfil</span>
<span class="tablink trActive">TRmediano de perfil</span>
<span class="tablink trUp">TRlargo de perfil</span>
</div>
<div style="border: #666666 solid 1px; width:930px">
<?

if($perfil)
{

  //$query="SELECT `cveempleado`  FROM `empleados` WHERE edoprom$anio='PROM'";
  $query='Select NoPersonal, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos';
  $query.=" where NoPersonal IN(SELECT NoPersonal FROM simrh.trmediano WHERE PerfilTipo=$perfil)";
  $data=$sql->queryArreglo($query);
  
  //--------limpieza para lectores y editores    Director, Gerente, Grouper
  
  if($niveldeacceso!='Admin')
  {
    foreach($data as $key=>$renglon)
    {   
      if(in_array($renglon["TipodePuesto"],$tiposdepuestopermitidos))
      {
        unset($data[$key]);
      } 
    } 
  }
  //------------------------------    
  
  $tabla=new datatable('resultados',$camposentrada,$campossalidagrid,$data);
  $tamano=sizeof($tabla->tabla);
  $tabla->imprimeHTMLGrid('grid5','930px','220');
}
?>
</div>
</div>

<div class="tab t2sim" style="margin-left:13px;">
<div class="tabsProm">
<span class="tablink trUp">Promovibles</span>
<span class="tablink trUp">Altos potenciales</span>
<span class="tablink trUp">Ranking Cleaver</span>
<span class="tablink trUp">TRcorto de perfil</span>
<span class="tablink trUp">TRmediano de perfil</span>
<span class="tablink trActive">TRlargo de perfil</span>
</div>
<div style="border: #666666 solid 1px; width:930px">
<?
if($perfil)
{

  //$query="SELECT `cveempleado`  FROM `empleados` WHERE edoprom$anio='PROM'";
  $query='Select NoPersonal, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos';
  $query.=" where NoPersonal IN(SELECT NoPersonal FROM simrh.trlargo WHERE PerfilTipo=$perfil)";
  $data=$sql->queryArreglo($query);
  
  //--------limpieza para lectores y editores    Director, Gerente, Grouper
  
  if($niveldeacceso!='Admin')
  {
    foreach($data as $key=>$renglon)
    {   
      if(in_array($renglon["TipodePuesto"],$tiposdepuestopermitidos))
      {
        unset($data[$key]);
      } 
    } 
  }
  //------------------------------    
  
  $tabla=new datatable('resultados',$camposentrada,$campossalidagrid,$data);
  $tamano=sizeof($tabla->tabla);
  $tabla->imprimeHTMLGrid('grid6','930px','220');
}
?>
</div>
</div>

<? 
  include('partials/footer.php'); 
?>

<!-- FIN de sim -->
</div>
<? 
  include('partials/buscador.php'); 
?>

</body>
</html>
