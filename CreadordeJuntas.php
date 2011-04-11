<?
require_once 'clasesincluder.php';

if($niveldeacceso!='Admin' AND $niveldeacceso!='Editor')
{
  header("Location: ./salir.php");
  die;
}

if($idjunta)
{
  header("Location: ./reportedejunta.php");
  die;
}


$mensajeJuntas='';

$datos=$sql->leeregistroporID('empleadosypuestos',$NoUsuario,'NoPersonal');

if($_POST['boton']=='Iniciar Junta')
{
  $participantes=explode(' ',$_POST['participantes']);
  foreach($participantes as $participante)
  {
    if($participante AND is_numeric($participante))
    {
      //chek($participante);
      $datos=$sql->leeregistroporID('empleadosypuestos',$participante,'NoPersonal');
      if(!$datos)
      {
        $mensajeJuntas.='El NoPersonal '.$participante.' No esta registrado en el sistema<br />';
      }else{
        $participantesclean.=' '.$participante;
      }
    }
  }
  //die;
  
  if(!$mensajeJuntas)
  {

    if($niveldeacceso=='Admin')
    { 
      
      $UnidadOperativa=$_POST['UnidadOperativa']; 
      $Division=$_POST['Division'];
      $Zona=$_POST['Zona'];

      if(!$UnidadOperativa){$UnidadOperativa='&nbsp;';}
      if(!$Division){$Division='&nbsp;';}
      if(!$Zona){$Zona='&nbsp;';}
    
    }else{ 

      $UnidadOperativa=$_SESSION['UnidadOperativaUsuario']; 
      $Division=$_SESSION['Division'];
      $Zona=$_SESSION['Zona'];
    }
    
    $participantes=trim($participantesclean);
    
    $sql->agregarregistro('juntas',array('unidadoperativa'=>$UnidadOperativa,'zona'=>$Zona,'division'=>$Division,'idresponsable'=>$NoUsuario,'asistentes'=>$participantes,'fecha'=>date('Y').'-'.date('m').'-'.date('d'),'comentarios'=>utf8_encode($_POST['comentarios'])  )      );
    
    
    $idjunta=$sql->queryArregloUNI("Select * from juntas where idresponsable=$NoUsuario Order by  Id DESC limit 1");
    $idjunta=$idjunta[0];
    $_SESSION['idjunta']=$idjunta;
    header("Location: ./simulador.php");
  }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" style="overflow:auto;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SimRH:: Administrador de Datos</title>
  <script language="JavaScript" type="text/javascript" src="/js/jquery-1.3.1.min.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/jTPS.js"></script>
  <script language="JavaScript" type="text/javascript" src="/js/FuncionesJavaScript.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/jTPS.css" />
  <link href="/css/estilos.css" rel="stylesheet" type="text/css" />
  <link href="/css/juntas.css" rel="stylesheet" type="text/css" />
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

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">



<div class="paddingbody">

<h1>Creador de Juntas</h1>

<?= $mensajeJuntas ?>

<p class="info">El modo <b>'Junta de Planeaci&oacute;n'</b> se activar&aacute; al crear una Junta permitiendo la edici&oacute;n de datos.<br/>
La junta será creada a partir de los siguientes campos:


</p>
<br />
<table cellpadding="0" cellspacing="0" width="400px">
<tr><td class="creador">Creador:</td><td class="creador"><b><?= $datos['NombreEmpleado'] ?></b></td></tr>
<tr><td class="creador">No. Empleado:</td><td class="creador"><?= $NoUsuario ?></tr>
<tr><td class="creador">Fecha de Junta:</td><td class="creador"><?= date("d/m/Y") ?></td></tr>
</table>


<?
if($niveldeacceso=='Admin')
{ 
?>
<table cellpadding="0" cellspacing="0" width="400px">
          <tr>
            <td class="creador">Divisi&oacute;n:</td>
            <td class="creador"><? htmlselectdesdesql ('Division', $sql, 'puestos', 'Division', 'Division', $Division); ?></td>
          </tr>
          <tr>
            <td class="creador">Zona:</td>
            <td class="creador"><? htmlselectdesdesql ('Zona', $sql, 'puestos', 'Zona', 'Zona', $Zona); ?></td>
          </tr>          
          <tr>
            <td class="creador">Unidad Operativa:</td>
            <td class="creador"><? htmlselectdesdesql ('UnidadOperativa', $sql, 'puestos', 'UnidadOperativa', 'UnidadOperativa', $UnidadOperativa); ?></td>
          </tr>
</table>
<?
}
?>
<br /><br />
Ingrese los<b> N&uacute;meros de empleado</b> de los asistentes la junta:<br />
<p class="note">*&nbsp;Separar con espacios, Ej. 12345 112233 34567 </p>
<textarea rows="5" cols="33" name="participantes"><?=$NoUsuario ?> </textarea><br />
<br />
<b>Comentarios:</b> 

<p class="note">Este campo podr&aacute; actualizarse al terminar la junta. No es obligatorio</p>
<textarea rows="5" cols="33" name="comentarios"></textarea><br /><br />
<input type="submit" name="boton" value="Iniciar Junta" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.back(1)">Cancelar</a>


</div>
</form>
<?  include('partials/footer.php'); ?>
</body>
</html>
