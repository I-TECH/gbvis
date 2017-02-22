set TIMESTAMP=%DATE:~10,4%%DATE:~4,2%%DATE:~7,2%

REM Use option -p[password] if database password is not empty
C:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump.exe -uroot gbvis --result-file=C:\Users\Administrator\Desktop\db_backup\gbvis.%TIMESTAMP%.sql

REM Change working directory to the location of the DB dump file.
C:
CD \Users\Administrator\Desktop\db_backup\

REM Compress DB dump file into CAB file (use "EXPAND file.cab" to decompress).
MAKECAB "gbvis.%TIMESTAMP%.sql" "gbvis.%TIMESTAMP%.sql.cab"

REM Delete uncompressed DB dump file.
DEL /q /f "gbvis.%TIMESTAMP%.sql"

