#!/bin/bash -e

PHP_MAJOR_VERSION="$(echo $PHP_VERSION | cut -d '.' -f 1,2)"

# Validate composer config
composer validate --strict
composer check-platform-reqs;

# Install dependencies
bin/console dependencies install --composer-options="$COMPOSER_ADD_OPTS --prefer-dist --no-progress"
