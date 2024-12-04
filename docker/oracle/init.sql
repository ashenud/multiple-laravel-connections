-- init.sql
ALTER SESSION SET CONTAINER = freepdb1;
CREATE USER oracle_server_user IDENTIFIED BY oracle_server_user_password;
GRANT ALL PRIVILEGES TO oracle_server_user;
GRANT DBA TO oracle_server_user;
GRANT SYSDBA TO oracle_server_user;
GRANT CONNECT, RESOURCE TO oracle_server_user;
ALTER SESSION SET "_ORACLE_SCRIPT"=FALSE;
EXIT;