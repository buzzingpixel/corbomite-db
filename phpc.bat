@echo off

docker exec -it --user root --workdir /app php-corbomite-db bash -c "php %*"
