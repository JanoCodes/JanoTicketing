#!/usr/bin/env bash
supervisord -c /etc/supervisor/conf.d/supervisord.conf &
sleep 20
fossa init
fossa analyze
