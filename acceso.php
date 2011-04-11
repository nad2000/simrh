<?php
session_start();

$mensaje='Introduce tu número de empleado y clave.';

if($_POST['usuario'] AND $_POST['clave'])
{
  if(is_numeric($_POST['usuario']))
  {
    $datos=$sql->leeregistroporID('usuarios',$_POST['usuario'],'NoPersonal');
  }
  if($datos['password']==$_POST['clave'])
  {
    $datos2=$sql->leeregistroporID('empleadosypuestos',$_POST['usuario'],'NoPersonal');
    $_SESSION['NoUsuario']=$datos['NoPersonal'];
    $_SESSION['niveldeacceso']=$datos['niveldeacceso'];
    $_SESSION['UnidadOperativaUsuario']=$datos2['UnidadOperativa'];
    $_SESSION['Division']=$datos2['Division'];
    $_SESSION['Zona']=$datos2['Zona'];
    $_SESSION['NivelUsuario']=$datos2['Niveldelpuesto'];
    $_SESSION['UnidadesOperativasUsuario']=explode(',',$datos['unidadesoperativas']);
    function trimer(&$var)
    {
      $var=trim($var);
    }
    array_walk($_SESSION['UnidadesOperativasUsuario'],'trimer');
  }else{
    $mensaje='Usuario y/o clave incorrectos, por favor vuelve a intentar.';
  }
}

$NoUsuario=$_SESSION['NoUsuario'];
$niveldeacceso=$_SESSION['niveldeacceso'];
$UnidadOperativaUsuario=$_SESSION['UnidadOperativaUsuario'];
$NivelUsuario=$_SESSION['NivelUsuario'];
$unidadesvisibles=$_SESSION['UnidadesOperativasUsuario'];

if(file_exists("./exceles/$NoUsuario.xls")){unlink("./exceles/$NoUsuario.xls");}

if( !($NoUsuario AND $niveldeacceso AND $UnidadOperativaUsuario AND $NivelUsuario) AND $niveldeacceso!='Admin')
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Acceso SIM-RH v2.5</title>
  <link href="/css/estilos.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#e5e5e5" class="verdana09em">
  <div id="login">
  <div class="header">
  <img src="imagenes/logosim_login.jpg" alt="logo" align="right" />
  <div class="texto_header">login</div>
  </div>

  <div class="login_conteiner">
    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>"><div class="info">
      <?= $mensaje ?>
    </div>
    <h2>NoPersonal</h2>
    <input type="text" name="usuario"/>
    Ej. 1327541
    <h2>Clave</h2>
    <input type="password" name="clave" /><br />
    <input type="submit" value="Entrar" class="enviar" />
    </form>
  </div>
</div>
</body>
</html>

<?
die;
}

if($_SESSION['idjunta'])
{
  $idjunta=$_SESSION['idjunta'];
  $editable=1;
}else{
  $idjunta=null;
  $editable=0;
}
?>
