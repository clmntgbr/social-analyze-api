#!/usr/bin/env bash

down:
	docker compose down --remove-orphans

up:
	docker compose up -d

php:
	docker exec -it social-analyze-api-php /bin/bash