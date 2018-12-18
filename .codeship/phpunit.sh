#!/usr/bin/env bash
supervisord &
sleep 20
/var/www/jano/vendor/bin/phpunit