<?php
require_once 'almacendedatos.php';

class datatable 
{
  var $tabla; 				//array(array(string))
  var $nombretabla;
  var $camposentrada; 		//array(campoentrada)
  var $campossalida; 		//array(camposalida)
  var $camponombre;			//string
  var $campollave;			//string
  
  function __construct($nombretabla, $camposentrada, $campossalida, &$fuenteodatos, $filtros=null, $campollave='id', $camponombre='nombre' )
  {

		$this->nombretabla=$nombretabla;
		$this->camposentrada=$camposentrada;
		$this->campossalida=$campossalida;
		$this->camponombre=$camponombre;
		$this->campollave=$campollave;
		
  		if(!$this->camposentrada)
  		{
			/* @var $fuenteodatos datosexcel2 */
  			if(is_a($fuenteodatos, 'datosexcel2') or is_a($fuenteodatos, 'datosexcel'))
  			{
				$camposentrada=$fuenteodatos->getencabezados($nombretabla); //OJO esto en realidad solo sirve en datos excel  2-4-2009	
  			}
  		}
		
		if(is_string($camposentrada[0]))
		{
			$temp=array();
			foreach($camposentrada as $campoentrada)
			{ $temp[]=new campoentrada($campoentrada); }
			$this->camposentrada=$temp;
			$camposentrada=$temp;
		}
		
		if($filtros==''){$filtros=null;}
		    
		if(is_a($fuenteodatos,'almacendedatos') ){
			$this->tabla=$this->leer($fuenteodatos, $camposentrada, $filtros);
		} else if(is_array($fuenteodatos)) {
			$this->tabla=$fuenteodatos;
		}	
		
		if(!$this->campossalida)
		{
			foreach($this->tabla[0] as $key=>$value)
			{
				$this->campossalida[]=new camposalida($key,$key);
			}
		}
			
		if(is_string($campossalida[0]))
		{
			$temp=array();
			foreach($campossalida as $camposalida)
			{ $temp[]=new camposalida($camposalida,$camposalida); }
			$this->campossalida=$temp;
		}	
	
  } 
  
	
	/**
	 * En la tabla que este en data(memoria) sustituye los valores de campo por los IDs de la tabla correspondiente. 
	 * Si un valor no corresponde devuelve false.
	 * Si todos se pueden cambiar devuelve true.
	 *
	 * @param string $campoentabladata
	 * @param string $tabladereferencia
	 * @param datossql $fuente
	 * @param string $campoidentablareferencia
	 * @param string $campoigual
	 * 
	 * @return boolean
	 */
	public function sutituyeporllaves($campoentabladata,&$fuente,$tabladereferencia,$campoIDentablareferencia,$campoenreferencia)
	{
		$relacionvaloresllaves=$fuente->obtenRelacionvaloresLlaves($tabladereferencia,$campoIDentablareferencia,$campoenreferencia);
		//$this->imprimeHTML();
		foreach($this->tabla as &$row)
		{
			//chek($row);
			//chek($row[$campoentabladata]);
			//chek($relacionvaloresllaves[$row[$campoentabladata]]);
			
			if($relacionvaloresllaves[$row[$campoentabladata]])
			{$row[$campoentabladata]=$relacionvaloresllaves[$row[$campoentabladata]];}
			else{ return false; }	
		}
		//$this->imprimeHTML();
		return true;
		
	}  
  
  function tablallavenombre()
  {
	foreach($this->tabla as $registro)
	{
		$ret[$registro[$this->campollave]]=$registro[$this->camponombre];
	}
	return $ret;
  }  
  
  private function leer(&$fuente, $camposentrada, $filtros=null)//falta por definir los filtros
  {
  	/* @var $fuente datossql */
  	$tabla=$fuente->leertabla($this->nombretabla,$camposentrada, $filtros);
  	return $tabla; //array(string)
  }
  
  function guardar(&$fuente, $appendORreplace='replace')
  {
  	/* @var $fuente almacendedatos */
  	//chek($this->nombretabla);
  	if($appendORreplace=='replace')
  	{ 
  		//if( $fuente->existetabla($this->nombretabla) ){$fuente->vaciatabla($this->nombretabla);} //si no hay tabla creala
  		$fuente->guardartabla($this->nombretabla,$this->tabla);  //esto vacia la tabla y cargo lo que este en el arreglo $this->tabla
  	}

  }  

  function imprimeHTMLListado($style=null, $width)
  {
	  	?><br /><? 
  		foreach($this->tabla as &$row)
		{
			?><span class="altcolor"><?
			foreach($this->campossalida as $camposalida)
		  	{
				/* @var $camposalida camposalida */
		  		$camposalida->imprimeHTML($row);
		  		//chek($row);
		  	}
		  	?></span><br /><? 
		}

  } 
  
  
  
  
  function imprimeHTML($class=null, $width='80%',$header=1)
  {
	
  	
  	?><table <? if($class){echo 'class="'.$class.'" ';} ?> <? if($width){echo 'width="'.$width.'" ';} ?>><?
	 	if($header==1){
	  		?><tr><? 
			foreach($this->campossalida as $camposalida)
		  	{
		  		// @var $camposalida camposalida 
		  		?><th width="<?= $camposalida->ancho ?>"><? 
	
		  		echo $camposalida->nombre;
		  		?></th><?	
		  	}
		  	?></tr><? 
	 	}
	 	
	  	foreach($this->tabla as &$row)
		{
	  		
			?><tr><? 
			foreach($this->campossalida as $camposalida)
		  	{
		  		?><td><? 
				/* @var $camposalida camposalida */
		  		$camposalida->imprimeHTML($row);
		  		//chek($row);
		  		?></td><?	
		  	}
		  	?></tr><? 
		}
	?></table><?  
	/*?></div><?  */
  }
  
  function imprimeHTMLGrid($id, $width, $height=150,$rowtitle=null)
  {
	?>
	<script>
		$(document).ready(
		
			function () 
			{	
				<?
				$this->imprimeHTMLGridStartUP($id);
				?>
 			}
		);
	</script> 	
	<div id="<?= $id; ?>" style="width:<?= $width; ?>"><?
		?><table style="border: 0px solid #ccc; background-color:#cfd1b6" cellpadding="0" cellspacing="0" width="100%"><!-- BORDE DEL header --><? 
			?><thead><?
			?><tr><? 
			foreach($this->campossalida as $camposalida)
		  	{
		  		/* @var $camposalida camposalida */
		  		?><th <? if($camposalida->ancho){ ?> style="width:<?= $camposalida->ancho; ?>px; max-width:<?= $camposalida->ancho; ?>px; height:16px; padding-bottom:3px" width="<?= $camposalida->ancho; ?>" <? } ?>  sort="<?= $camposalida->nombre; ?>"><?  
				
		  		echo $camposalida->nombre;
		  		?></th><?	
		  	}
		  	?><td style="width:16px; color:white" width="16">&nbsp;</td>
            </tr><?
	  	?></thead><?
	 ?></table><?
	 
	 ?><div style="overflow:scroll;  margin-right:16px; height:<?= $height; ?>px; overflow-y:scroll; overflow-x: hidden;"><? 
	 ?><table style="border: 0px solid #ccc;" cellspacing="0" width="100%"><!-- BORDE DE LA TABLA --><? 	 
	  	?><? 

		  		foreach($this->tabla as &$row)
				{
			  		
					?><tr <? if($rowtitle) { ?>id="<?= $row['id'] ?>" title="<?= $rowtitle ?>"<? }  ?>><? 
					foreach($this->campossalida as $camposalida)
				  	{
				  		?><td <? if($camposalida->ancho){ ?> style="word-wrap:break-word; max-width:<?= $camposalida->ancho; ?>px" width="<?= $camposalida->ancho; ?>" <? } ?> ><?  
						/* @var $camposalida camposalida */
				  		$camposalida->imprimeHTML($row);
				  		//chek($row);
				  		?></td><?	
				  	}
		
				  	?></tr><? 
				}
				

		?><?
	?></table><? 
	?></div><? 
	
	?>
	<div style="display: none">
	<table style="border: 1px solid #ccc;" cellspacing="0" width="100%">
    <tfoot>
		<tr>
			<td colspan=7>
				<div class="pagination"></div>
				<div class="paginationTitle">Page</div>

				<div class="selectPerPage"></div>
				<div class="status"></div>
			</td>
		</tr>
	</tfoot>
	</table>
	</div>
	
	</div>
	<?
  }  

  function imprimeHTMLGridStartUP($id)
  { 
	$renglones = sizeof( $this->tabla );
  	echo "
  	$('#$id').jTPS( {perPages:[$renglones],scrollStep:1,scrollDelay:30} );
	// bind mouseover for each tbody row and change cell (td) hover style
	$('#$id tbody tr:not(.stubCell)').bind('mouseover mouseout',
		function (e) 
		{
			// hilight the row
			e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
		}
	); 
	"; 
  }
  
  
  
}

?>