echo OFF
echo;

set setup_backup_dir=setup_backup
set copy_src_dir=Labmanob

echo Post Update Setup %DATE% %TIME%
echo current_dir: %CD%
echo;
echo ------------------------------------------------------------------------------
echo;

echo Proceed to Post Update Setup

echo;
echo ------------------------------------------------------------------------------
echo;
PAUSE
echo;

echo POST UPDATE SETUP
echo;
echo ------------------------------------------------------------------------------
echo;

rem reverse database
if exist %setup_backup_dir%\%copy_src_dir%\labdoor\appdoor\appfiles\databases\sqlite\medical_db.sqlite (
	echo INFO: database confirmed
	echo copying: initializing
	robocopy %setup_backup_dir%\%copy_src_dir%\labdoor\appdoor\appfiles\databases\sqlite\ %copy_src_dir%\labdoor\appdoor\appfiles\databases\sqlite\ medical_db.sqlite /E /IS /ETA /NFL /NDL /NJH /nc /ns
	
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
	echo CAUTION: database error
)

echo;
echo ------------------------------------------------------------------------------
echo;
PAUSE
echo;

rem reverse logs
if exist %setup_backup_dir%\%copy_src_dir%\labdoor\appdoor\logs\ (
	echo INFO: logs confirmed
	echo copying: initializing
	robocopy %setup_backup_dir%\%copy_src_dir%\labdoor\appdoor\logs\ %copy_src_dir%\labdoor\appdoor\logs\ /E /IS /ETA /NFL /NDL /NJH /nc /ns
	
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
	echo CAUTION: logs error
)

echo;
echo ------------------------------------------------------------------------------
echo;
PAUSE
echo;

rem reverse qrcodes
if exist %setup_backup_dir%\%copy_src_dir%\labdoor\assets\temp\qrcodes\ (
	echo INFO: qrcodes confirmed
	echo copying: initializing
	robocopy %setup_backup_dir%\%copy_src_dir%\labdoor\assets\temp\qrcodes\ %copy_src_dir%\labdoor\assets\temp\qrcodes\ /E /IS /ETA /NFL /NDL /NJH /nc /ns
	
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
	echo CAUTION: qrcodes error
)

echo;
echo ------------------------------------------------------------------------------
echo;
echo Exit
echo;

PAUSE