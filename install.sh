#!/bin/bash

# Check if install_logs directory exists
directory="install_logs"
if [ ! -d "$directory" ]; then
    # If it doesn't exist, create it
    mkdir -p "$directory"
    echo "Directory $directory created."
else 
    echo "Directory $directory already exists."
fi

echo "Starting migration script..."
docker compose up -d db > install_logs/db_start.log 2>&1
echo "Database service started."

docker compose build app > install_logs/app_build.log 2>&1
echo "App image built."

docker compose run --rm app php artisan migrate > install_logs/migrate_output.log 2>&1
echo "Migration completed."

docker compose run --rm app php artisan db:seed > install_logs/seed_output.log 2>&1
echo "Database seeded."

docker compose run --rm app php artisan storage:link > install_logs/storage_link.log 2>&1
echo "Storage linked."

docker compose run --rm app php artisan key:generate > install_logs/app_key.log 2>&1
echo "App key generated."

docker compose up -d webserver > install_logs/webserver_start.log 2>&1
echo "Webserver service started."

echo "Your program is running at http://localhost:8050"