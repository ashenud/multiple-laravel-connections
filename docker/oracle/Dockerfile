FROM container-registry.oracle.com/database/free:23.5.0.0

# Set environment variables for the password and database details
ENV ORACLE_PASSWORD=password
ENV ORACLE_USERNAME=username
ENV ORACLE_DATABASE=freepdb1

# Create a new Oracle user and grant full privileges
RUN echo "Creating user and granting privileges..." && \
    /bin/bash -c "echo 'ALTER SESSION SET CONTAINER = freepdb1;' | sqlplus / as sysdba && \
    echo 'CREATE USER ${ORACLE_USERNAME} IDENTIFIED BY ${ORACLE_PASSWORD};' | sqlplus / as sysdba && \
    echo 'GRANT ALL PRIVILEGES TO ${ORACLE_USERNAME};' | sqlplus / as sysdba && \
    echo 'GRANT DBA TO ${ORACLE_USERNAME};' | sqlplus / as sysdba && \
    echo 'GRANT SYSDBA TO ${ORACLE_USERNAME};' | sqlplus / as sysdba && \
    echo 'GRANT CONNECT, RESOURCE TO ${ORACLE_USERNAME};' | sqlplus / as sysdba && \
    echo 'ALTER SESSION SET \"_ORACLE_SCRIPT\"=FALSE;' | sqlplus / as sysdba"

# Open the pluggable database specified in the ORACLE_DATABASE environment variable
RUN echo "Opening ${ORACLE_DATABASE}..." && \
    /bin/bash -c "echo 'ALTER PLUGGABLE DATABASE ${ORACLE_DATABASE} OPEN;' | sqlplus / as sysdba"

# Expose necessary ports
EXPOSE 1521 5500
