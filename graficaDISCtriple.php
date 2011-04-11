<?php
require_once 'clasesincluder.php';
require_once 'acceso.php';


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DISC<?= $_GET['noempleado'] ?></title>
</head>
<body>
<img src="graficaDISC.php?noempleado=<?= $_GET['noempleado'] ?>&tipo=Observable&perfil=<?= $_GET['pefil'] ?>"  />
<!-- 
<img src="graficaDISC.php?noempleado=<?= $_GET['noempleado'] ?>&tipo=Proyectable"  />
<img src="graficaDISC.php?noempleado=<?= $_GET['noempleado'] ?>&tipo=Natural"  />
 -->
</body>
</html>