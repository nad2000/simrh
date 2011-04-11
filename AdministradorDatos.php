<?
require_once 'clasesincluder.php';

if($niveldeacceso!='Admin')
{
  header("Location: ./salir.php");
  die;
}

$sql->query("delete from puestos where NoPuesto=null or NoPuesto=0");
$sql->query("delete from empleados where NoPersonal=null or NoPersonal=0");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" style="overflow:auto;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrador de Datos</title>
    <link rel="stylesheet" type="text/css" href="/css/estilos.css" />
    <link href="/css/admin.css" rel="stylesheet" type="text/css" />
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
<h1>Administrador de Datos</h1>


<!-- Inicio Datos SAPEmpladosPuestos  -->
<?

//chek($_FILES);
if($_POST['botonSAPEmpleadosPuestos']){
  $namefileenviado='fileSAPEmpleadosPuestos';
  if($_FILES[$namefileenviado]['name']=='datosSAPempleadosypuestos.xls')
  {
    $newfile=dirname($_FILES[$namefileenviado]['tmp_name']).'\\'.$_FILES[$namefileenviado]['name'];
    
    //chek($newfile);
    
    rename($_FILES[$namefileenviado]['tmp_name'],$newfile);
    $excel= new datosexcel2($newfile,1);  
    
    //chek('excel');
    //die;
    if($excel->existetabla('datos'))
    {
      //chek($excel->getencabezados('datos'));
      //chek($camposdatosSAPempleadosypuestos);
      //chek('fuera datos');
      //die;
      
      if(
         array_in_array($camposdatosSAPempleadosypuestos, $excel->getencabezados('datos') ) 
      && array_in_array($excel->getencabezados('datos'), $camposdatosSAPempleadosypuestos )
        )
      {
        //chek('encabezados correctos existe adelante');
        //die();
        $datosSAPempleados=$excel->leertabla('datos',$camposdatosSAPempleados);
        //chek($camposdatosSAPempleados);
        //chek($datosSAPempleados[0]);
  
        foreach($datosSAPempleados as $registroemplado)//arregla las fechas y deja solo los registros con datos de empleados
        {
          
          if($registroemplado['NoPersonal'] )
          {         
            
            if($registroemplado['FechadeNacimiento'])
            {
              //chek($registroemplado['FechadeNacimiento']);
              $Fecha=split('/',$registroemplado['FechadeNacimiento']);  
              $registroemplado['FechadeNacimiento']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeAlta'])
            {
              $Fecha=split('/',$registroemplado['FechadeAlta']);  
              $registroemplado['FechadeAlta']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeIngresoaPuestoActual'])           
            {
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuestoActual']);  
              $registroemplado['FechadeIngresoaPuestoActual']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeIngresoaPuesto1'])
            {
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuesto1']);  
              $registroemplado['FechadeIngresoaPuesto1']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeIngresoaPuesto2'])
            {
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuesto2']);  
              $registroemplado['FechadeIngresoaPuesto2']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeIngresoaPuesto3'])
            {
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuesto3']);  
              $registroemplado['FechadeIngresoaPuesto3']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeIngresoaPuesto4'])
            {
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuesto4']);  
              $registroemplado['FechadeIngresoaPuesto4']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            
            $datosSAPempleados2[]=$registroemplado;
            $nuevosidsdeempleados[]=$registroemplado['NoPersonal'];
          }
          //-------extra para evitar ciclos en puestos
          if($registroemplado['NoPuesto']>0 )
          {         
            $nuevosidsdepuestos[]=$registroemplado['NoPuesto'];
          }
          
        }
        
        
        
        $datosSAPempleados=$datosSAPempleados2;
        unset($datosSAPempleados2);
        
        $empleadosactuales=$sql->queryArregloUNI('SELECT e.`NoPersonal` FROM simrh.empleados e;');
        

        //chek($empleadosactuales);
        //chek($nuevosidsdeempleados);
        //die();
        foreach($empleadosactuales as $empleadoactual)//borra lo que no este en el excel
        {
          if(!in_array($empleadoactual,$nuevosidsdeempleados))
          {
            $sql->borraregistroporID('empleados','NoPersonal',$empleadoactual);
          }
        }
        //$datosaremplazardeempleados=$sql->leertabla('empleados');
  
  
        
        foreach($datosSAPempleados as &$registroemplado)//arregla las fechas y deja sololos registros con datos de emplados
        {
          if($registroemplado['NoPersonal'])
          {
            $registroaremplazar=$sql->queryArreglo("SELECT * from empleados WHERE NoPersonal=".$registroemplado['NoPersonal']);
            $registroaremplazar=$registroaremplazar[0];
            
            //chek($registroemplado);
            //chek((integer)$registroaremplazar['NoPuesto'].'-'.(integer)$registroemplado['NoPuesto']);
            
            if(!$registroaremplazar){ $registroemplado['StatusSAP']='Nuevo'; }
            
            //chek();
            
            else if((integer)$registroaremplazar['NoPuesto']!=(integer)$registroemplado['NoPuesto'])
            {
              $registroemplado['StatusSAP']='Cambi&oacute; de puesto'; ///ojo si se cambio esto cambiar tambien el trigger
              //$registroemplado['APP']='';
            }
            //else if( $registroaremplazar['Escolaridad1']!=$registroemplado['Escolaridad1']){$registroemplado['StatusSAP']='Cambi&oacute; de escolaridad';}
            //else if( $registroaremplazar['StatusdeEscolaridad1']!=$registroemplado['StatusdeEscolaridad1']){$registroemplado['StatusSAP']='Cambi&oacute; de escolaridad';}
            else {$registroemplado['StatusSAP']='';}
          }
        }     
        
        
        
        $sql->actualizatablaconID('empleados',$datosSAPempleados,'NoPersonal');
        
        
        
        //-------------Puestos
        $puestosactuales=$sql->queryArregloUNI('SELECT p.`NoPuesto` FROM simrh.puestos p;');
        //chek($puestosactuales);
        foreach($puestosactuales as $puestoactual)//borra lo que no este en el excel
        {
          //chek($puestoactual);
          if(!in_array($puestoactual,$nuevosidsdepuestos))//$nuevosidsdepuestos sale de un ciclo en la parte de emplados
          {
            //chek($puestoactual);
            $sql->borraregistroporID('puestos','NoPuesto',$puestoactual);
          }
        }
        $datosSAPuestos=$excel->leertabla('datos',$camposdatosSAPuestos);
        //chek($camposdatosSAPuestos);
        //chek($datosSAPuestos[0]);
        
        //die();
        
        foreach($datosSAPuestos as &$registropuesto)//arregla las fechas y deja sololos registros con datos de emplados
        {
          //chek($registropuesto);
          if($registropuesto['NoPuesto'])
          {
            $query="SELECT p.`NoPuesto`, p.`NombrePuesto`, e.`NoPersonal` FROM simrh.puestos p LEFT JOIN simrh.empleados e ON p.NoPuesto=e.NoPuesto WHERE p.NoPuesto=".$registropuesto['NoPuesto'];
            $registroaremplazar=$sql->queryArreglo($query);
            $registroaremplazar=$registroaremplazar[0];
            
            //chek($query);
            //chek($registroaremplazar);
            
            if(!$registroaremplazar){ $registropuesto['StatusSAP']='Nuevo'; }
            else if($registroaremplazar['NombrePuesto']!=$registropuesto['NombrePuesto']){$registropuesto['StatusSAP']='Cambi&oacute; el nombre';}
            else if(!$registroaremplazar['NoPersonal']){$registropuesto['StatusSAP']='Vacante';}
            else {$registropuesto['StatusSAP']='';}
          }
        }     
        
        $sql->actualizatablaconID('puestos',$datosSAPuestos,'NoPuesto');
        
        procesaempleadosypuestos();
              
      }
  
    }else{
      chek('El archivo enviado no tiene la hoja - datos -');
    }
    
    unlink($newfile);
  }else{
    chek('El archivo enciado no es: datosSAPempleadosypuestos.xls');
  }
}


?>



<div style=" width:220px">
Fecha: <?= date("d/m/y"); ?>
</div><br />

<div class='caja' style="width:99%; height: 158px; padding:3px 3px 3px 3px">
<div style="width:100%; height:1px; background-color:#666666"></div>
<h4><div class='encabezado' style="">Datos de SAP sobre empleados y puestos</div></h4>
<div style=" float:left; width:34%; ">
  
    <div style="">
    <a href="exceles/datosSAPempleadosypuestos.xls"><img border="0" src="media/Excel-48x48.png" />Descargar archivo guia</a>
    </div>
    <form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
        <div style="">DatosEmpleadosPuestosSAP:
          <input name="fileSAPEmpleadosPuestos" type="file" />
        </div>
        <div style="">
          <input name="botonSAPEmpleadosPuestos" type="submit" value="Enviar archivos" />
        </div>
    </form>   
</div>


<div class='tablacontainer' style=" float:left;  width:33%;">
  <?
  
  
  //--------datos SAP puestos
  $totalSAPpuestos=$sql->queryArregloUNI('SELECT count(*) FROM simrh.puestos e');
  $totalSAPpuestos=$totalSAPpuestos[0];
  
  $totalSAPpuestosNuevos=$sql->queryArregloUNI('SELECT count(*) FROM simrh.puestos e Where StatusSAP="Nuevo"');
  $totalSAPpuestosNuevos=$totalSAPpuestosNuevos[0];
  $porcentajeSAPpuestosNuevos=($totalSAPpuestosNuevos*100)/$totalSAPpuestos;
  
  $totalSAPpuestosCambioNombre=$sql->queryArregloUNI('SELECT count(*) FROM simrh.puestos e Where StatusSAP="Cambi&oacute; el nombre"');
  $totalSAPpuestosCambioNombre=$totalSAPpuestosCambioNombre[0];
  $porcentajeSAPpuestosCambioNombre=($totalSAPpuestosCambioNombre*100)/$totalSAPpuestos;
  
  $totalSAPpuestosVacantes=$sql->queryArregloUNI('SELECT count(*) FROM simrh.puestos e Where StatusSAP="Vacante"');
  $totalSAPpuestosVacantes=$totalSAPpuestosVacantes[0];
  $porcentajeSAPpuestosVacantes=($totalSAPpuestosVacantes*100)/$totalSAPpuestos;
  
  ?>
  
  
    Puestos:
  <table width="100%"  class="tabla" >
      <tr>
        <td width="62%">Total:</td>
        <td width="38%"><?= $totalSAPpuestos ?>(100%)</td>
      </tr>
      <tr>
        <td>Nuevos:</td>
        <td><?= $totalSAPpuestosNuevos ?>(<? printf("%.2f", $porcentajeSAPpuestosNuevos); ?>%)</td>
      </tr> 
      <tr>
        <td>Vacantes:</td>
        <td><?= $totalSAPpuestosVacantes ?>(<? printf("%.2f", $porcentajeSAPpuestosVacantes); ?>%)</td>
      </tr>          
      <tr>
        <td>Cambio el nombre:</td>
        <td><?= $totalSAPpuestosCambioNombre ?>(<? printf("%.2f", $porcentajeSAPpuestosCambioNombre); ?>%)</td>
      </tr>     
    </table>
  </div>
  
  
  <div class='tablacontainer' style=" float:left; width:33%;">
    <?
    //--------datos SAP empleados
    $totalSAPempleados=$sql->queryArregloUNI('SELECT count(*) FROM simrh.empleados e');
    $totalSAPempleados=$totalSAPempleados[0];
    
    $totalSAPempleadosNuevos=$sql->queryArregloUNI('SELECT count(*) FROM simrh.empleados e Where StatusSAP="Nuevo"');
    $totalSAPempleadosNuevos=$totalSAPempleadosNuevos[0];
    $porcentajeSAPempleadosNuevos=($totalSAPempleadosNuevos*100)/$totalSAPempleados;
    
    $totalSAPempleadosCambioPuesto=$sql->queryArregloUNI('SELECT count(*) FROM simrh.empleados e Where StatusSAP="Cambi&oacute; de puesto"');
    $totalSAPempleadosCambioPuesto=$totalSAPempleadosCambioPuesto[0];
    $porcentajeSAPempleadosCambioPuesto=($totalSAPempleadosCambioPuesto*100)/$totalSAPempleados;
    
    $totalSAPempleadosCambioEscolaridad=$sql->queryArregloUNI('SELECT count(*) FROM simrh.empleados e Where StatusSAP="Cambi&oacute; de escolaridad"');
    $totalSAPempleadosCambioEscolaridad=$totalSAPempleadosCambioEscolaridad[0];
    $porcentajeSAPempleadosCambioEscolaridad=($totalSAPempleadosCambioEscolaridad*100)/$totalSAPempleados;

    
 
    ?>
        Empleados:
    <table width="100%"  class="tabla" >
          <tr>
            <td width="62%">Total:</td>
            <td width="38%"><?= $totalSAPempleados ?>(100%)</td>
          </tr>
          <tr>
            <td>Nuevos:</td>
            <td><?= $totalSAPempleadosNuevos ?>(<?printf("%.2f", $porcentajeSAPempleadosNuevos); ?>%)</td>
          </tr>
          <tr>
            <td>Cambi&oacute; de puesto:</td>
            <td><?= $totalSAPempleadosCambioPuesto ?>(<?printf("%.2f", $porcentajeSAPempleadosCambioPuesto); ?>%)</td>
          </tr>     
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;
      <? 
        //echo $totalSAPempleadosCambioEscolaridad ;
      ?>
            <? 
        //printf("%.2f", $porcentajeSAPempleadosCambioEscolaridad);
      ?>
            </td>
          </tr>    
        </table>
      </div>
</div>
<!-- Fin Datos SAPEmpladosPuestos  -->

<br />
<br />

<!-- Inicio Puestos RH -->
<?

//-------------Procesar archivos que envien 
  //----------------Puestos
  if($_POST['botonRHpuestos']=='Enviar archivos')
  { 
    $namefileenviado='fileRHpuestos';
    $newfile=dirname($_FILES[$namefileenviado]['tmp_name']).'\\'.$_FILES[$namefileenviado]['name'];
    
    if(file_exists($newfile)){unlink($newfile);}
    
    rename($_FILES[$namefileenviado]['tmp_name'],$newfile);
    
    
    //chek(basename($newfile));
    if(basename($newfile)=='datosRHpuestos.xls')
    {
      $excel= new datosexcel2($newfile,1,true);
      if($excel->existetabla('datos'))
      {
        
      //  chek('dsdsd');
      //  $tabla= new datatable('datos',NULL,NULL,$excel);
      //  chek($tabla);       
      //  $tabla->imprimeHTML();
                
        
        if  ( array_in_array($excel->getencabezados('datos'),$camposdatosRHpuestos)//--Los campos corresponden
            AND
            in_array('NoPuesto',$excel->getencabezados('datos')) //----tiene el campo de NoPuesto
            )
        {   
          $tabla= new datatable('datos',NULL,NULL,$excel);

          if($tabla->sutituyeporllaves('PerfilTipo',$sql,'perfiles','NoPerfil','NombrePerfil') )
          { 
            $sql->actualizatablaconID('puestos',$tabla->tabla,'NoPuesto',false);
            unlink($newfile);
            procesaempleadosypuestos();
          }else{
            chek('El archivo datosRHpuestos.xls tiene perfiles vacios o que no estan registrados');
            unlink($newfile);
          }
                
        }else{
          //las columnas del archivo no son correctas
          //aunque se vean vacias si se escribio algo mas aya de las columnas marca error si pasa hay que elimnar algunas las columnas despues de los contenidos
          chek('las columnas del archivo no son correctas');
        }
      }else{
        //la hoja datos del archivo no esta 
        chek('la hoja datos del archivo no esta ');
      }
      
    }else if(basename($newfile)=='datosRHpuestos.zip'){
//OJO cambio no bine revisado de decia datosFEMSA     
        unlinkRecursive('./exceles/temp/',FALSE);  
      $zip = new ZipArchive;
        if ($zip->open($newfile)) {
            $zip->extractTo('./exceles/temp/');
            $zip->close();
            //----fin deszipeado
            
        //----inicia lectura de datos
          $Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');
  
        $almenosunfile=false;
          foreach ($Unidadesoperativas as $unidadoperativa)
        {
          $unidadoperativafile=cadenafilesystem($unidadoperativa);
          $newfile2="./exceles/temp/datosRHpuestos-$unidadoperativafile-.xls";
          if(file_exists($newfile2))
          {
            $almenosunfile=true;
            $excel= new datosexcel2($newfile2,1);
            if($excel->existetabla('datos'))
            {
              if  ( array_in_array($excel->getencabezados('datos'),$camposdatosRHpuestos)//--Los campos corresponden
                  AND
                  in_array('NoPersonal',$excel->getencabezados('datos')) //----tiene el campo de NoPersonal
                  )
              {
                //chek('Archivo correcto');
//                $camposainsertar=$excel->getencabezados('datos');       
//                $camposainsertar=array_diff($camposainsertar,array('TipodePuesto'));    
//                $datosFEMSAempleados=$excel->leertabla('datos',$camposainsertar);   
//                $sql->actualizatablaconID('empleados',$datosFEMSAempleados,'NoPersonal');
//                unlink($newfile2);

                if($tabla->sutituyeporllaves('PerfilTipo',$sql,'perfiles','NoPerfil','NombrePerfil') )
                { 
                  $sql->actualizatablaconID('puestos',$tabla->tabla,'NoPuesto');
                  unlink($newfile2);
                }else{
                  chek("El archivo $newfile2 tiene perfiles vacios o que no estan registrados");
                  unlink($newfile2);
                }                   
                
              }else{
                //las columnas del archivo no son correctas
                //aunque se vean vacias si se escribio algo mas aya de las columnas marca error si pasa hay que elimnar algunas las columnas despues de los contenidos
                chek("las columnas del archivo $newfile2 no son correctas");
              }
            }else{
              //la hoja datos del archivo no esta 
              chek("la hoja datos del archivo $newfile2 no esta ");
            }
          } 
        }
        unlinkRecursive('./exceles/temp/',FALSE);         
            if(!$almenosunfile){
              chek('No se encontraron los archivos correcots en el ZIP - deben llamarse datosFEMSAempleados-uopX-.xls - donde X es el numero d ela unidad operativa');
            }else{
          procesaempleadosypuestos(); 
        }
            
         } else {
            chek('Error en el ZIP');
         }
    }else{
      chek('En la seccion -Datos de PH Puestos sobre empleados- solo puede subir el archivo datosRHpuestos.xls');
      
    }
  } 
  
  
  //----------------Perfiles
  if($_POST['botonperfiles']=='Subir Perfiles')
  {
    $namefileenviado='fileperfiles';
    $newfile=dirname($_FILES[$namefileenviado]['tmp_name']).'\\'.$_FILES[$namefileenviado]['name'];
    
    if(file_exists($newfile)){unlink($newfile);}
    
    rename($_FILES[$namefileenviado]['tmp_name'],$newfile);
    
    //chek(basename($newfile));
    if(basename($newfile)=='perfiles.xls')
    {
      $excel= new datosexcel2($newfile,1);
      if($excel->existetabla('datos'))
      { 
        //chek($excel->getencabezados('datos'));
        //chek($camposdatosRHperfiles);
        
        if(array_in_array($excel->getencabezados('datos'),$camposdatosRHperfiles))//--Los campos corresponden
        {
          //chek('Archivo correcto');
          $camposainsertar=$excel->getencabezados('datos');           
          $datosRHperfiles=$excel->leertabla('datos',$camposainsertar); 
          //chek($datosRHperfiles); 
          $sql->guardartabla('perfiles',$datosRHperfiles);
          unlink($newfile); 
          $sql->query("delete from perfiles where NoPerfil=null or NoPerfil=0");
        }else{
          //las columnas del archivo no son correctas
          //aunque se vean vacias si se escribio algo mas aya de las columnas marca error si pasa hay que elimnar algunas las columnas despues de los contenidos
          chek('las columnas del archivo no son correctas');
        }   
      }else{
        chek('En la seccion el archivo perfiles.xls no tiene hoja de datos');
      }
    }else{
      chek('En la seccion -Perfiles- solo puede subir el archivo perfiles.xls');  
    }
    
    
  }

  
  //-----------hacer cadenas para consultas sql 
  $where='';
  $campos='';
  foreach ($camposdatosRHpuestos as $campo)
  {
    $where.= " $campo is NULL OR ";
    $campos.= " $campo, ";
  }
  $where=rtrim($where,'OR ');
  $campos=rtrim($campos,', ');
  
  ////--------obtien datos para la tabla
  $query="Select count(*) FROM puestos";  
  $totalpuestos=$sql->queryArregloUNI($query);
  $totalpuestos=$totalpuestos[0];
  
  $query="Select count(*) FROM puestos WHERE $where"; 
  $puestoscondatosfaltantes=$sql->queryArregloUNI($query);
  $puestoscondatosfaltantes=$puestoscondatosfaltantes[0];
  
  ///-------------genera archivo total
  $query="Select $campos FROM puestos WHERE $where";  
  $data=$sql->queryArreglo($query);
  
//  $tabla= new datatable('datos',null,null,$data); 
//  $tabla->sutituyeporllaves('PerfilTipo',$sql,'perfiles','NombrePerfil','NoPerfil');
//  $excel= new datosexcel('./exceles/datosRHpuestos.xls');
//  $excel->guardartabla('datos',$tabla->tabla);  

  
  ///--------------Genera archivo por unidad operatativa
//  unlinkRecursive('./exceles/temp/',FALSE);
//  $Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');
//
//  foreach ($Unidadesoperativas as $unidadoperativa)
//  {
//    //chek($unidadoperativa);
//    $unidadoperativafile=cadenafilesystem($unidadoperativa);
//    $query="Select $campos FROM puestos WHERE ($where) and UnidadOperativa='$unidadoperativa'";
//    $data=$sql->queryArreglo($query);
//    unlink("./exceles/temp/datosFEMSAempleados-$unidadoperativafile-.xls");
//    if(sizeof($data)>=1){
//      $tabla= new datatable('datos',null,null,$data); 
//      $tabla->sutituyeporllaves('PerfilTipo',$sql,'perfiles','NombrePerfil','NoPerfil');
//      $excel= new datosexcel("./exceles/temp/datosRHpuestos-$unidadoperativafile-.xls");
//      $excel->guardartabla('datos',$tabla->tabla);
//    }
//  }
//  unlink('./exceles/datosRHpuestos.zip');
//  $zip=new PclZip('./exceles/datosRHpuestos.zip');
//  $zip->add("./exceles/temp/"); 
//  
//  unlinkRecursive('./exceles/temp/',FALSE); 
  
?>

<br />
<div class='caja' style="width:100%; ">
<div style="width:100%; height:1px; background-color:#666666"></div>
<h4>  <div class='encabezado' style="">Datos de RH sobre puestos y perfiles</div></h4>
  
<div class='caja' style="margin:5px 5px 5px 5px; height:95px">
   
    <div class='tablacontainer' style="float:left; width:30%;  height:78px">Puestos:
    <table width="100%"  class="tabla" >
          <tr>
            <td width="62%">Total:</td>
            <td width="38%"><?= $totalpuestos ?>(100%)</td>
          </tr>
          <tr>
            <td>Con datos faltantes:</td>
            <td><?= $puestoscondatosfaltantes ?>(<? printf("%.2f", ($puestoscondatosfaltantes*100)/$totalpuestos); ?>%)</td>
          </tr>
        </table>
    </div>
    
    <div class='caja' style="float:left;  width:33%;  margin:5px 5px 5px 5px;  height:78px">
    <? if($puestoscondatosfaltantes>0) { ?> 
        <a href="./AdministradorDatosExceles.php?file=datosRHpuestos.xls">
        <img border="0" src="media/Excel-48x48.png" width="20" height="25" />Con datos incompletos en todas la unidades</a>
        <br />
        <a href="./AdministradorDatosExceles.php?file=datosRHpuestos.zip"><img border="0" src="media/Excel-48x48.png" width="20" height="25" />Con datos incompletos por unidad operativa</a>     
   <? }else{ ?>
      Todos los datos de esta seccion estan completos<br />
      <a href="./exceles/datosRHpuestos.xls"><img border="0" src="media/Excel-48x48.png" width="20" height="25" />Descarga un archivo guia con los campos necesarios para hacer cambios.</a>
   <? } ?>
    </div>
    
    <div class='caja' style="float:left; width:33%; margin:5px 5px 5px 5px;  height:78px">
      <form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
      <div style="width:100%">Subir archivos (ZIP):
        <input name="fileRHpuestos" type="file" />
      </div>
      <div style="width:100%">
        <input name="botonRHpuestos" type="submit" value="Enviar archivos" />
      </div>
      </form>
    </div>
    
  </div>
  
  

  <div class='caja' style="margin:5px 5px 5px 5px;">
  <div class='encabezado' style="width:100%">Perfiles</div>
  <?
    //------------imprime la tabla
    $tablaperfiles=new datatable('perfiles',$camposdatosRHperfiles,$camposdatosRHperfiles,$sql);
    $tablaperfiles->imprimeHTML('tdscentrados','100%');
    
    //------------genera el archivo
//    unlink('./exceles/perfiles.xls');
//    $tablaperfiles->nombretabla='datos';
//    $excel=new datosexcel('./exceles/perfiles.xls',1);
//    $tablaperfiles->guardar($excel);
  ?>
  </div>
  
    <div class='caja' style="margin:5px 5px 5px 5px; height:60px">
    <div style="float:left; width:49%; height: 53px;">
      <a href="./AdministradorDatosExceles.php?file=perfiles.xls"><img border="0" src="media/Excel-48x48.png" width="33" height="34" />Descargar Perfiles</a>
    </div>
    <div style="float:left; width:49%">
      <form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
      Subir archivo de periles:<input name="fileperfiles" type="file" />
      <input type="submit" name="botonperfiles" value="Subir Perfiles" />
      </form>
    </div>
  </div>

</div>
<!-- Fin Puestos RH -->

<br />

<!-- Inicio Datos FEMSA Empleados  -->
<?
if($_POST['botonFEMSAEmplados']=='Generar Archivos')
{
  $camposparaarchivos=array();
  //chek($_POST['tiposdepuesto']);
  //chek($_POST['pruebas']);
  //chek($_POST['formatodeentrega']);

  foreach($_POST['pruebas'] as $valorpost)
  {
    $camposparaarchivos=array_merge($camposparaarchivos,$camposFEMSAempleadosporconcepto[$valorpost]);
  }
  
  $where='';
  $campos='';
  foreach ($camposparaarchivos as $campo)
  {
    $where.= " $campo is NULL OR ";
    $campos.= " $campo, ";
  }
  $where=rtrim($where,'OR ');
  $campos=rtrim($campos,', ');
  
  $where2='';
  foreach($_POST['tiposdepuesto'] as $tipodepuesto)
  {
    $where2.=" TipodePuesto='$tipodepuesto' OR ";
  }
  $where2=rtrim($where2,'OR ');
  
  unlink('./exceles/datosFEMSAempleados.xls');
  unlink('./exceles/datosFEMSAempleados.zip');
  unlinkRecursive('./exceles/temp/',FALSE); 
  
  
  if($_POST['formatodeentrega']=='total')
  {
    $query="Select NoPersonal, NombreEmpleado, TipodePuesto, $campos FROM empleadosypuestos WHERE ($where) AND ($where2)";  
    
    //chek($query);
    
    $data=$sql->queryArreglo($query);
    $excel= new datosexcel('./exceles/datosFEMSAempleados.xls');
    //$tabla= new datatable('datos',NULL,NULL,$data);
    //chek($data);
    //$tabla->guardar($excel);
    $excel->guardartabla('datos',$data);
      
  }else if($_POST['formatodeentrega']=='porUO'){
    
    
    $Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');
    

    foreach ($Unidadesoperativas as $unidadoperativa)
    {
      $unidadoperativafile=cadenafilesystem($unidadoperativa);
      
      $query="Select NoPersonal, NombreEmpleado, TipodePuesto, $campos FROM empleadosypuestos WHERE UnidadOperativa='$unidadoperativa' AND ($where) AND ($where2)";
      $data=$sql->queryArreglo($query);
      unlink("./exceles/temp/datosFEMSAempleados-$unidadoperativafile-.xls");
      if(sizeof($data)>=1){
        $excel= new datosexcel("./exceles/temp/datosFEMSAempleados-$unidadoperativafile-.xls");
        $excel->guardartabla('datos',$data);
      }
      //$zip->addFile("/exceles/temp/datosFEMSAempleados-$unidadoperativa-.xls","datosFEMSAempleados-$unidadoperativa-.xls");
      
    }
    //$zip=new zip();
    
    //$zip->makeZip("./exceles/temp/",'./exceles/datosFEMSAempleados.zip');
    unlink('./exceles/datosFEMSAempleados.zip');
    $zip=new PclZip('./exceles/datosFEMSAempleados.zip');
    $zip->add("./exceles/temp/"); 
    
    unlinkRecursive('./exceles/temp/',FALSE);
    
  }
}


//------------------si lo que hacen es enviar el archivo
if($_POST['botonFEMSAEmplados']=='Enviar archivos')
{
  
  
  $namefileenviado='filedatosFEMSAempleados';
  $newfile=dirname($_FILES[$namefileenviado]['tmp_name']).'\\'.$_FILES[$namefileenviado]['name'];
  
  if(file_exists($newfile)){unlink($newfile);}
  
  rename($_FILES[$namefileenviado]['tmp_name'],$newfile);
  
  
  //chek(basename($newfile));
  if(basename($newfile)=='datosFEMSAempleados.xls')
  {
    $excel= new datosexcel2($newfile,1);
    if($excel->existetabla('datos'))
    {
      if  ( array_in_array($excel->getencabezados('datos'),$camposdatosFEMSAempleados)//--Los campos corresponden
          AND
          in_array('NoPersonal',$excel->getencabezados('datos')) //----tiene el campo de NoPersonal
          )
      {
        //chek('Archivo correcto');
        $camposainsertar=$excel->getencabezados('datos');       
        $camposainsertar=array_diff($camposainsertar,array('TipodePuesto'));    
        $datosFEMSAempleados=$excel->leertabla('datos',$camposainsertar);   
        $sql->actualizatablaconID('empleados',$datosFEMSAempleados,'NoPersonal');
        unlink($newfile); 
        unlink('./exceles/datosFEMSAempleados.xls');
        
        procesaempleadosypuestos();
    
      }else{
        //las columnas del archivo no son correctas
        //aunque se vean vacias si se escribio algo mas aya de las columnas marca error si pasa hay que elimnar algunas las columnas despues de los contenidos
        chek('las columnas del archivo no son correctas');
      }
    }else{
      //la hoja datos del archivo no esta 
      chek('la hoja datos del archivo no esta ');
    }
    
  }else if(basename($newfile)=='datosFEMSAempleados.zip'){
    
      unlinkRecursive('./exceles/temp/',FALSE);  
    $zip = new ZipArchive;
      if ($zip->open($newfile)) {
          $zip->extractTo('./exceles/temp/');
          $zip->close();
          //----fin deszipeado
          
      //----inicia lectura de datos
        $Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');

      $almenosunfile=false;
        foreach ($Unidadesoperativas as $unidadoperativa)
      {
        $unidadoperativafile=cadenafilesystem($unidadoperativa);
        $newfile2="./exceles/temp/datosFEMSAempleados-$unidadoperativafile-.xls";
        if(file_exists($newfile2))
        {
          $almenosunfile=true;
          $excel= new datosexcel2($newfile2,1);
          if($excel->existetabla('datos'))
          {
            if  ( array_in_array($excel->getencabezados('datos'),$camposdatosFEMSAempleados)//--Los campos corresponden
                AND
                in_array('NoPersonal',$excel->getencabezados('datos')) //----tiene el campo de NoPersonal
                )
            {
              //chek('Archivo correcto');
              $camposainsertar=$excel->getencabezados('datos');       
              $camposainsertar=array_diff($camposainsertar,array('TipodePuesto'));    
              $datosFEMSAempleados=$excel->leertabla('datos',$camposainsertar);   
              $sql->actualizatablaconID('empleados',$datosFEMSAempleados,'NoPersonal');
              unlink($newfile2);
              procesaempleadosypuestos();
            }else{
              //las columnas del archivo no son correctas
              //aunque se vean vacias si se escribio algo mas aya de las columnas marca error si pasa hay que elimnar algunas las columnas despues de los contenidos
              chek("las columnas del archivo $newfile2 no son correctas");
            }
          }else{
            //la hoja datos del archivo no esta 
            chek("la hoja datos del archivo $newfile2 no esta ");
          }
        } 
      }
      unlinkRecursive('./exceles/temp/',FALSE);         
          if(!$almenosunfile){
            chek('No se encontraron los archivos correcots en el ZIP - deben llamarse datosFEMSAempleados-uopX-.xls - donde X es el numero d ela unidad operativa');
          }
          unlink('./exceles/datosFEMSAempleados.zip');
      unlinkRecursive('./exceles/temp/',FALSE);   
       } else {
          chek('Error en el ZIP');
       }
  }else{
    chek('En la seccion -Datos de FEMSA sobre empleados- solo puede subir el archivo datosFEMSAempleados.zip o datosFEMSAempleados.xls');
    
  }
}
?>

<div class='caja' style="width:100%;">
  <? 
  $tiposdepuesto=$sql->leeColumnaUnicos('puestos','TipodePuesto');
  //chek($tiposdepuesto);
  ?>
<div style="width:100%; height:1px; background-color:#666666"></div>
<h4>   <div class='encabezado' style="">Datos de FEMSA sobre empleados </div></h4>
  <div class='caja' style=" margin:5px 5px 5px 5px;">
  <form action="AdministradorDatosExceles.php"  method="post">
    <div class='encabezado' style="">Filtros:</div>
    <div class='texto' style="">
        <strong>Tipo de Puesto:</strong> 
        <?
    foreach($tiposdepuesto as $tipodepuesto)
    {
      ?><span class='nb'><?= $tipodepuesto ?>:<? checkbox('tiposdepuesto',$tipodepuesto,$_POST['tiposdepuesto'])?></span>&nbsp;&nbsp;&nbsp;<?
    }
        ?>
    </div>
    <div class='texto' style="">
        <strong>Pruebas:</strong>
        <? 
    foreach($camposFEMSAempleadosporconcepto as $key=>$value)
    {
      ?><span class='nb'><?= $key ?>:<? checkbox('pruebas',$key,$_POST['pruebas'])?></span>&nbsp;&nbsp;&nbsp;<?
    } 
    ?>
    </div>
    <br />
    <div style="">
      Todos:<? radio('formatodeentrega','total',$_POST['formatodeentrega']) ?>&nbsp;&nbsp;&nbsp;&nbsp;Por UO:<? radio('formatodeentrega','porUO',$_POST['formatodeentrega']) ?>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="botonFEMSAEmplados" value="Generar Archivos" />
    </div>
  </form>
  </div>
 <br />
    
    <div style="">
    <form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
      <div style="">Subir archivos (ZIP):
        <input type="file" name="filedatosFEMSAempleados" />
      </div>
      <div style="">
        <input name="botonFEMSAEmplados" type="submit" value="Enviar archivos" />
      </div>
    </form>
    </div> 

</div>
<!-- Fin Datos FEMSA Empleados  -->

<br />


<!-- Inicio Datos RH Empleados  -->
<?
if($_POST['botonRHEmplados']=='Generar Archivos')
{
  $camposparaarchivos=array();
  //chek($_POST['tiposdepuesto']);
  //chek($_POST['pruebas']);
  //chek($_POST['formatodeentrega']);

  foreach($_POST['pruebas'] as $valorpost)
  {
    $camposparaarchivos=array_merge($camposparaarchivos,$camposRHempleadosporconcepto[$valorpost]);
  }
  
  $where='';
  $campos='';
  foreach ($camposparaarchivos as $campo)
  {
    $where.= " $campo is NULL OR ";
    $campos.= " $campo, ";
  }
  $where=rtrim($where,'OR ');
  $campos=rtrim($campos,', ');
  
  $where2='';
  foreach($_POST['tiposdepuesto'] as $tipodepuesto)
  {
    $where2.=" TipodePuesto='$tipodepuesto' OR ";
  }
  $where2=rtrim($where2,'OR ');
  
  unlink('./exceles/datosRHempleados.xls');
  unlink('./exceles/datosRHempleados.zip');
  unlinkRecursive('./exceles/temp/',FALSE); 
  
  
  if($_POST['formatodeentrega']=='total')
  {
    $query="Select NoPersonal, NombreEmpleado, TipodePuesto, $campos FROM empleadosypuestos WHERE ($where) AND ($where2)";  
    
    //chek($query);
    
    $data=$sql->queryArreglo($query);
    $excel= new datosexcel('./exceles/datosRHempleados.xls');
    //$tabla= new datatable('datos',NULL,NULL,$data);
    //chek($data);
    //$tabla->guardar($excel);
    $excel->guardartabla('datos',$data);
      
  }else if($_POST['formatodeentrega']=='porUO'){
    
    $Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');

    foreach ($Unidadesoperativas as $unidadoperativa)
    {
      //chek($unidadoperativa);
      $unidadoperativafile=cadenafilesystem($unidadoperativa);
      //$unidadoperativafile=utf8_decode($unidadoperativa);
      //chek($unidadoperativa);
      $query="Select NoPersonal, NombreEmpleado, TipodePuesto, $campos FROM empleadosypuestos WHERE UnidadOperativa='$unidadoperativa' AND ($where) AND ($where2)";
      $data=$sql->queryArreglo($query);
      unlink("./exceles/temp/datosRHempleados-$unidadoperativafile-.xls");
      if(sizeof($data)>=1){
        $excel= new datosexcel("./exceles/temp/datosRHempleados-$unidadoperativafile-.xls");
        $excel->guardartabla('datos',$data);
      }
      
      //$zip->addFile("/exceles/temp/datosRHempleados-$unidadoperativa-.xls","datosRHempleados-$unidadoperativa-.xls");
      
    }
    //$zip=new zip();
    
    //$zip->makeZip("./exceles/temp/",'./exceles/datosRHempleados.zip');
    unlink('./exceles/datosRHempleados.zip');
    $zip=new PclZip('./exceles/datosRHempleados.zip');
    $zip->add("./exceles/temp/"); 
    
    unlinkRecursive('./exceles/temp/',FALSE);
    
  }
}


//------------------si lo que hacen es enviar el archivo
if($_POST['botonfotos']=='Subir fotos')
{
  $namefileenviado='fotos';
  $newfile='./fotos/'.$_FILES[$namefileenviado]['name'];
  
//  chek($newfile);
//  chek(filenamewithoutextension($newfile));
//  chek(fileextension($newfile));
  
  if(fileextension($newfile)=='jpg')
  {
    $ret=0;
    $posibleid=str_replace(" ", "", filenamewithoutextension($newfile));
    if( is_numeric($posibleid) )
    {
      $ret=$sql->queryArregloUNI('Select NoPersonal from empleados WHERE NoPersonal='.$posibleid);
    }
    if($ret!=0)
    {
      if(file_exists($newfile)){unlink($newfile);}
      rename($_FILES[$namefileenviado]['tmp_name'],$newfile); 
    }else{
      chek("El emplado con NoPersonal: ".filenamewithoutextension($newfile).'no esta regitrado');
      unlink($_FILES[$namefileenviado]['tmp_name']);
    }
    
  }else if(basename($newfile)=='fotos.zip'){

      unlinkRecursive('./exceles/temp/',FALSE);  
    $zip = new ZipArchive;
      if ($zip->open($_FILES[$namefileenviado]['tmp_name'])) 
      {
          $zip->extractTo('./exceles/temp/');
          $zip->close();
        foreach (new DirectoryIterator('./exceles/temp/') as $file) 
        { 
          $file=$file->getFilename();
          //chek($file);
          if(fileextension($file)=='jpg')
        {
          $ret=0;
          //$posibleid=str_replace(" ", "", filenamewithoutextension($file));
          $posibleid=filenamewithoutextension($file);
          if( is_numeric($posibleid) )
          {
            $ret=$sql->queryArregloUNI('Select NoPersonal from empleados WHERE NoPersonal='.$posibleid);
          }
          if($ret!=0)
          {
            $newfile='./fotos/'.basename($file);
            if(file_exists($newfile)){unlink($newfile);}
            rename('./exceles/temp/'.$file,$newfile); 
          }else{
            chek("El empleado con NoPersonal: ".filenamewithoutextension($file).' -no esta regitrado');
          }         
        }else if($file!='.' && $file!='..'){
          chek($file.' no es un archivo de foto valido');
        }
                 
      }       
      }   
    unlinkRecursive('./exceles/temp/',FALSE);
    unlink($_FILES[$namefileenviado]['tmp_name']);
    
  }else{
    chek('En la seccion de fotos solo puedes eviar un archivo #####.jpg donde ##### es un numero de Personal registrado o un archivo fotos.zip con varias fotos con ese mismo formato de nombre.');
  } 
  
}


if($_POST['botonRHEmplados']=='Enviar archivos')
{
  $namefileenviado='filedatosRHempleados';
  $newfile=dirname($_FILES[$namefileenviado]['tmp_name']).'\\'.$_FILES[$namefileenviado]['name'];
  
  if(file_exists($newfile)){unlink($newfile);}
  
  rename($_FILES[$namefileenviado]['tmp_name'],$newfile);
  
  
  //chek(basename($newfile));
  if(basename($newfile)=='datosRHempleados.xls')
  {
    $excel= new datosexcel2($newfile,1);
    if($excel->existetabla('datos'))
    {
      //chek($excel->getencabezados('datos'));
      //chek($camposdatosRHempleados);
      
      if  ( array_in_array($excel->getencabezados('datos'),$camposdatosRHempleados)//--Los campos corresponden
          AND
          in_array('NoPersonal',$excel->getencabezados('datos')) //----tiene el campo de NoPersonal
          )
      {
        //chek('Archivo correcto');
        $camposainsertar=$excel->getencabezados('datos');       
        $camposainsertar=array_diff($camposainsertar,array('TipodePuesto'));    
        $datosRHempleados=$excel->leertabla('datos',$camposainsertar);    


        foreach($datosRHempleados as $registroemplado)//arregla las fechas y deja solo los registros con datos de empleados
        {
          
          //
          
          if($registroemplado['NoPersonal'] )
          {         
            
            if($registroemplado['FechadeNacimiento'])
            {
              $Fecha=split('/',$registroemplado['FechadeNacimiento']);  
              $registroemplado['FechadeNacimiento']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeAlta'])
            {
              $Fecha=split('/',$registroemplado['FechadeAlta']);  
              $registroemplado['FechadeAlta']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeIngresoaPuestoActual'])           
            {
              //chek($registroemplado['FechadeIngresoaPuestoActual']);
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuestoActual']);  
              $registroemplado['FechadeIngresoaPuestoActual']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
              //chek($registroemplado['FechadeIngresoaPuestoActual']);
            }
            if($registroemplado['FechadeIngresoaPuesto1'])
            {
              //chek($registroemplado['FechadeIngresoaPuesto1']);
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuesto1']);  
              $registroemplado['FechadeIngresoaPuesto1']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
              //chek($registroemplado['FechadeIngresoaPuesto1']);
            }
            if($registroemplado['FechadeIngresoaPuesto2'])
            {
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuesto2']);  
              $registroemplado['FechadeIngresoaPuesto2']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeIngresoaPuesto3'])
            {
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuesto3']);  
              $registroemplado['FechadeIngresoaPuesto3']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            if($registroemplado['FechadeIngresoaPuesto4'])
            {
              $Fecha=split('/',$registroemplado['FechadeIngresoaPuesto4']);  
              $registroemplado['FechadeIngresoaPuesto4']= trim($Fecha[2]).'-'.trim($Fecha[1]).'-'.trim($Fecha[0]);
            }
            
            $datosRHempleados2[]=$registroemplado;
          }

          
        }
        //chek($datosRHempleados2);
        $datosRHempleados=$datosRHempleados2;
/**/
        $sql->actualizatablaconID('empleados',$datosRHempleados,'NoPersonal');
        unlink($newfile);
        unlink('./exceles/datosRHempleados.xls');
        
        procesaempleadosypuestos();
        
      }else{
        //las columnas del archivo no son correctas
        //aunque se vean vacias si se escribio algo mas aya de las columnas marca error si pasa hay que elimnar algunas las columnas despues de los contenidos
        chek('las columnas del archivo no son correctas');
      }
    }else{
      //la hoja datos del archivo no esta 
      chek('la hoja datos del archivo no esta ');
    }
    
  }else if(basename($newfile)=='datosRHempleados.zip'){
    
      unlinkRecursive('./exceles/temp/',FALSE);  
    $zip = new ZipArchive;
      if ($zip->open($newfile)) {
          $zip->extractTo('./exceles/temp/');
          $zip->close();
          //----fin deszipeado
          
      //----inicia lectura de datos
        $Unidadesoperativas=$sql->leeColumnaUnicos('puestos','UnidadOperativa');

      $almenosunfile=false;
        foreach ($Unidadesoperativas as $unidadoperativa)
      {
        $unidadoperativafile=cadenafilesystem($unidadoperativa);
        $newfile2="./exceles/temp/datosRHempleados-$unidadoperativafile-.xls";
        if(file_exists($newfile2))
        {
          $almenosunfile=true;
          $excel= new datosexcel2($newfile2,1);
          if($excel->existetabla('datos'))
          {
            if  ( array_in_array($excel->getencabezados('datos'),$camposdatosRHempleados)//--Los campos corresponden
                AND
                in_array('NoPersonal',$excel->getencabezados('datos')) //----tiene el campo de NoPersonal
                )
            {
              //chek('Archivo correcto');
              $camposainsertar=$excel->getencabezados('datos');       
              $camposainsertar=array_diff($camposainsertar,array('TipodePuesto'));    
              $datosRHempleados=$excel->leertabla('datos',$camposainsertar);    
              $sql->actualizatablaconID('empleados',$datosRHempleados,'NoPersonal');
              unlink($newfile2);  
              procesaempleadosypuestos();
            }else{
              //las columnas del archivo no son correctas
              //aunque se vean vacias si se escribio algo mas aya de las columnas marca error si pasa hay que elimnar algunas las columnas despues de los contenidos
              chek("las columnas del archivo $newfile2 no son correctas");
            }
          }else{
            //la hoja datos del archivo no esta 
            chek("la hoja datos del archivo $newfile2 no esta ");
          }
        } 
      }
      unlinkRecursive('./exceles/temp/',FALSE);         
          if(!$almenosunfile){
            chek('No se encontraron los archivos correcots en el ZIP - deben llamarse datosRHempleados-uopX-.xls - donde X es el numero d ela unidad operativa');
          }
          unlink('./exceles/datosRHempleados.zip');
      unlinkRecursive('./exceles/temp/',FALSE);
       } else {
          chek('Error en el ZIP');
       }
  }else{
    chek('En la seccion -Datos de RH sobre empleados- solo puede subir el archivo datosRHempleados.zip o datosRHempleados.xls');
    
  }
}
?>

<div class='caja' style="width:100%;">
  <? 
  $tiposdepuesto=$sql->leeColumnaUnicos('puestos','TipodePuesto');
  //chek($tiposdepuesto);
  ?>
  <div style="width:100%; height:1px; background-color:#666666"></div>
  <h4><div class='encabezado' style="">Datos de RH sobre empleados </div></h4>
  <div class='caja' style=" margin:5px 5px 5px 5px;">
  <form action="AdministradorDatosExceles.php"  method="post">
    <div class='encabezado' style="">Filtros:</div>
    <div class='texto' style="">
        <strong>Tipo de Puesto:</strong> 
        <?
    foreach($tiposdepuesto as $tipodepuesto)
    {
      ?><span class='nb'><?= $tipodepuesto ?>:<? checkbox('tiposdepuesto',$tipodepuesto,$_POST['tiposdepuesto'])?></span>&nbsp;&nbsp;&nbsp;<?
    }
        ?>
    </div>
    <div class='texto' style="">
        <strong>Pruebas:</strong>
        <? 
    foreach($camposRHempleadosporconcepto as $key=>$value)
    {
      ?><span class='nb'><?= $key ?>:<? checkbox('pruebas',$key,$_POST['pruebas'])?></span>&nbsp;&nbsp;&nbsp;<?
    } 
    ?>
    </div>
    <br />
    <div style="">
      Todos:<? radio('formatodeentrega','total',$_POST['formatodeentrega']) ?>&nbsp;&nbsp;&nbsp;&nbsp;Por UO:<? radio('formatodeentrega','porUO',$_POST['formatodeentrega']) ?>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="botonRHEmplados" value="Generar Archivos" />
    </div>
  </form>
  </div>

  <br />
    
    <div style="">
    <form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
      <div style="">Subir archivos (ZIP):
        <input type="file" name="filedatosRHempleados" />
      </div>
      <div style="">
        <input name="botonRHEmplados" type="submit" value="Enviar archivos" />
      </div>
    </form>
    </div> 
  </div>
  <br /><br />
  
  <div class='caja' style=" margin:5px 5px 5px 5px; height:78px "> 
  <form action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
  Subir archivo de fotos: <input type="file" name="fotos" /> <input type="submit" name="botonfotos" value="Subir fotos" />
  </form>
  </div> 
    
    
    
</div> 

<!-- Fin Datos RH Empleados  -->


<?
//if($_POST['botonpreproceso']=='Preproceso de datos'){}

?>
<div>

<?  include('partials/footer.php'); ?>
</body>
</html>
