set TIMESTAMP=%DATE:~10,4%%DATE:~4,2%%DATE:~7,2%

REM remove option -p if database password is empty
C:\[path_to_mysql_bin]\mysqldump.exe -u[username] -p[password] [db_name] --result-file=C:\[db_backup_location]\[db_name].%TIMESTAMP%.sql

REM Change working directory to the location of the DB dump file.
C:
CD \[db_backup_location]\

REM Compress DB dump file into CAB file (use "EXPAND file.cab" to decompress).
MAKECAB "[db_name].%TIMESTAMP%.sql" "[db_name].%TIMESTAMP%.sql.cab"

REM Delete uncompressed DB dump file.
DEL /q /f "[db_name].%TIMESTAMP%.sql"

