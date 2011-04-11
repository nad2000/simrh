<?php

class campoentrada
{
	var $nombre;

	function __construct($nombre)
	{
		$this->nombre=$nombre;
	}
}



//--------------CAMPOS SALIDA---------------------------------------
class camposalida
{
	var $nombre;
	var $campo;
	var $ancho;

	function __construct($nombre,$campo,$ancho='10%')
	{
		$this->nombre=$nombre;
		$this->campo=$campo;
		$this->ancho=$ancho;
	}
	
	function imprimeHTML(&$datarow)
	{
		echo $datarow[$this->campo].'&nbsp;';
	}
}

//-------------campos de simulador
class focorojo
{

	function __construct()
	{
	}
	
	function imprimeHTML($finta1=null,$finta2=null,$finta3=null)
	{
		?><div class="focorojo"> FOCO ROJO</div><?
	}
}

class pendiente
{

	function __construct()
	{
			
	}
	
	function imprimeHTML($finta1=null,$finta2=null,$finta3=null)
	{
		?><div> Pendiente </div><?
	}
}


class camposalidaobjeto 
{
	var $nombre;

	function __construct($nombre,$campo,$ancho='10%')
	{
		$this->nombre=$nombre;
	}
	
	
	function imprimeHTML($objeto,$finta2=null,$finta3=null)
	{
		$objeto->imprimeHTML;
	}
}

class camposalidaLinkEmpleado extends camposalidaLink 
{
	function imprimeHTML(&$datarow)
	{
		if($datarow[$this->campotexto_o_texto])
			{$campotexto_o_texto=$datarow[$this->campotexto_o_texto];}
		else
			{$campotexto_o_texto=$this->campotexto_o_texto;}
		
		global $unidadesvisibles;
		
		global $niveldeacceso;
		
		if( $niveldeacceso=='Admin' OR in_array($datarow['UnidadOperativa'],$unidadesvisibles))
		{
			echo '<a href="'.$this->url.'?'.$this->nombredevariable.'='.$datarow[$this->campodevariable].'" target="'.$this->target.'" >'.$campotexto_o_texto.'</a>';
		}else{
			echo '&nbsp;';
		}
	}
}



class camposalidaLinkPopUpNombre extends camposalidaLinkPopUp 
{
	function imprimeHTML(&$datarow)
	{
		if($datarow[$this->campotexto_o_texto])
			{$campotexto_o_texto=$datarow[$this->campotexto_o_texto];}
		else
			{$campotexto_o_texto=$this->campotexto_o_texto;}

		global $unidadesvisibles;
		
		global $niveldeacceso;
			
		if( $niveldeacceso=='Admin' OR in_array($datarow['UnidadOperativa'],$unidadesvisibles))
		{
			
			echo '<a href="javascript:popUp'.$this->tipodepopoup.'(\''.$this->url.'?'.$this->nombredevariable.'='.$datarow[$this->campodevariable].'\')" target="'.$this->target.'" >'.$campotexto_o_texto.'</a>';
		}else{
			//chek($unidadesvisibles);
			echo $campotexto_o_texto;
		}	
	
	}
}


//------------FIN-campos de simulador

class camposalidaMAIL extends camposalida 
{
	function imprimeHTML(&$datarow)
	{
		echo '<a href="mailto:'.$datarow[$this->campo].'">'.$datarow[$this->campo].'</a>&nbsp;';
	}
}

class camposalidaPeriodoHastaHoy extends camposalida 
{
	function imprimeHTML(&$datarow)
	{
		echo getAge(strtotime( $datarow[$this->campo] ));
	}
}

class camposalidaURL extends camposalida
{
	var $target;

	function __construct($nombre,$campo,$ancho='10%',$target='_blank')
	{
		parent::__construct($nombre,$campo,$ancho);
		$this->target=$target;
	}
	
	function imprimeHTML(&$datarow)
	{
		$link=ltrim($datarow[$this->campo],'http://');
		echo '<a href="http://'.$link.'" target="'.$this->target.'">'.$link.'</a>&nbsp;';
	}
}

class camposalidaMultiple
{
	var $separador;

	function __construct($nombre,$campos,$separador='<br />',$ancho='10%')
	{
		parent::__construct($nombre,$campo,$ancho);
		$this->separador=$separador;
	}
	
	function imprimeHTML(&$datarow)
	{
		foreach($this->campos as $campo)
		{
			$str.=$datarow[$campo].$this->separador.' ';
		}
		$str=rtrim($str,$this->separador.' ');
		echo $str.'&nbsp;';
	}
}

class camposalidaMultipleKey
{

	var $separador;
	var $tabladellaves;
	
	function __construct($nombre,$campos,$tabladellaves,$separador='<br />',$ancho='10%')
	{
		parent::__construct($nombre,$campo,$ancho);
		$this->separador=$separador;
		$this->tabladellaves=$tabladellaves;
	}
	
	function imprimeHTML(&$datarow)
	{
		//chek($this->tabladellaves);
		foreach($this->campos as $campo)
		{
			if($this->tabladellaves[$datarow[$campo]]){
				//chek('-'.$this->tabladellaves[$datarow[$campo]]);
				$str.=$this->tabladellaves[$datarow[$campo]].$this->separador.' ';
			}
		}
		$str=rtrim($str,$this->separador.' ');
		echo $str.'&nbsp;';
	}
}

class camposalidaCHKBOX extends camposalida 
{
	var $name;
	
	function __construct($nombre, $campo, $name, $ancho='10%')
	{
		parent::__construct($nombre,$campo,$ancho);
		$this->name=$name;
	}	

	function imprimeHTML(&$datarow)
	{
		echo '<input type="checkbox" value="'.$datarow[$this->campo].'" name="'.$this->name.'" />';
	}
}


class camposalidaKEYSELECT extends camposalida 
{
	var $prefijoname;
	var $tabladelallave;
	var $campollaveentablareferida;
	var $camponombreentablareferida;
	var $campollaveentablaconsultada;
	var $fuente;
	
	
	function __construct($nombre, $campo, $prefijoname, $ancho='10%',$campollaveentablaconsultada,$tabladelallave,$campollaveentablareferida,$camponombreentablareferida,&$fuente)
	{
		parent::__construct($nombre,$campo,$ancho);
		$this->prefijoname=$prefijoname;
		$this->tabladelallave=$tabladelallave;
		$this->campollaveentablareferida=$campollaveentablareferida;
		$this->camponombreentablareferida=$camponombreentablareferida;
		$this->campollaveentablaconsultada=$campollaveentablaconsultada;
		$this->fuente=&$fuente;//---ojo por como esta hecho ahora solo jala con fuentes sql peor se puede arreglar "facil"
	}	

	function imprimeHTML(&$datarow)
	{
		//echo '<input type="radio" value="'.$datarow[$this->campo].'" name="'.$this->name.'" />';
		$selct=new formelement('',$this->prefijoname.$datarow[$this->campollaveentablaconsultada],
		array_merge(
			array(array('','--')),
			$this->fuente->queryArreglo("SELECT DISTINCT p.`$this->campollaveentablareferida` as '0', p.`$this->camponombreentablareferida` as '1' FROM $this->tabladelallave p;")),
			$datarow[$this->campo]);
		$selct->imprimeselect();		
		
	}
}

class camposalidaRADIO extends camposalida 
{
	var $name;
	
	function __construct($nombre, $campo, $name, $ancho='10%')
	{
		parent::__construct($nombre,$campo,$ancho);
		$this->name=$name;
	}	

	function imprimeHTML(&$datarow)
	{
		echo '<input type="radio" value="'.$datarow[$this->campo].'" name="'.$this->name.'" />';
	}
}





class camposalidaLinkPopUp extends camposalida 
{
	var $nombre;
	var $ancho;
	
	var $url;
	var $nombredevariable;
	var $campodevariable;
	var $campotexto;
	
	function __construct($nombre, $campotexto_o_texto, $url, $nombredevariable, $campodevariable, $tipodepopoup='',$ancho='10%')
	{
		$this->nombre=$nombre;
		$this->ancho=$ancho;
		
		$this->url=$url;
		$this->campotexto_o_texto=$campotexto_o_texto;
		$this->campodevariable=$campodevariable;
		$this->nombredevariable=$nombredevariable;
		$this->target=$target;
		$this->tipodepopoup=$tipodepopoup;
	}	

	function imprimeHTML(&$datarow)
	{
		if($datarow[$this->campotexto_o_texto])
			{$campotexto_o_texto=$datarow[$this->campotexto_o_texto];}
		else
			{$campotexto_o_texto=$this->campotexto_o_texto;}
		echo '<a href="javascript:popUp'.$this->tipodepopoup.'(\''.$this->url.'?'.$this->nombredevariable.'='.$datarow[$this->campodevariable].'\')" target="'.$this->target.'" >'.$campotexto_o_texto.'</a>';
	}
}

class camposalidaLink extends camposalida 
{
	var $nombre;
	var $ancho;
	
	var $url;
	var $nombredevariable;
	var $campodevariable;
	var $campotexto;
	
	function __construct($nombre, $campotexto_o_texto, $url, $nombredevariable, $campodevariable, $target='_self',$ancho='10%')
	{
		$this->nombre=$nombre;
		$this->ancho=$ancho;
		
		$this->url=$url;
		$this->campotexto_o_texto=$campotexto_o_texto;
		$this->campodevariable=$campodevariable;
		$this->nombredevariable=$nombredevariable;
		$this->target=$target;
	}	

	function imprimeHTML(&$datarow)
	{
		if($datarow[$this->campotexto_o_texto])
			{$campotexto_o_texto=$datarow[$this->campotexto_o_texto];}
		else
			{$campotexto_o_texto=$this->campotexto_o_texto;}
		echo '<a href="'.$this->url.'?'.$this->nombredevariable.'='.$datarow[$this->campodevariable].'" target="'.$this->target.'" >'.$campotexto_o_texto.'</a>';
	}
}

class camposalidaSPAN extends camposalida
{
	var $nombre;
	var $ancho;
	
	var $url;
	var $nombredevariable;
	var $campodevariable;
	var $campotexto;
	
	function __construct($nombre, $campotexto_o_texto, $title, $campodeid='id', $ancho='10%')
	{
		$this->nombre=$nombre;
		$this->ancho=$ancho;
		
		$this->campotexto_o_texto=$campotexto_o_texto;
		$this->title=$title;
		$this->campodeid=$campodeid;
	}	

	function imprimeHTML(&$datarow)
	{
		if($datarow[$this->campotexto_o_texto])
			{$campotexto_o_texto=$datarow[$this->campotexto_o_texto];}
		else
			{$campotexto_o_texto=$this->campotexto_o_texto;}
		echo '<span title="'.$this->title.'" id="'.$datarow[$this->campodeid].'">'.$campotexto_o_texto.'</span>';
		//echo '<span onclick="">ab</span>';
	}
}


?>