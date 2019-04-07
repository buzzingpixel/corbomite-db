@echo off

docker-compose -f docker-compose.yml -p corbomite-db up -d
docker exec -it --user root --workdir /app php-corbomite-db bash -c "cd /app && composer install"
