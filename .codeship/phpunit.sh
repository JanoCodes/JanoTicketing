#!/usr/bin/env bash
supervisord -c /etc/supervisor/conf.d/supervisord.conf &
sleep 20
/var/www/jano/vendor/bin/phpunit --coverage-clover
/var/www/jano/vendor/bin/codacycoverage clover /var/www/jano/build/coverage/xml
