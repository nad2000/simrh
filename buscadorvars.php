<?
if($_POST['botonbuscador']=='Buscar')
{
	$NombreEmpleado=$_POST['NombreEmpleado'];
	$estudios=$_POST['estudios'];
	
	$NombrePuesto=$_POST['NombrePuesto'];
	$OtrasPosiciones=$_POST['OtrasPosiciones'];
	$Division=$_POST['Division'];
	$TipodePuesto=$_POST['TipodePuesto'];
	$Area=$_POST['Area'];
	$UnidadOperativa=$_POST['UnidadOperativa'];
	$Zona=$_POST['Zona'];
	$PerfilTipo=$_POST['Perfil'];
	$Experiencia=$_POST['Experiencia'];
	$EstadoPromocional=$_POST['EstadoPromocional'];	
	$Temporalidad=$_POST['Temporalidad'];	
	
	$_SESSION['NombreEmpleado']=$NombreEmpleado;
	$_SESSION['estudios']=$estudios;
	$_SESSION['NombrePuesto']=$NombrePuesto;
	$_SESSION['OtrasPosiciones']=$OtrasPosiciones;
	$_SESSION['Division']=$Division;
	$_SESSION['TipodePuesto']=$TipodePuesto;
	$_SESSION['Area']=$Area;
	$_SESSION['UnidadOperativa']=$UnidadOperativa;
	$_SESSION['Zona']=$Zona;
	$_SESSION['Perfil']=$PerfilTipo;
	$_SESSION['Experiencia']=$Experiencia;
	$_SESSION['EstadoPromocional']=$EstadoPromocional;	
	$_SESSION['Temporalidad']=$Temporalidad;		
	
	$_SESSION['Pagina']=0;
	$Pagina=$_SESSION['Pagina'];
	
}else{
	$NombreEmpleado=$_SESSION['NombreEmpleado'];
	$estudios=$_SESSION['estudios'];
	
	$NombrePuesto=$_SESSION['NombrePuesto'];
	$OtrasPosiciones=$_SESSION['OtrasPosiciones'];
	$Division=$_SESSION['Division'];
	$TipodePuesto=$_SESSION['TipodePuesto'];
	$Area=$_SESSION['Area'];
	$UnidadOperativa=$_SESSION['UnidadOperativa'];
	$Zona=$_SESSION['Zona'];
	$PerfilTipo=$_SESSION['Perfil'];
	$Experiencia=$_SESSION['Experiencia'];
	$EstadoPromocional=$_SESSION['EstadoPromocional'];	
	$Temporalidad=$_SESSION['Temporalidad'];	

	$Pagina=$_SESSION['Pagina'];

	if($_GET['pag']=='siguiente'){$Pagina++;}
	if($_GET['pag']=='aterior' AND $Pagina>=1 ){$Pagina--;}
	
	$_SESSION['Pagina']=$Pagina;
}
?>
