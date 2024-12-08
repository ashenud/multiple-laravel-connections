-- TODO: Update or remove this file to align user access management with environment variable configurations.
-- NOTE: Temporary this file creates an accessible user for the service `freepdb1`.
-- WARNING: Do not change the container name.
-- Ensure that the username and password remain consistent with the oracle related `.env` settings.
-- Reference: https://github.com/ashenud/multiple-laravel-connections/issues/3

-- init.sql
ALTER SESSION SET CONTAINER = freepdb1;
CREATE USER oracle_server_user IDENTIFIED BY oracle_server_user_password;
GRANT ALL PRIVILEGES TO oracle_server_user;
GRANT DBA TO oracle_server_user;
GRANT SYSDBA TO oracle_server_user;
GRANT CONNECT, RESOURCE TO oracle_server_user;
ALTER SESSION SET "_ORACLE_SCRIPT"=FALSE;
EXIT;