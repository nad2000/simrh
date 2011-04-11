<?php

$globalDB='simrh';
$globalDBusr='root';
$globalDBpwd='';
$globalDBhost='localhost';



////-------------------------
	$itemsporpagina=50;	

//-------------------------------------------------
$arreglodearreglosparacedula=Array('DatosPersonales','HistorialLaboral','HistorialAcademico','DatosPuesto','DISCObserbablePerfil','KostikPerfil','ALIVPerfil','CLEAVER','KOSTIK','ProcesoPensante','BARSIT','EQI','INTERESESPersonales','TERMAN','a360_actual','a360_anterior','AGENDA_DE_DESARROLLO_actual','AGENDA_DE_DESARROLLO_anterior','APP','ASSESSMENT_actual','ASSESSMENT_anterior','FEEDBACK');
	
	
$DatosPersonales=Array('NoPersonal','NombreEmpleado','EstadoCivil','FechadeAlta','FechadeNacimiento','Genero','NombrePuesto','FechadeIngresoaPuestoActual');	
$HistorialLaboral=Array('FechadeIngresoaPuesto1','FechadeIngresoaPuesto2','FechadeIngresoaPuesto3','FechadeIngresoaPuesto4','Puesto1','Puesto2','Puesto3','Puesto4');	
$HistorialAcademico=Array('ExamenTOEIC','EstilodeAprendizaje','Escolaridad1','StatusdeEscolaridad1','Escolaridad2','StatusdeEscolaridad2','Escolaridad3','StatusdeEscolaridad3','Escolaridad4','StatusdeEscolaridad4','Escolaridad5','StatusdeEscolaridad5');

$DatosPuesto=Array('NombrePuesto','Area','Division','UnidadOperativa','Zona','Niveldelpuesto','NombrePerfil','TipodePuesto');	
	$DISCObserbablePerfil=Array('CObservable','DObservable','IObservable','SObservable');	
	$KostikPerfil=Array('LKostik','PKostik','IKostik','TKostik','VKostik','XKostik','SKostik','BKostik','OKostik','RKostik','DKostik','CKostik','ZKostik','EKostik','KKostik','FKostik','WKostik','NKostik','GKostik','AKostik');	
	$ALIVPerfil=Array('Analitico','Intuitivo','Logico','Visionario');	

$CLEAVER=array('DObservable','IObservable','SObservable','CObservable','DProyectable','IProyectable','SProyectable','CProyectable','DNatural','INatural','CNatural','SNatural');
$KOSTIK=array('LKostik','PKostik','IKostik','TKostik','VKostik','XKostik','SKostik','BKostik','OKostik','RKostik','DKostik','CKostik','ZKostik','EKostik','KKostik','FKostik','WKostik','NKostik','GKostik','AKostik');
$ProcesoPensante=array('Analitico','Intuitivo','Logico','Visionario');
$BARSIT=array('Indicedeinteligencia','InformacionBarsit','RazonamientoVerbal','RazonamientoNumerico','Razonamimentologico');
$EQI=array('EQAdaptabilidad','EQEstadodeAnimo','EQInterpersonal','EQIntrapersonal','EQManejodeEstres','EQTotal');
$INTERESESPersonales=array('Teorico','Economico','Artistico','Social','Politico','Regulatorio');
$TERMAN=array('Informacion','Juicio','Vocabulario','Sintesis','Concentracion','Analsis','Abstraccion','Planeacion','Organizacion','Atencion','TermanCI');

//$a360_actual=array('AdaptabilidadCultural360act','ConstruirCultura360act','Delegacion360act','DesarrollarRelacionesEstrategicas360act','DesarrollodeTalento360act','DireccionEstrategica360act','EjecucionImpecable360act','EnfoquealCliente360act','Integridad360act','LiderazgodeCambio360act','LiderazgodeInfluencia360act','OrientacionaResultados360act','PerspicaciadeNegocio360act','PerspicaciaGlobal360act','TomadeDecisionesOperacionales360act','ValoresCentralesFemco360act','VenderlaVision360act');
//$a360_anterior=array('AdaptabilidadCultural360ant','ConstruirCultura360ant','Delegacion360ant','DesarrollarRelacionesEstrategicas360ant','DesarrollodeTalento360ant','DireccionEstrategica360ant','EjecucionImpecable360ant','EnfoquealCliente360ant','Integridad360ant','LiderazgodeCambio360ant','LiderazgodeInfluencia360ant','OrientacionaResultados360ant','PerspicaciadeNegocio360ant','PerspicaciaGlobal360ant','TomadeDecisionesOperacionales360ant','ValoresCentralesFemco360ant','VenderlaVision360ant');

$a360_07=array('IniciativayProactividad36007','Innovacionycreatividad36007','Armonizacion36007','SentidoComun36007','Motivacion36007','Visionestrategica36007','Vocaciondeservicio36007','Respeto36007','Etica36007','Empuje36007','Empatia36007','Orientacionaresultados36007','Analisis36007','Comunicacion36007','Prudencia36007','Negociacion36007','Coaching36007','Formaciondecultura36007','Analisisdesistematotal36007','VentadeIdeas36007','Valoracionderiesgos36007','Facilitacion36007','Facultamiento36007','EjecucionEstrategica36007','Aseguramientoderesultados36007','TomadeDecisiones36007');

$a360_09=array('AdaptabilidadCultural36009','ConstruirCultura36009','Delegacion36009','DesarrollarRelacionesEstrategicas36009','DesarrollodeTalento36009','DireccionEstrategica36009','EjecucionImpecable36009','EnfoquealCliente36009','Integridad36009','LiderazgodeCambio36009','LiderazgodeInfluencia36009','OrientacionaResultados36009','PerspicaciadeNegocio36009','PerspicaciaGlobal36009','TomadeDecisionesOperacionales36009','ValoresCentralesFemco36009','VenderlaVision36009');
$a360_11=array('AdaptabilidadCultural36011','ConstruirCultura36011','Delegacion36011','DesarrollarRelacionesEstrategicas36011','DesarrollodeTalento36011','DireccionEstrategica36011','EjecucionImpecable36011','EnfoquealCliente36011','Integridad36011','LiderazgodeCambio36011','LiderazgodeInfluencia36011','OrientacionaResultados36011','PerspicaciadeNegocio36011','PerspicaciaGlobal36011','TomadeDecisionesOperacionales36011','ValoresCentralesFemco36011','VenderlaVision36011');
$a360_13=array('AdaptabilidadCultural36013','ConstruirCultura36013','Delegacion36013','DesarrollarRelacionesEstrategicas36013','DesarrollodeTalento36013','DireccionEstrategica36013','EjecucionImpecable36013','EnfoquealCliente36013','Integridad36013','LiderazgodeCambio36013','LiderazgodeInfluencia36013','OrientacionaResultados36013','PerspicaciadeNegocio36013','PerspicaciaGlobal36013','TomadeDecisionesOperacionales36013','ValoresCentralesFemco36013','VenderlaVision36013');

//$AGENDA_DE_DESARROLLO_actual=array('Competencias20act','Programas20act','Avance20act');
//$AGENDA_DE_DESARROLLO_anterior=array('Competencias20ant','Programas20ant','Avance20ant');

$AGENDA_DE_DESARROLLO_2008=array('Competencias2008','Programas2008','Avance2008');
$AGENDA_DE_DESARROLLO_2009=array('Competencias2009','Programas2009','Avance2009');
$AGENDA_DE_DESARROLLO_2010=array('Competencias2010','Programas2010','Avance2010');
$AGENDA_DE_DESARROLLO_2011=array('Competencias2011','Programas2011','Avance2011');
$AGENDA_DE_DESARROLLO_2012=array('Competencias2012','Programas2012','Avance2012');
$AGENDA_DE_DESARROLLO_2013=array('Competencias2013','Programas2013','Avance2013');
$AGENDA_DE_DESARROLLO_2014=array('Competencias2014','Programas2014','Avance2014');

$APP=array('APP',"ED$anioant","ED$anioantant");

//$ASSESSMENT_actual=array('ConocerTransformarInnovacionASSESSMENT20act','DesarrollodeTalentoCoachingASSESSMENT20act','DireccionEstrategicaASSESSMENT20act','EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT20act','EjecucionImpecableASSESSMENT20act','GenerarValorASSESSMENT20act','LiderazgoeInfluenciaASSESSMENT20act','NegociacionASSESSMENT20act','OrientacionaResultadosASSESSMENT20act','VisiondeNegocioASSESSMENT20act');
//$ASSESSMENT_anterior=array('ConocerTransformarInnovacionASSESSMENT20ant','DesarrollodeTalentoCoachingASSESSMENT20ant','DireccionEstrategicaASSESSMENT20ant','EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT20ant','EjecucionImpecableASSESSMENT20ant','GenerarValorASSESSMENT20ant','LiderazgoeInfluenciaASSESSMENT20ant','NegociacionASSESSMENT20ant','OrientacionaResultadosASSESSMENT20ant','VisiondeNegocioASSESSMENT20ant');

$ASSESSMENT_2007=array('ConocerTransformarInnovacionASSESSMENT2007','DesarrollodeTalentoCoachingASSESSMENT2007','DireccionEstrategicaASSESSMENT2007','EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2007','EjecucionImpecableASSESSMENT2007','GenerarValorASSESSMENT2007','LiderazgoeInfluenciaASSESSMENT2007','NegociacionASSESSMENT2007','OrientacionaResultadosASSESSMENT2007','VisiondeNegocioASSESSMENT2007');
$ASSESSMENT_2010=array('ConocerTransformarInnovacionASSESSMENT2010','DesarrollodeTalentoCoachingASSESSMENT2010','DireccionEstrategicaASSESSMENT2010','EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2010','EjecucionImpecableASSESSMENT2010','GenerarValorASSESSMENT2010','LiderazgoeInfluenciaASSESSMENT2010','NegociacionASSESSMENT2010','OrientacionaResultadosASSESSMENT2010','VisiondeNegocioASSESSMENT2010');
$ASSESSMENT_2013=array('ConocerTransformarInnovacionASSESSMENT2013','DesarrollodeTalentoCoachingASSESSMENT2013','DireccionEstrategicaASSESSMENT2013','EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2013','EjecucionImpecableASSESSMENT2013','GenerarValorASSESSMENT2013','LiderazgoeInfluenciaASSESSMENT2013','NegociacionASSESSMENT2013','OrientacionaResultadosASSESSMENT2013','VisiondeNegocioASSESSMENT2013');




$FEEDBACK=array('Fortalezas','Oportunidadesdemejora','Sujerenciasdedesarrollo');


	
	
//-------------------------------------------------

$camposdatosSAPempleadosypuestos=array('NoPersonal','NombreEmpleado','EstadoCivil','FechadeAlta','FechadeNacimiento','Genero','NombrePuesto','NoPuesto');
//,'FechadeIngresoaPuestoActual','FechadeIngresoaPuesto1','FechadeIngresoaPuesto2','FechadeIngresoaPuesto3','FechadeIngresoaPuesto4','Puesto1','Puesto2','Puesto3','Puesto4');

$camposdatosSAPempleados=array('NoPersonal','NombreEmpleado','EstadoCivil','FechadeAlta','FechadeNacimiento','Genero','NoPuesto','FechadeIngresoaPuestoActual','FechadeIngresoaPuesto1','FechadeIngresoaPuesto2','FechadeIngresoaPuesto3','FechadeIngresoaPuesto4','Puesto1','Puesto2','Puesto3','Puesto4');

$camposdatosSAPuestos=array('NoPuesto','NombrePuesto'); //'NombrePuesto','Idpuestoactual'

$camposdatosRHpuestos=array('NoPuesto','NombrePuesto','Area','Division','UnidadOperativa','Zona','Niveldelpuesto','PerfilTipo','TipodePuesto');

$camposdatosRHperfiles=array('NoPerfil','NombrePerfil','CObservable','DObservable','IObservable','SObservable','LKostik','PKostik','IKostik','TKostik','VKostik','XKostik','SKostik','BKostik','OKostik','RKostik','DKostik','CKostik','ZKostik','EKostik','KKostik','FKostik','WKostik','NKostik','GKostik','AKostik','Analitico','Intuitivo','Logico','Visionario');

$camposFEMSAempleadosporconcepto=array(
		
		'CLEAVER'=>array('DObservable','IObservable','SObservable','CObservable','DProyectable','IProyectable','SProyectable','CProyectable','DNatural','INatural','CNatural','SNatural'),
		'KOSTIK'=>array('LKostik','PKostik','IKostik','TKostik','VKostik','XKostik','SKostik','BKostik','OKostik','RKostik','DKostik','CKostik','ZKostik','EKostik','KKostik','FKostik','WKostik','NKostik','GKostik','AKostik'),
		'PROCESO PENSANTE'=>array('Analitico','Intuitivo','Logico','Visionario'),
		'BARSIT'=>array('Indicedeinteligencia','InformacionBarsit','RazonamientoVerbal','RazonamientoNumerico','Razonamimentologico'),
		'EQI'=>array('EQAdaptabilidad','EQEstadodeAnimo','EQInterpersonal','EQIntrapersonal','EQManejodeEstres','EQTotal'),
		'INTERESES Personales'=>array('Teorico','Economico','Artistico','Social','Politico','Regulatorio'),
		'TERMAN'=>array('Informacion','Juicio','Vocabulario','Sintesis','Concentracion','Analsis','Abstraccion','Planeacion','Organizacion','Atencion','TermanCI'),
		'360-2007'=>array('IniciativayProactividad36007','Innovacionycreatividad36007','Armonizacion36007','SentidoComun36007','Motivacion36007','Visionestrategica36007','Vocaciondeservicio36007','Respeto36007','Etica36007','Empuje36007','Empatia36007','Orientacionaresultados36007','Analisis36007','Comunicacion36007','Prudencia36007','Negociacion36007','Coaching36007','Formaciondecultura36007','Analisisdesistematotal36007','VentadeIdeas36007','Valoracionderiesgos36007','Facilitacion36007','Facultamiento36007','EjecucionEstrategica36007','Aseguramientoderesultados36007','TomadeDecisiones36007'),
		'360-2009'=>array('AdaptabilidadCultural36009','ConstruirCultura36009','Delegacion36009','DesarrollarRelacionesEstrategicas36009','DesarrollodeTalento36009','DireccionEstrategica36009','EjecucionImpecable36009','EnfoquealCliente36009','Integridad36009','LiderazgodeCambio36009','LiderazgodeInfluencia36009','OrientacionaResultados36009','PerspicaciadeNegocio36009','PerspicaciaGlobal36009','TomadeDecisionesOperacionales36009','ValoresCentralesFemco36009','VenderlaVision36009'),
		'360-2011'=>array('AdaptabilidadCultural36011','ConstruirCultura36011','Delegacion36011','DesarrollarRelacionesEstrategicas36011','DesarrollodeTalento36011','DireccionEstrategica36011','EjecucionImpecable36011','EnfoquealCliente36011','Integridad36011','LiderazgodeCambio36011','LiderazgodeInfluencia36011','OrientacionaResultados36011','PerspicaciadeNegocio36011','PerspicaciaGlobal36011','TomadeDecisionesOperacionales36011','ValoresCentralesFemco36011','VenderlaVision36011'),
		'360-2013'=>array('AdaptabilidadCultural36013','ConstruirCultura36013','Delegacion36013','DesarrollarRelacionesEstrategicas36013','DesarrollodeTalento36013','DireccionEstrategica36013','EjecucionImpecable36013','EnfoquealCliente36013','Integridad36013','LiderazgodeCambio36013','LiderazgodeInfluencia36013','OrientacionaResultados36013','PerspicaciadeNegocio36013','PerspicaciaGlobal36013','TomadeDecisionesOperacionales36013','ValoresCentralesFemco36013','VenderlaVision36013')

	 );
	 
	 	 
$camposdatosFEMSAempleados=array_flatten($camposFEMSAempleadosporconcepto);
$camposdatosFEMSAempleados=array_merge(array('NoPersonal','NombreEmpleado'),$camposdatosFEMSAempleados);


//----------------------------------------------


$camposRHempleadosporconcepto=array(
		
		'AGENDA DE DESARROLLO 2008'=>array('Competencias2008','Programas2008','Avance2008'),
		'AGENDA DE DESARROLLO 2009'=>array('Competencias2009','Programas2009','Avance2009'),
		'AGENDA DE DESARROLLO 2010'=>array('Competencias2010','Programas2010','Avance2010'),
		'AGENDA DE DESARROLLO 2011'=>array('Competencias2011','Programas2011','Avance2011'),
		'AGENDA DE DESARROLLO 2012'=>array('Competencias2012','Programas2012','Avance2012'),
		'AGENDA DE DESARROLLO 2013'=>array('Competencias2013','Programas2013','Avance2013'),
		'AGENDA DE DESARROLLO 2014'=>array('Competencias2014','Programas2014','Avance2014'),
		'APP'=>array('APP','ED07','ED08','ED09','ED10','ED11','ED12','ED13','ED14'),
		'ASSESSMENT 2007'=>array('ConocerTransformarInnovacionASSESSMENT2007','DesarrollodeTalentoCoachingASSESSMENT2007','DireccionEstrategicaASSESSMENT2007','EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2007','EjecucionImpecableASSESSMENT2007','GenerarValorASSESSMENT2007','LiderazgoeInfluenciaASSESSMENT2007','NegociacionASSESSMENT2007','OrientacionaResultadosASSESSMENT2007','VisiondeNegocioASSESSMENT2007'),
		'ASSESSMENT 2010'=>array('ConocerTransformarInnovacionASSESSMENT2010','DesarrollodeTalentoCoachingASSESSMENT2010','DireccionEstrategicaASSESSMENT2010','EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2010','EjecucionImpecableASSESSMENT2010','GenerarValorASSESSMENT2010','LiderazgoeInfluenciaASSESSMENT2010','NegociacionASSESSMENT2010','OrientacionaResultadosASSESSMENT2010','VisiondeNegocioASSESSMENT2010'),
		'ASSESSMENT 2013'=>array('ConocerTransformarInnovacionASSESSMENT2013','DesarrollodeTalentoCoachingASSESSMENT2013','DireccionEstrategicaASSESSMENT2013','EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2013','EjecucionImpecableASSESSMENT2013','GenerarValorASSESSMENT2013','LiderazgoeInfluenciaASSESSMENT2013','NegociacionASSESSMENT2013','OrientacionaResultadosASSESSMENT2013','VisiondeNegocioASSESSMENT2013'),
		'FEEDBACK'=>array('Fortalezas','Oportunidadesdemejora'),
		'INGLES'=>array('ExamenTOEIC'),
		'OTRAS EVALUACIONES'=>array('EstilodeAprendizaje'),
		
		'ESCOLARIDAD1'=>array('Escolaridad1','StatusdeEscolaridad1'),
		'ESCOLARIDAD2'=>array('Escolaridad2','StatusdeEscolaridad2'),
		'ESCOLARIDAD3'=>array('Escolaridad3','StatusdeEscolaridad3'),
		'ESCOLARIDAD4'=>array('Escolaridad4','StatusdeEscolaridad4'),
		'ESCOLARIDAD5'=>array('Escolaridad5','StatusdeEscolaridad5'),
		
		'Puesto Actual'=>array('FechadeIngresoaPuestoActual'),
		'Puesto 1'=>array('Puesto1','FechadeIngresoaPuesto1'),
		'Puesto 2'=>array('Puesto2','FechadeIngresoaPuesto2'),
		'Puesto 3'=>array('Puesto3','FechadeIngresoaPuesto3'),
		'Puesto 4'=>array('Puesto4','FechadeIngresoaPuesto4')
	);
$camposdatosRHempleados=array_flatten($camposRHempleadosporconcepto);
$camposdatosRHempleados=array_merge(array('NoPersonal','NombreEmpleado'),$camposdatosRHempleados);


//---------------------
	$campossalidagrid=array();

	$campossalidagrid[]=new camposalidaLinkEmpleado('&nbsp;','<img src="./imagenes/bonton_sim.jpg" />','simulador.php','idempleado','NoPersonal',null,'38');
	if($urlpagina=='simulador'&& $idempleado ){$campossalidagrid[]=new camposalidaLink('&nbsp;','<img src="./pics/trImg.jpg" />','simulador.php','idcandidato','NoPersonal',null,'38');}	
	$campossalidagrid[]=new camposalidaLinkPopUpNombre('Empleado','NombreEmpleado','cedula.php','idempleado','NoPersonal','Cedula','122');
	$campossalidagrid[]=new camposalida('Puesto','NombrePuesto','122');
	$campossalidagrid[]=new camposalida('Perfil','NombrePerfil','72');	
	$campossalidagrid[]=new camposalida('Tipo','TipodePuesto','72');
	$campossalidagrid[]=new camposalida('Divisi&oacute;n','Division','72');
	$campossalidagrid[]=new camposalida('&Aacute;rea','Area','92');
	$campossalidagrid[]=new camposalida('Zona','Zona','92');
	$campossalidagrid[]=new camposalida('Unidad','UnidadOperativa');


//------------------------------	


	$campossalidajuntas[]=new camposalida('Campo','Campo');
	$campossalidajuntas[]=new camposalida('del empleado','empleado');
	$campossalidajuntas[]=new camposalida('al valor','NuevoValor');

	
	$campossalidalistadodejuntas[]=new camposalidaLink('Junta','id','reportedejunta.php','idjunta','id','_blank');
	$campossalidalistadodejuntas[]=new camposalida('Division','division');
	$campossalidalistadodejuntas[]=new camposalida('Zona','zona');
	$campossalidalistadodejuntas[]=new camposalida('Unidad<br />Operativa','unidadoperativa');
	$campossalidalistadodejuntas[]=new camposalida('Responsable','responsable');
	$campossalidalistadodejuntas[]=new camposalida('Fecha','fecha');
	
	
	//-Id, division, Zona, UnOp, responsable nombre(NoPersonal), fecha.

	
///----------------Graficador


	
//----------------------------------------------------------------------------------------

	$opcionesdeestadospromocionales=array(''=>'--','AP'=>'AP','PROM'=>'PROM','EST'=>'EST','FOCO ROJO'=>'FOCO ROJO','MO'=>'MO','Por jubilarse'=>'Por jubilarse');
	
	$opcionesdetemporalidad=array(''=>'--','0 - 12 meses'=>'0 - 12 meses','13 - 24 meses'=>'13 - 24 meses','25 - 36 meses'=>'25 - 36 meses');
	
	//$opcionesevaluaciondesempenio=array(''=>'--','B'=>'B','C-'=>'C-','C'=>'C','C+'=>'C+','D'=>'D');
	
	$opciones9BXS=array(''=>'--','TALENTO TOP'=>'TALENTO TOP','TALENTO PROMOVIBLE POTENCIAL'=>'TALENTO PROMOVIBLE POTENCIAL','TALENTO COLUMNA'=>'TALENTO COLUMNA','TALENTO POR PROBAR'=>'TALENTO POR PROBAR','SEGUIMIENTO'=>'SEGUIMIENTO','TALENTO PROMOVIBLE'=>'TALENTO PROMOVIBLE','TALENTO EN CONSOLIDACION'=>'TALENTO EN CONSOLIDACION','COLUMNA EN CONSOLIDACION'=>'COLUMNA EN CONSOLIDACION','CASO CRITICO'=>'CASO CRITICO','REVISION'=>'REVISION');
	
	$tablasdecamposeditables['EdoPromocional2007']='empleados';
	$tablasdecamposeditables['EdoPromocional2008']='empleados';
	$tablasdecamposeditables['EdoPromocional2009']='empleados';
	$tablasdecamposeditables['EdoPromocional2010']='empleados';
	$tablasdecamposeditables['EdoPromocional2011']='empleados';
	$tablasdecamposeditables['EdoPromocional2012']='empleados';
	$tablasdecamposeditables['EdoPromocional2013']='empleados';
	$tablasdecamposeditables['EdoPromocional2014']='empleados';
	
	$tablasdecamposeditables['ComentariosJunta2007']='empleados';
	$tablasdecamposeditables['ComentariosJunta2008']='empleados';
	$tablasdecamposeditables['ComentariosJunta2009']='empleados';
	$tablasdecamposeditables['ComentariosJunta2010']='empleados';
	$tablasdecamposeditables['ComentariosJunta2011']='empleados';
	$tablasdecamposeditables['ComentariosJunta2012']='empleados';
	$tablasdecamposeditables['ComentariosJunta2013']='empleados';
	$tablasdecamposeditables['ComentariosJunta2014']='empleados';

	$tablasdecamposeditables['Temporalidad2007']='empleados';
	$tablasdecamposeditables['Temporalidad2008']='empleados';
	$tablasdecamposeditables['Temporalidad2009']='empleados';
	$tablasdecamposeditables['Temporalidad2009']='empleados';
	$tablasdecamposeditables['Temporalidad2010']='empleados';
	$tablasdecamposeditables['Temporalidad2011']='empleados';
	$tablasdecamposeditables['Temporalidad2012']='empleados';
	$tablasdecamposeditables['Temporalidad2013']='empleados';
	$tablasdecamposeditables['Temporalidad2014']='empleados';
	
	$tablasdecamposeditables['Sugerenciasdedesarrollo2014']='empleados';
	$tablasdecamposeditables['Sugerenciasdedesarrollo2013']='empleados';
	$tablasdecamposeditables['Sugerenciasdedesarrollo2012']='empleados';
	$tablasdecamposeditables['Sugerenciasdedesarrollo2011']='empleados';
	$tablasdecamposeditables['Sugerenciasdedesarrollo2010']='empleados';
	$tablasdecamposeditables['Sugerenciasdedesarrollo2009']='empleados';
	$tablasdecamposeditables['Sugerenciasdedesarrollo2008']='empleados';
	$tablasdecamposeditables['Sugerenciasdedesarrollo2007']='empleados';

	$tablasdecamposeditables['OtrasPosiciones']='empleados';
	$tablasdecamposeditables['9BXS07']='empleados';
	$tablasdecamposeditables['9BXS08']='empleados';
	$tablasdecamposeditables['9BXS09']='empleados';
	$tablasdecamposeditables['9BXS10']='empleados';
	$tablasdecamposeditables['9BXS11']='empleados';
	$tablasdecamposeditables['9BXS12']='empleados';
	$tablasdecamposeditables['9BXS13']='empleados';
	$tablasdecamposeditables['9BXS14']='empleados';
	
	$tablasdecamposeditables['Salidaencontroplazo']='empleados';
	$tablasdecamposeditables['CometariosSalidaencontroplazo']='empleados';
	
	$tablasdecamposeditables['Fortalezas']='empleados';
	
	$tablasdecamposeditables['Oportunidadesdemejora']='empleados';
	
	
	

	

	

?>