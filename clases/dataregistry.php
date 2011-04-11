<?php

class dataregistry 
{
  var $data; 				//array(array(string))
  var $nombretabla;
  var $camposentrada; 		//array(campoentrada)
  var $campossalida; 		//array(camposalida)
  var $camponombre;			//string
  var $campollave;			//string
  
  function dataregistry($nombretabla, $camposentrada, $campossalida, &$fuenteodatos, $filtros=null, $campollave='id', $valorllave=null )
  {
	$this->nombretabla=$nombretabla;
	$this->camposentrada=$camposentrada;
	$this->campossalida=$campossalida;
	$this->camponombre=$camponombre;
	$this->campollave=$campollave;
	
	if($filtros==''){$filtros=null;}
	
  	if($filtros==''){$filtros=null;}
	    
	if(is_a($fuenteodatos,'almacendedatos') ){
		$this->data=$this->leer($fuenteodatos, $camposentrada,$campollave, $valorllave, $filtros=null);
	} else if(is_array($fuenteodatos)) {
		$this->data=$fuenteodatos;
	}	
	
	
	
	
  }

  function update($destino)
  {
	/* @var $destino datossql */
  	$destino->updateregistro($this->nombretabla,$this->data,'id');
  }  
  
  
  
  private function leer(&$fuente, $camposentrada, $campollave, $valorllave, $filtros=null)
  {
  	if(is_class('datossql',$fuente))
  	{
		/* @var $fuente datossql */
	  	$registro=$fuente->leerregistro($this->nombretabla,$camposentrada,$campollave, $valorllave,$filtros);
	  	
  	} else if(is_array($fuente) && $camposentrada) { ///--para leer desde el posrt o el request o similar
  		foreach ($camposentrada as $campoentrada )
  		{
  			/* @var $campoentrada campoentrada */
  			if($fuente[$campoentrada->nombre])
  			{
  				$registro[$campoentrada->nombre]=$fuente[$campoentrada->nombre];
  			}
  		}
  		
  	} else if(is_array($fuente) && !$camposentrada) { // para leer desde un arreglo (por ejemplo uno arreglo de un dattable)
  		$registro=$fuente;
  	}
  	return $registro; //array(string)
  }

  function imprimecampo($clasecss='titulocampo',$nulos=1)
  { 
	  foreach($this->campossalida as $camposalida)
	  {
		/* @var $camposalida camposalida */
	  	$camposalida->imprimeHTML($camposalida);
	  	//chek($row);
	  }
  } 
  
  
  function imprimeHTML($clasecss='titulocampo',$nulos=1)
  {
	if(!$this->campossalida)
	{
		foreach($this->data as $key=>$value)
	  	{
			/* @var $camposalida camposalida */
	  		if($nulos OR $value){
	  		echo '<span class="'.$clasecss.'">'.$key.': </span>'.trim($value);
	  		?><br /><br /><?
	  		}	
	  	}
  	}else{
	  	foreach($this->campossalida as $camposalida)
	  	{
			/* @var $camposalida camposalida */
	  		
	  		if($nulos OR $this->data[$camposalida->campo] OR $this->data[$camposalida->campos[0]]) {
	  		?> 
	  		<span class="<?= $clasecss ?>"><?= $camposalida->nombre ?>:
	  		<? if ($this->data[$camposalida->campos[1]]){?><br /><?} ?>
	  		</span>
			<?
	  		trim( $camposalida->imprimeHTML($this->data) );
	  		?><br /><br /><?
	  		}else{
	  			if($camposalida->campos)
	  			{
	  				//chek($camposalida->campos);
	  				//chek($this->data);
	  			}
	  		}
	  			
	  	}
	}
  }
  
  
}
?>