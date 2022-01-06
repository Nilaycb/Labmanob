echo OFF
echo;

set setup_backup_dir=setup_backup
set copy_src_dir=Labmanob

echo Pre Update Setup %DATE% %TIME%
echo current_dir: %CD%
echo;
echo ------------------------------------------------------------------------------
echo;

echo Proceed to Pre Update Setup

echo;
echo ------------------------------------------------------------------------------
echo;
PAUSE
echo;

echo PRE UPDATE SETUP
echo;
echo ------------------------------------------------------------------------------
echo;

if exist %setup_backup_dir%\ (
	echo %setup_backup_dir%: already exists
) else (
	echo %setup_backup_dir%: no such directory
	echo %setup_backup_dir%: creating the directory
	mkdir %setup_backup_dir%
	echo %setup_backup_dir%: directory created
)

if not exist %setup_backup_dir%\%copy_src_dir%\ (
	echo;
	echo %setup_backup_dir%\%copy_src_dir%: no such directory
	echo %setup_backup_dir%\%copy_src_dir%: creating the directory
	mkdir %setup_backup_dir%\%copy_src_dir%
	echo %setup_backup_dir%\%copy_src_dir%: directory created
)

echo;
echo ------------------------------------------------------------------------------
echo;

if exist %setup_backup_dir%\%copy_src_dir%\ (
	echo %setup_backup_dir%\%copy_src_dir%: directory exists
	echo copying: initializing
	robocopy %copy_src_dir% %setup_backup_dir%\%copy_src_dir%\ /E /IS /ETA /NFL /NDL /NJH /nc /ns
	
	rem /E   : Copy subdirectories, including Empty ones.
	rem /IS  : Include Same files.
	rem /IT  : Include Tweaked files.
	rem /NFL : No File List - don't log file names.
	rem /NDL : No Directory List - don't log directory names.
	rem /NJH : No Job Header.
	rem /NJS : No Job Summary.
	rem /NP  : No Progress - don't display percentage copied.
	rem /NS  : No Size - don't log file sizes.
	rem /NC  : No Class - don't log file classes.

	if %ERRORLEVEL% LEQ 1 (
		echo copying: copied successfully
	) else (
		echo copying: error level %ERRORLEVEL%
	)
) else (
	echo %setup_backup_dir%\%copy_src_dir%: no such directory
)

echo;
echo ------------------------------------------------------------------------------
echo;

if not exist %setup_backup_dir%\%copy_src_dir%\labdoor\appdoor\appfiles\databases\sqlite\medical_db.sqlite (
	echo CAUTION: database error
) else (
	echo INFO: database confirmed
)

echo;
echo ------------------------------------------------------------------------------
echo;
echo Exit
echo;
PAUSE