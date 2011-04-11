<?
/*
candidatos a funciones
-al guardar cambio de orden en as_cambio_orden.php
-para ver el numero de diseños en as_seleccion _diseno.php



cambia_archivos_seccion
borra seccion



*/
////INDICE
/*
///////////////////////////////////////Pantalla
	imprime_mensaje($string,$formato)
	
///////////////////////////////////////Seguridad
	solo_en_tu_sitio($tipo)
	
///////////////////////////////////////Secciones
	guarda_descripcion($string,$seccion)
	registra_seccion($string,$tipo)
	--guarda_comentarios($string,$seccion)



///////////////////////////////////////Directorios
	zp_mk_dir($dir)
	zp_del_dir($dir)

///////////////////////////////////////Permisos
	exede_espacio('') //true si size>ESPACIO_MB
	
////////////////////////////////////////Texto	
	checa_archivos_texto($string,$dir) //borra lo que no esta en el texto

//////////////////////////////////ORDEN Para todas las tablas con campo orden
	
*/

///////////////////////////////////////Pantalla

require_once('zpf-xml_array.php');
require_once('zpf-files.php');


function imprime_mensaje($string,$formato) { 

// Imprime la variable $string en dos formatos. Error y Notificación se define cual se usa leyendo la variable $formato que debe ser igual a E a N respectivamente. El “mensaje” es impreso en una tabla de una celda centrada cuyo color y letra cambia segun se al caso. (E o N).
if($formato=='E')
{ ?>
<table width="747" height="54"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" colspan="2"><img src="img/linea_red.gif" width="747" height="1" align="texttop"></td>
  </tr>
  <tr> 
    <td width="80" align="center" valign="middle" bgcolor="#ffffcc"><img src="img/info_red.gif" width="42" height="42"></td>
    <td width="668" bgcolor="#ffffcc"><div align="justify"><font color="#FF3333"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">NOTIFICACI&Oacute;N:<BR>
        <? echo $string ?></font></strong></font></div></td>
  </tr>
  <tr> 
    <td align="center" colspan="2"><img src="img/linea_red.gif" width="747" height="1" align="texttop"></td>
  </tr>
</table>
<? } // if($formato='E')

if($formato=='N')
{ ?>
<table width="747" height="54"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" colspan="3"><img src="img/linea_green.gif" width="747" height="1" align="texttop"></td>
  </tr>
  <tr> 
    <td width="79" align="center" valign="middle" bgcolor="#ccffcc"><img src="img/info_green.gif" width="42" height="42" align="middle"></td>
    <td width="605" bgcolor="#ccffcc"><div align="justify"><strong><font color="#00cc66" size="1" face="Verdana, Arial, Helvetica, sans-serif">NOTIFICACI&Oacute;N:<BR>
        <? echo $string ?> </font></strong></div></td>
    <td width="63" valign="middle" bgcolor="#ccffcc"><strong></strong></td>
  </tr>
  <tr> 
    <td align="center" colspan="3"><img src="img/linea_green.gif" width="747" height="1" align="texttop"></td>
  </tr>
</table>
<!--aqui empieza el temporal
<table width="747" height="54"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center" colspan="2"><img src="img/linea_blue.gif" width="747" height="1" align="texttop"></td>
  </tr>
  <tr> 
    <td width="80" align="center" valign="middle" bgcolor="#ccccff"><img src="img/info_blue.gif" width="42" height="42" align="middle"></td>
    <td width="681" bgcolor="#ccccff"><div align="justify"><font color="#9999CC"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">NOTIFICACI&Oacute;N:<BR>
        </font></strong></font></div></td>
  </tr>
  <tr> 
    <td align="center" colspan="2"><img src="img/linea_blue.gif" width="747" height="1" align="texttop"></td>
   </tr>
</table>
aqui termina el temporal-->
<? } //if($formato='N')
} //function imprime_mensaje($string,$formato)

function crea_seccion($string,$file,$tipo)
{	
	global $Dominio_s;
	global $path_a_info;
global $path_a_paginas;	
	global $xmla;

	//--leer Id de la seccion  /*<seccion tipo="1" id="index">I N I C I O</seccion>*/
	$cnf=xml_to_xmla("$path_a_info/config.xml");
	$id=xmla_getElemntsByTag(&$cnf,'seccion');
	if( sizeof($id)>=1 )
	{ 
		if(sizeof($id)==1){ $id='s1'; }else
		{
		
			$id=array_pop($id);
			$id=$id['attributes']['id'];
			$d=ltrim($id,'s');
			$d++;
			$id='s'.$d;

		}  //if(sizeof($id)==1){ $id='s1'; }else
	} else { //if( sizeof($id)>=1 )
		
		$id='index'; 
		
	}//else { //if( sizeof($id)>=1 )
	//--copiar archivo limpio
	copy("$path_a_info/Diseno/$file", "$path_a_paginas/$id.html");
	
	//--agregar seccion en config.xml
	$seccionestag =& xmla_getElemntsByTag(&$cnf,'secciones'); 
	$secciontag =& $seccionestag[0];
	$secciontag['nodes'][]=array ( 'tag' => 'seccion', 'attributes' => array ( 'tipo' => $tipo, 'id' => $id ), 'nodes' => array ( 0 => $string ) );

	xmla_to_file($cnf,"$path_a_info/config.xml");
	//$cnf=xml_to_xmla("$path_a_info/config.xml");///esto se peude evitar pero hayque hacer cosas mas complejas con el sitring en l ainstruccion $secciontag['nodes'][]='<seccion tipo="'.$tipo.'" id="'.$id.'">'.$string.'</seccion>'

//Si es el primer archivo solo cambio el contenido del texto de la liga

	$files=dir_files("$path_a_paginas",'html'); //lee archivos
			
	foreach($files as $filepath)
	{
		$filearray=html_to_xmla($filepath);
		
		//Si es cualquier otro archivo solo agrego la liga al final
		if('/'.$id.'.html'!=strrchr($filepath, "/") ) 
		{
			agrega_link(&$filearray,$id,$string);
		}else{//Si es el nuevo archivo debo generar toda la barra
			
			genera_barra(&$filearray,$cnf);
			
			//titulo de la pagina tag title
			$title =& xmla_getElemntsByTag(&$filearray,'title');
			$title =& $title[0];
			$title['nodes']='';
			$title['nodes'][0]=$Dominio_s.'::'.$string;
	
			//--Nombre-indica en al pagina donde estas (barra de ubicacion)
			$nombre =& xmla_getElemntByID(&$filearray,'nombre');
			$nombre['nodes']='';
			$nombre['nodes'][]=$string;
			
			$xmla=$filearray;//xmla se nesecita  fuera de la seccion y esta como global por eso la asigno aqui  evito overhead
		}//else{//Si es el nuevo archivo debo generar toda la barra
		xmla_to_HTML_file($filearray,$filepath);	
	}//foreach($files as $filepath)
	
	return $id;
}//function crea_seccion($seccion,$file,$tipo)

function genera_barra(&$filearray,$cnf=NULL)//si esta abierto el config en la seccion lo uso si no lo abro
{
	global $Dominio_s;
	global $path_a_info;
global $path_a_paginas;
	//----localizo la barra de navegacion
	$barranavegacion =& xmla_getElemntByID($filearray,'barranavegacion');
	
	//----localizo un elemento de la barra
	$elementonav = xmla_getElemntsByClass($barranavegacion,'elementonav'); 
	eval('$elementonav = '.var_export($elementonav[0], true).';'); //con eval y todo show porque copiaba la referencia a como fuera y necesito uana copia

	//limpio la barra
	$barranavegacion['nodes']=array();

	if(!$cnf) { $cnf=xml_to_xmla("$path_a_info/config.xml"); }
	
	$secciones=xmla_getElemntsByTag(&$cnf,'seccion');
	
	foreach($secciones as $seccion)
	{  agrega_link(&$filearray,$seccion['attributes']['id'],$seccion['nodes'][0],$barranavegacion,$elementonav); }
	
}

function agrega_link(&$filearray,$Id_seccion,$nombre,&$barranavegacion=NULL,$elementonav=NULL)//si no envian eso los calcula pero si lo senvia no asi evito overhead en generabarra y es facil de usar en toros lugares
{
	//----localizo la barra de navegacion
	if(!$barranavegacion ) { $barranavegacion =& xmla_getElemntByID($filearray,'barranavegacion'); }
	
	//----localizo un elemento de la barra
	if(!$elementonav ) 
	{
		$elementonav = xmla_getElemntsByClass($barranavegacion,'elementonav'); 
		eval('$elementonav = '.var_export($elementonav[0], true).';'); //con eval y todo show porque copiaba la referencia a como fuera y necesito uana copia
	}//if(!$elementonav ) 

	//----Ya que es el primer elemento debe tener el Id index en el texto de su link lo localizo y cambio
	$textolink =& xmla_getElemntByID(&$elementonav,'index');
	$textolink['attributes']['id']=$Id_seccion;
	$textolink['nodes'][0]=$nombre;
	
	//-----Localizo y cambio la referencia del link
	$link =& xmla_getElemntsByClass(&$elementonav,'linknav');
	$link[0]['attributes']['href']=$Id_seccion.".html";
	//$link[0]['attributes']['id']=$Id_seccion;

	
	//--agrego al final de la barra el nuevo elemento
	$barranavegacion['nodes'][]=$elementonav;

} //function agrega_link(&$array,$Id_seccion,$nombre)

function cambia_archivos_seccion($viejo,$nuevo='index')
{
	global $Dominio_s;
	global $path_a_info;
global $path_a_paginas;
	
	//chek(array_combine(array($viejo),array($nuevo) ));
	
	$files=array_merge(dir_files("$path_a_info",'xml'),dir_files("$path_a_paginas",'html'));
	
	//chek($viejo);
	
	foreach($files as $filepath)
	{
		if(strpos($filepath,"$path_a_paginas/$viejo".'_')===0 OR strpos($filepath,"$path_a_paginas/$viejo".'.')===0	)//si es archivo del sitio...	
		{
		//chek($filepath);
			$filearray=html_to_xmla($filepath);
			
			//busco ligas a archivos de la seccion
			$hrefs=xmla_getElemntsByAttrib(&$filearray,'href');
			foreach($hrefs as &$href)
			{
				$href['attributes']['href']=str_replace($viejo,$nuevo,$href['attributes']['href']);
			}		

			//busco referencias a archivos de la seccion
			$srcs=xmla_getElemntsByAttrib(&$filearray,'src');
			foreach($srcs as &$src)
			{
				$src['attributes']['src']=str_replace($viejo,$nuevo,$src['attributes']['src']);
			}	
		
			xmla_to_HTML_file($filearray,$filepath);
			//Renombro el archivo
			rename($filepath,str_replace($viejo,$nuevo,$filepath) );
		}else{
			//sino es archivo del sitio....  - en otros casos no hago nada
			if(strpos($filepath,"$path_a_info/$viejo_")===0)//checo si es da datos del sitio
			{
				//si es de datos del sitio lo renombro
				rename($filepath,str_replace($viejo,$nuevo,$filepath) );
			}
		}		
	}
	//Renombro el directorio si lo hay
	//chek("$path_a_paginas/$viejo");
	if(is_dir("$path_a_paginas/$viejo")){rename("$path_a_paginas/$viejo","$path_a_paginas/$nuevo");}
}


function borraseccion($seccion)
{
	global $Dominio_s;
	global $path_a_info;
global $path_a_paginas;
	global $cnf;
	
	//--borro el archivo
	if ( file_exists("$path_a_paginas/$seccion.html") )
	{ 		
		unlink("$path_a_paginas/$seccion.html");		// borro el archivo
	}//if ( file_exists("$path_a_paginas/$seccion.html") )

	//borro la seccion del archivo config.xml 
	$secciontag =& xmla_getElemntByID(&$cnf,$seccion);
	$secciontag = NULL;

	$secciones=xmla_getElemntsByTag(&$cnf,'seccion');
	$numerodesecciones=sizeof($secciones);
	
	//echo 'numero de secciones: '.$numerodesecciones.'<br>';

	del_dir("$path_a_paginas/$seccion");

	$files=array_merge(dir_files("$path_a_info",'xml'),dir_files("$path_a_paginas",'html'));	
	//chek($files);
	//---------------------------quito la liga de la barra de los archivos y borro los que esten relacionados con la seccion
		foreach($files as $filepath)
		{
			if(strpos($filepath,"$path_a_paginas/".$seccion.'_')===0)//si es archivo de la seccion lo borro
			{
				unlink($filepath);
			}else{//if(strpos($filepath,$seccion.'_')===0)
			
				
				$filearray=html_to_xmla($filepath);
				//chek($filearray);
				$elementosnav = xmla_getElemntsByClass(&$filearray,'elementonav');
				
				
				foreach($elementosnav as &$elementonav)//busco el elemento que tiene el link con el id de la seccion y lo borro
				{
					$empty=xmla_getElemntByID(&$elementonav,$seccion);
					//chek($empty);
					
					if($next=='ok')  //si en el elementop anterior se pusoel ok cambia el actual a index
					{
						//cambio en el html
						$linknav = xmla_getElemntsByClass(&$elementonav,'linknav');
						$linknav =& $linknav[0];
						
						$linknav['attributes']['id']='index';
						$linknav['attributes']['href']='index.html';
						
						$next=NULL;
					}
					
					if( !empty($empty) )
					{
						$elementonav=NULL;
						//echo 'una vez '.$seccion;
	
						if($seccion=='index' AND $numerodesecciones >= 1)
						{
							$next='ok';
						}//if($seccion=='index' AND $numerodesecciones > 1)
	
					} 
				}
				
				//chek($filearray);
				xmla_to_HTML_file($filearray,$filepath);
				
			}//	}else{//if(strpos($filepath,$seccion.'_')===
			
		}//foreach($files as $filepath)
		
		if($seccion=='index' AND $numerodesecciones >= 1)
		{
			//$secciones=xmla_getElemntsByTag(&$cnf,'seccion'); esto se corre mas arriba y no se altera la variable
			$secciontag2 =& $secciones[0];
			
			cambia_archivos_seccion($secciontag2['attributes']['id']);
			
			$secciontag2['attributes']['id']='index';
		}//if($seccion=='index' AND $numerodesecciones > 1)
		
	xmla_to_file($cnf,"$path_a_info/config.xml");	

}//function borraseccion()

function muestra_espacio($pre)
{
   global $db;
   global $IdSitio_s;
   global $Dominio_s;
	global $path_a_info;
global $path_a_paginas;
	$db2 = new ZP2_DB;
   $db->query("SELECT Nombre, IdSeccion FROM indicesecciones WHERE IdSitio=$IdSitio_s AND Tipo=1"); //lee secciones 1 de la base de datos
   while($db->next_record())
   {
    $tamanos['1'.$db->f("Nombre")]=espacio_dir("$pre$path_a_paginas/".$db->f("IdSeccion").'/');
   }//while($db->next_record())
   
   $db->query("SELECT IdSeccion, Nombre FROM indicesecciones WHERE IdSitio=$IdSitio_s AND Tipo=2"); //lee secciones 1 de la base de datos
   while($db->next_record())
   {
   	   $size=0;
       $db2->query("SELECT Imagen, Extension FROM imagenes WHERE IdSeccion=".$db->f("IdSeccion")); //lee secciones 1 de la base de datos
	   while($db2->next_record())
	   {
	    $size+=filesize("$pre$path_a_paginas/Img/".$db2->f('Imagen').'.'.$db2->f('Extension'));
		$size+=filesize("$pre$path_a_paginas/Img/".$db2->f('Imagen').'---tumb.'.$db2->f('Extension'));
	   }//while($db->next_record())
	   $tamanos['2'.$db->f("Nombre")]=$size;;
   }//while($db->next_record())   
   
   
   if($tamanos)
   { 
	   arsort($tamanos); 
	   foreach ($tamanos as $seccion => $tamano)
	   {
		$tamano=round($tamano/(1024*1024),2);
		$tipo=substr($seccion,0,1);
		$seccion=substr($seccion,1);
		if($tamano==0) { $tamano='0'; }
		?>
		<tr bgcolor="#FFFFFF"> 
        <td height="25"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $seccion ?></font></strong></td>
        <td><img src="./img/tipo<? echo $tipo ?>.gif"></td>
        <td width="100" align="center" valign="middle"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $tamano ?></font></td>
		<td width="50" align="center" valign="middle" bgcolor="#CCCCCC"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">MB</font></strong></td>
		</tr>
		<?
		$total+=$tamano;
	   }
   }// if($tamanos)
   ?>
<table width="250" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="bottom"> 
    <td width="191" height="33" align="right"><strong><font color="#6666CC" size="1" face="Verdana, Arial, Helvetica, sans-serif">Espacio 
      TOTAL UTILIZADO:</font></strong> </td>
    <td width="59" align="right"><font color="#6666CC" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2"><? echo $total;?>&nbsp;</font></strong> 
      <strong>M</strong></font></td>
  </tr>
  <tr> 
    <td align="right"><strong><font color="#339966" size="1" face="Verdana, Arial, Helvetica, sans-serif">Espacio 
      TOTAL DISPONIBLE:</font></strong></td>
    <td align="right"><font color="#339966" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2"> 
      <? echo ESPACIO_MB-$total;?>&nbsp;</font></strong> <strong>M</strong></font></td>
  </tr>
</table>
   <?
}//muestra_espacio()




//////////////////


function guarda_nombre($string,$seccion) {

	global $Dominio_s;
	global $path_a_info;
global $path_a_paginas;
	global $xmla;
	
	//$htmlstring = htmlentities($string, ENT_QUOTES);

	if ( file_exists("$path_a_paginas/$seccion.html") )
	{ // Si corresponden se guarda la informacion
		
		//titulo de la pagina tag title
		$title =& xmla_getElemntsByTag(&$xmla,'title');
		$title =& $title[0];
		$title['nodes']='';
		$title['nodes'][0]=$Dominio_s.'::'.$string;
		
		//--Nombre-indica en al pagina donde estas (barra de ubicacion)
		$nombre =& xmla_getElemntByID(&$xmla,"nombre");
		$nombre['nodes']='';
		$nombre['nodes'][0]=$string;
		
		//Archivo config
		$cnf=xml_to_xmla("$path_a_info/config.xml");
		$cnfsec =& xmla_getElemntByID(&$cnf,$seccion);
		$cnfsec['nodes'][0] = $string;
		xmla_to_file($cnf,"$path_a_info/config.xml");
		
		xmla_to_HTML_file($xmla,"$path_a_paginas/$seccion.html");
		
		$files=dir_files("$path_a_paginas",'html');
		foreach($files as $filepath)
		{
			$filearray=html_to_xmla($filepath); 
			$link =& xmla_getElemntByID($filearray,$seccion);
			if(!empty($link) ) { $link['nodes'][0]=$string; }
			if(!empty($link) ) { xmla_to_HTML_file($filearray,$filepath); }
		}
		
		
	} //if ($db->nf()>0) { // Si corresponden se guarda la informacion
	else
	{ return false; }

}

///////////////////////////////////////Secciones


function guarda_descripcion($string,$seccion) {
//Guarda los cambios en una descripcion
	global $Dominio_s;
	global $path_a_info;
	global $path_a_paginas;
	global $xmla;
	
	//$string=fixcharacterszp($string);
	remove_tags_zp ($string, array( 'object' => true,'embed' => true,'applet' => true,'script' => true));
	if ( file_exists("$path_a_paginas/$seccion.html") )
	{ // Si corresponden se guarda la informacion
			$Contenido =& xmla_getElemntByID(&$xmla,"descripcion");
			$Contenido['nodes']='';
			$Contenido['nodes']=html_part_to_nodelist($string);

			xmla_to_HTML_file($xmla,"$path_a_paginas/$seccion.html");
			return true;
	} //if ($db->nf()>0) { // Si corresponden se guarda la informacion
	else
	{ return false; }
}


function registra_seccion($string,$tipo) {
// Registra una seccion revisando que no exista
	global $IdSitio_s;
	global $Orden_f;
	global $db;
	$db->query("SELECT Tipo FROM indicesecciones WHERE IdSitio=$IdSitio_s"); //cuantas secciones hay
	if(trim($string)!=""||$db->nf()>MAX_SECS)
	{
		remove_tags_zp ($string, array('object' => true,'embed' => true,'applet' => true,'script' => true));
		$db->query("SELECT Tipo FROM indicesecciones WHERE Nombre='$string' AND IdSitio=$IdSitio_s"); //ve si hay secciones con el mismo nombre
		if ($db->nf()>0) // si si hay manda a la paguina anterior con el mensaje de error
		{
		header("Location: ./seccion".$tipo."_as1.php?mensaje=Ya+tienes+una+seccion+con+ese+nombre&formato=E");
		page_close(); die;
		} // if ($db->nf()>0)
		else //------si no hay procede con el registro
		{
			$db->query("SELECT Orden FROM indicesecciones WHERE IdSitio=$IdSitio_s Order by Orden DESC Limit 1"); //obten el orden
			$db->next_record();
			$Orden=$db->f("Orden");
			$Orden++; //orden de la nueva seccion
			$db->query("INSERT INTO indicesecciones VALUES($IdSitio_s,'',$Orden,$tipo,'$string','')"); //inserta la seccion
			$db->query("SELECT IdSeccion FROM indicesecciones WHERE Nombre='$string' AND IdSitio=$IdSitio_s");
			$db->next_record();
	
			if($db->f("IdSeccion")) { Return $db->f("IdSeccion"); }else{ Return false; }
		}   //else //------si no hay procede con el registro
	}
	else
	{
		header("Location: ./seccion".$tipo."_as1.php?mensaje=Debes+poner+algun+nombre+a+la+seccion&formato=E");
		page_close(); die;
	} // if ($db->nf()>0)
	
} //function registra_seccion($string,$tipo)

///////////////////////////////////////////Directorios

function zp_del_dir($dir) //Borrar el directorio
{
 global $Dominio_s;
	global $path_a_info;
global $path_a_paginas;
	$dir="$path_a_paginas/$dir";
 chmod($dir,0777);
 if (is_dir($dir))
 {
   $handle = opendir($dir);
   while(false !==($filename=readdir($handle)))
	{
	  if (is_file("$dir/$filename"))
	  {
		unlink("$dir/$filename");
	  }
	}
   closedir($handle);
   rmdir($dir);
 }
 else
 {
  unlink($dir);
 }
} // de function del-dir($dir) //Borrar el directorio

function zp_mk_dir($dir)
{
	global $Dominio_s;
	global $path_a_info;
global $path_a_paginas;
	mkdir("$path_a_paginas/$dir", 0777);
}//function mk_dir($dir){

///////////////////////////////Permisos


function espacio_dir_files($dir)//da el tamaño que ocupan los archivos de un directorio
{
	$d=opendir($dir);
	while (false != ($f=readdir($d)))//listo los archivos del directorio
	{
	if(is_file($dir.$f))
		{
		 $size+=filesize($dir.$f);
		}//--if(is_file("./$f"))
	}//--while (false != ($f=readdir($d)))
	Return $size/(1024*1024);
}//function espacio_dir($dir)//da el tamaño que ocupan los archivos de un directorio


function dir_size($dir, $unit, $block_size=null)
{
    $skip = array('.','..','');
    $returnarr = array();
    
    if( @is_resource($handle=opendir($dir)) ) {
        $items = null;
        while($items[] = readdir($handle)) {
        }
        closedir($handle);
        
        foreach ($items as $item) {
            if( !in_array($item, $skip) ) {
                $item_path = $dir.'/'.$item;
                if(is_dir($item_path) ) {
                    $returnarr['dirs']++;
                    $dir_ret = dir_size($item_path, $unit, $block_size);
                    $returnarr['dirs'] += $dir_ret['dirs'];
                    $returnarr['files'] += $dir_ret['files'];
                    $returnarr['bytesondisk'] += $dir_ret['bytesondisk'];
                    $returnarr['sizeondisk'] += $dir_ret['sizeondisk'];
                } else {
                    $fsize = filesize($item_path);
                    $returnarr['files']++;
                    $returnarr['bytesondisk'] += $fsize;
                    if($block_size) {
                        $blocks = round(($fsize/$block_size)+.5,0) ;
                        $returnarr['sizeondisk'] += convert_bytes_to(($blocks*$block_size),$unit);
                    } else {
                        $returnarr['sizeondisk'] += convert_bytes_to($fsize,$unit);
                    }
                }
                
            }
        }
    }
    return $returnarr;
}
function convert_bytes_to($value, $new_unit)
{
    switch( strtolower("$new_unit") )
    {
        case 'bit':
        case 'bits':
            return ($value*8);
        break;
        case 'kb':
        case 'kilobyte':
        case 'kilobytes':
            return $value/1024;
        break;
        
        case 'mb':
        case 'megabyte':
        case 'megabytes':
            return $value/1048576;
        break;
        
        case 'gb':
        case 'gigabyte':
        case 'gigabytes':
            return $value/1073741824;
        break;
    }
    return $value;
}





/////////////////////////////////////////////////////////////ORDEN Para todas las tablas con campo orden

function ordena_desc($string,$seccion,$Orden) {
//Recorre el orden de cualquier tabla (con Orden)cuando se elimina un elemento de esta
		global $db;
		$db->query("SELECT Orden FROM $string WHERE IdSeccion=$seccion Order by Orden DESC Limit 1"); //obten el orden
		$db->next_record();
		$Orden_max=$db->f("Orden");
		for($i=$Orden_max;$i>=$Orden;$i--)
		{
		 $db->query("UPDATE $string SET Orden=".($i+1)." WHERE IdSeccion='$seccion' AND Orden=$i");
		} // for($i=($Orden+1);$i==$Orden_max;$i++)
}//function ordena_desc($string,$seccion,$Orden)

function ordena_asce($string,$seccion,$Orden) {
//Recorre el orden de cualquier tabla (con Orden)cuando se inserta un elemento de esta
		global $db;
		$db->query("SELECT Orden FROM $string WHERE IdSeccion=$seccion Order by Orden DESC Limit 1"); //obten el orden
		$db->next_record();
		$Orden_max=$db->f("Orden");
		for($i=$Orden;$i<=$Orden_max;$i++)
		{
		 $db->query("UPDATE $string SET Orden=$i WHERE IdSeccion='$seccion' AND Orden=".($i+1));
		} // for($i=($Orden+1);$i==$Orden_max;$i++)
}//function ordena_desc($string,$seccion,$Orden)

function ultimo($string,$seccion)
{
// Da el valor del Orden del unltimo elemento de una tabla
		global $db;
		$db->query("SELECT Orden FROM $string WHERE IdSeccion=$seccion Order by Orden DESC Limit 1"); //obten el orden
		$db->next_record();
		Return $db->f("Orden");
} //function ultimo($string,$seccion)


//////////////////////////////Texto

function checa_archivos_texto($string,$dir)//borra los archivos que no esten en el texto
{
	$d=opendir($dir);
	remove_tags_zp ($string, array('object' => true,'embed' => true,'applet' => true,'script' => true));
	while (false != ($f=readdir($d)))//listo los archivos del directorio
	{
	if(is_file($dir.$f))
		{
		 if(!substr_count($string,'/'.$f))
		 { unlink("$dir/$f"); }
		}//--if(is_file("./$f"))
	}//--while (false != ($f=readdir($d)))
}// function checa_archivos_texto($string,$dir)



//////////////////////////////////////////////////////////////////////////////////imagenes
function nombreimagen($string)
{
$not = array('.BMP','.bmp','á','é','í','ó','ú',' ','Á','É','Í','Ó','Ú','Ñ','ñ','ü','Ü',"'", ';', '"','/','\\','@',":",'?','&');
$yes = array('.jpg','.jpg','a','e','i','o','u','_','A','E','I','O','U','N','n','u','U', '',  '',  '', '',  '', '', '', '', '');
$string = str_replace($not, $yes, $string);

Return $string;
}


////////////////////////OJO esta funcion es del editor

/****************************************************************************/
//////////////////////////
// function fixcharacterszp //
//////////////////////////
// XHTML requires all special characters to be encoded, this nice little hack makes sure of that.
function fixcharacterszp($string) {

	//return html_entity_decode($string);
	$string = htmlentities( $string, ENT_QUOTES );
	
	$trans_array = array();
	
	// html entities doesn't fix ascii characters above 127 so we'll do this ourselves using a string translation
	for ($i=127; $i<256; $i++) {
		$trans_array[chr($i)] = "&#" . $i . ";";
	}
	
	// add html entities to the translation table so they will be converted back
	$trans_array['&lt;'] = '<';
	$trans_array['&gt;'] = '>';
	$trans_array['&quot;'] = '"';
	$trans_array['&amp;nbsp;'] = '&nbsp;';
	
	// do translation and return
	return strtr($string, $trans_array);

}

function remove_tags_zp($code, $tags) {
	if (!empty($code)) {
		if (!is_array($tags)) {
			page_close(); die('<p><b>WYSIWYGPRO Paramater Error:</b> Your list of tags is not an array!</p>');
		} else {
			foreach($tags as $k => $v) {
				if (!empty($k)) {
					if ($v) {
						// remove tags and all code contained within the tags
						$code = preg_replace("/<".quotemeta($k)."[^>]*?>.*?<\/".quotemeta($k).">/smi",  "", $code);
						$code = preg_replace("/<".quotemeta($k)."[^>]*?>/smi",  "", $code);
					} else {
						// remove tags but leave code within the tags
						$code = preg_replace("/<".quotemeta($k)."[^>]*?>(.*?)<\/".quotemeta($k).">/smi",  "\$1", $code);
						$code = preg_replace("/<".quotemeta($k)."[^>]*?>/smi",  "", $code);
					}
				}
			}
		}
	}
	return $code;
}

?>
