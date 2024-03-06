#!/bin/bash -e

php --version
php -r 'echo(sprintf("PHP extensions: %s\n", implode(", ", get_loaded_extensions())));'
node --version
npm --version
mysql --version;
