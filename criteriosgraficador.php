<?php


function transforma(&$r,$t)
{
	foreach($t['rangos'] as $rango=>$vals)
	{
		if($vals['igual'] AND $r[$t['campo']]==$vals['igual']){$r[$t['campo']]=$rango; return; }
		if	(
				( 
					($vals['mayoroigual'] AND $vals['menoroigual']) AND ( $r[$t['campo']]>=$vals['mayoroigual'] AND $r[$t['campo']]<=$vals['menoroigual'] )
				)
				OR
				( 
					($vals['mayoroigual'] AND !$vals['menoroigual']) AND ( $r[$t['campo']]>=$vals['mayoroigual'])
				)
				OR
				( 
					(!$vals['mayoroigual'] AND $vals['menoroigual']) AND ( $r[$t['campo']]<=$vals['menoroigual'] )
				)
			)
		{$r[$t['campo']]=$rango; return; }
	}
	
	
	
	//$r[$t['campo']]='a';
	
}	
	
	
function obtendatosgrafica(&$criterio1,&$criterio2,&$data,&$Criterios)
{
	//return $data;
	//chek($Criterios);
	//
	$transf1=$Criterios[$criterio1];
	$c1=$transf1['campo'];
	if($criterio2)
	{
		$transf2=$Criterios[$criterio2];
		$c2=$transf2['campo'];
	}
	//$transf2&=$Criterios[$criterio2];
	$ix=0;
	foreach($data as &$r)
	{
		
		//$r=array('edad'=>'aa');
		transforma($r,$transf1);
		
		if(!$c2){$ret[0][$r[$c1]]++;}
		else
		{
			transforma($r,$transf2);
			$ret[$r[$c1]][$r[$c2]]++;
		}
		
		//if($r[$c1])
	}
	
	//return $ret;
	
	if(!$c2){ return $ret; }
	else
	{
		foreach($ret as $crit1=>$arraycrit2)
		{
			foreach($arraycrit2 as $crit2=>$sum)
			{
				$ret2[]=array($criterio1=>$crit1,$criterio2=>$crit2,'Cuenta'=>$sum);
			}
		}
		return $ret2;
	}		
	
}

//$diviciones=$

		$Criterios=array(
		'Rango de Edad'=>array(
			'campo'=>'edad',
			'rangos'=>array(
				'19 o menos a&ntilde;os'=>array('mayoroigual'=>null,'menoroigual'=>20, 'igual'=>null),
				'20 - 25 a&ntilde;os'=>array('mayoroigual'=>20,'menoroigual'=>25,'igual'=>null),
				'26 - 30 a&ntilde;os'=>array('mayoroigual'=>26,'menoroigual'=>30,'igual'=>null),
				'31 - 35 a&ntilde;os'=>array('mayoroigual'=>31,'menoroigual'=>35,'igual'=>null),
				'36 - 40 a&ntilde;os'=>array('mayoroigual'=>36,'menoroigual'=>40,'igual'=>null),
				'41 - 45 a&ntilde;os'=>array('mayoroigual'=>41,'menoroigual'=>45,'igual'=>null),
				'46 - 50 a&ntilde;os'=>array('mayoroigual'=>46,'menoroigual'=>50,'igual'=>null),
				'51 - 55 a&ntilde;os'=>array('mayoroigual'=>51,'menoroigual'=>55,'igual'=>null),
				'56 - 60 a&ntilde;os'=>array('mayoroigual'=>56,'menoroigual'=>60,'igual'=>null),
				'61 - 65 a&ntilde;os'=>array('mayoroigual'=>61,'menoroigual'=>65,'igual'=>null),
				'66 o m&aacute;s a&ntilde;os'=>array('mayoroigual'=>66,'menoroigual'=>null,'igual'=>null)
			)
		),
		'Genero'=>array(
			'campo'=>'Genero',
			'rangos'=>array(
				'Masculino'=>array('mayoroigual'=>null,'menoroigual'=>null, 'igual'=>'Masculino'),
				'Femenino'=>array('mayoroigual'=>null,'menoroigual'=>null,'igual'=>'Femenino')
			)
		),
		"Estado Promocional 20$anio"=>array(
			'campo'=>"EdoPromocional20$anio",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "EdoPromocional20$anio")
			
		),
		"Estado Promocional 20$anioant"=>array(
			'campo'=>"EdoPromocional20$anioant",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "EdoPromocional20$anioant")
			
		),
		"Estado Promocional 20$anioantant"=>array(
			'campo'=>"EdoPromocional20$anioantant",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "EdoPromocional20$anioantant")
			
		),
		"9BXS 20$anio"=>array(
			'campo'=>"9BXS$anio",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "9BXS$anio")
			
		),
		"9BXS 20$anioant"=>array(
			'campo'=>"9BXS$anioant",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "9BXS$anioant")
			
		),
		"9BXS 20$anioantant"=>array(
			'campo'=>"9BXS$anioantant",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "9BXS$anioantant")
			
		),		
		'Antiguedad en el puesto'=>array(
			'campo'=>'antiguedadpuesto',
			'rangos'=>array(
				'Menos de 1 a&ntilde;o'=>array('mayoroigual'=>null,'menoroigual'=>0, 'igual'=>null),
				'1 a 3 a&ntilde;os'=>array('mayoroigual'=>1,'menoroigual'=>2, 'igual'=>null),
				'3 a 5 a&ntilde;os'=>array('mayoroigual'=>3,'menoroigual'=>4, 'igual'=>null),
				'5 a 7 a&ntilde;os'=>array('mayoroigual'=>5,'menoroigual'=>6, 'igual'=>null),
				'7 a 9 a&ntilde;os'=>array('mayoroigual'=>7,'menoroigual'=>9, 'igual'=>null),
				'10 o mas a&ntilde;os'=>array('mayoroigual'=>10,'menoroigual'=>null, 'igual'=>null)
			)
		),
		'Antiguedad en la empresa'=>array(
			'campo'=>'antiguedadcompania',
			'rangos'=>array(
				'Menos de 1 a&ntilde;o'=>array('mayoroigual'=>null,'menoroigual'=>0, 'igual'=>null),
				'1 a 3 a&ntilde;os'=>array('mayoroigual'=>1,'menoroigual'=>2, 'igual'=>null),
				'3 a 5 a&ntilde;os'=>array('mayoroigual'=>3,'menoroigual'=>4, 'igual'=>null),
				'5 a 7 a&ntilde;os'=>array('mayoroigual'=>5,'menoroigual'=>6, 'igual'=>null),
				'7 a 9 a&ntilde;os'=>array('mayoroigual'=>7,'menoroigual'=>9, 'igual'=>null),
				'10 o mas a&ntilde;os'=>array('mayoroigual'=>10,'menoroigual'=>null, 'igual'=>null)
			)
		),
		'Division'=>array(
			'campo'=>'Division',
			'rangos'=>criteriodesdesql(&$sql, 'puestos',  'Division')
		),
		'Area'=>array(
			'campo'=>'Area',
			'rangos'=>criteriodesdesql(&$sql, 'puestos',  'Area')
		),
		'Zona'=>array(
			'campo'=>'Zona',
			'rangos'=>criteriodesdesql(&$sql, 'puestos',  'Zona')
		),
		'Unidad Operativa'=>array(
			'campo'=>'UnidadOperativa',
			'rangos'=>criteriodesdesql(&$sql, 'puestos',  'UnidadOperativa')
		),	
		'Estado Civil'=>array(
			'campo'=>'EstadoCivil',
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  'EstadoCivil')
		),
		"Evaluacion de desempeno 20$anio"=>array(
			'campo'=>"ED$anio",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "ED$anio")
			
		),
		"Evaluacion de desempeno 20$anioant"=>array(
			'campo'=>"ED$anioant",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "ED$anioant")
			
		),
		"Evaluacion de desempeno 20$anioantant"=>array(
			'campo'=>"ED$anioantant",
			'rangos'=>criteriodesdesql(&$sql, 'empleados',  "ED$anioantant")
			
		),
		"Nivel de ingles"=>array(
			'campo'=>"ExamenTOEIC",
			'rangos'=>array(
				'Principiante'=>array('mayoroigual'=>10,'menoroigual'=>250, 'igual'=>null),
				'Elemental'=>array('mayoroigual'=>251,'menoroigual'=>400, 'igual'=>null),
				'Intermedio'=>array('mayoroigual'=>401,'menoroigual'=>600, 'igual'=>null),
				'Habilidad Laboral Intermedia'=>array('mayoroigual'=>601,'menoroigual'=>780, 'igual'=>null),
				'Habilidad Laboral Avanzada'=>array('mayoroigual'=>781,'menoroigual'=>900, 'igual'=>null),
				'Habilidad Profesional Avanzada'=>array('mayoroigual'=>901,'menoroigual'=>990, 'igual'=>null)
			)
		),
		"Terman"=>array(
			'campo'=>"TermanCI",
			'rangos'=>array(
				'Inferior'=>array('mayoroigual'=>50,'menoroigual'=>92, 'igual'=>null),
				"Inferior al TM"=>array('mayoroigual'=>93,'menoroigual'=>99, 'igual'=>null),
				'T&eacute;rmino Medio-Bajo'=>array('mayoroigual'=>100,'menoroigual'=>105, 'igual'=>null),
				'T&eacute;rmino Medio'=>array('mayoroigual'=>106,'menoroigual'=>110, 'igual'=>null),
				'T&eacute;rmino Medio-Alto'=>array('mayoroigual'=>111,'menoroigual'=>115, 'igual'=>null),
				"Superior al TM"=>array('mayoroigual'=>116,'menoroigual'=>120, 'igual'=>null),
				'Superior'=>array('mayoroigual'=>121,'menoroigual'=>null, 'igual'=>null)
			)
		),
		'Mas de 25 anios en la empresa'=>array(
			'campo'=>'antiguedadcompania',
			'rangos'=>array(
				'25 o mas a&ntilde;os'=>array('mayoroigual'=>25,'menoroigual'=>null, 'igual'=>null)
			)
		),
		'5 anios o mas en el puesto'=>array(
			'campo'=>'antiguedadpuesto',
			'rangos'=>array(
				'5 o mas a&ntilde;os'=>array('mayoroigual'=>5,'menoroigual'=>null, 'igual'=>null)
			)
		),
		'1 anios o menos en el puesto'=>array(
			'campo'=>'antiguedadpuesto',
			'rangos'=>array(
				'1 o menos a&ntilde;os'=>array('mayoroigual'=>null,'menoroigual'=>1, 'igual'=>null)
			)
		)
	);
	
$criteriosgraficador=array_combine(array_keys($Criterios),array_keys($Criterios));


//sort($criteriosgraficador);
/*
Criterios:
--Género
--Edos. Promocionales
--División
--Área
--Zona
--Unidad Operativa
--Edad (rangos)       EstadoCivil
--Edo. Civil
--Antigüedad en Puesto (rangos)
--Antigüedad en Empresa (rangos)
--Evaluación desempeño (año corriente)
--Evaluación desempeño (año corriente -1 )
-Evaluación en Junta de Planeación (mapeados/pendientes)
--Nivel de inglés
-Status de Tabla de reemplazo (con tablas, sin tablas)

* Coeficiente Intelectual
* Eqi
* Status Agenda de Desarrollo
* Calidad Organizacional
* Tipo de Puesto
* APP (rangos)

** CLEAVER
** ALIV, etc  por rangos en cada variable
( EJ. todos los que tengan la combinación de habilidades intelectuales arriba de 110, con un analítico entre 80 y 90, y un visionario mayor a 70)

-	Data Grid de tabla de datos de gráfica actual
-	Exportador de datos a excel (botón dowload tabla de datos de gráfica actual

*/

//$criteriosgraficador['Genero']='Genero';
////$criteriosgraficador['genero']=$sql->cuentadiferentesdeuncampo('empleadosypuestos','Genero',$where);
//
//$criteriosgraficador["EdoPromocional20$anio"]="EdoPromocional20$anio";
////$criteriosgraficador["EdoPromocional20$anio"]=$sql->cuentadiferentesdeuncampo('empleadosypuestos',"EdoPromocional20$anio",$where);
//
//$temp="EdoPromocional20".sprintf("%02s", $anio-1);
//$temp=trim($temp);
//$criteriosgraficador[$temp]=$temp;
////$criteriosgraficador[$temp]=$sql->cuentadiferentesdeuncampo('empleadosypuestos',$temp,$where);
//
//$criteriosgraficador['Division']='Division';
////$criteriosgraficador['Division']=$sql->cuentadiferentesdeuncampo('empleadosypuestos','Division',$where);
//
//$criteriosgraficador['Area']='Area';
////$criteriosgraficador['Area']=$sql->cuentadiferentesdeuncampo('empleadosypuestos','Area',$where);
//
//$criteriosgraficador['Zona']='Zona';
////$criteriosgraficador['Zona']=$sql->cuentadiferentesdeuncampo('empleadosypuestos','Zona',$where);
//
//$criteriosgraficador['rangodeedad']='Rango de edad';
//$criteriosgraficador['rangodeedad']=$sql->cuentadiferentesdeuncampo('edadesporrango','rangodeedad',$where);


//$criterios['division']=$sql->cuentadiferentesdeuncampo('empleadosypuestos','division',$where);
//$criterios['division']=$sql->cuentadiferentesdeuncampo('empleadosypuestos','division',$where);
//$criterios['division']=$sql->cuentadiferentesdeuncampo('empleadosypuestos','division',$where);
//$criterios['division']=$sql->cuentadiferentesdeuncampo('empleadosypuestos','division',$where);

//chek($criterios);	
	








//---------------------pal titulo


	$Perfilesllavevalor=$sql->queryArregloKeyUNI("Select distinct NoPerfil, NombrePerfil from perfiles ");


?>