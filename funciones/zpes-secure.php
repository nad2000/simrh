<?

//Si el Apache chec ala clave aca solo hay que agignar a $Dominio_s el valor del dominio que sale directo de la variable de servidor.
$Dominio_s=$_SERVER["SERVER_NAME"];
$path_a_info='./site-info';
$path_a_paginas=$_SERVER["DOCUMENT_ROOT"].'/sitios/'.$Dominio_s;

/*
Script para verificar que el usuario esta logeado y alterando su sitio



$root=$_SERVER['DOCUMENT_ROOT'];


//si viene del login busca el archivo de configuracion lee la clave y si coinciden registra la session
if($login_f=='login')
{
	if(strlen(trim($clave_f))>0 AND strlen(trim($Dominio1_f))>0)//si lleno ambos campos sigue
	{
		
		if(is_file("$root/sites-data/www.$Dominio1_f/config.xml") )//si existe el archivo obten la clave
		{
			$cnf=xml_to_xmla("$root/sites-data/www.$Dominio1_f/config.xml");
			$clave=xmla_getElemntsByTag(&$cnf,'clave');
			$clave=$clave[0]['nodes'][0];
			
		}
		//Si la clave esta bien registra la variable de session Dominio_s si no vuelve a login
		//chek(trim($clave)."==".trim($clave_f));
		if(trim($clave)==trim($clave_f))
		{
			$_SESSION[Dominio_s]='www.'.$Dominio1_f;
		}else{
			header('Location: ./loginzp.php?mensaje=La direccion y/o la contrasena no coinciden por favor vuelve a intentar');
			die;
		}
	}else{//si no lleno ambos campos no sigue
		header('Location: ./loginzp.php?mensaje=Llena ambos campos por favor');
		die;
	}
}//if($Dominio1_f)

//Si no hay variable de dominio borra la session y manda al usuario a loginZP 
if(!$_SESSION[Dominio_s]) 
{ 
	session_unset();
	header('Location: ./loginzp.php?mensaje=Paso mucho tiempo desde tu ultima accion en el sitio por favor vuelve a identificarte');
	die;
	
}else{ //si hay variable Domino_s la globaliza -importante pues globalizer podria permitir que escribiera otro sitio enviando otro valor para Dominio_s- y sige con el programa
	$Dominio_s=&$_SESSION[Dominio_s];
}//if(!$_SESSION[Dominio_s])

*/

?>
