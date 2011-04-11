<div style="height:45px; width:100%; background-image:url(imagenes/navbar_bkg.gif); background-repeat:repeat-x;">

<img src="imagenes/navbar_logo.gif" border="0" />
   <ul id="nav" class="dropdown dropdown-horizontal" style="width:100%; position:absolute; z-index:60;">
        <li class="first"><a href="simulador.php">Simulador</a></li>
        <li><a href="gameplan.php">Game Plan</a></li>
        <li><a href="#">Reportes</a>
            <ul>
                <li class="first"><a href="/reporte9bxs.php">9BXS</a></li>
                <li><a href="graficador.php">Gr&aacute;ficas</a></li>
                <li><a href="reporteoportunidades.php">Oportunidades</a></li> 
                <li><a href="/graficador.php?tipo=Barras+acumuladas&criterio1=Division&criterio2=Estado+Promocional+2009&botonbuscador=Graficar">Estados Promocionales OM</a></li>
                <li><a href="/graficador.php?tipo=Pay&criterio1=Genero&criterio2=Estado+Promocional+2009&botonbuscador=Graficar">G&eacute;nero</a></li>
                <li><a href="/graficador.php?tipo=Barras+dobles&criterio1=Area&criterio2=Genero&botonbuscador=Graficar">G&eacute;nero por &Aacute;rea</a></li>
                <li><a href="/graficador.php?tipo=Pay&criterio1=Estado+Civil&criterio2=Genero&botonbuscador=Graficar">Estado Civil</a></li>
                <li><a href="/graficador.php?tipo=Barras+dobles&criterio1=Estado+Civil&criterio2=Genero&botonbuscador=Graficar">Estado Civil por genero</a></li>
                <li><a href="/graficador.php?tipo=Pay&criterio1=Rango+de+Edad&criterio2=Genero&botonbuscador=Graficar">Edad</a></li>
                <li><a href="/graficador.php?tipo=Barras+dobles&criterio1=Rango+de+Edad&criterio2=Genero&botonbuscador=Graficar">Edad por genero</a></li>
                <li><a href="/graficador.php?tipo=Barras+dobles&criterio1=Area&criterio2=Rango+de+Edad&botonbuscador=Graficar">Edad por &Aacute;rea</a></li>
                <li><a href="/graficador.php?tipo=Pay&criterio1=Antiguedad+en+el+puesto&criterio2=Rango+de+Edad&botonbuscador=Graficar">Antig&uuml;edad en el puesto actual</a></li>
                <li><a href="/graficador.php?tipo=Pay&criterio1=Antiguedad+en+la+empresa&criterio2=Rango+de+Edad&botonbuscador=Graficar">Antig&uuml;edad en la compa&ntilde;&iacute;a</a></li>
                <li><a href="/graficador.php?tipo=Pay&criterio1=Evaluacion+de+desempeno+2009&criterio2=Rango+de+Edad&botonbuscador=Graficar">Evaluaci&oacute;n de desempe&ntilde;o 2009</a></li>
                <li><a href="/graficador.php?tipo=Pay&criterio1=Nivel+de+ingles&criterio2=Rango+de+Edad&botonbuscador=Graficar">Nivel de ingles</a></li>
            </ul>
        </li>
        <? if($niveldeacceso=='Admin' or $niveldeacceso=='Editor'){ ?>
        <li><a href="#">Juntas</a>
            <ul>
                <li class="first"><a href="CreadordeJuntas.php">Abrir/Cerrar Junta</a></li>
                <li><a href="listadodejuntas.php">Listado de Juntas</a></li>
            </ul>
        </li>
        <? } ?>
        <? if($niveldeacceso=='Admin'){ ?>
        <li><a href="#">Administrador</a>
            <ul>
                <li class="first"><a href="AdministradorDatos.php">Datos</a></li>
                <li><a href="AdministradorUsuariosListadoyUpload.php">Usuarios</a></li>
            </ul>
        </li>
        <? } ?>
        <li><a href="salir.php">Cerrar sesi&oacute;n</a></li>
    </ul>
</div>
<!--
<ul id="nav" class="dropdown dropdown-horizontal">
    <li id="n-home"><a href="#">Simulador</a></li>
    <li id="n-home"><a href="#">Game Plan</a></li>
  <li id="n-shows"><a href="#">Reportes</a>
    <ul>
      <li class="first"><a href="#">9BXS</a></li>
      <li><a href="#">Gr&aacute;ficas</a></li>
    </ul>
  </li>
  <li id="n-news"><a href="#">Juntas</a>
    <ul>
      <li class="first"><a href="#">Abrir &frasl; Cerrar Junta</a></li>
      <li><a href="#">Listado de Juntas</a></li>
    </ul>
  </li>
      <li id="n-music"><a href="#">Admin</a>
    <ul>
      <li class="first"><a href="#">Administrar Datos</a></li>
      <li><a href="#">Usuarios</a></li>
    </ul>
  </li>
    <li id="n-home"><a href="#">Salir</a></li>
</ul>
    -->

