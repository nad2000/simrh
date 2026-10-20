The *simrh* project is a PHP-based web application designed for Human Resources (HR) management, psychometric testing, and data analysis. The acronym "SIM-RH" likely stands for Sistema de Información de Recursos Humanos (Human Resources Information System) or Simulador de Recursos Humanos (HR Simulator).
This project acts as an internal HR portal where administrators can upload user data, administer standard corporate psychometric exams, generate visual reports (like 9-box grids and test charts), and simulate talent placement metrics.

# 1. Psychometric Testing & Evaluation

The repository contains specialized scripts to process, analyze, and graph several well-known corporate psychological and psychometric tests:

 -  DISC Assessment: Features files like graficaDISC.php and graficaDISCtriple.php to map behavioral styles.
 -  Kostick Cleaver: graficaKostik.php tracks personality traits in a work environment.
 -  Terman Merril: graficaTerman.php evaluates intellectual capacity and intelligence quotient.
 -  Other Assessments: Includes files for graficaALIV.php and graficaEQUI.php.

# 2. HR Dashboards and Data Visualisation

 - Chart Generation: It heavily relies on JpGraph (jpgraph folder), a PHP library used to generate dynamic charts and visual representations of candidate or employee test scores.
 - HR Reporting: Contains metrics such as reporte9bxs.php (likely a 9-Box Grid matrix used for talent management and performance vs. potential planning) and a talent simulator (simulador.php).

# 3. Data & User Management

 - Excel Integration: Dedicated scripts like Excelusuarios.php and ExcelBusqueda.php allow the system to import, export, and search HR data using spreadsheets.
 - Access Control: Includes user portal and authentication infrastructure such as acceso.php (login), salir.php (logout), and AdministradorUsuariosListadoyUpload.php (user/candidate profile list and file uploader).
 - Meeting/Board Management: Scripts like CreadordeJuntas.php and listadodejuntas.php are built to schedule and review talent evaluation board meetings.
