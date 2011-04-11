<?php



function procesaempleadosypuestos()
{
	
	global $sql;
	
	$sql->query('drop table IF EXISTS empleadosypuestos');
	$sql->query("create table empleadosypuestos select `empleados`.`NoPersonal` AS `NoPersonal`,`empleados`.`NombreEmpleado` AS `NombreEmpleado`,`empleados`.`EstadoCivil` AS `EstadoCivil`,`empleados`.`FechadeAlta` AS `FechadeAlta`,`empleados`.`FechadeNacimiento` AS `FechadeNacimiento`,`empleados`.`Genero` AS `Genero`,`empleados`.`NoPuesto` AS `NoPuesto`,`empleados`.`FechadeIngresoaPuestoActual` AS `FechadeIngresoaPuestoActual`,`empleados`.`FechadeIngresoaPuesto1` AS `FechadeIngresoaPuesto1`,`empleados`.`FechadeIngresoaPuesto2` AS `FechadeIngresoaPuesto2`,`empleados`.`FechadeIngresoaPuesto3` AS `FechadeIngresoaPuesto3`,`empleados`.`FechadeIngresoaPuesto4` AS `FechadeIngresoaPuesto4`,`empleados`.`Puesto1` AS `Puesto1`,`empleados`.`Puesto2` AS `Puesto2`,`empleados`.`Puesto3` AS `Puesto3`,`empleados`.`Puesto4` AS `Puesto4`,`empleados`.`StatusSAP` AS `StatusSAP`,`empleados`.`DObservable` AS `DObservable`,`empleados`.`IObservable` AS `IObservable`,`empleados`.`SObservable` AS `SObservable`,`empleados`.`CObservable` AS `CObservable`,`empleados`.`DProyectable` AS `DProyectable`,`empleados`.`IProyectable` AS `IProyectable`,`empleados`.`SProyectable` AS `SProyectable`,`empleados`.`CProyectable` AS `CProyectable`,`empleados`.`DNatural` AS `DNatural`,`empleados`.`INatural` AS `INatural`,`empleados`.`CNatural` AS `CNatural`,`empleados`.`SNatural` AS `SNatural`,`empleados`.`EQAdaptabilidad` AS `EQAdaptabilidad`,`empleados`.`EQEstadodeAnimo` AS `EQEstadodeAnimo`,`empleados`.`EQInterpersonal` AS `EQInterpersonal`,`empleados`.`EQIntrapersonal` AS `EQIntrapersonal`,`empleados`.`EQManejodeEstres` AS `EQManejodeEstres`,`empleados`.`EQTotal` AS `EQTotal`,`empleados`.`Teorico` AS `Teorico`,`empleados`.`Economico` AS `Economico`,`empleados`.`Artistico` AS `Artistico`,`empleados`.`Social` AS `Social`,`empleados`.`Politico` AS `Politico`,`empleados`.`Regulatorio` AS `Regulatorio`,`empleados`.`LKostik` AS `LKostik`,`empleados`.`PKostik` AS `PKostik`,`empleados`.`IKostik` AS `IKostik`,`empleados`.`TKostik` AS `TKostik`,`empleados`.`VKostik` AS `VKostik`,`empleados`.`XKostik` AS `XKostik`,`empleados`.`SKostik` AS `SKostik`,`empleados`.`BKostik` AS `BKostik`,`empleados`.`OKostik` AS `OKostik`,`empleados`.`RKostik` AS `RKostik`,`empleados`.`DKostik` AS `DKostik`,`empleados`.`CKostik` AS `CKostik`,`empleados`.`ZKostik` AS `ZKostik`,`empleados`.`EKostik` AS `EKostik`,`empleados`.`KKostik` AS `KKostik`,`empleados`.`FKostik` AS `FKostik`,`empleados`.`WKostik` AS `WKostik`,`empleados`.`NKostik` AS `NKostik`,`empleados`.`GKostik` AS `GKostik`,`empleados`.`AKostik` AS `AKostik`,`empleados`.`Analitico` AS `Analitico`,`empleados`.`Intuitivo` AS `Intuitivo`,`empleados`.`Logico` AS `Logico`,`empleados`.`Visionario` AS `Visionario`,`empleados`.`Informacion` AS `Informacion`,`empleados`.`Juicio` AS `Juicio`,`empleados`.`Vocabulario` AS `Vocabulario`,`empleados`.`Sintesis` AS `Sintesis`,`empleados`.`Concentracion` AS `Concentracion`,`empleados`.`Analsis` AS `Analsis`,`empleados`.`Abstraccion` AS `Abstraccion`,`empleados`.`Planeacion` AS `Planeacion`,`empleados`.`Organizacion` AS `Organizacion`,`empleados`.`Atencion` AS `Atencion`,`empleados`.`TermanCI` AS `TermanCI`,`empleados`.`Indicedeinteligencia` AS `Indicedeinteligencia`,`empleados`.`InformacionBarsit` AS `InformacionBarsit`,`empleados`.`RazonamientoVerbal` AS `RazonamientoVerbal`,`empleados`.`RazonamientoNumerico` AS `RazonamientoNumerico`,`empleados`.`Razonamimentologico` AS `Razonamimentologico`,`empleados`.`IniciativayProactividad36007` AS `IniciativayProactividad36007`,`empleados`.`Innovacionycreatividad36007` AS `Innovacionycreatividad36007`,`empleados`.`Armonizacion36007` AS `Armonizacion36007`,`empleados`.`SentidoComun36007` AS `SentidoComun36007`,`empleados`.`Motivacion36007` AS `Motivacion36007`,`empleados`.`Visionestrategica36007` AS `Visionestrategica36007`,`empleados`.`Vocaciondeservicio36007` AS `Vocaciondeservicio36007`,`empleados`.`Respeto36007` AS `Respeto36007`,`empleados`.`Etica36007` AS `Etica36007`,`empleados`.`Empuje36007` AS `Empuje36007`,`empleados`.`Empatia36007` AS `Empatia36007`,`empleados`.`Orientacionaresultados36007` AS `Orientacionaresultados36007`,`empleados`.`Analisis36007` AS `Analisis36007`,`empleados`.`Comunicacion36007` AS `Comunicacion36007`,`empleados`.`Prudencia36007` AS `Prudencia36007`,`empleados`.`Negociacion36007` AS `Negociacion36007`,`empleados`.`Coaching36007` AS `Coaching36007`,`empleados`.`Formaciondecultura36007` AS `Formaciondecultura36007`,`empleados`.`Analisisdesistematotal36007` AS `Analisisdesistematotal36007`,`empleados`.`VentadeIdeas36007` AS `VentadeIdeas36007`,`empleados`.`Valoracionderiesgos36007` AS `Valoracionderiesgos36007`,`empleados`.`Facilitacion36007` AS `Facilitacion36007`,`empleados`.`Facultamiento36007` AS `Facultamiento36007`,`empleados`.`EjecucionEstrategica36007` AS `EjecucionEstrategica36007`,`empleados`.`Aseguramientoderesultados36007` AS `Aseguramientoderesultados36007`,`empleados`.`TomadeDecisiones36007` AS `TomadeDecisiones36007`,`empleados`.`AdaptabilidadCultural36009` AS `AdaptabilidadCultural36009`,`empleados`.`ConstruirCultura36009` AS `ConstruirCultura36009`,`empleados`.`Delegacion36009` AS `Delegacion36009`,`empleados`.`DesarrollarRelacionesEstrategicas36009` AS `DesarrollarRelacionesEstrategicas36009`,`empleados`.`DesarrollodeTalento36009` AS `DesarrollodeTalento36009`,`empleados`.`DireccionEstrategica36009` AS `DireccionEstrategica36009`,`empleados`.`EjecucionImpecable36009` AS `EjecucionImpecable36009`,`empleados`.`EnfoquealCliente36009` AS `EnfoquealCliente36009`,`empleados`.`Integridad36009` AS `Integridad36009`,`empleados`.`LiderazgodeCambio36009` AS `LiderazgodeCambio36009`,`empleados`.`LiderazgodeInfluencia36009` AS `LiderazgodeInfluencia36009`,`empleados`.`OrientacionaResultados36009` AS `OrientacionaResultados36009`,`empleados`.`PerspicaciadeNegocio36009` AS `PerspicaciadeNegocio36009`,`empleados`.`PerspicaciaGlobal36009` AS `PerspicaciaGlobal36009`,`empleados`.`TomadeDecisionesOperacionales36009` AS `TomadeDecisionesOperacionales36009`,`empleados`.`ValoresCentralesFemco36009` AS `ValoresCentralesFemco36009`,`empleados`.`VenderlaVision36009` AS `VenderlaVision36009`,`empleados`.`AdaptabilidadCultural36011` AS `AdaptabilidadCultural36011`,`empleados`.`ConstruirCultura36011` AS `ConstruirCultura36011`,`empleados`.`Delegacion36011` AS `Delegacion36011`,`empleados`.`DesarrollarRelacionesEstrategicas36011` AS `DesarrollarRelacionesEstrategicas36011`,`empleados`.`DesarrollodeTalento36011` AS `DesarrollodeTalento36011`,`empleados`.`DireccionEstrategica36011` AS `DireccionEstrategica36011`,`empleados`.`EjecucionImpecable36011` AS `EjecucionImpecable36011`,`empleados`.`EnfoquealCliente36011` AS `EnfoquealCliente36011`,`empleados`.`Integridad36011` AS `Integridad36011`,`empleados`.`LiderazgodeCambio36011` AS `LiderazgodeCambio36011`,`empleados`.`LiderazgodeInfluencia36011` AS `LiderazgodeInfluencia36011`,`empleados`.`OrientacionaResultados36011` AS `OrientacionaResultados36011`,`empleados`.`PerspicaciadeNegocio36011` AS `PerspicaciadeNegocio36011`,`empleados`.`PerspicaciaGlobal36011` AS `PerspicaciaGlobal36011`,`empleados`.`TomadeDecisionesOperacionales36011` AS `TomadeDecisionesOperacionales36011`,`empleados`.`ValoresCentralesFemco36011` AS `ValoresCentralesFemco36011`,`empleados`.`VenderlaVision36011` AS `VenderlaVision36011`,`empleados`.`AdaptabilidadCultural36013` AS `AdaptabilidadCultural36013`,`empleados`.`ConstruirCultura36013` AS `ConstruirCultura36013`,`empleados`.`Delegacion36013` AS `Delegacion36013`,`empleados`.`DesarrollarRelacionesEstrategicas36013` AS `DesarrollarRelacionesEstrategicas36013`,`empleados`.`DesarrollodeTalento36013` AS `DesarrollodeTalento36013`,`empleados`.`DireccionEstrategica36013` AS `DireccionEstrategica36013`,`empleados`.`EjecucionImpecable36013` AS `EjecucionImpecable36013`,`empleados`.`EnfoquealCliente36013` AS `EnfoquealCliente36013`,`empleados`.`Integridad36013` AS `Integridad36013`,`empleados`.`LiderazgodeCambio36013` AS `LiderazgodeCambio36013`,`empleados`.`LiderazgodeInfluencia36013` AS `LiderazgodeInfluencia36013`,`empleados`.`OrientacionaResultados36013` AS `OrientacionaResultados36013`,`empleados`.`PerspicaciadeNegocio36013` AS `PerspicaciadeNegocio36013`,`empleados`.`PerspicaciaGlobal36013` AS `PerspicaciaGlobal36013`,`empleados`.`TomadeDecisionesOperacionales36013` AS `TomadeDecisionesOperacionales36013`,`empleados`.`ValoresCentralesFemco36013` AS `ValoresCentralesFemco36013`,`empleados`.`VenderlaVision36013` AS `VenderlaVision36013`,`empleados`.`Competencias2008` AS `Competencias2008`,`empleados`.`Programas2008` AS `Programas2008`,`empleados`.`Avance2008` AS `Avance2008`,`empleados`.`Competencias2009` AS `Competencias2009`,`empleados`.`Programas2009` AS `Programas2009`,`empleados`.`Avance2009` AS `Avance2009`,`empleados`.`Competencias2010` AS `Competencias2010`,`empleados`.`Programas2010` AS `Programas2010`,`empleados`.`Avance2010` AS `Avance2010`,`empleados`.`Competencias2011` AS `Competencias2011`,`empleados`.`Programas2011` AS `Programas2011`,`empleados`.`Avance2011` AS `Avance2011`,`empleados`.`Competencias2012` AS `Competencias2012`,`empleados`.`Programas2012` AS `Programas2012`,`empleados`.`Avance2012` AS `Avance2012`,`empleados`.`Competencias2013` AS `Competencias2013`,`empleados`.`Programas2013` AS `Programas2013`,`empleados`.`Avance2013` AS `Avance2013`,`empleados`.`Competencias2014` AS `Competencias2014`,`empleados`.`Programas2014` AS `Programas2014`,`empleados`.`Avance2014` AS `Avance2014`,`empleados`.`APP` AS `APP`,`empleados`.`ED07` AS `ED07`,`empleados`.`ED08` AS `ED08`,`empleados`.`ED09` AS `ED09`,`empleados`.`ED10` AS `ED10`,`empleados`.`ED11` AS `ED11`,`empleados`.`ED12` AS `ED12`,`empleados`.`ED13` AS `ED13`,`empleados`.`ED14` AS `ED14`,`empleados`.`ConocerTransformarInnovacionASSESSMENT2007` AS `ConocerTransformarInnovacionASSESSMENT2007`,`empleados`.`DesarrollodeTalentoCoachingASSESSMENT2007` AS `DesarrollodeTalentoCoachingASSESSMENT2007`,`empleados`.`DireccionEstrategicaASSESSMENT2007` AS `DireccionEstrategicaASSESSMENT2007`,`empleados`.`EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2007` AS `EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2007`,`empleados`.`EjecucionImpecableASSESSMENT2007` AS `EjecucionImpecableASSESSMENT2007`,`empleados`.`GenerarValorASSESSMENT2007` AS `GenerarValorASSESSMENT2007`,`empleados`.`LiderazgoeInfluenciaASSESSMENT2007` AS `LiderazgoeInfluenciaASSESSMENT2007`,`empleados`.`NegociacionASSESSMENT2007` AS `NegociacionASSESSMENT2007`,`empleados`.`OrientacionaResultadosASSESSMENT2007` AS `OrientacionaResultadosASSESSMENT2007`,`empleados`.`VisiondeNegocioASSESSMENT2007` AS `VisiondeNegocioASSESSMENT2007`,`empleados`.`ConocerTransformarInnovacionASSESSMENT2010` AS `ConocerTransformarInnovacionASSESSMENT2010`,`empleados`.`DesarrollodeTalentoCoachingASSESSMENT2010` AS `DesarrollodeTalentoCoachingASSESSMENT2010`,`empleados`.`DireccionEstrategicaASSESSMENT2010` AS `DireccionEstrategicaASSESSMENT2010`,`empleados`.`EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2010` AS `EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2010`,`empleados`.`EjecucionImpecableASSESSMENT2010` AS `EjecucionImpecableASSESSMENT2010`,`empleados`.`GenerarValorASSESSMENT2010` AS `GenerarValorASSESSMENT2010`,`empleados`.`LiderazgoeInfluenciaASSESSMENT2010` AS `LiderazgoeInfluenciaASSESSMENT2010`,`empleados`.`NegociacionASSESSMENT2010` AS `NegociacionASSESSMENT2010`,`empleados`.`OrientacionaResultadosASSESSMENT2010` AS `OrientacionaResultadosASSESSMENT2010`,`empleados`.`VisiondeNegocioASSESSMENT2010` AS `VisiondeNegocioASSESSMENT2010`,`empleados`.`ConocerTransformarInnovacionASSESSMENT2013` AS `ConocerTransformarInnovacionASSESSMENT2013`,`empleados`.`DesarrollodeTalentoCoachingASSESSMENT2013` AS `DesarrollodeTalentoCoachingASSESSMENT2013`,`empleados`.`DireccionEstrategicaASSESSMENT2013` AS `DireccionEstrategicaASSESSMENT2013`,`empleados`.`EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2013` AS `EfectividadMulticulturalSensibilidadInterpersonalASSESSMENT2013`,`empleados`.`EjecucionImpecableASSESSMENT2013` AS `EjecucionImpecableASSESSMENT2013`,`empleados`.`GenerarValorASSESSMENT2013` AS `GenerarValorASSESSMENT2013`,`empleados`.`LiderazgoeInfluenciaASSESSMENT2013` AS `LiderazgoeInfluenciaASSESSMENT2013`,`empleados`.`NegociacionASSESSMENT2013` AS `NegociacionASSESSMENT2013`,`empleados`.`OrientacionaResultadosASSESSMENT2013` AS `OrientacionaResultadosASSESSMENT2013`,`empleados`.`VisiondeNegocioASSESSMENT2013` AS `VisiondeNegocioASSESSMENT2013`,`empleados`.`Fortalezas` AS `Fortalezas`,`empleados`.`Oportunidadesdemejora` AS `Oportunidadesdemejora`,`empleados`.`Sujerenciasdedesarrollo` AS `Sujerenciasdedesarrollo`,`empleados`.`ExamenTOEIC` AS `ExamenTOEIC`,`empleados`.`EstilodeAprendizaje` AS `EstilodeAprendizaje`,`empleados`.`Escolaridad1` AS `Escolaridad1`,`empleados`.`Escolaridad2` AS `Escolaridad2`,`empleados`.`Escolaridad3` AS `Escolaridad3`,`empleados`.`Escolaridad4` AS `Escolaridad4`,`empleados`.`Escolaridad5` AS `Escolaridad5`,`empleados`.`StatusdeEscolaridad1` AS `StatusdeEscolaridad1`,`empleados`.`StatusdeEscolaridad2` AS `StatusdeEscolaridad2`,`empleados`.`StatusdeEscolaridad3` AS `StatusdeEscolaridad3`,`empleados`.`StatusdeEscolaridad4` AS `StatusdeEscolaridad4`,`empleados`.`StatusdeEscolaridad5` AS `StatusdeEscolaridad5`,`puestos`.`NombrePuesto` AS `NombrePuesto`,`puestos`.`Area` AS `Area`,`puestos`.`Division` AS `Division`,`puestos`.`UnidadOperativa` AS `UnidadOperativa`,`puestos`.`Zona` AS `Zona`,`puestos`.`Niveldelpuesto` AS `Niveldelpuesto`,`puestos`.`PerfilTipo` AS `PerfilTipo`,`puestos`.`TipodePuesto` AS `TipodePuesto`,`perfiles`.`NombrePerfil` AS `NombrePerfil`,`perfiles`.`LKostik` AS `pLKostik`,`perfiles`.`PKostik` AS `pPKostik`,`perfiles`.`IKostik` AS `pIKostik`,`perfiles`.`TKostik` AS `pTKostik`,`perfiles`.`VKostik` AS `pVKostik`,`perfiles`.`XKostik` AS `pXKostik`,`perfiles`.`SKostik` AS `pSKostik`,`perfiles`.`BKostik` AS `pBKostik`,`perfiles`.`OKostik` AS `pOKostik`,`perfiles`.`RKostik` AS `pRKostik`,`perfiles`.`DKostik` AS `pDKostik`,`perfiles`.`CKostik` AS `pCKostik`,`perfiles`.`ZKostik` AS `pZKostik`,`perfiles`.`EKostik` AS `pEKostik`,`perfiles`.`KKostik` AS `pKKostik`,`perfiles`.`FKostik` AS `pFKostik`,`perfiles`.`NKostik` AS `pNKostik`,`perfiles`.`WKostik` AS `pWKostik`,`perfiles`.`GKostik` AS `pGKostik`,`perfiles`.`AKostik` AS `pAKostik`,`empleados`.`EdoPromocional2007` AS `EdoPromocional2007`,`empleados`.`EdoPromocional2008` AS `EdoPromocional2008`,`empleados`.`EdoPromocional2009` AS `EdoPromocional2009`,`empleados`.`EdoPromocional2010` AS `EdoPromocional2010`,`empleados`.`EdoPromocional2011` AS `EdoPromocional2011`,`empleados`.`EdoPromocional2012` AS `EdoPromocional2012`,`empleados`.`EdoPromocional2013` AS `EdoPromocional2013`,`empleados`.`EdoPromocional2014` AS `EdoPromocional2014`,`empleados`.`ComentariosJunta2007` AS `ComentariosJunta2007`,`empleados`.`ComentariosJunta2008` AS `ComentariosJunta2008`,`empleados`.`ComentariosJunta2009` AS `ComentariosJunta2009`,`empleados`.`ComentariosJunta2010` AS `ComentariosJunta2010`,`empleados`.`ComentariosJunta2011` AS `ComentariosJunta2011`,`empleados`.`ComentariosJunta2012` AS `ComentariosJunta2012`,`empleados`.`ComentariosJunta2013` AS `ComentariosJunta2013`,`empleados`.`ComentariosJunta2014` AS `ComentariosJunta2014`,`empleados`.`Temporalidad2007` AS `Temporalidad2007`,`empleados`.`Temporalidad2008` AS `Temporalidad2008`,`empleados`.`Temporalidad2009` AS `Temporalidad2009`,`empleados`.`Temporalidad2010` AS `Temporalidad2010`,`empleados`.`Temporalidad2011` AS `Temporalidad2011`,`empleados`.`Temporalidad2012` AS `Temporalidad2012`,`empleados`.`Temporalidad2013` AS `Temporalidad2013`,`empleados`.`Temporalidad2014` AS `Temporalidad2014`,`empleados`.`OtrasPosiciones` AS `OtrasPosiciones`,`empleados`.`Salidaencontroplazo` AS `Salidaencontroplazo`,`empleados`.`CometariosSalidaencontroplazo` AS `CometariosSalidaencontroplazo`,`empleados`.`Sugerenciasdedesarrollo2014` AS `Sugerenciasdedesarrollo2014`,`empleados`.`Sugerenciasdedesarrollo2013` AS `Sugerenciasdedesarrollo2013`,`empleados`.`Sugerenciasdedesarrollo2012` AS `Sugerenciasdedesarrollo2012`,`empleados`.`Sugerenciasdedesarrollo2011` AS `Sugerenciasdedesarrollo2011`,`empleados`.`Sugerenciasdedesarrollo2010` AS `Sugerenciasdedesarrollo2010`,`empleados`.`Sugerenciasdedesarrollo2009` AS `Sugerenciasdedesarrollo2009`,`empleados`.`Sugerenciasdedesarrollo2008` AS `Sugerenciasdedesarrollo2008`,`empleados`.`Sugerenciasdedesarrollo2007` AS `Sugerenciasdedesarrollo2007`,`empleados`.`DObservableAnterior` AS `DObservableAnterior`,`empleados`.`IObservableAnterior` AS `IObservableAnterior`,`empleados`.`SObservableAnterior` AS `SObservableAnterior`,`empleados`.`CObservableAnterior` AS `CObservableAnterior`,`empleados`.`DProyectableAnterior` AS `DProyectableAnterior`,`empleados`.`IProyectableAnterior` AS `IProyectableAnterior`,`empleados`.`SProyectableAnterior` AS `SProyectableAnterior`,`empleados`.`CProyectableAnterior` AS `CProyectableAnterior`,`empleados`.`DNaturalAnterior` AS `DNaturalAnterior`,`empleados`.`INaturalAnterior` AS `INaturalAnterior`,`empleados`.`CNaturalAnterior` AS `CNaturalAnterior`,`empleados`.`SNaturalAnterior` AS `SNaturalAnterior`,`empleados`.`AnaliticoAnterior` AS `AnaliticoAnterior`,`empleados`.`IntuitivoAnterior` AS `IntuitivoAnterior`,`empleados`.`LogicoAnterior` AS `LogicoAnterior`,`empleados`.`VisionarioAnterior` AS `VisionarioAnterior`,((date_format(now(),_utf8'%Y') - date_format(`empleados`.`FechadeNacimiento`,_utf8'%Y')) - (date_format(now(),_utf8'00-%m-%d') < date_format(`empleados`.`FechadeNacimiento`,_utf8'00-%m-%d'))) AS `edad`,((date_format(now(),_utf8'%Y') - date_format(`empleados`.`FechadeIngresoaPuestoActual`,_utf8'%Y')) - (date_format(now(),_utf8'00-%m-%d') < date_format(`empleados`.`FechadeIngresoaPuestoActual`,_utf8'00-%m-%d'))) AS `antiguedadpuesto`,((date_format(now(),_utf8'%Y') - date_format(`empleados`.`FechadeAlta`,_utf8'%Y')) - (date_format(now(),_utf8'00-%m-%d') < date_format(`empleados`.`FechadeAlta`,_utf8'00-%m-%d'))) AS `antiguedadcompania`,`empleados`.`9BXS14` AS `9BXS14`,`empleados`.`9BXS13` AS `9BXS13`,`empleados`.`9BXS12` AS `9BXS12`,`empleados`.`9BXS11` AS `9BXS11`,`empleados`.`9BXS10` AS `9BXS10`,`empleados`.`9BXS09` AS `9BXS09`,`empleados`.`9BXS08` AS `9BXS08`,`empleados`.`9BXS07` AS `9BXS07` from ((`empleados` join `puestos`) join `perfiles`) where ((`empleados`.`NoPuesto` = `puestos`.`NoPuesto`) and (`puestos`.`PerfilTipo` = `perfiles`.`NoPerfil`))");	
	
	
	
}



function to_utf8($in)
{
        if (is_array($in)) {
            foreach ($in as $key => $value) {
                $out[to_utf8($key)] = to_utf8($value);
            }
        } elseif(is_string($in)) {

                return utf8_encode($in);

        } else {
            return $in;
        }
        return $out;
} 

function cadenafilesystem($nom_archivo)
{
    $nom_archivoa=$nom_archivo;
	$arr_busca = array(' ','á','à','â','ã','ª','Á','À',
    'Â','Ã', 'é','è','ê','É','È','Ê','í','ì','î','Í',
    'Ì','Î','ò','ó','ô', 'õ','º','Ó','Ò','Ô','Õ','ú',
    'ù','û','Ú','Ù','Û','ç','Ç','Ñ','ñ');
	//chek($arr_busca);
    $arr_busca=to_utf8($arr_busca);
    //chek($arr_busca);
    $arr_susti = array('_','a','a','a','a','a','A','A',
    'A','A','e','e','e','E','E','E','i','i','i','I','I',
    'I','o','o','o','o','o','O','O','O','O','u','u','u',
    'U','U','U','c','C','N','n');
    
    $nom_archivo = trim(str_replace($arr_busca, $arr_susti, $nom_archivo));
    
   // chek($nom_archivoa.' '.$nom_archivo);
    return ereg_replace('[^A-Za-z0-9\_\.\-]', '', $nom_archivo);
} 

function ae_nocache() 
{
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}


function hayvariables($FEEDBACK,$datos)
{
	foreach($FEEDBACK as $campo)
	{
		if($datos[$campo]){return true;}
	}
	return false;
}

function setActual($nombredearreglodecampos,$arreglodecampos,&$datos)
{
	$anio=0;
	
	foreach($datos as $key=>$value)
	{
		$pos = strpos($key, $grupodecampos);

	//	if ($pos === false AND) {
		
	}
	
	return $anio;
}




function chek($var='chek aqui')
{
	if($var===0){$var='- 0 -';}
	if($var==='0'){$var='- =0= -';}
	if ( !empty($var) ){
	?><pre><?
	print_r ($var);
	?></pre><?
	}
	else { echo 'vacio<br>'; }
}//function arrchek($arr)

function is_class($class,&$object)
{
	return $class==get_class($object);
}

function checkbox($name,$value,$chekedarray=array(), $atribs='')
{
	?><input name="<?= $name ?>[]" type="checkbox" value="<?= $value ?>" <? if(in_array($value,$chekedarray)){ ?> checked="checked" <? } ?> <?= $atribs ?> /><?
}

function radio($name,$value,$cheked=null)
{
	?><input name="<?= $name ?>" type="radio" value="<?= $value ?>" <? if($value==$cheked){ ?> checked="checked"  <? } ?>  /><?
}


function unlinkRecursive($dir, $deleteRootToo)
{
    if(!$dh = @opendir($dir))
    {
        return;
    }
    while (false !== ($obj = readdir($dh)))
    {
        if($obj == '.' || $obj == '..')
        {
            continue;
        }

        if (!@unlink($dir . '/' . $obj))
        {
            unlinkRecursive($dir.'/'.$obj, true);
        }
    }

    closedir($dh);
   
    if ($deleteRootToo)
    {
        @rmdir($dir);
    }
   
    return;
} 

/**
 * Revisa si todos los elementos de arreglochico estan en arreglogrande
 *
 * @param array $arreglochico
 * @param array $arreglogrande
 * @return boolenan
 */
function array_in_array($arreglochico, $arreglogrande)
{
	foreach($arreglochico as $valor)//se peude optimizar con un while ret = true
	{
		if(!in_array($valor,$arreglogrande))
		{
			chek($valor);
			return false;
		}
	}
	return true;
}

/**
 * Flatten an array so that resulting array is of depth 1.
 * If any value is an array itself, it is merged by parent array, and so on.
 *
 * @param array $array
 * @param bool $preserver_keys OPTIONAL When true, keys are preserved when mergin nested arrays (=> values with same key get overwritten)
 * @return array
 */
function array_flatten($array, $preserve_keys = false)
{
    if (!$preserve_keys) {
        // ensure keys are numeric values to avoid overwritting when array_merge gets called
        $array = array_values($array);
    }
   
    $flattened_array = array();
    foreach ($array as $k => $v) {
        if (is_array($v)) {
            $flattened_array = array_merge($flattened_array, call_user_func(__FUNCTION__, $v, $preserve_keys));
        } elseif ($preserve_keys) {
            $flattened_array[$k] = $v;
        } else {
            $flattened_array[] = $v;
        }
    }
    return $flattened_array;
}


function fileextension($filename)
{
	$ret=pathinfo($filename);
	return $ret['extension'];
}

function filenamewithoutextension($filename)
{
	$ret=pathinfo($filename);
	return $ret['filename'];
}


/**
 * Enter description here...
 *
 * @param datossql $fuente
 * @param string $camponombre
 * @param string $campovalor
 * @param string $default
 * @param string $atrribs
 */
function htmlselectdesdesql ($nombre, &$fuente, $tabla,  $camponombre, $campovalor, $default, $inicial='Todas',$atrribs='')//lista tiene un arreglo de arreglos con valor en el 0 y texto en el 1
{

$data=$fuente->queryArregloKeyUNI("Select distinct $camponombre, $campovalor from $tabla Order by $camponombre");

if($inicial){array_unshift($data,$inicial);}

htmlselectuni2($data, $nombre, $default, $atrribs);

}




function criteriodesdesql (&$fuente, $tabla,  $camponombre)//lista tiene un arreglo de arreglos con valor en el 0 y texto en el 1
{

	$data=$fuente->queryArregloUNI("Select distinct $camponombre from $tabla Order by $camponombre");
	//chek($data);
	foreach($data as $valor)
	{
		$ret[$valor]=array('mayoroigual'=>null,'menoroigual'=>null,'igual'=>$valor);
	}

	return $ret;
}


/**
 * Imprime un select a partir de un arreglo unidimencional poene valor y texto iguales
 *
 * @param array $lista
 * @param string $nombre
 * @param string $valor
 * @param string $atrribs
 */
function htmlselectuni ($lista, $nombre, $valor, $atrribs='')//lista tiene es un arreglounidimesional y pone el vlaor y el nombre iguales
{
?> 

<select name="<? printf($nombre); ?>" <? echo $atrribs ?> >
<?php foreach($lista as $item){?>
<option <? if($valor === $item) {?> selected="selected" <? } ?>value="<? Printf($item); ?>"><? Printf ($item); ?></option>				 
<?php } ?>
</select>

<?
}

function htmlselectuni2 ($lista, $nombre, $valor, $atrribs='')//lista tiene es un arreglounidimesional llave-valor
{
?> 

<select name="<? printf($nombre); ?>" <? echo $atrribs ?> >
<?php foreach($lista as $key=>$item){?>
<option <? if($valor == $key) {?> selected="selected" <? } ?>value="<? Printf($key); ?>"><? Printf ($item); ?></option>				 
<?php } ?>
</select>

<?
}

/*
 * getAge() by Nathan Strong
 * $start_ts is a UNIX timestamp sometime in the past.
 * This function will not work with dates prior to epoch (EPOCH FAIL!)
 */


function printdate($mysqlstringdate)
{
		$ret=explode('-',$mysqlstringdate);
		return $ret[2].'-'.$ret[1].'-'.$ret[0];
}



function getAge($start_ts)
{
  	$end_ts = time();

  	$mesdiaactual=date("md",$end_ts);
	$mesdiafecha=date("md",$start_ts);

  	$diaactual=date("d",$end_ts);
	$diafecha=date("d",$start_ts);
	
  	$anios=date("Y",$end_ts)-date("Y",$start_ts);
  	
  	$meses=date("m",$end_ts)-date("m",$start_ts);
  	
  	if($mesdiaactual<$mesdiafecha)
  	{
  		$anios--;
  		$meses=$meses+12;
  	}
  	if($diaactual<$diafecha)
  	{
  		$meses--;
  	}	

	
	return $anios.' a&ntilde;os '.$meses.' meses ';

}



function getAgeold($start_ts)
{
  $end_ts = time();
  $anniversary = date('z', $start_ts);
  $days_in_year = date('L', $start_ts) ? 366 : 365;
  $sec_per_day = 86400; // 60 * 60 * 24
  $diff = $end_ts - $start_ts;
  $diff -= $diff % $sec_per_day; // discard misc seconds
  $days = $diff / $sec_per_day; // number of days to iterate through;

  if( $diff < 0 )
    return false; // $start_ts is in the future!

  if( $days < $days_in_year ) // less than 1 year old; don't need to loop
    return 0;

  $years = 0;

  do {
    // add the remaining days left in the current year first.
    $left_in_year = $days_in_year - $anniversary;
    if( $days < $left_in_year )
      $left_in_year = $days;

    $start_ts += $sec_per_day * $left_in_year;
    $days -= $left_in_year;
    // are there enough days remaining to make it to the next birthday?
    if( $days > $anniversary )
    {
      $years++; // increment years;
      $to_anniv = $anniversary;
    } else {
      $to_anniv = $days;
    }

    // add the days remaining to either the next birthday, or today's date, whichever
    // is closer.
    $start_ts += $sec_per_day * $to_anniv;
    $days -= $to_anniv;
    // reevaluate $days_in_year so that leap year is taken into account.
    $days_in_year = date('L', $start_ts) ? 366 : 365;
  } while( $days > 0 );

  // return the result.
  return $years;
}








?>