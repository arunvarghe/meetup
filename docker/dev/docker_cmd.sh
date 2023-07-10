#!/bin/bash

# composer
composer install &&
bin/console cache:clear &&

# yarn
yarn install &&
yarn encore dev &&

# start server
symfony server:start --port=8000
