# TODO: This file is currently unused. Update it to create users based on `.env` configurations.
# Reference: https://github.com/ashenud/multiple-laravel-connections/issues/3

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
