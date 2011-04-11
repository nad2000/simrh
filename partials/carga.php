<div id="carga" width="100%" height="100%" style="position:absolute; width:100%; height:100%; background-color:#FFF; z-index:200; text-align: center; color:#D1B6B6; margin-top:40px">
    <br /><br /><br /><br /><br /><br />
    <img src="imagenes/Cargando.gif" />
    <h6> loading... </h6>
</div>

<script language="JavaScript" type="text/javascript">
  //$("html").css("overflow",'hidden');
  $("#carga").css("height",($(window).height())+'px');
  $("#carga").css("width",($(window).width())+'px');
  $(document).ready(function()
  {
    $("#carga").css("display",'none');
    //$("html").css("overflow",'auto');
  });
</script>
