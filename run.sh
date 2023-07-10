#!/usr/bin/env bash

docker build -t meetup-prod-php -f ./docker/prod/Dockerfile .
docker run -tid --name meetup-app-prod meetup-prod-php
docker build -t meetup-prod-nginx -f ./docker/prod/nginx/Dockerfile .
docker run -dit --name meetup-prod-app-nginx -p 8000:8080 --link meetup-app-prod meetup-prod-nginx