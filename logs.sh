#!/bin/bash

. ./.env

docker-compose -f docker-compose.yml -f "docker.$NAME_ENV.yml" logs --tail 50 -f $@
