#!/bin/bash

php artisan elastic:write lnk
php artisan elastic:write lnk9
php artisan elastic:write lnk12

echo "sleeping 5 minutes";
sleep 5m;

php artisan elastic:run

curl 'localhost:9200/_cat/indices?v'
