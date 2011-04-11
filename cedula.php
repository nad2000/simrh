<?php
$urlpagina='cedula';


require_once 'clasesincluder.php';

require_once 'criteriosgraficador.php';

$idempleado=$_GET['idempleado'];





$datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');



if($niveldeacceso!='Admin' AND !in_array($datos["UnidadOperativa"],$unidadesvisibles))
{
	?>
	No tienes permiso para ver esta cedula por favor solicitala  a nivel central.<br />GRACIAS.
	<?
	die;
}



if($idempleado)
{
	$puesto=$datos['NoPuesto'];
	$perfil=$puesto['PerfilTipo'];
}


///-----------------------------------------------
if($_POST['botonGuardar']=='Guardar')
{

	
	
	if($editable==1)
	{

	$variablesGuardar=array("EdoPromocional20$anio","EdoPromocional20$anioant","Temporalidad20$anio","Temporalidad20$anioant","OtrasPosiciones","Fortalezas","Oportunidadesdemejora","Salidaencontroplazo","CometariosSalidaencontroplazo","9BXS$anio","ComentariosJunta20$anio","Sugerenciasdedesarrollo20$anio");
		
	//$idempleado=$_REQUEST['idempleado'];	
			
	//	$puesto=$_POST['idpuesto'];
	//	$nombre=$_POST['name'];
	//	$valor=$_POST['value'];
		foreach($variablesGuardar as $nombre)
		{
			//chek("rev: $nombre --  $_REQUEST[$nombre] ?? $datos[$nombre] ");
			if($_REQUEST[$nombre]!=$datos[$nombre])
			{
				
				if($tablasdecamposeditables[$nombre]=='empleados')
				{
					$campoid='NoPersonal';
					$valorid=$idempleado;
				}else if($tablasdecamposeditables[$nombre]=='puestos'){
					$campoid='NoPuesto';
					$valorid=$puesto;///-------------esto aun o se usa ni se calcula
				}
				
				$sql->actualizaregistroporID($tablasdecamposeditables[$nombre],array($nombre=>$_REQUEST[$nombre]),$campoid,$valorid);
//-----SpeedUP-25-6-2009				
				if($tablasdecamposeditables[$nombre]=='empleados' || $tablasdecamposeditables[$nombre]=='puestos' || $tablasdecamposeditables[$nombre]=='perfiles')
				{
					$sql->actualizaregistroporID('empleadosypuestos',array($nombre=>$_REQUEST[$nombre]),$campoid,$valorid);
				}	
//----------------------				
				$sql->agregarregistro('historico',array('idJunta'=>$idjunta,'Tabla'=>$tablasdecamposeditables[$nombre],'CampoId'=>$campoid,'ValorId'=>$valorid,'Campo'=>$nombre,'NuevoValor'=>$_REQUEST[$nombre]));
				//$sql->actualizaregistroporID($tablasdecamposeditables[$nombre],array($nombre=>$valor),$idempleado,$campoid);
				//chek("se actualizo $nombre a ".$_REQUEST[$nombre]);
				//$datos[$nombre]=$_REQUEST[$nombre];
			}
		}
	
		$datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
	}
		
	
}

	




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="overflow-y:auto; ">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $datos['NombreEmpleado'] ?></title>


	<script language="JavaScript" type="text/javascript" src="jquery-1.3.1.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="jTPS.js"></script>
	<script language="JavaScript" type="text/javascript" src="FuncionesJavaScript.js"></script>
    <link rel="stylesheet" type="text/css" href="jTPS.css" />
    <link href="./estilos.css" rel="stylesheet" type="text/css" />
    <link href="./cedula.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/javascript">
	<?

	
	if($datos["ED$anio"]=='D')
	{
		$calc9boxs1='TALENTO TOP';
		$calc9boxs2='TALENTO PROMOVIBLE POTENCIAL';
		$calc9boxs3='TALENTO COLUMNA';
		$calc9boxs4='TALENTO POR PROBAR';
		$calc9boxs5='SEGUIMIENTO';
		$calc9boxs6='TALENTO COLUMNA';		
	}
	else if($datos["ED$anio"]=='C+')
	{
		$calc9boxs1='TALENTO PROMOVIBLE';
		$calc9boxs2='TALENTO EN CONSOLIDACION';
		$calc9boxs3='TALENTO EN CONSOLIDACION';
		$calc9boxs4='SEGUIMIENTO';
		$calc9boxs5='SEGUIMIENTO';
		$calc9boxs6='TALENTO COLUMNA';
	}
	else if($datos["ED$anio"]=='C')
	{
		$calc9boxs1='TALENTO EN CONSOLIDACION';
		$calc9boxs2='COLUMNA EN CONSOLIDACION';
		$calc9boxs3='COLUMNA EN CONSOLIDACION';
		$calc9boxs4='SEGUIMIENTO';
		$calc9boxs5='CASOS CRITICOS';
		$calc9boxs6='TALENTO EN CONSOLIDACION';
	}
	else if($datos["ED$anio"]=='C-')
	{
		$calc9boxs1='TALENTO POR PROBAR';
		$calc9boxs2='TALENTO POR PROBAR';
		$calc9boxs3='TALENTO POR PROBAR';
		$calc9boxs4='SEGUIMIENTO';
		$calc9boxs5='CASOS CRITICOS';
		$calc9boxs6='TALENTO POR PROBAR';	
	}
	else if($datos["ED$anio"]=='B')
	{
		$calc9boxs1='REVISION';
		$calc9boxs2='REVISION';
		$calc9boxs3='REVISION';
		$calc9boxs4='CASOS CRITICOS';
		$calc9boxs5='CASOS CRITICOS';
		$calc9boxs6='SEGUIMIENTO';		
	}
	else if($datos["ED$anio"]=='A')
	{
		$calc9boxs1='CASOS CRITICOS';
		$calc9boxs2='CASOS CRITICOS';
		$calc9boxs3='CASOS CRITICOS';
		$calc9boxs4='CASOS CRITICOS';
		$calc9boxs5='CASOS CRITICOS';
		$calc9boxs6='CASOS CRITICOS';		
	}
	else
	{
		$calc9boxs1='REVISION';
		$calc9boxs2='REVISION';
		$calc9boxs3='REVISION';
		$calc9boxs4='REVISION';
		$calc9boxs5='REVISION';	
		$calc9boxs6='REVISION';		
	}
	
	
	?>
	
	
	$(document).ready(function() 
	{
		$("#EdoProm").change(function(){
			if($(this).attr("value")=='AP'){$("#9BXS option[value='<?= $calc9boxs1 ?>']").attr('selected', 'selected');}
			if($(this).attr("value")=='PROM'){$("#9BXS option[value='<?= $calc9boxs2 ?>']").attr('selected', 'selected');}			
			if($(this).attr("value")=='EST'){$("#9BXS option[value='<?= $calc9boxs3 ?>']").attr('selected', 'selected');}			
			if($(this).attr("value")=='FOCO ROJO'){$("#9BXS option[value='<?= $calc9boxs4 ?>']").attr('selected', 'selected');}				
			if($(this).attr("value")=='MO'){$("#9BXS option[value='<?= $calc9boxs5 ?>']").attr('selected', 'selected');}
			if($(this).attr("value")=='Por jubilarse'){$("#9BXS option[value='<?= $calc9boxs6 ?>']").attr('selected', 'selected');}
		});
		establecefuncionalidaddetabs();
	}); 
	
	</script>
	<style type="css">
	.borde
	{
		border=1px 1px 1px 1px;
	}
	</style>

</head>

<body class="verdana09em paddingbody">

<div class="tab ceduimg">
  <div style="margin-left:45%; margin-right:auto">
  <span class="tablink"> C&eacute;dula</span>&nbsp;&nbsp;&nbsp; <span class="tablink"> Gr&aacute;ficas</span>
  </div>
    <form action="<?= $_SERVER['PHP_SELF'] ?>?idempleado=<?= $idempleado ?>" method="post">
    <div class="caja" style=" width: 100%; ">
    
    <div id="columna_izq">
                <div class="left" id="cont_basico">
                <h1>Datos Personales  </h1>
                <!-- Inicio:Foto -->
                
                <?
                if($idempleado)
                {
                    $datos=$sql->leeregistroporID('empleadosypuestos',$idempleado,'NoPersonal');
                    //chek($datos);
                    $nombre=$datos['NombreEmpleado'];
                ?>
               
             
               
                <? if(file_exists("./fotos/$idempleado.jpg")){$foto="./fotos/$idempleado.jpg";}else{$foto="./fotos/sinfoto.jpg";} ?>
                    <div class="left margin">
                    <img src="<?= $foto ?>" width="70px" height="87px" /> <br /> <br /> <br />
                    <input type="submit" value="Guardar" name="botonGuardar" />
                    </div>
                <!-- Inicio:Foto -->           
                 
                <!-- Inicio:DatosPersonales -->
                <? if(hayvariables($DatosPersonales,$datos))
                { ?>
                  <div class="borde left margin">
                   <h2 class="name"><?= $datos["NombreEmpleado"] ?></h2>
                   
                   
                       <table border="0" cellpadding="0" cellspacing="0">
                       <tr><td>Empleado</td><td><?= $datos["NoPersonal"] ?></td></tr>
                       <tr><td>Edo. Civil</td><td><?= $datos["EstadoCivil"] ?> </td></tr>
                       <tr><td>Edad</td><td><?=  getAge(strtotime( $datos['FechadeNacimiento'] ))	?> </td></tr>
                       <tr><td>G&eacute;nero</td><td><?= $datos["Genero"] ?></td></tr>
                       <tr><td> Antig</td><td><?=  getAge(strtotime( $datos['FechadeAlta'] ))	?> </td></tr>
                       <tr><td>Ing.Puesto Actual</td><td><?= getAge(strtotime( $datos["FechadeIngresoaPuestoActual"])) ?></td></tr>
                       </table>
                   
                  </div>
                <? } ?>
                <!-- Fin:DatosPersonales -->
          
          
          <!-- Inicio:DatosPuesto -->
                    <? if(hayvariables($DatosPuesto,$datos))
                    { ?><div class="left margin">
                       <h2 class="rojo"><?= $datos["NombrePuesto"] ?></h2>
                       
                       <table border="0" cellpadding="0" cellspacing="0">
                       <tr><td>&Aacute;rea</td><td><?= $datos["Area"] ?></td></tr>
                       <tr><td>Divisi&oacute;n</td><td><?= $datos["Division"] ?></td></tr>
                       <tr><td>U.Op.</td><td><?= $datos["UnidadOperativa"] ?></td></tr>
                       <tr><td>Zona</td><td><?= $datos["Zona"] ?></td></tr>
                       <tr><td>Perfil</td><td><?= $datos["NombrePerfil"] ?></td></tr>
                       <tr><td>Tipo</td><td><?= $datos["TipodePuesto"] ?></td></tr>
                       </table>
                    </div>
                                <? } ?>
                    <!-- Fin:DatosPuesto -->
          
          
          
    
                          
                           
            </div> <!-- fin contenedor basico -->
            
                
              <!-- Inicio:APP -->
            <?  if(hayvariables($APP,$datos))
            { 
            //--------------------------------
			$APP=$datos["APP"];
			
			if($APP<700){$appnum=1;}
			else if($APP>=700 AND $APP<750){$appnum=2;}
			else if($APP>=750 AND $APP<800){$appnum=3;}
			else if($APP>=800){$appnum=4;}
           
			$cocalc=$datos["ED$anioant"].$appnum;

			if($cocalc=='B1' OR $cocalc=='C-1' OR $cocalc=='C1' OR $cocalc=='B2' OR $cocalc=='B3' ){$CO="IPPA";}
			else if($cocalc=="B4" OR $cocalc=="C-2" OR $cocalc=="C-3" OR $cocalc=="C2" OR $cocalc=="C+1" OR $cocalc=="D1"){$CO="AL";}
			else if($cocalc=="C-4" OR $cocalc=="C3" OR $cocalc=="C4" OR $cocalc=="C+2" OR $cocalc=="C+3" OR $cocalc=="D2"){$CO="APPA";}
			else if($cocalc=="C+4" OR $cocalc=="D3" OR $cocalc=="D4"){$CO="PDPS";}
			else {$CO="FUERA_DE_RANGO";}

			
            ?>
              <div id="app" class="left">
                <h6>APP:&nbsp;&nbsp;<? printf("%d",$datos["APP"]);  ?>&nbsp;&nbsp;&nbsp;ED <?= $anioant ?>:<?= $datos["ED$anioant"] ?>&nbsp;&nbsp;&nbsp;ED <?= $anioantant ?>:<?= $datos["ED$anioantant"] ?>&nbsp;&nbsp;&nbsp;CO:<span class="<?= $CO ?>"><?= $CO ?></span>
              </h6>
              </div>
            <? } ?>
            <!-- Fin:APP -->        
     
     
     
           <!-- Inicio:HistorialLaboral -->
                <? if(hayvariables($HistorialLaboral,$datos))
                { ?><div class="left" id="historial_laboral">
                   <h1>Historial Laboral</h1>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <th>Puesto</th>
                    <th>Fecha de Ingreso</th>
                    <tr><td><?= $datos["Puesto1"] ?></td><td><?= $datos["FechadeIngresoaPuesto1"] ?></td></tr> 
                    <tr><td><?= $datos["Puesto2"] ?></td><td><?= $datos["FechadeIngresoaPuesto2"] ?></td></tr>    
                    <tr><td><?= $datos["Puesto3"] ?></td><td><?= $datos["FechadeIngresoaPuesto3"] ?></td></tr>    
                    <tr><td><?= $datos["Puesto4"] ?></td><td><?= $datos["FechadeIngresoaPuesto4"] ?></td></tr> 
                    </table>
    
                  </div>
                <? } ?>
        <!-- Fin:HistorialLaboral -->
        
    
        <!-- Inicio:HistorialAcademico -->
            <? if(hayvariables($HistorialAcademico,$datos))
            { ?><div class="left" id="historial_academico">
                    <h1>Historial Acad&eacute;mico </h1>
                       
                        
                       <table border="0" cellpadding="0" cellspacing="0" width="100%">
                       <th>Escolaridad</th>
                       <th>Estatus</th>
                       <tr><td><?= $datos["Escolaridad1"] ?> </td><td><?= $datos["StatusdeEscolaridad1"] ?> </td></tr>
                       <tr><td><?= $datos["Escolaridad2"] ?> </td><td><?= $datos["StatusdeEscolaridad2"] ?> </td></tr>
                       <tr><td><?= $datos["Escolaridad3"] ?> </td><td><?= $datos["StatusdeEscolaridad3"] ?> </td></tr>
                       <tr><td><?= $datos["Escolaridad4"] ?> </td><td><?= $datos["StatusdeEscolaridad4"] ?> </td></tr>
                       <tr><td><?= $datos["Escolaridad5"] ?> </td><td><?= $datos["StatusdeEscolaridad5"] ?> </td></tr>
                       </table>
    
                       <table border="0" cellpadding="0" cellspacing="0" width="100%">
                       <tr><td>Examen TOEIC</td><td><? transforma(&$datos,$Criterios['Nivel de ingles']); ?><?= $datos["ExamenTOEIC"] ?></td></tr>
                       
                       
                       
                       
                       <tr><td>Estilo de Aprendizaje</td><td><?= $datos["EstilodeAprendizaje"] ?></td></tr>
                       </table>
    
        </div>
        <? } ?>
        <!-- Fin:HistorialAcademico -->
     
     
     
     
            
            
            <div class="left" id="datos_editables">
                             <h1>Datos Editables </h1>
                             
             <table cellpadding="0" cellspacing="0" width="100%">
             <th>EP 20<?= $anio ?> </th>
             <th>Temp. 20<?= $anio ?> </th>
             <th>EP 20<?= $anioant ?> </th>
             <th>Temp. 20<?= $anioant ?> </th>
                <tr>
                <td
                <? if($editable!=1)
                { ?>  class="<?= str_replace(' ','', $datos["EdoPromocional20$anio"]) ?>" <? } ?>
                >                            <?
                                    if($editable==1)
                                    {
                                        htmlselectuni2($opcionesdeestadospromocionales,"EdoPromocional20$anio",$datos["EdoPromocional20$anio"],'id="EdoProm"');
                                    }else{
										?><?= $datos["EdoPromocional20$anio"] ?><?
                                        //echo $datos["EdoPromocional20$anio"];
                                    }			
                                ?> 
                                <br />
                                Actualizaci&oacute;n: <?= $sql->getlastupdatedate('empleados',"EdoPromocional20$anio",'NoPersonal',$idempleado); ?>
                                </td>
                    
                    <td> <?
                                    if($editable==1)
                                    {
                                        htmlselectuni2($opcionesdetemporalidad,"Temporalidad20$anio",$datos["Temporalidad20$anio"],'class="editable"');
                                    }else{
                                        echo $datos["Temporalidad20$anio"];
                                    }			
                                ?>
                                <br />
                                Actualizaci&oacute;n: <?= $sql->getlastupdatedate('empleados',"Temporalidad20$anio",'NoPersonal',$idempleado); ?>
                    
                                    </td>
                    
                    
                    
                    <td class="<?= str_replace(' ','', $datos["EdoPromocional20$anioant"]) ?>">
                                                <?
                            //		if($editable==1)
                            //		{
                            //			htmlselectuni2($opcionesdeestadospromocionales,"EdoPromocional20$anioant",$datos["EdoPromocional20$anioant"],'class="editable"');
                            //		}else{
                                        ?><?= $datos["EdoPromocional20$anioant"] ?><?
										//echo $datos["EdoPromocional20$anioant"];
                            //		}			
                                ?> </td>
                    
                    <td>                            <?
                            //		if($editable==1)
                            //		{
                            //			htmlselectuni2($opcionesdetemporalidad,"Temporalidad20$anioant",$datos["Temporalidad20$anioant"],'class="editable"');
                            //		}else{
                                        echo $datos["Temporalidad20$anioant"];
                            //		}				
                                ?></td>
                                
                                </tr>
             </table>
             
             
                             
            <h5>Otras Posiciones</h5>
            <div style="width:556px; overflow:auto; height:12em; padding:5px">
            <?
                                    if($editable==1)
                                    {
                                        ?><textarea name="OtrasPosiciones" class="editable" rows="5" cols="65"><?= $datos['OtrasPosiciones']; ?></textarea>  <?
                                    }else{
                                        ?><pre><?= $datos['OtrasPosiciones'] ?></pre><?
                                    }			
                                ?>	
    
    
            </div>
    

                </div><!-- Fin:datos editables -->
             
             <!-- Inicio: 9BXS --> 
 <div id="nineboxes" class="left">           
            	<h5>9BXS</h5> 
               20<?= $anio ?>: 
				<?
                    if($editable==1)
                    {
                        htmlselectuni2($opciones9BXS,"9BXS$anio",$datos["9BXS$anio"],'id="9BXS"');
                    }else{
                        echo $datos["9BXS$anio"];
                    }			
                ?>
                <br />20<?= $anioant ?>: <?= $datos["9BXS$anioant"] ?>
                <br />20<?= $anioantant ?>: <?= $datos["9BXS$anioantant"] ?>
            
</div>               
             <!-- Fin: 9BXS --> 
             
             
    <div id="cont_evalua" class="left">
        <h1>Evaluaciones</h1>
                <!-- Inicio:CLEAVER -->
                <? if(hayvariables($CLEAVER,$datos))
                { ?>
                <div id="CLEAVER">
    
    <table cellspacing="0" cellspacing="0" class="left tablita">
                   <th colspan="2">DISC Oservable</th>
                   <tr><td>D</td><td><?= $datos["DObservable" ] ?></td></tr>
                   <tr><td>I</td><td><?= $datos["IObservable" ] ?></td></tr>
                   <tr><td>S</td><td><?= $datos["SObservable" ] ?></td></tr>
                   <tr><td>C</td><td><?= $datos["CObservable" ] ?></td></tr>
                   </table>
                   
     <table cellspacing="0" cellspacing="0" class="left tablita">
                   <th colspan="2">DISC Proyectable</th>        
                   <tr><td>D</td><td><?= $datos["DProyectable" ] ?></td></tr>
                   <tr><td>I</td><td><?= $datos["IProyectable" ] ?></td></tr>
                   <tr><td>S</td><td><?= $datos["SProyectable" ] ?></td></tr>
                   <tr><td>C</td><td><?= $datos["CProyectable" ] ?></td></tr>
                   </table>
                   
    <table cellspacing="0" cellspacing="0" class="left tablita">
                   <th colspan="2">DISC Natural</th>               
                   <tr><td>D</td><td><?= $datos["DNatural" ] ?></td></tr>
                   <tr><td>I</td><td><?= $datos["INatural" ] ?></td></tr>
                   <tr><td>C</td><td><?= $datos["CNatural" ] ?></td></tr>
                   <tr><td>S</td><td><?= $datos["SNatural" ] ?></td></tr>
                   </table>
                   
                   
                  </div>
                <? } ?>
                <!-- Fin:CLEAVER -->
    
    
         
          <!-- Inicio:ProcesoPensante -->
                <? if(hayvariables($ProcesoPensante,$datos))
                { ?>
                  <div id="ProcesoPensante">
                    
    <table cellspacing="0" cellspacing="0" class="left tablita">
                   <th colspan="2">Proceso Pensante </th>
                   <tr><td>Anal&iacute;tico</td><td><?= $datos["Analitico" ] ?></td></tr>
                   <tr><td>Intuitivo</td><td><?= $datos["Intuitivo" ] ?></td></tr>
                   <tr><td>L&oacute;gico</td><td><?= $datos["Logico" ] ?></td></tr>
                   <tr><td>Visionario</td><td><?= $datos["Visionario" ] ?></td></tr>
                   </table>
                   
                   
    
                  </div>
                <? } ?>
                <!-- Fin:ProcesoPensante -->
    
    
    
    
    
    
                <!-- Inicio:TERMAN -->
                <? if(hayvariables($TERMAN,$datos))
                { ?>
                  <div id="terman">
                 
    <table cellspacing="0" cellspacing="0" class="left tablita">
                 <th colspan="4">TERMAN</th>
    
                   <tr><td>Informaci&oacute;n</td><td><?= $datos["Informacion" ] ?></td>
                       <td>Juicio</td><td><?= $datos["Juicio" ] ?></td> </tr>
                   <tr><td>Vocabulario</td><td><?= $datos["Vocabulario" ] ?></td>
                       <td>S&iacute;ntesis</td><td><?= $datos["Sintesis" ] ?></td> </tr>
                   <tr><td>Concentraci&oacute;n</td><td><?= $datos["Concentracion" ] ?></td>
                       <td>An&aacute;lisis</td><td><?= $datos["Analsis" ] ?></td> </tr>
                   <tr><td>Abstracci&oacute;n</td><td><?= $datos["Abstraccion" ] ?></td>
                       <td>Planeaci&oacute;n</td><td><?= $datos["Planeacion" ] ?></td></tr>
                   <tr><td>Organizaci&oacute;n</td><td><?= $datos["Organizacion" ] ?></td>
                       <td>Atenci&oacute;n</td><td><?= $datos["Atencion" ] ?></td></tr>
                   <tr><td>Terman CI</td><td><? transforma(&$datos,$Criterios['Terman']); ?><?= $datos["TermanCI"] ?></td>
                        <td>&nbsp;</td><td>&nbsp;</td></tr>
                    
                   
                   </table>
                   
                   
    
    
    
    
    
                  </div>
                <? } ?>
                <!-- Fin:TERMAN -->
    
    
    
    </div>
    
    
    <div id="cont_evalua2" class="left">
    
    
    
                <!-- Inicio:BARSIT -->
                <? if(hayvariables($BARSIT,$datos))
                { ?>
                 <div id="BARSIT">
                 
    <table cellspacing="0" cellspacing="0" class="left tablita">
                 <th colspan="2">BARSIT </th>
                   <tr><td>&Iacute;ndice de Inteligencia</td><td><?= $datos["Indicedeinteligencia" ] ?></td></tr>
                   <tr><td>Informaci&oacute;n Barsit</td><td><?= $datos["InformacionBarsit" ] ?></td></tr>
                   <tr><td>Razonamiento Verbal</td><td><?= $datos["RazonamientoVerbal" ] ?></td></tr>
                   <tr><td>Razonamiento Num&eacute;rico</td><td><?= $datos["RazonamientoNumerico" ] ?></td></tr>
                   <tr><td>Razonamimento L&oacute;gico</td><td><?= $datos["Razonamimentologico" ] ?></td></tr>
                   </table>
                   
                   
    
                 </div>
                <? } ?>
                <!-- Fin:BARSIT -->
    
    
    
                <!-- Inicio:EQI -->
                <? if(hayvariables($EQI,$datos))
                { ?>
                 <div id="EQI">
                 
    <table cellspacing="0" cellspacing="0" class="left tablita">
                   <th colspan="2">EQI </th>
                   <tr><td>Adaptabilidad</td><td><?= $datos["EQAdaptabilidad" ] ?></td></tr>
                   <tr><td>Estado de Animo</td><td><?= $datos["EQEstadodeAnimo" ] ?></td></tr>
                   <tr><td>Interpersonal</td><td><?= $datos["EQInterpersonal" ] ?></td></tr>
                   <tr><td>Intrapersonal</td><td><?= $datos["EQIntrapersonal" ] ?></td></tr>
                   <tr><td>Manejo de Estres</td><td><?= $datos["EQManejodeEstres" ] ?></td></tr>
                   <tr><td>Total</td><td><?= $datos["EQTotal" ] ?></td></tr>
                   </table>
                   
                   
    
                  </div>
                <? } ?>
                <!-- Fin:EQI -->
    
                <!-- Inicio:INTERESESPersonales -->
                <? if(hayvariables($INTERESESPersonales,$datos))
                { ?>
                  <div id="Intereses_personales">
            
    <table cellspacing="0" cellspacing="0" class="left tablita">
                 <th colspan="2">Intereses Personales</th>
                   <tr><td>Te&oacute;rico</td><td><?= $datos["Teorico" ] ?></td></tr>
                   <tr><td>Econ&oacute;mico</td><td><?= $datos["Economico" ] ?></td></tr>
                   <tr><td>Art&iacute;stico</td><td><?= $datos["Artistico" ] ?></td></tr>
                   <tr><td>Social</td><td><?= $datos["Social" ] ?></td></tr>
                   <tr><td>Pol&iacute;tico</td><td><?= $datos["Politico" ] ?></td></tr>
                   <tr><td>Regulatorio</td><td><?= $datos["Regulatorio" ] ?></td></tr>
                   </table>
                   
                   
    
                  </div>
                <? } ?>
                <!-- Fin:INTERESESPersonales -->
    
    
          
    
    
    
           <!-- Inicio:KOSTIK -->
                <? if(hayvariables($KOSTIK,$datos))
                { ?>
                <div id="KOSTIK">
                
    <table cellspacing="0" cellspacing="0" class="left tablita">
                <th colspan="10">KOSTIK </th>
                   <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;L</td><td><?= $datos["LKostik" ] ?></td>
                       <td>&nbsp;&nbsp;&nbsp;&nbsp;P</td><td><?= $datos["PKostik" ] ?></td>
                       <td>&nbsp;&nbsp;&nbsp;&nbsp;I</td><td><?= $datos["IKostik" ] ?></td>
                       <td>&nbsp;&nbsp;&nbsp;&nbsp;T</td><td><?= $datos["TKostik" ] ?></td>
                       <td>&nbsp;&nbsp;&nbsp;&nbsp;V</td><td><?= $datos["VKostik" ] ?></td></tr>
                       
                   <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;X</td><td><?= $datos["XKostik" ] ?></td>
                   <td>&nbsp;&nbsp;&nbsp;&nbsp;S</td><td><?= $datos["SKostik" ] ?></td>
                   <td>&nbsp;&nbsp;&nbsp;&nbsp;B</td><td><?= $datos["BKostik" ] ?></td>
                   <td>&nbsp;&nbsp;&nbsp;&nbsp;O</td><td><?= $datos["OKostik" ] ?></td>
                   <td>&nbsp;&nbsp;&nbsp;&nbsp;R</td><td><?= $datos["RKostik" ] ?></td></tr>
                   
                   <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;D</td><td><?= $datos["DKostik" ] ?></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;C</td><td><?= $datos["CKostik" ] ?></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;Z</td><td><?= $datos["ZKostik" ] ?></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;E</td><td><?= $datos["EKostik" ] ?></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;K</td><td><?= $datos["KKostik" ] ?></td></tr>
                   
                   <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;F</td><td><?= $datos["FKostik" ] ?></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;W</td><td><?= $datos["WKostik" ] ?></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;N</td><td><?= $datos["NKostik" ] ?></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;G</td><td><?= $datos["GKostik" ] ?></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;A</td><td><?= $datos["AKostik" ] ?></td></tr>
                   </table>
                   
                   
                   
                  </div>
                <? } ?>
    
                <!-- Fin:KOSTIK -->
    
    </div>
    
    
    
    <div id="evs_perfil" class="left">
    
            <h1>Evaluaciones del Perfil</h1>
            <!-- Inicio:DISCObserbablePerfil -->
                <? if(hayvariables($DISCObserbablePerfil,$datos))
                { ?>
             
            <div id="DISCObserbablePerfil">
                       <table cellpadding="0" cellspacing="0" class="left tablita">
                       <th colspan="2">DISC Observ.</th>
                       <tr><td>D</td><td><?= $datos["DObservable"] ?></td></tr>
                       <tr><td>I</td><td><?= $datos["IObservable"] ?></td></tr>
                       <tr><td>S</td><td><?= $datos["SObservable"] ?></td></tr>
                       <tr><td>C</td><td><?= $datos["CObservable"] ?></td></tr>
                       
                       </table>
              </div>
                <? } ?>
            <!-- Fin:DISCObserbablePerfil -->
    
    
            <!-- Inicio:KostikPerfil -->
            <? if(hayvariables($KostikPerfil,$datos))
            { ?>
              <div id="KostikPerfil">
             
               <table cellpadding="0" cellspacing="0" class="left tablita">
                       <th colspan="2">Kostik Perfil</th>
     
               <tr><td>L</td><td><?= $datos["pLKostik"] ?></td></tr>
               <tr><td>P</td><td><?= $datos["pPKostik"] ?></td></tr>
               <tr><td>I</td><td><?= $datos["pIKostik"] ?></td></tr>
               <tr><td>T</td><td><?= $datos["pTKostik"] ?></td></tr>
               <tr><td>V</td><td><?= $datos["pVKostik"] ?></td></tr>
               <tr><td>X</td><td><?= $datos["pXKostik"] ?></td></tr>
               <tr><td>S</td><td><?= $datos["pSKostik"] ?></td></tr>
               <tr><td>B</td><td><?= $datos["pBKostik"] ?></td></tr>
               <tr><td>O</td><td><?= $datos["pOKostik"] ?></td></tr>
               <tr><td>R</td><td><?= $datos["pRKostik"] ?></td></tr>
               <tr><td>D</td><td><?= $datos["pDKostik"] ?></td></tr>
               <tr><td>C</td><td><?= $datos["pCKostik"] ?></td></tr>
               <tr><td>Z</td><td><?= $datos["pZKostik"] ?></td></tr>
               <tr><td>E</td><td><?= $datos["pEKostik"] ?></td></tr>
               <tr><td>K</td><td><?= $datos["pKKostik"] ?></td></tr>
               <tr><td>F</td><td><?= $datos["pFKostik"] ?></td></tr>
               <tr><td>W</td><td><?= $datos["pWKostik"] ?></td></tr>
               <tr><td>N</td><td><?= $datos["pNKostik"] ?></td></tr>
               <tr><td>G</td><td><?= $datos["pGKostik"] ?></td></tr>
               <tr><td>A</td><td><?= $datos["pAKostik"] ?></td></tr>
              
              
              
              </table>
              </div>
            <? } ?>
            <!-- Fin:KostikPerfil -->
    
    
    
            <!-- Inicio:ALIVPerfil -->
            <? if(hayvariables($ALIVPerfil,$datos))
            { ?>
              <div id="ALIVPerfil">
              
                       <table cellpadding="0" cellspacing="0" class="left tablita">
                       <th colspan="2">ALIV Perfil</th>
               <tr><td>Analitico</td><td><?= $datos["Analitico"] ?></td></tr>
               <tr><td>Intuitivo</td><td><?= $datos["Intuitivo"] ?></td></tr>
               <tr><td>Logico</td><td><?= $datos["Logico"] ?></td></tr>
               <tr><td>Visionario</td><td><?= $datos["Visionario"] ?></td></tr>
               
               </table>
              </div>
            <? } ?>
            <!-- Fin:ALIVPerfil -->
    
    </div>
    
    
    
    
    
    
    
    <div id="tressesenta" class="left">
    <h1>Evaluaci&oacute;n 360</h1>
                            <!-- Inicio:a360_13 -->
                            <? if(hayvariables($a360_13,$datos))
                            { ?>
                              <div class="tab a360 borde">
                              <div>
                                <? if(hayvariables($a360_13,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_11,$datos)){ ?><span class="tablink">2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_09,$datos)){ ?><span class="tablink">2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_07,$datos)){ ?><span class="tablink">2007</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                              </div>
                            
                             <h2>360 <? $anio ?> (13)</h2>
                            
                               Adaptabilidad Cultural:<?= $datos["AdaptabilidadCultural36013"] ?><br />
                               Construir Cultura:<?= $datos["ConstruirCultura36013"] ?><br />
                               Delegaci&oacute;n:<?= $datos["Delegacion36013"] ?><br />
                               Desarrollar Relaciones Estrat&eacute;gicas:<?= $datos["DesarrollarRelacionesEstrategicas36013"] ?><br />
                               Desarrollo de Talento:<?= $datos["DesarrollodeTalento36013"] ?><br />
                               Direcci&oacute;n Estrat&eacute;gica:<?= $datos["DireccionEstrategica36013"] ?><br />
                               Ejecuci&oacute;n Impecable:<?= $datos["EjecucionImpecable36013"] ?><br />
                               Enfoque al Cliente:<?= $datos["EnfoquealCliente36013"] ?><br />
                               Integridad:<?= $datos["Integridad36013"] ?><br />
                               Liderazgo de Cambio:<?= $datos["LiderazgodeCambio36013"] ?><br />
                               Liderazgo de Influencia:<?= $datos["LiderazgodeInfluencia36013"] ?><br />
                               Orientaciona Resultados:<?= $datos["OrientacionaResultados36013"] ?><br />
                               Perspicacia de Negocio:<?= $datos["PerspicaciadeNegocio36013"] ?><br />
                               Perspicacia Global:<?= $datos["PerspicaciaGlobal36013"] ?><br />
                               Toma de Decisiones Operacionales:<?= $datos["TomadeDecisionesOperacionales36013"] ?><br />
                               Valores Centrales Femco:<?= $datos["ValoresCentralesFemco36013"] ?><br />
                               Vender Visi&oacute;n:<?= $datos["VenderlaVision360$anio"] ?><br />
                              
                               
                              </div>
                            <? } ?>
                            <!-- Fin:a360_13 -->
                            
                            <!-- Inicio:a360_11 -->
                            <? if(hayvariables($a360_11,$datos))
                            { ?>
                              <div class="tab a360 borde">
                              <div>
                                <? if(hayvariables($a360_13,$datos)){ ?><span class="tablink"> 2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_11,$datos)){ ?><span class="tablink"> 2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_09,$datos)){ ?><span class="tablink"> 2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_07,$datos)){ ?><span class="tablink"> 2007</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                              </div>
                             
                              <h2>360 <? $anio ?> (11)</h2>
                            
                               Adaptabilidad Cultural:<?= $datos["AdaptabilidadCultural36011"] ?><br />
                               Construir Cultura:<?= $datos["ConstruirCultura36011"] ?><br />
                               Delegaci&oacute;n:<?= $datos["Delegacion36011"] ?><br />
                               Desarrollar Relaciones Estrat&eacute;gicas:<?= $datos["DesarrollarRelacionesEstrategicas36011"] ?><br />
                               Desarrollo de Talento:<?= $datos["DesarrollodeTalento36011"] ?><br />
                               Direcci&oacute;n Estrat&eacute;gica:<?= $datos["DireccionEstrategica36011"] ?><br />
                               Ejecuci&oacute;n Impecable:<?= $datos["EjecucionImpecable36011"] ?><br />
                               Enfoque al Cliente:<?= $datos["EnfoquealCliente36011"] ?><br />
                               Integridad:<?= $datos["Integridad36011"] ?><br />
                               Liderazgo de Cambio:<?= $datos["LiderazgodeCambio36011"] ?><br />
                               Liderazgo de Influencia:<?= $datos["LiderazgodeInfluencia36011"] ?><br />
                               Orientaciona Resultados:<?= $datos["OrientacionaResultados36011"] ?><br />
                               Perspicacia de Negocio:<?= $datos["PerspicaciadeNegocio36011"] ?><br />
                               Perspicacia Global:<?= $datos["PerspicaciaGlobal36011"] ?><br />
                               Toma de Decisiones Operacionales:<?= $datos["TomadeDecisionesOperacionales36011"] ?><br />
                               Valores Centrales Femco:<?= $datos["ValoresCentralesFemco36011"] ?><br />
                               Vender Visi&oacute;n:<?= $datos["VenderlaVision360$anio"] ?><br />
    
                             
                             </div>
                            <? } ?>
                            <!-- Fin:a360_11 -->
                            <!-- Inicio:a360_09 -->
                            <? if(hayvariables($a360_09,$datos))
                            { ?>
                              <div class="tab a360 borde">
                              <div>
                                <? if(hayvariables($a360_13,$datos)){ ?><span class="tablink"> 2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_11,$datos)){ ?><span class="tablink"> 2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_09,$datos)){ ?><span class="tablink"> 2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_07,$datos)){ ?><span class="tablink"> 2007</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                              </div>
                            
                            
                              <h2>360 <? $anio ?> (09)</h2>
                            
                               Adaptabilidad Cultural:<?= $datos["AdaptabilidadCultural36009"] ?><br />
                               Construir Cultura:<?= $datos["ConstruirCultura36009"] ?><br />
                               Delegaci&oacute;n:<?= $datos["Delegacion36009"] ?><br />
                               Desarrollar Relaciones Estrat&eacute;gicas:<?= $datos["DesarrollarRelacionesEstrategicas36009"] ?><br />
                               Desarrollo de Talento:<?= $datos["DesarrollodeTalento36009"] ?><br />
                               Direcci&oacute;n Estrat&eacute;gica:<?= $datos["DireccionEstrategica36009"] ?><br />
                               Ejecuci&oacute;n Impecable:<?= $datos["EjecucionImpecable36009"] ?><br />
                               Enfoque al Cliente:<?= $datos["EnfoquealCliente36009"] ?><br />
                               Integridad:<?= $datos["Integridad36009"] ?><br />
                               Liderazgo de Cambio:<?= $datos["LiderazgodeCambio36009"] ?><br />
                               Liderazgo de Influencia:<?= $datos["LiderazgodeInfluencia36009"] ?><br />
                               Orientaciona Resultados:<?= $datos["OrientacionaResultados36009"] ?><br />
                               Perspicacia de Negocio:<?= $datos["PerspicaciadeNegocio36009"] ?><br />
                               Perspicacia Global:<?= $datos["PerspicaciaGlobal36009"] ?><br />
                               Toma de Decisiones Operacionales:<?= $datos["TomadeDecisionesOperacionales36009"] ?><br />
                               Valores Centrales Femco:<?= $datos["ValoresCentralesFemco36009"] ?><br />
                               Vender Visi&oacute;n:<?= $datos["VenderlaVision360$anio"] ?><br />
                              
                              
                              
                              </div>
                            <? } ?>
                            <!-- Fin:a360_09 -->
                            <!-- Inicio:a360_07 -->
                            <? if(hayvariables($a360_07,$datos))
                            { ?>
                              <div class="tab a360 borde">
                              <div>
                                <? if(hayvariables($a360_13,$datos)){ ?><span class="tablink"> 2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_11,$datos)){ ?><span class="tablink"> 2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_09,$datos)){ ?><span class="tablink"> 2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                                <? if(hayvariables($a360_07,$datos)){ ?><span class="tablink"> 2007</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                              </div>
                              
                              <h2>360 <? $anio ?> (07)</h2>
  
                                --- Talentos ---<br />
                                Innovacionycreatividad36007:<?= $datos["Innovacionycreatividad36007"] ?><br />
                                Armonizacion36007:<?= $datos["Armonizacion36007"] ?><br />
                                SentidoComun36007:<?= $datos["SentidoComun36007"] ?><br />
                                Motivacion36007:<?= $datos["Motivacion36007"] ?><br />
                                Visionestrategica36007:<?= $datos["Visionestrategica36007"] ?><br />
                                Vocaciondeservicio36007:<?= $datos["Vocaciondeservicio36007"] ?><br />
                                Respeto36007:<?= $datos["Respeto36007"] ?><br />
                                Etica36007:<?= $datos["Etica36007"] ?><br />
                                Empuje36007:<?= $datos["Empuje36007"] ?><br />
                                Empatia36007:<?= $datos["Empatia36007"] ?><br />
                                Orientacionaresultados36007:<?= $datos["Orientacionaresultados36007"] ?><br />
                                Analisis36007:<?= $datos["Analisis36007"] ?><br />
                                Comunicacion36007:<?= $datos["Comunicacion36007"] ?><br />
                                Prudencia36007:<?= $datos["Prudencia36007"] ?><br />
                                <br />
                                --- Destrezas ---<br />
                                Negociacion36007:<?= $datos["Negociacion36007"] ?><br />
                                Coaching36007:<?= $datos["Coaching36007"] ?><br />
                                Formaciondecultura36007:<?= $datos["Formaciondecultura36007"] ?><br />
                                Analisisdesistematotal36007:<?= $datos["Analisisdesistematotal36007"] ?><br />
                                VentadeIdeas36007:<?= $datos["VentadeIdeas36007"] ?><br />
                                Valoracionderiesgos36007:<?= $datos["Valoracionderiesgos36007"] ?><br />
                                Facilitacion36007:<?= $datos["Facilitacion36007"] ?><br />
                                Facultamiento36007:<?= $datos["Facultamiento36007"] ?><br />
                                EjecucionEstrategica36007:<?= $datos["EjecucionEstrategica36007"] ?><br />
                                Aseguramientoderesultados36007:<?= $datos["Aseguramientoderesultados36007"] ?><br />
                                TomadeDecisiones36007:<?= $datos["TomadeDecisiones36007"] ?><br />
 
                               
                              </div>
                            <? } ?>
                            </div>
                            <!-- Fin:a360_07 -->
    
    
    
                <div id="agenda_desarrollo" class="left">
                <h1>Agenda de desarrollo</h1>
                        <!-- Inicio:AGENDA_DE_DESARROLLO_2014 -->
                        <? if(hayvariables($AGENDA_DE_DESARROLLO_2014,$datos))
                        { ?>
                          <div class="tab AGENDA_DE_DESARROLLO borde">
                          <div>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2014,$datos)){ ?><span class="tablink">2014</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2012,$datos)){ ?><span class="tablink">2012</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2011,$datos)){ ?><span class="tablink">2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2009,$datos)){ ?><span class="tablink">2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2008,$datos)){ ?><span class="tablink">2008</span>&nbsp;&nbsp;&nbsp;<? } ?>
                          </div>
                         -AGENDA_DE_DESARROLLO_2014- <br />
                           <b>Competencias2014</b>:<?= $datos["Competencias2014"] ?><br />
                           <b>Programas2014</b>:<?= $datos["Programas2014"] ?><br />
                           <b>Avance2014</b>:<? printf('%01.0f%%', $datos["Avance2014"]*100) ?><br />
                          </div>
                        <? } ?>
                        <!-- Fin:AGENDA_DE_DESARROLLO_2014 -->
                        
                        <!-- Inicio:AGENDA_DE_DESARROLLO_2013 -->
                        <? if(hayvariables($AGENDA_DE_DESARROLLO_2013,$datos))
                        { ?>
                          <div class="tab AGENDA_DE_DESARROLLO borde">
                          <div>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2014,$datos)){ ?><span class="tablink">2014</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2012,$datos)){ ?><span class="tablink">2012</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2011,$datos)){ ?><span class="tablink">2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2009,$datos)){ ?><span class="tablink">2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2008,$datos)){ ?><span class="tablink">2008</span>&nbsp;&nbsp;&nbsp;<? } ?>
                          </div>
                         -AGENDA_DE_DESARROLLO_2013- <br />
                           <b>Competencias2013</b>:<?= $datos["Competencias2013"] ?><br />
                           <b>Programas2013</b>:<?= $datos["Programas2013"] ?><br />
                           <b>Avance2013</b>:<? printf('%01.0f%%', $datos["Avance2013"]*100) ?><br />
                          </div>
                        <? } ?>
                        <!-- Fin:AGENDA_DE_DESARROLLO_2013 -->
                        
                        <!-- Inicio:AGENDA_DE_DESARROLLO_2012 -->
                        <? if(hayvariables($AGENDA_DE_DESARROLLO_2012,$datos))
                        { ?>
                          <div class="tab AGENDA_DE_DESARROLLO borde">
                          <div>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2014,$datos)){ ?><span class="tablink">2014</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2012,$datos)){ ?><span class="tablink">2012</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2011,$datos)){ ?><span class="tablink">2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2009,$datos)){ ?><span class="tablink">2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2008,$datos)){ ?><span class="tablink">2008</span>&nbsp;&nbsp;&nbsp;<? } ?>
                          </div>
                         -AGENDA_DE_DESARROLLO_2012- <br />
                           <b>Competencias2012</b>:<?= $datos["Competencias2012"] ?><br />
                           <b>Programas2012</b>:<?= $datos["Programas2012"] ?><br />
                           <b>Avance2012</b>:<? printf('%01.0f%%', $datos["Avance2012"]*100) ?><br />
                          </div>
                        <? } ?>
                        <!-- Fin:AGENDA_DE_DESARROLLO_2012 -->
                        
                        <!-- Inicio:AGENDA_DE_DESARROLLO_2011 -->
                        <? if(hayvariables($AGENDA_DE_DESARROLLO_2011,$datos))
                        { ?>
                          <div class="tab AGENDA_DE_DESARROLLO borde">
                          <div>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2014,$datos)){ ?><span class="tablink">2014</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2012,$datos)){ ?><span class="tablink">2012</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2011,$datos)){ ?><span class="tablink">2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2009,$datos)){ ?><span class="tablink">2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2008,$datos)){ ?><span class="tablink">2008</span>&nbsp;&nbsp;&nbsp;<? } ?>
                          </div>
                         -AGENDA_DE_DESARROLLO_2011- <br />
                           <b>Competencias2011</b>:<?= $datos["Competencias2011"] ?><br />
                           <b>Programas2011</b>:<?= $datos["Programas2011"] ?><br />
                           <b>Avance2011</b>:<? printf('%01.0f%%', $datos["Avance2011"]*100) ?><br />
                          </div>
                        <? } ?>
                        <!-- Fin:AGENDA_DE_DESARROLLO_2011 -->
                        
                        <!-- Inicio:AGENDA_DE_DESARROLLO_2010 -->
                        <? if(hayvariables($AGENDA_DE_DESARROLLO_2010,$datos))
                        { ?>
                          <div class="tab AGENDA_DE_DESARROLLO borde">
                          <div>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2014,$datos)){ ?><span class="tablink">2014</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2012,$datos)){ ?><span class="tablink">2012</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2011,$datos)){ ?><span class="tablink">2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2009,$datos)){ ?><span class="tablink">2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2008,$datos)){ ?><span class="tablink">2008</span>&nbsp;&nbsp;&nbsp;<? } ?>
                          </div>
                         -AGENDA_DE_DESARROLLO_2010- <br />
                           <b>Competencias2010</b>:<?= $datos["Competencias2010"] ?><br />
                           <b>Programas2010</b>:<?= $datos["Programas2010"] ?><br />
                           <b>Avance2010</b>:<? printf('%01.0f%%', $datos["Avance2010"]*100) ?><br />
                          </div>
                        <? } ?>
                        <!-- Fin:AGENDA_DE_DESARROLLO_2010 -->
                        
                        <!-- Inicio:AGENDA_DE_DESARROLLO_2009 -->
                        <? if(hayvariables($AGENDA_DE_DESARROLLO_2009,$datos))
                        { ?>
                          <div class="tab AGENDA_DE_DESARROLLO borde">
                          <div>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2014,$datos)){ ?><span class="tablink">2014</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2012,$datos)){ ?><span class="tablink">2012</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2011,$datos)){ ?><span class="tablink">2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2009,$datos)){ ?><span class="tablink">2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2008,$datos)){ ?><span class="tablink">2008</span>&nbsp;&nbsp;&nbsp;<? } ?>
                          </div>
                         -AGENDA_DE_DESARROLLO_2009- <br />
                           <b>Competencias2009</b>:<?= $datos["Competencias2009"] ?><br />
                           <b>Programas2009</b>:<?= $datos["Programas2009"] ?><br />
                           <b>Avance2009</b>:<? printf('%01.0f%%', $datos["Avance2009"]*100) ?><br />
                          </div>
                        <? } ?>
                        <!-- Fin:AGENDA_DE_DESARROLLO_2009 -->
                        
                        <!-- Inicio:AGENDA_DE_DESARROLLO_2008 -->
                        <? if(hayvariables($AGENDA_DE_DESARROLLO_2008,$datos))
                        { ?>
                          <div class="tab AGENDA_DE_DESARROLLO borde">
                          <div>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2014,$datos)){ ?><span class="tablink">2014</span>&nbsp;&nbsp;&nbsp;<? } ?> 	 	
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2012,$datos)){ ?><span class="tablink">2012</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2011,$datos)){ ?><span class="tablink">2011</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2009,$datos)){ ?><span class="tablink">2009</span>&nbsp;&nbsp;&nbsp;<? } ?>
                            <? if(hayvariables($AGENDA_DE_DESARROLLO_2008,$datos)){ ?><span class="tablink">2008</span>&nbsp;&nbsp;&nbsp;<? } ?>
                          </div>
                         -AGENDA_DE_DESARROLLO_2008- <br />
                           <b>Competencias2008</b>:<?= $datos["Competencias2008"] ?><br />
                           <b>Programas2008</b>:<?= $datos["Programas2008"] ?><br />
                           <b>Avance2008</b>:<? printf('%01.0f%%', $datos["Avance2008"]*100) ?><br />
                          </div>
                        <? } ?>
                        <!-- Fin:AGENDA_DE_DESARROLLO_2008 -->
                        
                        </div>
    
    
                    
                    <div id="assesstment" class="left">
                    <h1>Assessment</h1>
                    <!-- InicioASSESSMENT_2013 -->
                    <? 
                    if(hayvariables($ASSESSMENT_2013,$datos))
                    { ?>
                      <div class="tab ASSESSMENT borde">
                      <div>
                        <? if(hayvariables($ASSESSMENT_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                        <? if(hayvariables($ASSESSMENT_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                        <? if(hayvariables($ASSESSMENT_2007,$datos)){ ?><span class="tablink">2007</span>&nbsp;&nbsp;&nbsp;<? } ?>
                      </div>  
                    
                        <table cellpadding="0" cellspacing="0">
                       <th>Assessment 2013</th>
                       <tr><td>Conocer Transformar Innovaci&oacute;n&nbsp;&nbsp;</td><td><?= $datos["ConocerTransformarInnovacionASSESSMENT2013"] ?></td></tr>
                       <tr><td>Desarrollo de Talento Coaching&nbsp;&nbsp;</td><td><?= $datos["DesarrollodeTalentoCoachingASSESSMENT2013"] ?></td></tr>
                       <tr><td>Direcci&oacute;n Estrat&eacute;gica&nbsp;&nbsp;</td><td><?= $datos["DireccionEstrategicaASSESSMENT2013"] ?></td></tr>
                       <tr><td>Efectividad Multicultural Sensibilidad Interpersonal&nbsp;&nbsp;</td><td><?= $datos["EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2013"] ?></td></tr>
                       <tr><td>Ejecuci&oacute;n Impecable&nbsp;&nbsp;</td><td><?= $datos["EjecucionImpecableASSESSMENT2013"] ?></td></tr>
                       <tr><td>Generar Valor&nbsp;&nbsp;</td><td><?= $datos["GenerarValorASSESSMENT2013"] ?></td></tr>
                       <tr><td>Liderazgo e Influencia&nbsp;&nbsp;</td><td><?= $datos["LiderazgoeInfluenciaASSESSMENT2013"] ?></td></tr>
                       <tr><td>Negociacion&nbsp;&nbsp;</td><td><?= $datos["NegociacionASSESSMENT2013"] ?></td></tr>
                       <tr><td>Orientaci&oacute;n a Resultados&nbsp;&nbsp;</td><td><?= $datos["OrientacionaResultadosASSESSMENT2013"] ?></td></tr>
                       <tr><td>Visi&oacute;n de Negocio&nbsp;&nbsp;</td><td><?= $datos["VisiondeNegocioASSESSMENT2013"] ?></td></tr>
                      </table> 
                       
                       
                       
                      </div>
                    <? } ?>
                    <!-- FinASSESSMENT_2013 -->
                    
                    
                    <!-- InicioASSESSMENT_2010 -->
                    <? 
                    if(hayvariables($ASSESSMENT_2010,$datos))
                    { ?>
                      <div class="tab ASSESSMENT borde">
                      <div>
                        <? if(hayvariables($ASSESSMENT_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                        <? if(hayvariables($ASSESSMENT_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                        <? if(hayvariables($ASSESSMENT_2007,$datos)){ ?><span class="tablink">2007</span>&nbsp;&nbsp;&nbsp;<? } ?>
                      </div> 
                    
                    
                    
                       <table cellpadding="0" cellspacing="0">
                       <th>Assessment 2010</th>
                       <tr><td>Conocer Transformar Innovaci&oacute;n&nbsp;&nbsp;</td><td><?= $datos["ConocerTransformarInnovacionASSESSMENT2010"] ?></td></tr>
                       <tr><td>Desarrollo de Talento Coaching&nbsp;&nbsp;</td><td><?= $datos["DesarrollodeTalentoCoachingASSESSMENT2010"] ?></td></tr>
                       <tr><td>Direcci&oacute;n Estrat&eacute;gica&nbsp;&nbsp;</td><td><?= $datos["DireccionEstrategicaASSESSMENT2010"] ?></td></tr>
                       <tr><td>Efectividad Multicultural Sensibilidad Interpersonal&nbsp;&nbsp;</td><td><?= $datos["EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2010"] ?></td></tr>
                       <tr><td>Ejecuci&oacute;n Impecable&nbsp;&nbsp;</td><td><?= $datos["EjecucionImpecableASSESSMENT2010"] ?></td></tr>
                       <tr><td>Generar Valor&nbsp;&nbsp;</td><td><?= $datos["GenerarValorASSESSMENT2010"] ?></td></tr>
                       <tr><td>Liderazgo e Influencia&nbsp;&nbsp;</td><td><?= $datos["LiderazgoeInfluenciaASSESSMENT2010"] ?></td></tr>
                       <tr><td>Negociacion&nbsp;&nbsp;</td><td><?= $datos["NegociacionASSESSMENT2010"] ?></td></tr>
                       <tr><td>Orientaci&oacute;n a Resultados&nbsp;&nbsp;</td><td><?= $datos["OrientacionaResultadosASSESSMENT2010"] ?></td></tr>
                       <tr><td>Visi&oacute;n de Negocio&nbsp;&nbsp;</td><td><?= $datos["VisiondeNegocioASSESSMENT2010"] ?></td></tr>
                      </table> 
    
                       
                       
                       
                       
                      </div>
                    <? } ?>
                    <!-- FinASSESSMENT2010 -->
                    
                    <!-- InicioASSESSMENT_2007 -->
                    <? 
                    if(hayvariables($ASSESSMENT_2007,$datos))
                    { ?>
                      <div class="tab ASSESSMENT borde">
                      <div>
                        <? if(hayvariables($ASSESSMENT_2013,$datos)){ ?><span class="tablink">2013</span>&nbsp;&nbsp;&nbsp;<? } ?>
                        <? if(hayvariables($ASSESSMENT_2010,$datos)){ ?><span class="tablink">2010</span>&nbsp;&nbsp;&nbsp;<? } ?>
                        <? if(hayvariables($ASSESSMENT_2007,$datos)){ ?><span class="tablink">2007</span>&nbsp;&nbsp;&nbsp;<? } ?>
                      </div> 
                
                
                       <table cellpadding="0" cellspacing="0">
                       <th>Assessment 2007</th>
                       <tr><td>Conocer Transformar Innovaci&oacute;n&nbsp;&nbsp;</td><td><?= $datos["ConocerTransformarInnovacionASSESSMENT2007"] ?></td></tr>
                       <tr><td>Desarrollo de Talento Coaching&nbsp;&nbsp;</td><td><?= $datos["DesarrollodeTalentoCoachingASSESSMENT2007"] ?></td></tr>
                       <tr><td>Direcci&oacute;n Estrat&eacute;gica&nbsp;&nbsp;</td><td><?= $datos["DireccionEstrategicaASSESSMENT2007"] ?></td></tr>
                       <tr><td>Efectividad Multicultural Sensibilidad Interpersonal&nbsp;&nbsp;</td><td><?= $datos["EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2007"] ?></td></tr>
                       <tr><td>Ejecuci&oacute;n Impecable&nbsp;&nbsp;</td><td><?= $datos["EjecucionImpecableASSESSMENT2007"] ?></td></tr>
                       <tr><td>Generar Valor&nbsp;&nbsp;</td><td><?= $datos["GenerarValorASSESSMENT2007"] ?></td></tr>
                       <tr><td>Liderazgo e Influencia&nbsp;&nbsp;</td><td><?= $datos["LiderazgoeInfluenciaASSESSMENT2007"] ?></td></tr>
                       <tr><td>Negociacion&nbsp;&nbsp;</td><td><?= $datos["NegociacionASSESSMENT2007"] ?></td></tr>
                       <tr><td>Orientaci&oacute;n a Resultados&nbsp;&nbsp;</td><td><?= $datos["OrientacionaResultadosASSESSMENT2007"] ?></td></tr>
                       <tr><td>Visi&oacute;n de Negocio&nbsp;&nbsp;</td><td><?= $datos["VisiondeNegocioASSESSMENT2007"] ?></td></tr>
                      </table> 
    
                       
                       
                       
                      </div>
                    <? } ?>
                    
                    
                    </div>
                    <!-- FinASSESSMENT_2007 -->
    
    
    <div id="datos_editables2">
    
            <h5>Fortalezas</h5>
            <div style="width:100%; overflow:auto; height:12em">
                        
                                <?
                                    if($editable==1)
                                    {
                                        ?><textarea name="Fortalezas"  class="editable" rows="5" cols="65"><?= $datos['Fortalezas']; ?></textarea>  <?
                                    }else{
                                        echo $datos['Fortalezas'];
                                    }			
                                ?>	
                </div>                  
                            
            <h5>Oportunidades de mejora</h5>
            <div style="width:100%; overflow:auto; height:12em">               
                                
                                <?
                                    if($editable==1)
                                    {
                                        ?><textarea name="Oportunidadesdemejora" class="editable" rows="5" cols="65"><?= $datos['Oportunidadesdemejora']; ?></textarea>  <?
                                    }else{
                                           echo $datos['Oportunidadesdemejora'];
                                    }			
                                ?>		
                            
                </div>
                
                
                
                                        <!-- Inicio:Sugerencias de desarrollo -->
                                <h5>Sugerencias de Desarrollo</h5>
                                <?
                                if($anio>=14)
                                {
                                ?>
                                  <div class="tab Sugerenciasdedesarrollo borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>
                                    
                                    <h2>Sugerencias de desarrollo 2014</h2>
                                    <?
                                
                                            if($editable==1 and 'Sugerenciasdedesarrollo20'.$anio=='Sugerenciasdedesarrollo2014')
                                            {
                                                ?><textarea name="Sugerenciasdedesarrollo2014"  class="editable" rows="5" cols="65"><?= $datos['Sugerenciasdedesarrollo2014']; ?></textarea>  <?
                                            }else{
                                                 echo   $datos['Sugerenciasdedesarrollo2014'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>
                                
                                <?
                                if($anio>=13)
                                {
                                ?>
                                  <div class="tab Sugerenciasdedesarrollo borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                   <h2>Sugerencias de desarrollo 2013</h2>
                                    <?
                                
                                            if($editable==1 and 'Sugerenciasdedesarrollo20'.$anio=='Sugerenciasdedesarrollo2013')
                                            {
                                                ?><textarea name="Sugerenciasdedesarrollo2013"  class="editable" rows="5" cols="65"><?= $datos['Sugerenciasdedesarrollo2013']; ?></textarea>  <?
                                            }else{
                                               echo     $datos['Sugerenciasdedesarrollo2013'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                            
                                <?
                                if($anio>=12)
                                {
                                ?>
                                  <div class="tab Sugerenciasdedesarrollo borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                   <h2>Sugerencias de desarrollo 2012</h2>
                                    <?
                                
                                            if($editable==1 and 'Sugerenciasdedesarrollo20'.$anio=='Sugerenciasdedesarrollo2012')
                                            {
                                                ?><textarea name="Sugerenciasdedesarrollo2012"  class="editable" rows="5" cols="65"><?= $datos['Sugerenciasdedesarrollo2012']; ?></textarea>  <?
                                            }else{
                                                 echo   $datos['Sugerenciasdedesarrollo2012'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                                <?
                                if($anio>=11)
                                {
                                ?>
                                  <div class="tab Sugerenciasdedesarrollo borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                  <h2>Sugerencias de desarrollo 2011</h2>
                                    <?
                                
                                            if($editable==1 and 'Sugerenciasdedesarrollo20'.$anio=='Sugerenciasdedesarrollo2011')
                                            {
                                                ?><textarea name="Sugerenciasdedesarrollo2011"  class="editable" rows="5" cols="65"><?= $datos['Sugerenciasdedesarrollo2011']; ?></textarea>  <?
                                            }else{
                                                 echo   $datos['Sugerenciasdedesarrollo2011'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                                <?
                                if($anio>=10)
                                {
                                ?>
                                  <div class="tab Sugerenciasdedesarrollo borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                  <h2>Sugerencias de desarrollo 2010</h2>
                                    <?
                                
                                            if($editable==1 and 'Sugerenciasdedesarrollo20'.$anio=='Sugerenciasdedesarrollo2010')
                                            {
                                                ?><textarea name="Sugerenciasdedesarrollo2010" class="editable" rows="5" cols="65"><?= $datos['Sugerenciasdedesarrollo2010']; ?></textarea>  <?
                                            }else{
                                                 echo   $datos['Sugerenciasdedesarrollo2010'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                                <?
                                if($anio>=9)
                                {
                                ?>
                                  <div class="tab Sugerenciasdedesarrollo borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                  <h2>Sugerencias de desarrollo 2009</h2>
                                    <?
                                
                                            if($editable==1 and 'Sugerenciasdedesarrollo20'.$anio=='Sugerenciasdedesarrollo2009')
                                            {
                                                ?><textarea name="Sugerenciasdedesarrollo2009"  class="editable" rows="5" cols="65"><?= $datos['Sugerenciasdedesarrollo2009']; ?></textarea>  <?
                                            }else{
                                                 echo   $datos['Sugerenciasdedesarrollo2009'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>
                                
                                <?
                                if($anio>=8)
                                {
                                ?>
                                  <div class="tab Sugerenciasdedesarrollo borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>
                                    
                                  <h2>Sugerencias de desarrollo 2008</h2>
                                    <?
                                
                                            if($editable==1 and 'Sugerenciasdedesarrollo20'.$anio=='Sugerenciasdedesarrollo2008')
                                            {
                                                ?><textarea name="Sugerenciasdedesarrollo2008" class="editable" rows="5" cols="65"><?= $datos['Sugerenciasdedesarrollo2008']; ?></textarea>  <?
                                            }else{
                                                echo    $datos['Sugerenciasdedesarrollo2008'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                                
                                <?
                                if($anio>=7)
                                {
                                ?>
                                  <div class="tab Sugerenciasdedesarrollo borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                   <h2>Sugerencias de desarrollo 2007</h2>
                                    <?
                                
                                            if($editable==1 and 'Sugerenciasdedesarrollo20'.$anio=='Sugerenciasdedesarrollo2007')
                                            {
                                                ?><textarea name="Sugerenciasdedesarrollo2007"  class="editable" rows="5" cols="65"><?= $datos['Sugerenciasdedesarrollo2007']; ?></textarea>  <?
                                            }else{
                                                echo    $datos['Sugerenciasdedesarrollo2007'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>		
                            <!-- Fin:Sugerencias de desarrollo -->	
    
                
                
                
                
                
                
                
                
                
                                  
                            
            <h6>Movimiento a corto plazo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
            <?
                                    if($editable==1)
                                    {
                                        ?>Si:<? radio('Salidaencontroplazo','Si',$datos['Salidaencontroplazo']) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No:<? radio('Salidaencontroplazo','No',$datos['Salidaencontroplazo']) ?><?
                                    }else{
                                           echo $datos['Salidaencontroplazo'];
                                    }			
                                ?>
            
            
            </h6>
                            
                                            <div style="width:100%; overflow:auto; height:12em">               
    
                                <?
                                    if($editable==1)
                                    {
                                        ?><textarea name="CometariosSalidaencontroplazo" class="editable" rows="5" cols="65"><?= $datos['CometariosSalidaencontroplazo']; ?></textarea>  <?
                                    }else{
                                          echo  $datos['CometariosSalidaencontroplazo'];
                                    }			
                                ?>		
                            
                            </div>
                            
                            
    
                                
                            <!-- Inicio:ComentariosJunta -->
                                <h5>Comentarios Juntas</h5>
                                <?
                                if($anio>=14)
                                {
                                ?>
                                  <div class="tab ComentariosJunta">
                                      <div>
                                        <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                        <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                        <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                        <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                        <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                        <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                        <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                        <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                      </div>
                                
                                    <h2>Comentarios Junta 2014</h2>
                                    <?
                                
                                            if($editable==1 and 'ComentariosJunta20'.$anio=='ComentariosJunta2014')
                                            {
                                                ?><textarea name="ComentariosJunta2014"  class="editable" rows="5" cols="65"><?= $datos['ComentariosJunta2014']; ?></textarea>  <?
                                            }else{
                                                echo    $datos['ComentariosJunta2014'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>
                                
                                <?
                                if($anio>=13)
                                {
                                ?>
                                  <div class="tab ComentariosJunta borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                       <h2>Comentarios Junta 2013</h2>
                                    <?
                                
                                            if($editable==1 and 'ComentariosJunta20'.$anio=='ComentariosJunta2013')
                                            {
                                                ?><textarea name="ComentariosJunta2013" class="editable" rows="5" cols="65"><?= $datos['ComentariosJunta2013']; ?></textarea>  <?
                                            }else{
                                                echo    $datos['ComentariosJunta2013'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                            
                                <?
                                if($anio>=12)
                                {
                                ?>
                                  <div class="tab ComentariosJunta borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                       <h2>Comentarios Junta 2012</h2>
                                    <?
                                
                                            if($editable==1 and 'ComentariosJunta20'.$anio=='ComentariosJunta2012')
                                            {
                                                ?><textarea name="ComentariosJunta2012" class="editable" rows="5" cols="65"><?= $datos['ComentariosJunta2012']; ?></textarea>  <?
                                            }else{
                                                 echo   $datos['ComentariosJunta2012'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                                <?
                                if($anio>=11)
                                {
                                ?>
                                  <div class="tab ComentariosJunta borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                       <h2>Comentarios Junta 2011</h2>
                                    <?
                                
                                            if($editable==1 and 'ComentariosJunta20'.$anio=='ComentariosJunta2011')
                                            {
                                                ?><textarea name="ComentariosJunta2011" class="editable" rows="5" cols="65"><?= $datos['ComentariosJunta2011']; ?></textarea>  <?
                                            }else{
                                                echo    $datos['ComentariosJunta2011'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                                <?
                                if($anio>=10)
                                {
                                ?>
                                  <div class="tab ComentariosJunta borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                       <h2>Comentarios Junta 2010</h2>
                                    <?
                                
                                            if($editable==1 and 'ComentariosJunta20'.$anio=='ComentariosJunta2010')
                                            {
                                                ?><textarea name="ComentariosJunta2010"  class="editable" rows="5" cols="65"><?= $datos['ComentariosJunta2010']; ?></textarea>  <?
                                            }else{
                                                echo    $datos['ComentariosJunta2010'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                                <?
                                if($anio>=9)
                                {
                                ?>
                                  <div class="tab ComentariosJunta borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                      <h2> Comentarios Junta 2009</h2>
                                    <?
                                
                                            if($editable==1 and 'ComentariosJunta20'.$anio=='ComentariosJunta2009')
                                            {
                                                ?><textarea name="ComentariosJunta2009" class="editable" rows="5" cols="65"><?= $datos['ComentariosJunta2009']; ?></textarea>  <?
                                            }else{
                                                 echo   $datos['ComentariosJunta2009'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>
                                
                                <?
                                if($anio>=8)
                                {
                                ?>
                                  <div class="tab ComentariosJunta borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>
                                    
                                       <h2>Comentarios Junta 2008</h2>
                                    <?
                                
                                            if($editable==1 and 'ComentariosJunta20'.$anio=='ComentariosJunta2008')
                                            {
                                                ?><textarea name="ComentariosJunta2008"  class="editable" rows="5" cols="65"><?= $datos['ComentariosJunta2008']; ?></textarea>  <?
                                            }else{
                                                echo    $datos['ComentariosJunta2008'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>	
                                
                                
                                <?
                                if($anio>=7)
                                {
                                ?>
                                  <div class="tab ComentariosJunta borde">
                                  <div>
                                    <? if($anio>=14){ ?><span class="tablink">2014</span><? } ?>
                                    <? if($anio>=13){ ?><span class="tablink">2013</span><? } ?>	 	
                                    <? if($anio>=12){ ?><span class="tablink">2012</span><? } ?>	 	
                                    <? if($anio>=11){ ?><span class="tablink">2011</span><? } ?>	 	
                                    <? if($anio>=10){ ?><span class="tablink">2010</span><? } ?>	 	
                                    <? if($anio>=9){ ?><span class="tablink">2009</span><? } ?>	 	
                                    <? if($anio>=8){ ?><span class="tablink">2008</span><? } ?>
                                    <? if($anio>=7){ ?><span class="tablink">2007</span><? } ?>	 		
                                  </div>	
                                    
                                       <h2>Comentarios Junta 2007</h2>
                                    <?
                                
                                            if($editable==1 and 'ComentariosJunta20'.$anio=='ComentariosJunta2007')
                                            {
                                                ?><textarea name="ComentariosJunta2007" class="editable" rows="5" cols="65"><?= $datos['ComentariosJunta2007']; ?></textarea>  <?
                                            }else{
                                                 echo   $datos['ComentariosJunta2007'];
                                            }				
                                    ?>	
                                    </div>
                                <? } ?>		
                            <!-- Fin:ComentariosJunta -->
                            
                            
                            <h6>
                                <?
                                    if($editable==1)
                                    {
                                        ?><input type="submit" value="Guardar" name="botonGuardar" class="right margin"/><?
                                    }		
                                ?></h6>
            
    
    
    
    
    
    </div>
    
    
    
    
    
            
    </div><!-- Fin:col izquierda -->
    
    <div id="columna_der">          
              <div class="left" id="ced_graficas">
                    <!-- Inicio se selector de grafica DISC � Kostik -->
                    <? if($datos["DObservable"] OR $datos["IObservable"] OR $datos["SObservable"] OR $datos["CObservable"]){ ?>
                    
                    <img src="graficaDISC.php?noempleado=<?= $idempleado ?>&tipo=Observable&graficaanterior=si"  />
                    <img src="graficaDISC.php?noempleado=<?= $idempleado ?>&tipo=Proyectable&graficaanterior=si"  />
                    <img src="graficaDISC.php?noempleado=<?= $idempleado ?>&tipo=Natural&graficaanterior=si"  />
                    
                    <? }else{ ?>
                    
                    <img src="graficaKostik.php?noempleado=<?= $idempleado ?>"  />
                
                    <? } ?>
                    
                    <!-- Fin se selector de grafica DISC � Kostik -->
                              
                    <img src="graficaALIV.php?noempleado=<?= $idempleado ?>"  />
                    <img src="graficaTerman.php?noempleado=<?= $idempleado ?>"  /> 
                    <img src="graficaEQUI.php?noempleado=<?= $idempleado ?>"  /> 
                    <img src="graficaBarsit.php?noempleado=<?= $idempleado ?>"  /> 
                                   
        </div>
        
        
        
    </div><!-- fin COLUMNA DER -->
    

    
    <!-- Fin:Evaluaciones -->
    

        
        
    <?
    }
    ?>
    </div>
    </form>
</div>
<div class="tab ceduimg borde">
  <div>
  <span class="tablink"> Cedula</span>&nbsp;&nbsp;&nbsp; <span class="tablink"> Graficas</span>
  </div>
                    <!-- Inicio se selector de grafica DISC � Kostik -->
                    <? if($datos["DObservable"] OR $datos["IObservable"] OR $datos["SObservable"] OR $datos["CObservable"]){ ?>
                    
                    <img src="graficaDISC.php?noempleado=<?= $idempleado ?>&tipo=Observable&graficaanterior=si"  />
                    <img src="graficaDISC.php?noempleado=<?= $idempleado ?>&tipo=Proyectable&graficaanterior=si"  />
                    <img src="graficaDISC.php?noempleado=<?= $idempleado ?>&tipo=Natural&graficaanterior=si"  />
                    
                    <? }else{ ?>
                    
                    <img src="graficaKostik.php?noempleado=<?= $idempleado ?>"  />
                
                    <? } ?>
                    
                    <!-- Fin se selector de grafica DISC � Kostik -->
                              
                    <img src="graficaALIV.php?noempleado=<?= $idempleado ?>"  />
                    <img src="graficaTerman.php?noempleado=<?= $idempleado ?>"  /> 
                    <img src="graficaEQUI.php?noempleado=<?= $idempleado ?>"  /> 
                    <img src="graficaBarsit.php?noempleado=<?= $idempleado ?>"  />   
  
</div>

</body>
</html>