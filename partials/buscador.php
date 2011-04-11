<?php
//session_start();
//
//
//require_once 'clasesincluder.php';
//require_once 'arreglosdecampos.php';
//
//$sql=new datossql($globalDB,$globalDBusr,$globalDBpwd,$globalDBhost);


$leftbuscador='100%';
$anchobuscador='3%';
$margenpestania='-35px';

if($muestrabuscador==1 OR $_POST['botonbuscador']=='Buscar' OR $_GET['pag']=='siguiente' OR $_GET['pag']=='aterior' )
{
  $leftbuscador='7%';
  $anchobuscador='93%';
  $margenpestania='-18px';
}
?>
  <script language="JavaScript" type="text/javascript" src="/js/jquery.checkboxes.min.js"></script>
  <script type="text/javascript">

  $(document).ready(function()
  {
    $("#buscadorlink").css("cursor","pointer");
    $("#buscadorlink").click(function(){
      //alert($(this).attr("id"));
      var elem=$('#buscador');
      //alert(elem.css('left'));
      if(elem.css("left")=='7%')
      {animacionOculta(elem);}
      else{animacionMuesta(elem);}
    });
    $("#buscadorlink2").css("cursor","pointer");
    $("#buscadorlink2").click(function(){
      //alert($(this).attr("id"));
      var elem=$('#buscador');
      //alert(elem.css('left'));
      if(elem.css("left")=='7%')
      {animacionOculta(elem);}
      else{animacionMuesta(elem);}
    });

    iframeigualabuscador();
    //---------------------------------
    $("#puestostodos").css("cursor","pointer");
    $("#puestostodos").click(function()
    {
      $("#select").checkCheckboxes();
    });

    $("#puestosninguno").css("cursor","pointer");
    $("#puestosninguno").click(function()
    {
      $("#select").unCheckCheckboxes();
    });
  });


  function animacionOculta(elem)
    {
    //alert(elem.css('left'));
    elem.animate({left: "100%"}, 400,"linear",function(){iframeigualabuscador();}); 
    elem.animate({width: "0%"}, 400,"linear",function(){iframeigualabuscador();});
    $("#buscadorlink").css('margin-left','-35px');
  }

  function animacionMuesta(elem)
    {
    $("#buscadorlink").css('margin-left','-18px');
    elem.animate({width: "93%"}, 400,"linear",function(){iframeigualabuscador();});
    elem.animate({left: "7%"}, 400,"linear",function(){iframeigualabuscador();});
  }

  function iframeigualabuscador()
    {
    $("#selectfreelayer").css('top',$("#buscador").position().top);
    $("#selectfreelayer").css('left',$("#buscador").position().left);
    $("#selectfreelayer").css('height',$("#buscador").outerHeight() );
    $("#selectfreelayer").css('width',$("#buscador").outerWidth() );
    //alert($("#selectfreelayer").position().left);
  }
  </script>
  <link href="/css/buscadorCDD.css" rel="stylesheet" type="text/css" />

<iframe id="selectfreelayer"></iframe>

<div id='buscador' class="cajaBuscador" style="position:absolute; top:46px; bottom:33px; left:<?= $leftbuscador ?>; width:<?= $anchobuscador ?>;">


  <div id='buscadorlink' class='pestaBusca' style="margin-left: <?= $margenpestania ?>;">
  </div>
 
  <div class='cajaForma1'>
      <form name="a" action="<?= $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
       
       
        <div id="form1">
        
         <table border="0" cellspacing="0" cellpadding="0">
         <tr>
         <td>Nombre:</td>
         <td><input type="text" name="NombreEmpleado" value="<?= $NombreEmpleado ?>" /></td>
         </tr>
         <tr>
         <td> Estudios:</td>
         <td><input type="text" name="estudios"  value="<?= $estudios ?>" /></td>
         </tr>
         <tr>
         <td>Puesto:</td>
         <td><input type="text" name="NombrePuesto"  value="<?= $NombrePuesto ?>" /></td>
         </tr>
         <tr>
         <td>Experiencia:</td>
         <td><input type="text" name="Experiencia"  value="<?= $Experiencia ?>" /></td>
         </tr>
         <tr>
         <td>Otras posiciones:</td>
         <td><input type="text" name="OtrasPosiciones"  value="<?= $OtrasPosiciones ?>" /></td>
         </tr>
              <tr><td>EP:</td>
     <td><?= htmlselectuni2 ($opcionesdeestadospromocionales, 'EstadoPromocional', $EstadoPromocional, 'class="dropdown"'); ?></td></tr>

        </table>
        
        </div>
          
          <div id="form2">
          <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>Divisi&oacute;n:</td>
            <td><? htmlselectdesdesql ('Division', $sql, 'puestos', 'Division', 'Division', $Division, 'Todas', 'class="dropdown"'); ?></td>
            </tr>
          <tr>
            <td>&Aacute;rea:</td>
            <td><? htmlselectdesdesql ('Area', $sql, 'puestos', 'Area', 'Area', $Area, 'Todas', 'class="dropdown"'); ?></td>
            </tr>
            <tr>
            <td>Unidad Operativa:</td>
            <td><? htmlselectdesdesql ('UnidadOperativa', $sql, 'puestos', 'UnidadOperativa', 'UnidadOperativa', $UnidadOperativa, 'Todas', 'class="dropdown"'); ?></td>
            </tr>
            <tr>
            <td>Zona:</td>
            <td><? htmlselectdesdesql ('Zona', $sql, 'puestos', 'Zona', 'Zona', $Zona, 'Todas', 'class="dropdown"'); ?></td>
            </tr>
            <tr>
            <td>Perfil:</td>
            <td><? htmlselectdesdesql ('Perfil', $sql, 'perfiles', 'NoPerfil', 'NombrePerfil', $PerfilTipo, 'Todos', 'class="dropdown"'); ?></td>
            </tr>
                 <tr><td>Temporalidad:</td>
         <td><?= htmlselectuni2 ($opcionesdetemporalidad, 'Temporalidad', $Temporalidad, 'class="dropdown"'); ?></td></tr>

          </table>
         </div>
            
        
 <table cellpadding="0" cellspacing="0" border="0" id="form3">
     <tr>
     <td style="text-align:left" align="left">
            Tipo de puesto: <span id='puestostodos'>Todos</span> <span id='puestosninguno'>Limpiar</span>
            <div style="max-width:300px; height:160px; overflow:auto; text-align:left" id="select">  
                <?
                $tiposdepuesto=$sql->leeColumnaUnicos('puestos','TipodePuesto');
                foreach($tiposdepuesto as $tipodepuesto)
                {
                    ?><span class='nb'><? checkbox('TipodePuesto',$tipodepuesto,$TipodePuesto)?>&nbsp;<?= $tipodepuesto ?><br /></span><?
                }
                //chek($TipodePuesto);
    
                ?>
      </div>
      <input name="botonbuscador" type="submit" value="Buscar" class="boton" />      
     </td>
     </tr>   
  </table>          
</form>
 
  </div>
    <div class="cajaResultados">
    <div id="Resul">Resultados</div>
  <?
//chek($_POST);


$tabla->tabla=array();
$tamano=0;


if($Experiencia OR $Zona OR $UnidadOperativa OR $Temporalidad OR $NombreEmpleado OR $EstadoPromocional OR $estudios OR $NombrePuesto OR $OtrasPosiciones OR $Division OR $TipodePuesto OR $Area OR $PerfilTipo)
{
  
  ///-------------------------Query
  $query='Select NoPersonal, NombreEmpleado ,NombrePuesto, NombrePerfil, PerfilTipo, TipodePuesto, Division, Area, Zona, UnidadOperativa from empleadosypuestos';
  $query.=" where ";
  
  if($NombreEmpleado){$query.=" NombreEmpleado like '%$NombreEmpleado%' AND ";}
  if($NombrePuesto){$query.=" NombrePuesto like '%$NombrePuesto%' AND ";}
  if($Experiencia)
  {
    $query.="( NombrePuesto like '%$Experiencia%' OR ";
    $query.=" Puesto1 like '%$Experiencia%' OR ";
    $query.=" Puesto2 like '%$Experiencia%' OR ";
    $query.=" Puesto3 like '%$Experiencia%' OR ";
    $query.=" Puesto4 like '%$Experiencia%' ) AND ";
  }
  if($OtrasPosiciones){$query.=" OtrasPosiciones like '%$OtrasPosiciones%' AND ";}
  if($estudios){$query.=" Escolaridad1 like '%$estudios%' AND ";} 
  if($estudios){$query.=" Escolaridad2 like '%$estudios%' AND ";} 
  if($estudios){$query.=" Escolaridad3 like '%$estudios%' AND ";} 
  if($estudios){$query.=" Escolaridad4 like '%$estudios%' AND ";} 
  if($Division){$query.="Division='$Division' AND ";}
  if($TipodePuesto)
  {
    $query.="(";
    foreach($TipodePuesto as $TipodePuestoSeleccionado)
    {
      $query.="TipodePuesto='$TipodePuestoSeleccionado' OR ";
    }
    $query=trim($query,'OR ');
    $query.=") AND ";
  }
  if($Area){$query.="Area='$Area' AND ";}
  if($PerfilTipo){$query.="PerfilTipo=$PerfilTipo AND ";}
  
  if($EstadoPromocional)
  {
    $query.="(EdoPromocional20$anio='$EstadoPromocional' OR (EdoPromocional20$anio IS NULL AND EdoPromocional20$anioant='$EstadoPromocional') ) AND ";
  }

  if($Temporalidad)
  {
    $query.="(Temporalidad20$anio='$Temporalidad' OR (Temporalidad20$anio IS NULL AND Temporalidad20$anioant='$Temporalidad') ) AND ";
  } 
  if($UnidadOperativa){$query.="UnidadOperativa='$UnidadOperativa' AND ";}
  if($Zona){$query.="Zona='$Zona' AND ";}

  
  $query=trim($query,'AND ');
  
  $desplazamiento=$Pagina*$itemsporpagina;
  $query.=" limit $desplazamiento, $itemsporpagina";
  

  
  $data=$sql->queryArreglo($query);
  $tabla=new datatable('resultados',$camposentrada,$campossalidagrid,$data);
  $tamano=sizeof($tabla->tabla);
  $tabla->imprimeHTMLGrid('grid','100%','226'); 
}else{
  
  ?>
<!-- EL TERCER VALOR DE ARRIBA ES EL HEIGHT DE LA GRID DE RESULTADOS-->

  <div class="info">
  Por favor elige alg&uacute;n criterio de b&uacute;squeda.
  </div>
    
    <table id="alert" >
    <tr><td style="padding-left:30px; padding-top:30px;">
    Para hacer una b&uacute;squeda de todos los empleados, seleccionar todos los tipos de puestos.<br /><br />
    Esta consulta puede tardar varios minutos.
    
    </td>
    <td><img src="imagenes/criterios_busq.jpg"/></td></tr>   
    </table>
    <div style="height:5px;"></div>
   
    
    


  <?
  
}
?>
   </div>
   <? 
    //chek($query); 
   ?>
   
<div id="contenedor_sig_ant">   
   
   <div class="excel">
   <a href="ExcelBusqueda.php">Exportar a EXCEL</a>
   </div>
   
   
   <div class="siguiente">
   <?
    if($Pagina>=1)
    {
    ?>
      <a href="<?= $_SERVER['PHP_SELF']; ?>?pag=aterior" id="linkAnterior"> &laquo;&nbsp; Anterior  </a>&nbsp;&nbsp;&nbsp;&nbsp; &brvbar;&nbsp;&nbsp;&nbsp;&nbsp;
      <?
    }
    if($tamano==$itemsporpagina)
    {
    ?>
      <a href="<?= $_SERVER['PHP_SELF']; ?>?pag=siguiente" id="linkSiguiente">Siguiente &nbsp;&raquo; </a>
      <?
    }
    ?>  
    
   </div>

 </div>     

  
</div>

