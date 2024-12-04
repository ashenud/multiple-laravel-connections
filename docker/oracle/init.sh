#!/bin/bash

# Start the Oracle Listener
echo "Starting Oracle Listener..."
lsnrctl start

# Start the Oracle Database
echo "Starting Oracle Database..."
sqlplus / as sysdba <<EOF
STARTUP;
ALTER PLUGGABLE DATABASE ALL OPEN;
EXIT;
EOF

echo "Database started and pluggable databases opened successfully."
