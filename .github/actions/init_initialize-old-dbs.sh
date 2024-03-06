#!/bin/bash -e

ROOT_DIR=$(readlink -f "$(dirname $0)/../..")

echo "Initialize old versions databases"
mysql --host=127.0.0.1 --user=root --password=rootpassword --execute="DROP DATABASE IF EXISTS \`glpitest0723\`;"
mysql --host=127.0.0.1 --user=root --password=rootpassword --execute="CREATE DATABASE \`glpitest0723\`;"
cat $ROOT_DIR/tests/glpi-0.72.3-empty.sql | mysql --host=127.0.0.1 --user=root --password=rootpassword glpitest0723
