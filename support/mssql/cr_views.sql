USE simrh
GO

--
--
-- Views:

DROP  VIEW "consultausuarios"
GO

CREATE VIEW "consultausuarios"
AS select
   "e"."NoPersonal" AS "NoPersonal",
   "u"."password" AS "password",
   "u"."niveldeacceso" AS "niveldeacceso",
   "e"."NombreEmpleado" AS "NombreEmpleado",
   "p"."NombrePuesto" AS "NombrePuesto",
   "p"."Division" AS "Division",
   "p"."Area" AS "Area",
   "p"."UnidadOperativa" AS "UnidadOperativa",
   "u"."unidadesoperativas" AS "unidadesoperativas"
from "usuarios" "u" join "empleados" "e"
	ON "u"."NoPersonal" = "e"."NoPersonal"
join "puestos" "p" ON "p"."NoPuesto" = "e"."NoPuesto"
GO



-- 
-- Structure for view "consultausuarios"
-- 
DROP VIEW "consultausuarios"
GO
CREATE VIEW "consultausuarios"
AS
    SELECT "e"."NoPersonal" AS "NoPersonal",
           "u"."password" AS "password",
           "u"."niveldeacceso" AS "niveldeacceso",
           "e"."NombreEmpleado" AS "NombreEmpleado",
           "p"."NombrePuesto" AS "NombrePuesto",
           "p"."Division" AS "Division",
           "p"."Area" AS "Area",
           "p"."UnidadOperativa" AS "UnidadOperativa",
           "u"."unidadesoperativas" AS "unidadesoperativas"
    FROM   "usuarios" AS "u"
           INNER JOIN "empleados" AS "e" ON "u"."NoPersonal" = "e"."NoPersonal"
           INNER JOIN "puestos" AS "p" ON "p"."NoPuesto" = "e"."NoPuesto";
GO

--- STILL TO GO:
           
-- --------------------------------------------------------
-- 
-- Structure for view "edades"
-- 

CREATE SQL SECURITY DEFINER VIEW "edades" AS select "empleados"."NoPersonal" AS "NoPersonal",((date_format(now(),_utf8'%Y') - date_format("empleados"."FechadeNacimiento",_utf8'%Y')) - (date_format(now(),_utf8'00-%m-%d') < date_format("empleados"."FechadeNacimiento",_utf8'00-%m-%d'))) AS "edad" from "empleados"
GO

-- --------------------------------------------------------

-- 
-- Structure for view "edadesporrango"
-- 

GO

CREATE 
VIEW "edadesporrango" AS 
select "e"."NoPersonal" AS "NoPersonal","e"."edad" AS "edad",
if(("e"."edad" <= 20),_utf8'menor a 20',if((("e"."edad" >= 21) 
and ("e"."edad" <= 30)),_utf8'21 a 30',if((("e"."edad" >= 31) 
and ("e"."edad" <= 40)),_utf8'31 a 40',if((("e"."edad" >= 41) and ("e"."edad" <= 50)),_utf8'41 a 50',if((("e"."edad" >= 51) and ("e"."edad" <= 60)),_utf8'51 a 60',if((("e"."edad" >= 61) and ("e"."edad" <= 70)),_utf8'61 a 70',_utf8'mayor a 70')))))) AS "rangodeedad" from "edades" "e"
GO

-- --------------------------------------------------------

-- 
-- Structure for view "historicoconfechas"
-- 

GO

CREATE SQL SECURITY DEFINER VIEW "historicoconfechas" AS select "historico"."idJunta" AS "idJunta","historico"."Tabla" AS "Tabla","historico"."CampoId" AS "CampoId","historico"."ValorId" AS "ValorId","historico"."Campo" AS "Campo","historico"."NuevoValor" AS "NuevoValor","juntas"."fecha" AS "fecha" from ("historico" join "juntas") where ("historico"."idJunta" = "juntas"."id")
GO

-- --------------------------------------------------------

-- 
-- Structure for view "historicoconnombres"
-- 

GO

CREATE SQL SECURITY DEFINER VIEW "historicoconnombres" AS select "historico"."idJunta" AS "idJunta","historico"."Tabla" AS "Tabla","historico"."CampoId" AS "CampoId","historico"."ValorId" AS "ValorId","historico"."Campo" AS "Campo","historico"."NuevoValor" AS "NuevoValor","empleados"."NombreEmpleado" AS "NombreEmpleado",concat("empleados"."NombreEmpleado",_utf8' ',_utf8'(',"historico"."ValorId",_utf8')') AS "empleado" from ("historico" join "empleados") where ("empleados"."NoPersonal" = "historico"."ValorId")
GO

-- --------------------------------------------------------

-- 
-- Structure for view "justasconresponsable"
-- 

GO

CREATE SQL SECURITY DEFINER VIEW "justasconresponsable" AS select "juntas"."id" AS "id","empleados"."NombreEmpleado" AS "responsable","juntas"."asistentes" AS "asistentes","juntas"."fecha" AS "fecha","juntas"."comentarios" AS "comentarios","juntas"."division" AS "division","juntas"."zona" AS "zona","juntas"."unidadoperativa" AS "unidadoperativa" from ("juntas" join "empleados") where ("juntas"."idresponsable" = "empleados"."NoPersonal")
GO

-- --------------------------------------------------------

-- 
-- Structure for view "trcorto"
-- 

GO

CREATE VIEW "trcorto" AS select "t"."NoPuesto" AS "NoPuesto","e"."NombreEmpleado" AS "NombreEmpleado","t"."NoPersonal" AS "NoPersonal","p"."PerfilTipo" AS "PerfilTipo" from (("tablasderemplaso" "t" join "empleados" "e") join "puestos" "p") where (("t"."NoPersonal" = "e"."NoPersonal") and ("p"."NoPuesto" = "t"."NoPuesto") and ("t"."plazo" = _latin1'corto'))
GO

-- --------------------------------------------------------

-- 
-- Structure for view "trlargo"
-- 

GO

CREATE VIEW "trlargo" AS select "t"."NoPuesto" AS "NoPuesto","e"."NombreEmpleado" AS "NombreEmpleado","t"."NoPersonal" AS "NoPersonal","p"."PerfilTipo" AS "PerfilTipo" from (("tablasderemplaso" "t" join "empleados" "e") join "puestos" "p") where (("t"."NoPersonal" = "e"."NoPersonal") and ("p"."NoPuesto" = "t"."NoPuesto") and ("t"."plazo" = _latin1'largo'))
GO

-- --------------------------------------------------------

-- 
-- Structure for view "trmediano"
-- 

GO

CREATE VIEW "trmediano" AS select "t"."NoPuesto" AS "NoPuesto","e"."NombreEmpleado" AS "NombreEmpleado","t"."NoPersonal" AS "NoPersonal","p"."PerfilTipo" AS "PerfilTipo" from (("tablasderemplaso" "t" join "empleados" "e") join "puestos" "p") where (("t"."NoPersonal" = "e"."NoPersonal") and ("p"."NoPuesto" = "t"."NoPuesto") and ("t"."plazo" = _latin1'mediano'))
GO

