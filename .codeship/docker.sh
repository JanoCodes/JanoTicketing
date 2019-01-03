#!/bin/sh
set -e

if [ -z "$1" ]; then
    DOCKER_TAG="development"
else
    DOCKER_TAG="$1"
fi


## Login to docker hub on release action
if [ ! -f "/root/.docker/config.json" ]; then
    docker login -u $DOCKER_REGISTRY_USERNAME -p $DOCKER_REGISTRY_PASSWORD
fi

docker tag janorocks/ticketing janorocks/ticketing:$DOCKER_TAG
docker push janorocks/ticketing:$DOCKER_TAG
