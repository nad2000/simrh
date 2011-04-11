<?  
/*
XMLA['tag']['attributes']['nodes']

xml_to_xmla($xml)
		Transforma un xml(string o archivo) a un arreglo xmla

html_to_xmla($html)

html_part_to_node($htmlpart)

xmla_getNode(&$xmla,$treeadress)
    ---Toma una xmla y una serie de numeros en string->'1,2,3,4' o array(1,2,3,4) que representan el indice del nodo hijo desedo 
																		
xmla_addNodes(&$parent,$childs,$possition = 'def' )
    recibe el nodo(xmla) al que se le agregaran hijos, un hijo (string o xmla) o un arreglo con varios hijos que puede contener string o xlma, los inserta en la posicion indicada o al final -si no se proporciona posicion
		
xmla_getElemntByID(&$array,$id)
    Da el primer elemnto con el Id indicado en el xlma recibido

xmla_getElemntsByClass(&$array,$id)
    Da un arreglo todos los elementos del xlma que tengan la clase indicada
		
xmla_setAttrib(&$node,$attrib,$val)
    Cambia o establece un atributo

xmla_getElemntsByTag(&$array,$tag)
		Devuelve un arreglo con todos los nodos en el xmla que tienen una etiqueta al valor dado -se debe agragr manejo de expresiones regulares-

xmla_getElemntsByAttrib(&$array,$attrib,$val)
		Devuelve un arreglo con todos los nodos en el xmla que tienen un atributo igual al valor dado -se debe agragr manejo de expresiones regulares-  si no se envia el valor $val devuelve todas las etiquetas con ese atributo
		
dom_to_xmla($domnode)
		genera un xmla a partir de uno dom de PHP5

xmla_to_string($array)
		genra un xml en string
		
xmla_to_HTML_string		
		
xmla_content_to_string($array)
		genera un string de del contendio del nodo
		
xmla_content_to_HTML_string

xmla_to_file(&$array,$file)
		genera un file a partir de un arreglo xmla
*/
require_once('zpf-charsets.php');

function xml_to_xmla($xml)//ret-safe
{
  $domdoc = new DOMDocument('1.0', 'utf-8');
  $domdoc->preserveWhiteSpace=false;

  //echo 'xml_to_xmla-> '.$xml.'<br>';
  if( is_file($xml) ) 
  { 
	$file=fopen($xml,'r');
	$xml=utf8_decode(fread($file,filesize($xml))) ;
	fclose($file); 
  }
 	$domdoc->loadXML($xml);

	$domnode = $domdoc->firstChild;

	if($domnode->nextSibling){ $domnode = $domnode->nextSibling; }

	return dom_to_xmla($domnode);
	
}//function xml_array($xml)
///-------------estas se peude fusionar pero lanza warnig al cargar un file que no es xhtml
function html_to_xmla($xml)//ret-safe
{
  $domdoc = new DOMDocument;
  $domdoc->preserveWhiteSpace=false;

//  echo 'html_to_xmla: '.$xml.'<br>';
  if( is_file($xml) ) 
  { 
  	$file=fopen($xml,'r');
	//$xml=UTF82ChafCode( fread($file,filesize($xml) ) );
	$xml=fread($file,filesize($xml) );
	fclose($file); 
  }

	$domdoc->loadHTML($xml); 

	$domnode = $domdoc->firstChild;

	if($domnode->nextSibling){ $domnode = $domnode->nextSibling; }
	
	return dom_to_xmla($domnode);
	
}//function xml_array($xml)

function html_part_to_nodelist($htmlpart)
{	
	$xmla=html_to_xmla('<html><head></head><body>'.$htmlpart.'</body></html>');
	return $xmla['nodes'][1]['nodes'];
}

function &xmla_getNode(&$xmla,$treeadress)
{
 $node=&$xmla;
 if( is_string($treeadress) ){ $treeadress=explode(",", $treeadress); }
 foreach($treeadress as $index)
 {
 	$node=&$node['nodes'][$index];
 }//foreach($treeadress as $index)
 return $node;
}//function xmla_getNode($xmla,$treeadress)

function xmla_addNodes(&$parent,$childs,$possition = 'def' ) //por alguna razon el array_splice con -1 no jala como se indica en sitio de php
{
 if($childs['tag']){ $childs=array($childs); }
 if($possition=='def'){ $possition=sizeof($parent['nodes'])+1; }
 //---if( is_string($child) ){ $child=xml_to_xmla($child); }//---seria bueno agregarlo pero como se debe poder agregar nodos de texto  se hace un desmadre pues no se distingue en tre cadenas de nodo texto y cadenas xml-
 array_splice($parent['nodes'], $possition, 0, $childs );
}//function xmla_addNode(&$parent,$possition,$child)

function &xmla_getElemntByID(&$array,$id)//ret-safe
{
 if( is_array($array) ){ $ret=xmla_getElemntsByAttrib(&$array,'id',$id); }
 
 if(empty($ret)) 
 	{ 
 		return $ret;
	
	} else { 
		
		return $ret[0];
	}

}//function xmla_getElemntByID(&$array,$id)

function xmla_getElemntByTag(&$array,$tag)//ret-safe
{
	$ret=xmla_getElemntsByTag(&$array,$tag);
	if(empty($ret)) 
	{ 
		return $ret;
	} else { 
		return $ret[0];
	}

}//function xmla_getElemntsByAttrib(&$array,$attrib,$val)

function xmla_getElemntsByClass(&$array,$class)
{
 return xmla_getElemntsByAttrib(&$array,'class',$class);
}//function xmla_getElemntsByClass(&$array,$id)

function xmla_setAttrib(&$node,$attrib,$val)
{
 $node[1][$attrib]=$val;
}//function xmla_addAttrib($node,$attrib,$val)

function xmla_getElemntsByAttrib(&$array,$attrib,$val=NULL)//ret-safe
{
 $pointers=array();
 if( is_array($array) )
 { 
	if( is_array($array['attributes']) )
	{
		 foreach( $array['attributes'] as $attribute => $value )
		 {
			if($attrib==$attribute && ($value==$val OR $val==NULL) )//mejorable -expresiones regulares-
			{
			 $pointers[]=&$array;
			 end($array['attributes']); 
			} 
		 }//if($attrib==$attrib && $value==$val)
	}//if( is_array($array['attributes']) )
	
	if(is_array($array['nodes']))
	{
		foreach($array['nodes'] as &$node)
		{
			if( is_array($node) ){ $pointers=array_merge( $pointers,xmla_getElemntsByAttrib($node,$attrib,$val) ); }
		}//foreach($array['nodes'] as &$node)
	}//if(is_array($array['nodes']))
 return $pointers;
 }//if( is_array($array) )
 else
 {
 return NULL;
 }
 
}//function xmla_getElemntsByAttrib(&$array,$attrib,$val)

function xmla_getElemntsByTag(&$array,$tag)//ret-safe
{
 $pointers=array();

	if($array['tag']==$tag)//mejorable -expresiones regulares para todas las etiquetas qu ecumplan con la expresion-
	{
	 $pointers[]=&$array;
	} 

 foreach($array['nodes'] as &$node)
 {
 	if( is_array($node) ){ $pointers=array_merge( $pointers,xmla_getElemntsByTag(&$node,$tag) ); }
 }
 return $pointers;
}//function xmla_getElemntsByAttrib(&$array,$attrib,$val)

function dom_to_xmla($domnode) //ret-safe
{				 

	$attributes=array();
	$nodes=array();
	$array=array();
	
  if ($domnode->nodeType==1)
  {		  
         if ($domnode->hasAttributes() ) 
		 {
			foreach ($domnode->attributes as $d_attribute)
			{
               $attributes[$d_attribute->name] = $d_attribute->value;
            }
         }//if ($domnode->hasAttributes() )

        if ($domnode->hasChildNodes() ) 
		{
			foreach ($domnode->childNodes as $child)
			{
				//$child = $child->firstChild;
				$nodes[] = dom_to_xmla($child);
            }
         }			 
				 							 
    $array=array('tag'=>$domnode->nodeName,'attributes'=>$attributes,'nodes'=>$nodes );				 
    				 
	}else if ($domnode->nodeType==3)
	{//if ($domnode->type!='text')
		$array=utf8_decode($domnode->nodeValue);
	} else if ($domnode->nodeType==4)
	{//if ($domnode->type!='text')
		$array=$domnode->nodeValue;
	}//	}else{//if ($domnode->type!='text')
return $array;
}//function dom_to_xmla($domnode)


function xmla_to_string($array)
{
	//si es arreglo es una etiqueta
	if(is_array($array))
	{
		$string='<'.$array['tag'];
		foreach($array['attributes'] as $attrib => $attrib_val )
		{
			$string.=' '.$attrib.'="'.$attrib_val.'"';
		}
		if(sizeof($array['nodes'])==0)
		{
			$string.=' />';
		}else{//if(sizeof($array['nodes'])==0)
			$string.='>';
			foreach($array['nodes'] as $node )
			{
				$string.=xmla_to_string($node);
			}
			$string.='</'.$array['tag'].'>';
		}//}else{//if(sizeof($array['nodes'])==0)
	}else{//if(is_array($array))

		$string=asciiandhtml2utf8($array);
	
	}//}else{//if(is_array($array))
return $string;
}//function xmla_to_string($array)

function xmla_to_HTML_string($array)
{
	//si es arreglo es una etiqueta
	if(is_array($array))
	{
		$string='<'.$array['tag'];
		foreach($array['attributes'] as $attrib => $attrib_val )
		{
			$string.=' '.$attrib.'="'.$attrib_val.'"';
		}
		
		$string.=">";
		
		if(sizeof($array['nodes'])==0)
		{
			if (!in_array( $array['tag'], array('AREA','area','BR','br','BASE','base','BASEFONT','basefont','COL','col','FRAME','frame','HR','hr','IMG','img','INPUT','input','ISINDEX','isindex','LINK','link','META','meta','PARAM','param') )  )//cierro la etiqueta a menos que se trate de etiquetas que no se cierran
			{
				$string.='</'.$array['tag'].'>';
			}			
		}else{//if(sizeof($array['nodes'])==0)
			foreach($array['nodes'] as $node )
			{
				$string.=xmla_to_HTML_string($node);
			}
			$string.='</'.$array['tag'].'>';
		}//}else{//if(sizeof($array['nodes'])==0)

	}else{//if(is_array($array))
		$string=htmlentities($array);
	}//}else{//if(is_array($array))
return $string;
}//function xmla_to_HTML_string($array)

function xmla_content_to_HTML_string($array)
{
	if( is_array($array['nodes']) )
	{
		foreach($array[nodes] as $nodo)
		{
		 $ret.=xmla_to_HTML_string($nodo);
		}
	} 
	return $ret;
}//function xmla_content_to_string($array)

function xmla_content_to_string($array)
{
	if( is_array($array['nodes']) )
	{
		foreach($array[nodes] as $nodo)
		{
		 $ret.=xmla_to_string($nodo);
		}
	} 
	return $ret;
}//function xmla_content_to_string($array)

function xmla_to_file(&$array,$file)
{
	$file=fopen($file,'w');
	fputs( $file ,'<?xml version="1.0" encoding="utf-8"?>'.xmla_to_string($array) );
	fclose($file);
}

function xmla_to_HTML_file(&$array,$file)
{
	$file=fopen($file,'w');
	//echo xmla_to_HTML_string($array);
	fputs( $file ,'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.xmla_to_HTML_string($array) );
	fclose($file);
}

?>