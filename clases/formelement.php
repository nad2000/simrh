<?php


class formelement
{
	var $nombre;
	var $tagname;
	var $datos;
	var $default;
	var $claseestilos;

	function __construct($nombre,$tagname,$datos,$default=null,$claseestilos=null)
	{
		$this->nombre=$nombre;	
		$this->tagname=$tagname;
		$this->default=$default;
		$this->datos=$datos;
		$this->claseestilos=$claseestilos;
	}

	
	function imprimeselect($contitulo=false)//lista tiene un arreglo de arreglos con valor en el 0 y texto en el 1
	{
		//chek($this->datos);
		?>
		<? if ($contitulo) { echo $this->nombre.':'; } ?>
		<select name="<?= $this->tagname ?>" class=<?= $this->claseestilos ?> >
		<?php for ($ren=0;  $ren< sizeof($this->datos); $ren++){?>
			<option <? if($this->default === $this->datos[$ren][0]) {?> selected="selected" <? } ?> value="<?= $this->datos[$ren][0]; ?>"><? Printf ($this->datos[$ren][1]); ?></option>				 
		<?php } ?>
		</select>		
		<?
	}
	
	function imprimetext($contitulo=false)//lista tiene un arreglo de arreglos con valor en el 0 y texto en el 1
	{
		//chek($this->datos);
		?>
		<? if ($contitulo) { echo $this->nombre.':'; } ?>
		<input type="text"  name="<?= $this->tagname ?>" class="<?= $this->claseestilos ?>" value="<?= $this->default ?>" />	
		<?
	}
	
	
}



?>