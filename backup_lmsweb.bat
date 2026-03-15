@echo off
set DB_USER=root
set DB_PASS=
set DB_NAME=lmsweb

rem tanggal format YYYY-MM-DD
for /f "tokens=2-4 delims=/ " %%a in ('date /t') do set DT=%%c-%%a-%%b
set BACKUP_DIR=C:\xampp\mysql\backup\%DT%
mkdir "%BACKUP_DIR%"

rem buat string password hanya kalau ada
set PWD_OPTS=
if not "%DB_PASS%"=="" set PWD_OPTS=-p%DB_PASS%

"C:\xampp\mysql\bin\mysqldump" -u%DB_USER% --password=%DB_PASS% %DB_NAME% …